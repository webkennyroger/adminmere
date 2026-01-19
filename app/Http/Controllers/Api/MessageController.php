<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        $messages = Message::where(function($query) use ($authUser, $userId) {
                $query->where(function($q) use ($authUser, $userId) {
                    $q->where('sender_id', $authUser->id)
                      ->where('receiver_id', $userId);
                })->orWhere(function($q) use ($authUser, $userId) {
                    $q->where('sender_id', $userId)
                      ->where('receiver_id', $authUser->id);
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
        $data = $request->only(['recipient_id', 'content']);
        $validator = Validator::make($data, [
            'recipient_id' => 'required|exists:users,id|different:' . $authUser->id,
            'content' => 'required|string|max:2000',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        $message = Message::create([
            'sender_id' => $authUser->id,
            'receiver_id' => $data['recipient_id'],
            'content' => $data['content'],
        ]);
        // TODO: disparar evento/notification se necessário
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
        $conversations = Message::selectRaw('IF(sender_id = receiver_id, NULL, IF(sender_id = ' . $authUser->id . ', receiver_id, sender_id)) as user_id, MAX(created_at) as last_message_at')
            ->where(function($q) use ($authUser) {
                $q->where('sender_id', $authUser->id)
                  ->orWhere('receiver_id', $authUser->id);
            })
            ->groupBy('user_id')
            ->orderByDesc('last_message_at')
            ->get();
        $userIds = $conversations->pluck('user_id')->filter()->all();
        $users = !empty($userIds) ? User::whereIn('id', $userIds)->get()->keyBy('id') : collect();
        $result = $conversations->map(function($conv) use ($users) {
            return [
                'user' => $users[$conv->user_id] ?? null,
                'last_message_at' => $conv->last_message_at,
            ];
        });
        return response()->json(['success' => true, 'data' => $result]);
    }
}
