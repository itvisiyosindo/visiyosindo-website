<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('training_enrollments')) {
            Schema::table('training_enrollments', function (Blueprint $table) {
                if (!Schema::hasColumn('training_enrollments', 'invoice_number')) {
                    $table->string('invoice_number', 50)->nullable()->index()->after('training_class_id');
                }
                if (!Schema::hasColumn('training_enrollments', 'base_price')) {
                    $table->unsignedBigInteger('base_price')->default(0)->after('payment_method');
                }
                if (!Schema::hasColumn('training_enrollments', 'discount_amount')) {
                    $table->unsignedBigInteger('discount_amount')->default(0)->after('base_price');
                }
                if (!Schema::hasColumn('training_enrollments', 'final_price')) {
                    $table->unsignedBigInteger('final_price')->default(0)->after('discount_amount');
                }
                if (!Schema::hasColumn('training_enrollments', 'affiliate_code_id')) {
                    $table->foreignId('affiliate_code_id')->nullable()->after('final_price')->constrained('affiliate_codes')->nullOnDelete();
                }
                if (!Schema::hasColumn('training_enrollments', 'affiliate_commission')) {
                    $table->unsignedBigInteger('affiliate_commission')->default(0)->after('affiliate_code_id');
                }
                if (!Schema::hasColumn('training_enrollments', 'commission_awarded_at')) {
                    $table->timestamp('commission_awarded_at')->nullable()->after('affiliate_commission');
                }
                if (!Schema::hasColumn('training_enrollments', 'payment_proof_path')) {
                    $table->string('payment_proof_path')->nullable()->after('commission_awarded_at');
                }
                if (!Schema::hasColumn('training_enrollments', 'payment_proof_uploaded_at')) {
                    $table->timestamp('payment_proof_uploaded_at')->nullable()->after('payment_proof_path');
                }
                if (!Schema::hasColumn('training_enrollments', 'rejection_reason')) {
                    $table->text('rejection_reason')->nullable()->after('notes');
                }
            });
        }

        if (Schema::hasTable('student_certificates')) {
            Schema::table('student_certificates', function (Blueprint $table) {
                if (!Schema::hasColumn('student_certificates', 'recipient_name')) {
                    $table->string('recipient_name')->nullable()->after('verification_code');
                }
                if (!Schema::hasColumn('student_certificates', 'recipient_institution')) {
                    $table->string('recipient_institution')->nullable()->after('recipient_name');
                }
                if (!Schema::hasColumn('student_certificates', 'pdf_path')) {
                    $table->string('pdf_path')->nullable()->after('recipient_institution');
                }
                if (!Schema::hasColumn('student_certificates', 'original_filename')) {
                    $table->string('original_filename')->nullable()->after('pdf_path');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('student_certificates')) {
            Schema::table('student_certificates', function (Blueprint $table) {
                foreach (['recipient_name', 'recipient_institution', 'pdf_path', 'original_filename'] as $col) {
                    if (Schema::hasColumn('student_certificates', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('training_enrollments')) {
            Schema::table('training_enrollments', function (Blueprint $table) {
                if (Schema::hasColumn('training_enrollments', 'affiliate_code_id')) {
                    $table->dropConstrainedForeignId('affiliate_code_id');
                }
                $cols = [
                    'invoice_number',
                    'base_price',
                    'discount_amount',
                    'final_price',
                    'affiliate_commission',
                    'commission_awarded_at',
                    'payment_proof_path',
                    'payment_proof_uploaded_at',
                    'rejection_reason',
                ];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('training_enrollments', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
