<?php

namespace Database\Seeders;

use App\Models\StudentCertificate;
use App\Models\TrainingClass;
use App\Models\TrainingEnrollment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrainingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Sample Training Classes
        $classes = [
            [
                'title' => 'Pelatihan Petugas Proteksi Radiasi (PPR) Medik Tk II',
                'slug' => 'ppr-medik-tk-ii-batch-7',
                'category' => 'PPR',
                'batch_name' => 'Batch 7 - Desember 2026',
                'description' => 'Program pelatihan komprehensif bagi calon Petugas Proteksi Radiasi di instalasi radiologi diagnostik dan intervensional sesuai kurikulum & standar regulasi BAPETEN.',
                'price' => 6000000,
                'duration' => '5 Hari Pelatihan',
                'schedule' => '2 - 6 Desember 2026 (08.00 - 16.30 WIB)',
                'whatsapp_group_link' => 'https://chat.whatsapp.com/demo-visilab-ppr7',
                'materials_link' => 'https://drive.google.com/drive/folders/demo-visilab-materials',
                'is_active' => true,
            ],
            [
                'title' => 'Pelatihan Kalibrasi & Uji Kelayakan Peralatan Elektromedis',
                'slug' => 'kalibrasi-elektromedis-batch-4',
                'category' => 'Kalibrasi',
                'batch_name' => 'Batch 4 - Januari 2027',
                'description' => 'Pelatihan praktek intensif prosedur kalibrasi vital signs monitor, syringe pump, centrifuge, incubator, dan electrical safety test sesuai standar Kemenkes.',
                'price' => 2500000,
                'duration' => '3 Hari Praktek',
                'schedule' => '15 - 17 Januari 2027 (09.00 - 16.00 WIB)',
                'whatsapp_group_link' => 'https://chat.whatsapp.com/demo-visilab-kalibrasi4',
                'materials_link' => null,
                'is_active' => true,
            ],
            [
                'title' => 'Pelatihan Uji Kesesuaian Pesawat Sinar-X Radiologi',
                'slug' => 'uji-kesesuaian-sinar-x-batch-2',
                'category' => 'Uji Kesesuaian',
                'batch_name' => 'Batch 2 - Februari 2027',
                'description' => 'Mendalami teknik verifikasi keamanan paparan radiasi, kolimasi, kVp accuracy, HVL, dan kinerja tabung sinar-X konvensional maupun digital.',
                'price' => 3500000,
                'duration' => '4 Hari Pelatihan & Lab',
                'schedule' => '10 - 13 Februari 2027 (08.30 - 16.00 WIB)',
                'whatsapp_group_link' => null,
                'materials_link' => null,
                'is_active' => true,
            ],
        ];

        $createdClasses = [];
        foreach ($classes as $data) {
            $createdClasses[] = TrainingClass::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        // 2. Create Demo Student Account
        $student = User::firstOrCreate(
            ['email' => 'pelajar@visiyosindo.com'],
            [
                'name' => 'Ahmad Fauzi, S.Tr.Kes',
                'phone' => '081298765432',
                'institution' => 'RSUD Dr. M. Djamil Padang',
                'profession' => 'Radiografer Senior',
                'address' => 'Jl. Perintis Kemerdekaan No. 14, Padang, Sumatera Barat',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_STUDENT,
                'is_active' => true,
            ]
        );

        // 3. Create Sample Completed Enrollment & Certificate
        if (isset($createdClasses[0])) {
            $enrollment1 = TrainingEnrollment::firstOrCreate(
                [
                    'user_id' => $student->id,
                    'training_class_id' => $createdClasses[0]->id,
                ],
                [
                    'status' => TrainingEnrollment::STATUS_COMPLETED,
                    'approved_at' => now()->subDays(10),
                    'completed_at' => now()->subDays(2),
                ]
            );

            StudentCertificate::firstOrCreate(
                ['training_enrollment_id' => $enrollment1->id],
                [
                    'user_id' => $student->id,
                    'training_class_id' => $createdClasses[0]->id,
                    'certificate_number' => 'CERT/VISILAB/' . date('Y/m') . '/0001',
                    'verification_code' => 'VSI-PPR-779812',
                    'issued_date' => now()->subDays(2)->toDateString(),
                ]
            );
        }

        // 4. Create Sample Pending Enrollment (waiting for WA payment)
        if (isset($createdClasses[1])) {
            TrainingEnrollment::firstOrCreate(
                [
                    'user_id' => $student->id,
                    'training_class_id' => $createdClasses[1]->id,
                ],
                [
                    'status' => TrainingEnrollment::STATUS_PENDING,
                ]
            );
        }
    }
}
