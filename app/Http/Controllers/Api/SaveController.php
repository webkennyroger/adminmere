<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\ResolvesActivityItems;
use App\Models\SavedItem;

class SaveController extends Controller
{
    use ResolvesActivityItems;

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
