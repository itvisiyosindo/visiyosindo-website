<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SgmPage extends Model
{
    protected $table = 'sgm_page';
    
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'company_name',
        'founded_year',
        'company_description',
        'about_text',
        'vision_text',
        'mission_items',
        'info_cards',
        'services_title',
        'services_subtitle',
        'services',
        'parent_company_name',
        'parent_company_description',
        'benefits',
        'cta_title',
        'cta_subtitle',
        'whatsapp_number',
    ];

    protected $casts = [
        'mission_items' => 'array',
        'info_cards' => 'array',
        'services' => 'array',
        'benefits' => 'array',
        'founded_year' => 'integer',
    ];
}
