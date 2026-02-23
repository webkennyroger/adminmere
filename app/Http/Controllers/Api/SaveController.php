<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SavedItem;

class SaveController extends Controller
{
    protected function resolveItem($id)
    {
        if (str_starts_with($id, 'post_') || str_starts_with($id, 'poll_')) {
            $realId = str_replace(['post_', 'poll_'], '', $id);
            return \App\Models\Post::findOrFail($realId);
        }

        if (str_starts_with($id, 'activity_')) {
            $realId = str_replace('activity_', '', $id);
            return \App\Models\Activity::findOrFail($realId);
        }

        // Fallback
        return \App\Models\Post::find($id) ?? \App\Models\Activity::findOrFail($id);
    }

    /**
     * Toggle save on an item (post, poll, activity).
     */
    public function toggleSave(Request $request, $id)
    {
        $item = $this->resolveItem($id);
        $user = $request->user();

        $existingSave = SavedItem::where('user_id', $user->id)
            ->where('saved_item_id', $item->id)
            ->where('saved_item_type', get_class($item))
            ->first();

        if ($existingSave) {
            $existingSave->delete();
            $isSaved = false;
        } else {
            SavedItem::create([
                'user_id' => $user->id,
                'saved_item_id' => $item->id,
                'saved_item_type' => get_class($item),
            ]);
            $isSaved = true;
        }

        return response()->json([
            'success' => true,
            'is_saved' => $isSaved,
        ]);
    }
}
