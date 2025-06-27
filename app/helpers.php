<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('throttleUploads')) {
    function throttleUploads() {
        $uploads_per_minute = config('consts.throttle.uploads_per_minute', 10);
        return "throttle:$uploads_per_minute,1,uploads";
    }
}

if (!function_exists('createNotification')) {
    function createNotification(
        $user_id,
        $message,
        $from_id = null,
        $link = null
    ) {
        \App\Notification::firstOrCreate([
            'user_id' => $user_id,
            'message' => $message,
            'from_id' => $from_id,
            'link' => $link,
        ]);
    }
}

if (!function_exists('getAuthUser')) {
    function getAuthUser() {
        $user = auth()->user();

        if (!$user) {
            $user = sanctumUser();
        }

        return $user;
    }
}

if (!function_exists('checkAuthUser')) {
    function checkAuthUser() {
        return auth()->check() || sanctumCheck();
    }
}

if (!function_exists('sanctumCheck')) {
    function sanctumCheck() {
        return Auth::guard('sanctum')->check();
    }
}

if (!function_exists('sanctumUser')) {
    function sanctumUser() {
        return Auth::guard('sanctum')->user();
    }
}
