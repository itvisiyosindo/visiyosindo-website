<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AcademySetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public const DEFAULTS = [
        'admin_whatsapp' => '6281261457547',
        'bank_name' => 'Bank Mandiri',
        'bank_account_number' => '137-00-1888-2929',
        'bank_account_holder' => 'PT Visi Yosindo Medikal',
        'affiliate_discount_percent' => '5',
        'affiliate_commission_percent' => '2',
        'affiliate_min_withdrawal' => '50000',
    ];

    public static function getValue(string $key, ?string $default = null): string
    {
        $fallback = $default ?? (self::DEFAULTS[$key] ?? '');

        try {
            if (!Schema::hasTable('academy_settings')) {
                return (string) $fallback;
            }

            $row = self::where('key', $key)->first();
            if ($row && $row->value !== null && $row->value !== '') {
                return (string) $row->value;
            }
        } catch (\Throwable $e) {
            return (string) $fallback;
        }

        return (string) $fallback;
    }

    public static function setValue(string $key, ?string $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value ?? '']
        );
    }

    public static function allSettings(): array
    {
        $settings = self::DEFAULTS;

        try {
            if (!Schema::hasTable('academy_settings')) {
                return $settings;
            }

            $rows = self::pluck('value', 'key')->toArray();
            foreach ($rows as $key => $value) {
                if ($value !== null && $value !== '') {
                    $settings[$key] = (string) $value;
                }
            }
        } catch (\Throwable $e) {
            return self::DEFAULTS;
        }

        return $settings;
    }
}
