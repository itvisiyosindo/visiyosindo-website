<?php

namespace App\Support;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AcademySchemaEnsurer
{
    private static bool $ensured = false;

    /**
     * Ensure all upgraded Academy tables and columns exist idempotently.
     * Prevents QueryException when code is deployed on cPanel prior to `php artisan migrate`.
     */
    public static function ensure(): void
    {
        if (self::$ensured) {
            return;
        }
        self::$ensured = true;

        try {
            self::ensureTrainingClassesAndMaterials();
            self::ensureAffiliateCodes();
            self::ensureEnrollmentsAndCertificates();
            self::ensureWithdrawalsAndSettings();
        } catch (\Throwable $e) {
            // Silently ignore if DB user lacks DDL privileges or concurrent execution occurs
        }
    }

    private static function ensureTrainingClassesAndMaterials(): void
    {
        if (Schema::hasTable('training_classes')) {
            $missing = [
                'program_type' => !Schema::hasColumn('training_classes', 'program_type'),
                'instructor' => !Schema::hasColumn('training_classes', 'instructor'),
                'location' => !Schema::hasColumn('training_classes', 'location'),
                'delivery_mode' => !Schema::hasColumn('training_classes', 'delivery_mode'),
                'syllabus' => !Schema::hasColumn('training_classes', 'syllabus'),
                'quota' => !Schema::hasColumn('training_classes', 'quota'),
                'registration_deadline' => !Schema::hasColumn('training_classes', 'registration_deadline'),
                'is_coming_soon' => !Schema::hasColumn('training_classes', 'is_coming_soon'),
            ];

            if (in_array(true, $missing, true)) {
                Schema::table('training_classes', function (Blueprint $table) use ($missing) {
                    if ($missing['program_type']) {
                        $table->string('program_type', 30)->default('pelatihan')->after('category');
                    }
                    if ($missing['instructor']) {
                        $table->string('instructor')->nullable()->after('batch_name');
                    }
                    if ($missing['location']) {
                        $table->string('location')->nullable()->after('schedule');
                    }
                    if ($missing['delivery_mode']) {
                        $table->string('delivery_mode', 30)->default('online')->after('location');
                    }
                    if ($missing['syllabus']) {
                        $table->longText('syllabus')->nullable()->after('description');
                    }
                    if ($missing['quota']) {
                        $table->unsignedInteger('quota')->nullable()->after('price');
                    }
                    if ($missing['registration_deadline']) {
                        $table->date('registration_deadline')->nullable()->after('quota');
                    }
                    if ($missing['is_coming_soon']) {
                        $table->boolean('is_coming_soon')->default(false)->after('is_active');
                    }
                });
            }
        }

        if (!Schema::hasTable('training_materials') && Schema::hasTable('training_classes')) {
            Schema::create('training_materials', function (Blueprint $table) {
                $table->id();
                $table->foreignId('training_class_id')->constrained('training_classes')->cascadeOnDelete();
                $table->string('title');
                $table->string('type', 20)->default('pdf');
                $table->string('file_path')->nullable();
                $table->string('external_url')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    private static function ensureAffiliateCodes(): void
    {
        if (!Schema::hasTable('affiliate_codes')) {
            Schema::create('affiliate_codes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('code', 32)->unique();
                $table->unsignedInteger('discount_percent')->default(5);
                $table->unsignedInteger('commission_percent')->default(2);
                $table->unsignedInteger('usage_count')->default(0);
                $table->unsignedBigInteger('total_commission')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    private static function ensureEnrollmentsAndCertificates(): void
    {
        if (Schema::hasTable('training_enrollments')) {
            $missing = [
                'invoice_number' => !Schema::hasColumn('training_enrollments', 'invoice_number'),
                'base_price' => !Schema::hasColumn('training_enrollments', 'base_price'),
                'discount_amount' => !Schema::hasColumn('training_enrollments', 'discount_amount'),
                'final_price' => !Schema::hasColumn('training_enrollments', 'final_price'),
                'affiliate_code_id' => !Schema::hasColumn('training_enrollments', 'affiliate_code_id'),
                'affiliate_commission' => !Schema::hasColumn('training_enrollments', 'affiliate_commission'),
                'commission_awarded_at' => !Schema::hasColumn('training_enrollments', 'commission_awarded_at'),
                'payment_proof_path' => !Schema::hasColumn('training_enrollments', 'payment_proof_path'),
                'payment_proof_uploaded_at' => !Schema::hasColumn('training_enrollments', 'payment_proof_uploaded_at'),
                'rejection_reason' => !Schema::hasColumn('training_enrollments', 'rejection_reason'),
            ];

            if (in_array(true, $missing, true)) {
                Schema::table('training_enrollments', function (Blueprint $table) use ($missing) {
                    if ($missing['invoice_number']) {
                        $table->string('invoice_number', 50)->nullable()->index()->after('training_class_id');
                    }
                    if ($missing['base_price']) {
                        $table->unsignedBigInteger('base_price')->default(0)->after('payment_method');
                    }
                    if ($missing['discount_amount']) {
                        $table->unsignedBigInteger('discount_amount')->default(0)->after('base_price');
                    }
                    if ($missing['final_price']) {
                        $table->unsignedBigInteger('final_price')->default(0)->after('discount_amount');
                    }
                    if ($missing['affiliate_code_id']) {
                        $table->foreignId('affiliate_code_id')->nullable()->after('final_price')->constrained('affiliate_codes')->nullOnDelete();
                    }
                    if ($missing['affiliate_commission']) {
                        $table->unsignedBigInteger('affiliate_commission')->default(0)->after('affiliate_code_id');
                    }
                    if ($missing['commission_awarded_at']) {
                        $table->timestamp('commission_awarded_at')->nullable()->after('affiliate_commission');
                    }
                    if ($missing['payment_proof_path']) {
                        $table->string('payment_proof_path')->nullable()->after('commission_awarded_at');
                    }
                    if ($missing['payment_proof_uploaded_at']) {
                        $table->timestamp('payment_proof_uploaded_at')->nullable()->after('payment_proof_path');
                    }
                    if ($missing['rejection_reason']) {
                        $table->text('rejection_reason')->nullable()->after('notes');
                    }
                });
            }
        }

        if (Schema::hasTable('student_certificates')) {
            $missing = [
                'recipient_name' => !Schema::hasColumn('student_certificates', 'recipient_name'),
                'recipient_institution' => !Schema::hasColumn('student_certificates', 'recipient_institution'),
                'pdf_path' => !Schema::hasColumn('student_certificates', 'pdf_path'),
                'original_filename' => !Schema::hasColumn('student_certificates', 'original_filename'),
            ];

            if (in_array(true, $missing, true)) {
                Schema::table('student_certificates', function (Blueprint $table) use ($missing) {
                    if ($missing['recipient_name']) {
                        $table->string('recipient_name')->nullable()->after('verification_code');
                    }
                    if ($missing['recipient_institution']) {
                        $table->string('recipient_institution')->nullable()->after('recipient_name');
                    }
                    if ($missing['pdf_path']) {
                        $table->string('pdf_path')->nullable()->after('recipient_institution');
                    }
                    if ($missing['original_filename']) {
                        $table->string('original_filename')->nullable()->after('pdf_path');
                    }
                });
            }
        }
    }

    private static function ensureWithdrawalsAndSettings(): void
    {
        if (!Schema::hasTable('affiliate_withdrawals')) {
            Schema::create('affiliate_withdrawals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->unsignedBigInteger('amount');
                $table->string('bank_name', 100);
                $table->string('account_number', 50);
                $table->string('account_holder', 100);
                $table->string('status', 20)->default('pending')->index();
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
            ['key' => 'admin_whatsapp', 'value' => '6289507240145'],
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

        // Switch legacy CRO default number to Admin Visilab if not customized
        DB::table('academy_settings')
            ->where('key', 'admin_whatsapp')
            ->where('value', '6281261457547')
            ->update([
                'value' => '6289507240145',
                'updated_at' => $now,
            ]);
    }
}
