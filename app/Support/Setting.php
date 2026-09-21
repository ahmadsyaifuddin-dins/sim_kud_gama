<?php

namespace App\Support;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Cache;

class Setting
{
    /**
     * Baca satu pengaturan. Cache 1 jam untuk mengurangi query berulang.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = Cache::remember('setting.value:'.$key, 3600, function () use ($key) {
            return optional(AppSetting::where('key', $key)->first())->value;
        });

        if ($value === null) {
            return $default;
        }

        return $value;
    }

    /**
     * Simpan / perbarui satu pengaturan lalu bersihkan cache-nya.
     */
    public static function set(string $key, mixed $value, string $group = 'general', ?string $label = null): void
    {
        AppSetting::updateOrCreate(['key' => $key], [
            'value' => (string) $value,
            'group' => $group,
            'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
        ]);

        Cache::forget('setting.value:'.$key);
    }
}