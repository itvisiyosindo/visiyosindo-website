<?php

use App\Models\NewsPost;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        NewsPost::syncVisiAcademyCategoryOnce();
    }

    public function down(): void
    {
        // Intentional no-op: do not strip categories from Visi Academy news posts
    }
};
