<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'history_title',
        'history_content',
        'history_stat_years',
        'history_stat_clients',
        'history_stat_professionals',
        'vision_title',
        'vision_content',
        'mission_title',
        'mission_items',
        'values_title',
        'values_items',
        'coverage_title',
        'coverage_description',
        'coverage_stat_provinces',
        'coverage_stat_hospitals',
        'coverage_stat_clinics',
        'coverage_stat_cities',
    ];

    protected $casts = [
        'mission_items' => 'array',
        'values_items' => 'array',
        'history_stat_years' => 'integer',
        'history_stat_clients' => 'integer',
        'history_stat_professionals' => 'integer',
        'coverage_stat_provinces' => 'integer',
        'coverage_stat_hospitals' => 'integer',
        'coverage_stat_clinics' => 'integer',
        'coverage_stat_cities' => 'integer',
    ];

    /**
     * Get the company info singleton
     * There should only be one record
     */
    public static function getInfo()
    {
        return static::firstOrCreate([]);
    }
}
