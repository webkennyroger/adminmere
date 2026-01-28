<?php

if (!function_exists('profile_url')) {
    /**
     * Generate profile URL using nickname
     *
     * @param \App\Models\User|int $user
     * @return string
     */
    function profile_url($user)
    {
        if (is_numeric($user)) {
            $user = \App\Models\User::find($user);
        }
        
        if (!$user) {
            return url('/@unknown');
        }
        
        $nickname = $user->profile?->nickname ?? $user->id;
        return url('/@' . $nickname);
    }
}
