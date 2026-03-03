<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    // Lista mensagens entre dois usuários
    public function getMessages(Request $request, $userId)
    {
        $authUser = Auth::user();
        if ($authUser->id == $userId) {
            return response()->json(['error' => 'Operação inválida'], 403);
        }
        $messages = Message::where(function ($query) use ($authUser, $userId) {
            $query->where(function ($q) use ($authUser, $userId) {
                $q->where('sender_id', $authUser->id)
                    ->where('receiver_id', $userId)
                    ->where('deleted_by_sender', false);
            })->orWhere(function ($q) use ($authUser, $userId) {
                $q->where('sender_id', $userId)
                    ->where('receiver_id', $authUser->id)
                    ->where('deleted_by_receiver', false);
            });
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['success' => true, 'data' => $messages]);
    }

    // Envia mensagem
    public function sendMessage(Request $request)
    {
        $authUser = Auth::user();

        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|exists:users,id|different:'.$authUser->id,
            'content' => 'nullable|string|max:2000',
            'type' => 'nullable|string|in:text,image,video,audio,document',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $type = $request->input('type', 'text');
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $path = 'messages/'.$type.'s';
            $file->move(public_path($path), $fileName);
            $filePath = $path.'/'.$fileName;

            if ($type === 'text') {
                $type = 'document'; // Fallback if file provided but type is text
            }
        }

        $message = Message::create([
            'sender_id' => $authUser->id,
            'receiver_id' => $request->recipient_id,
            'content' => $request->input('content') ?? ($filePath ? ucfirst($type) : ''),
            'type' => $type,
            'file_path' => $filePath,
        ]);

        // Broadcast a mensagem em tempo real
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['success' => true, 'data' => $message], 201);
    }

    // Marca mensagens como lidas
    public function markAsRead(Request $request, $userId)
    {
        $authUser = Auth::user();
        Message::where('sender_id', $userId)
            ->where('receiver_id', $authUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    // Lista conversas do usuário autenticado
    public function getConversations(Request $request)
    {
        $authUser = Auth::user();
        $showArchived = $request->boolean('archived', false);

        // Get unique user IDs the current user has chatted with, but only if not deleted
        $messages = Message::where(function($q) use ($authUser) {
                $q->where('sender_id', $authUser->id)->where('deleted_by_sender', false);
            })->orWhere(function($q) use ($authUser) {
                $q->where('receiver_id', $authUser->id)->where('deleted_by_receiver', false);
            })->get();

        $userIds = $messages->map(function ($message) use ($authUser) {
                return $message->sender_id == $authUser->id ? $message->receiver_id : $message->sender_id;
            })
            ->unique()
            ->values();

        $result = [];

        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if (! $user) {
                continue;
            }

            // check if conversation is archived
            $lastMessageQuery = Message::where(function ($q) use ($authUser, $userId) {
                $q->where('sender_id', $authUser->id)->where('receiver_id', $userId)->where('deleted_by_sender', false);
            })->orWhere(function ($q) use ($authUser, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authUser->id)->where('deleted_by_receiver', false);
            });

            $lastMessage = (clone $lastMessageQuery)->latest()->first();

            if (!$lastMessage) continue;

            // Check archival status based on the AUTH user's role in the messages
            $isArchived = Message::where(function ($q) use ($authUser, $userId) {
                $q->where('sender_id', $authUser->id)->where('receiver_id', $userId)->where('archived_by_sender', true);
            })->orWhere(function ($q) use ($authUser, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authUser->id)->where('archived_by_receiver', true);
            })->exists();

            if ($isArchived !== $showArchived) {
                continue;
            }

            $unreadCount = Message::where('sender_id', $userId)
                ->where('receiver_id', $authUser->id)
                ->whereNull('read_at')
                ->where('deleted_by_receiver', false)
                ->count();

            $result[] = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->image_url,
                ],
                'last_message' => [
                    'content' => $lastMessage ? $lastMessage->content : '',
                    'created_at' => $lastMessage ? $lastMessage->created_at->toIso8601String() : null,
                ],
                'unread_count' => $unreadCount,
                'is_archived' => $isArchived,
            ];
        }

        // Sort by last message time descending
        usort($result, function ($a, $b) {
            return ($b['last_message']['created_at'] ?? '') <=> ($a['last_message']['created_at'] ?? '');
        });

        return response()->json(['success' => true, 'data' => $result]);
    }

    // Apaga conversa (apenas para o usuário logado)
    public function destroy($userId)
    {
        $authUser = Auth::user();

        Message::where('sender_id', $authUser->id)
            ->where('receiver_id', $userId)
            ->update(['deleted_by_sender' => true]);

        Message::where('sender_id', $userId)
            ->where('receiver_id', $authUser->id)
            ->update(['deleted_by_receiver' => true]);

        return response()->json(['success' => true, 'message' => 'Conversa apagada com sucesso']);
    }

    // Arquiva conversa (apenas para o usuário logado)
    public function archive($userId, Request $request)
    {
        $authUser = Auth::user();
        $status = $request->input('status', true);

        Message::where('sender_id', $authUser->id)
            ->where('receiver_id', $userId)
            ->update(['archived_by_sender' => $status]);

        Message::where('sender_id', $userId)
            ->where('receiver_id', $authUser->id)
            ->update(['archived_by_receiver' => $status]);

        return response()->json(['success' => true, 'message' => $status ? 'Conversa arquivada' : 'Conversa desarquivada']);
    }

    // Limpa conversa para todos (Hard Delete)
    public function clearForEveryone($userId)
    {
        $authUser = Auth::user();

        Message::where(function ($q) use ($authUser, $userId) {
            $q->where('sender_id', $authUser->id)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($authUser, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authUser->id);
        })->delete();

        return response()->json(['success' => true, 'message' => 'Conversa removida para todos']);
    }

    // Apaga todas as conversas
    public function destroyAll()
    {
        $authUser = Auth::user();

        Message::where('sender_id', $authUser->id)->update(['deleted_by_sender' => true]);
        Message::where('receiver_id', $authUser->id)->update(['deleted_by_receiver' => true]);

        return response()->json(['success' => true, 'message' => 'Todas as conversas foram apagadas']);
    }

    // Arquiva todas as conversas
    public function archiveAll()
    {
        $authUser = Auth::user();

        Message::where('sender_id', $authUser->id)->update(['archived_by_sender' => true]);
        Message::where('receiver_id', $authUser->id)->update(['archived_by_receiver' => true]);

        return response()->json(['success' => true, 'message' => 'Todas as conversas foram arquivadas']);
    }

}
