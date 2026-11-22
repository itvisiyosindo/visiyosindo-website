<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('affiliate_withdrawals')) {
            Schema::create('affiliate_withdrawals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->unsignedBigInteger('amount');
                $table->string('bank_name', 100);
                $table->string('account_number', 50);
                $table->string('account_holder', 100);
                $table->string('status', 20)->default('pending')->index(); // pending, paid, rejected
                $table->text('admin_notes')->nullable();
                $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('academy_settings')) {
            Schema::create('academy_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        $now = now();
        $defaults = [
            ['key' => 'admin_whatsapp', 'value' => '6281261457547'],
            ['key' => 'bank_name', 'value' => 'Bank Mandiri'],
            ['key' => 'bank_account_number', 'value' => '137-00-1888-2929'],
            ['key' => 'bank_account_holder', 'value' => 'PT Visi Yosindo Medikal'],
            ['key' => 'affiliate_discount_percent', 'value' => '5'],
            ['key' => 'affiliate_commission_percent', 'value' => '2'],
            ['key' => 'affiliate_min_withdrawal', 'value' => '50000'],
        ];

        foreach ($defaults as $row) {
            DB::table('academy_settings')->insertOrIgnore([
                'key' => $row['key'],
                'value' => $row['value'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academy_settings');
        Schema::dropIfExists('affiliate_withdrawals');
    }
};
