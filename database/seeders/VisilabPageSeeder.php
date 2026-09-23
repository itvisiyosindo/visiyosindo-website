<?php

namespace Database\Seeders;

use App\Models\VisilabPage;
use Illuminate\Database\Seeder;

class VisilabPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            // Uji Kalibrasi
            [
                'slug' => 'uji-kalibrasi',
                'name' => 'Uji Kalibrasi',
                'hero_title' => 'Uji Kalibrasi',
                'hero_description' => 'Layanan kalibrasi peralatan kesehatan untuk memastikan akurasi pengukuran dan kinerja optimal sesuai standar nasional dan internasional.',
                'intro_title' => 'Apa itu Uji Kalibrasi?',
                'intro_description' => 'Uji Kalibrasi adalah proses verifikasi dan penyesuaian untuk memastikan bahwa alat ukur atau peralatan kesehatan memberikan hasil pengukuran yang akurat sesuai dengan standar yang telah ditetapkan. Kalibrasi berkala sangat penting untuk menjaga akurasi diagnosis, treatment, dan monitoring pasien, serta memenuhi persyaratan regulasi seperti Permenkes dan standar akreditasi rumah sakit.',
                'intro_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1581093588401-fbb62a02f120?q=80&w=400&h=500&fit=crop', 'label' => 'Kalibrasi Alat Ukur', 'badge' => 'Presisi'],
                    ['url' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=400&h=500&fit=crop', 'label' => 'Sertifikat Kalibrasi', 'badge' => 'Terakreditasi'],
                    ['url' => 'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?q=80&w=400&h=500&fit=crop', 'label' => 'Alat Standar', 'badge' => 'Standar'],
                    ['url' => 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?q=80&w=400&h=500&fit=crop', 'label' => 'Teknisi Kompeten', 'badge' => 'Profesional'],
                ],
                'services_title' => 'Layanan Uji Kalibrasi Kami',
                'services_content' => [
                    [
                        'title' => 'Kalibrasi Biomedis',
                        'description' => 'Kalibrasi peralatan medis diagnostik dan monitoring seperti tensimeter, thermometer, dan pulse oximeter.',
                        'icon' => 'medical',
                        'features' => ['Tensimeter digital & analog', 'Thermometer klinis', 'Pulse oximeter & ECG'],
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Kalibrasi Dimensi',
                        'description' => 'Kalibrasi alat ukur dimensi dan geometri untuk pengukuran panjang, berat, dan volume.',
                        'icon' => 'dimension',
                        'features' => ['Timbangan medis', 'Jangka sorong & mikrometer', 'Alat ukur volume'],
                        'color' => 'cyan'
                    ],
                    [
                        'title' => 'Kalibrasi Suhu',
                        'description' => 'Kalibrasi alat pengukur dan pengontrol suhu untuk cold chain dan sterilisasi.',
                        'icon' => 'temperature',
                        'features' => ['Refrigerator & freezer', 'Inkubator & oven', 'Autoclave & sterilizer'],
                        'color' => 'sky'
                    ],
                    [
                        'title' => 'Kalibrasi Tekanan',
                        'description' => 'Kalibrasi pressure gauge dan transduser tekanan untuk berbagai aplikasi medis.',
                        'icon' => 'pressure',
                        'features' => ['Pressure gauge', 'Manometer', 'Transduser tekanan'],
                        'color' => 'indigo'
                    ],
                    [
                        'title' => 'Kalibrasi Waktu',
                        'description' => 'Kalibrasi timer dan alat pengukur waktu untuk proses medis yang time-critical.',
                        'icon' => 'time',
                        'features' => ['Stopwatch medis', 'Timer otomatis', 'Peralatan time-lapse'],
                        'color' => 'violet'
                    ],
                    [
                        'title' => 'Kalibrasi Kelistrikan',
                        'description' => 'Kalibrasi safety analyzer dan peralatan ukur kelistrikan medis.',
                        'icon' => 'electrical',
                        'features' => ['Electrical safety analyzer', 'Multimeter', 'Defibrillator analyzer'],
                        'color' => 'purple'
                    ]
                ],
                'process_title' => 'Alur Layanan Uji Kalibrasi',
                'process_steps' => [
                    [
                        'id' => 1,
                        'title' => 'Registrasi Alat',
                        'description' => 'Pendaftaran dan identifikasi peralatan yang akan dikalibrasi',
                        'detail' => 'Tim kami akan mencatat detail alat, spesifikasi teknis, dan history kalibrasi sebelumnya untuk mendokumentasikan dan merencanakan proses kalibrasi yang sesuai.',
                        'color' => 'blue'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Inspeksi Visual',
                        'description' => 'Pemeriksaan kondisi fisik dan kelengkapan peralatan',
                        'detail' => 'Teknisi melakukan inspeksi menyeluruh terhadap kondisi fisik alat, kelengkapan aksesoris, dan identifikasi potensi kerusakan yang dapat mempengaruhi akurasi pengukuran.',
                        'color' => 'cyan'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Kalibrasi',
                        'description' => 'Proses kalibrasi menggunakan standar yang terkalibrasi',
                        'detail' => 'Pelaksanaan kalibrasi sesuai prosedur standar menggunakan alat standar yang traceable ke standar nasional/internasional dengan mencatat hasil pengukuran dan ketidakpastian.',
                        'color' => 'indigo'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Sertifikat & Stiker',
                        'description' => 'Penerbitan sertifikat kalibrasi dan pemasangan stiker',
                        'detail' => 'Anda akan menerima sertifikat kalibrasi lengkap dengan data pengukuran, ketidakpastian, dan stiker kalibrasi yang menunjukkan tanggal kalibrasi berikutnya.',
                        'color' => 'purple'
                    ]
                ],
                'cta_title' => 'Butuh Layanan Uji Kalibrasi?',
                'cta_description' => 'Hubungi tim kami untuk konsultasi dan jadwalkan kalibrasi peralatan kesehatan Anda. Dapatkan sertifikat kalibrasi yang terakreditasi KAN.',
                'is_active' => true,
            ],
            // Uji Paparan
            [
                'slug' => 'uji-paparan',
                'name' => 'Uji Paparan',
                'hero_title' => 'Uji Paparan',
                'hero_description' => 'Layanan pengujian paparan radiasi untuk memastikan keamanan peralatan radiologi dan perlindungan bagi pasien serta tenaga medis.',
                'intro_title' => 'Apa itu Uji Paparan?',
                'intro_description' => 'Uji Paparan adalah proses pengujian untuk mengukur dan memverifikasi tingkat paparan radiasi yang dihasilkan oleh peralatan radiologi seperti X-Ray, CT Scan, Fluoroscopy, dan peralatan radiodiagnostik lainnya. Pengujian ini penting untuk memastikan bahwa paparan radiasi berada dalam batas aman dan sesuai dengan standar BAPETEN serta protokol keselamatan radiasi internasional.',
                'intro_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=400&h=500&fit=crop', 'label' => 'Pesawat X-Ray', 'badge' => 'Peralatan'],
                    ['url' => 'https://images.unsplash.com/photo-1559757175-5700dde675bc?q=80&w=400&h=500&fit=crop', 'label' => 'Pengukuran Dosis', 'badge' => 'Akurat'],
                    ['url' => 'https://images.unsplash.com/photo-1581594549595-35f6edc7b762?q=80&w=400&h=500&fit=crop', 'label' => 'Alat Ukur Radiasi', 'badge' => 'Standar'],
                    ['url' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?q=80&w=400&h=500&fit=crop', 'label' => 'Fisikawan Medis', 'badge' => 'Profesional'],
                ],
                'services_title' => 'Layanan Uji Paparan Kami',
                'services_content' => [
                    [
                        'title' => 'X-Ray Konvensional',
                        'description' => 'Pengujian paparan radiasi pada pesawat Rontgen konvensional termasuk mobile X-Ray.',
                        'icon' => 'xray',
                        'features' => ['Uji output radiation', 'Uji HVL (Half Value Layer)', 'Uji scatter radiation'],
                        'color' => 'orange'
                    ],
                    [
                        'title' => 'Fluoroscopy & C-Arm',
                        'description' => 'Pengujian sistem fluoroskopi untuk memastikan paparan dalam batas aman.',
                        'icon' => 'carm',
                        'features' => ['Uji entrance dose', 'Uji DAP (Dose Area Product)', 'Uji automatic brightness'],
                        'color' => 'amber'
                    ],
                    [
                        'title' => 'CT Scanner',
                        'description' => 'Pengujian paparan CT Scan meliputi CTDI dan DLP untuk optimasi dosis pasien.',
                        'icon' => 'ct',
                        'features' => ['Uji CTDI', 'Uji DLP', 'Uji image quality'],
                        'color' => 'yellow'
                    ],
                    [
                        'title' => 'Dental X-Ray',
                        'description' => 'Pengujian paparan peralatan radiografi dental termasuk panoramik dan CBCT.',
                        'icon' => 'dental',
                        'features' => ['Uji output periapical', 'Uji panoramic', 'Uji CBCT dose'],
                        'color' => 'rose'
                    ],
                    [
                        'title' => 'Mammography',
                        'description' => 'Pengujian khusus untuk sistem mammografi dengan standar ACR.',
                        'icon' => 'mammo',
                        'features' => ['Uji MGD', 'Uji AEC', 'Uji compression force'],
                        'color' => 'pink'
                    ],
                    [
                        'title' => 'Survei Area',
                        'description' => 'Pengukuran paparan radiasi di area sekitar ruangan radiologi.',
                        'icon' => 'survey',
                        'features' => ['Uji area control', 'Uji area supervisi', 'Uji shielding'],
                        'color' => 'red'
                    ]
                ],
                'process_title' => 'Alur Layanan Uji Paparan',
                'process_steps' => [
                    [
                        'id' => 1,
                        'title' => 'Survey Lokasi',
                        'description' => 'Pemetaan area dan identifikasi peralatan radiologi',
                        'detail' => 'Tim fisikawan medis kami melakukan survey lokasi untuk memetakan layout ruangan, identifikasi sumber radiasi, dan merencanakan metode pengujian yang sesuai.',
                        'color' => 'orange'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Pengukuran',
                        'description' => 'Pengukuran paparan radiasi menggunakan dosimeter kalibrasi',
                        'detail' => 'Pelaksanaan pengukuran paparan radiasi pada berbagai titik dan kondisi operasi menggunakan dosimeter yang terkalibrasi dan terakreditasi.',
                        'color' => 'amber'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Analisa Data',
                        'description' => 'Evaluasi hasil pengukuran dan perbandingan dengan standar',
                        'detail' => 'Analisis mendalam terhadap data pengukuran, perhitungan dosis, dan membandingkan dengan batas aman yang ditetapkan BAPETEN dan standar internasional.',
                        'color' => 'yellow'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Laporan & Rekomendasi',
                        'description' => 'Penyusunan laporan lengkap dan rekomendasi perbaikan',
                        'detail' => 'Anda akan menerima laporan komprehensif berisi hasil pengukuran, kesimpulan, dan rekomendasi untuk optimasi proteksi radiasi jika diperlukan.',
                        'color' => 'red'
                    ]
                ],
                'cta_title' => 'Butuh Layanan Uji Paparan?',
                'cta_description' => 'Pastikan keamanan radiasi di fasilitas kesehatan Anda. Hubungi kami untuk jadwalkan uji paparan peralatan radiologi Anda.',
                'is_active' => true,
            ],
            // Uji Kesesuaian
            [
                'slug' => 'uji-kesesuaian',
                'name' => 'Uji Kesesuaian',
                'hero_title' => 'Uji Kesesuaian',
                'hero_description' => 'Layanan pengujian kesesuaian peralatan medis untuk memastikan compliance terhadap standar regulasi nasional dan internasional.',
                'intro_title' => 'Apa itu Uji Kesesuaian?',
                'intro_description' => 'Uji Kesesuaian adalah proses pengujian untuk memverifikasi bahwa peralatan medis yang digunakan telah sesuai dengan standar keamanan, akurasi, dan kinerja yang ditetapkan oleh regulasi nasional maupun internasional. Pengujian ini memastikan bahwa peralatan layak dan aman digunakan untuk pelayanan kesehatan.',
                'intro_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1530497610245-94d3c16cda28?q=80&w=400&h=500&fit=crop', 'label' => 'Inspeksi Alat', 'badge' => 'Menyeluruh'],
                    ['url' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=400&h=500&fit=crop', 'label' => 'Pengujian Fungsi', 'badge' => 'Akurat'],
                    ['url' => 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?q=80&w=400&h=500&fit=crop', 'label' => 'Dokumentasi',  'badge' => 'Standar'],
                    ['url' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=400&h=500&fit=crop', 'label' => 'Ahli Teknik', 'badge' => 'Bersertifikat'],
                ],
                'services_title' => 'Layanan Uji Kesesuaian Kami',
                'services_content' => [
                    [
                        'title' => 'Patient Monitor',
                        'description' => 'Pengujian akurasi parameter vital seperti ECG, SpO2, NIBP, dan temperature.',
                        'icon' => 'monitor',
                        'features' => ['Uji akurasi ECG', 'Uji akurasi SpO2', 'Uji akurasi NIBP'],
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Defibrillator & AED',
                        'description' => 'Pengujian energi output, charging time, dan fungsi sinkronisasi.',
                        'icon' => 'heart',
                        'features' => ['Uji energi output', 'Uji waktu charging', 'Uji sinkronisasi'],
                        'color' => 'red'
                    ],
                    [
                        'title' => 'Electrosurgical Unit',
                        'description' => 'Pengujian power output, HF leakage current, dan fungsi keamanan.',
                        'icon' => 'zap',
                        'features' => ['Uji power output', 'Uji HF leakage', 'Uji keamanan CQM'],
                        'color' => 'purple'
                    ],
                    [
                        'title' => 'Infusion & Syringe Pump',
                        'description' => 'Pengujian akurasi flow rate, occlusion detection, dan sistem alarm.',
                        'icon' => 'droplet',
                        'features' => ['Uji flow rate', 'Uji occlusion', 'Uji sistem alarm'],
                        'color' => 'cyan'
                    ],
                    [
                        'title' => 'Ventilator',
                        'description' => 'Pengujian volume, pressure, flow, dan akurasi FiO2.',
                        'icon' => 'wind',
                        'features' => ['Uji volume tidal', 'Uji pressure', 'Uji FiO2'],
                        'color' => 'green'
                    ],
                    [
                        'title' => 'Electrical Safety Test',
                        'description' => 'Pengujian keamanan listrik meliputi earth leakage dan patient leakage.',
                        'icon' => 'shield',
                        'features' => ['Earth leakage test', 'Enclosure leakage', 'Patient leakage'],
                        'color' => 'orange'
                    ]
                ],
                'process_title' => 'Alur Layanan Uji Kesesuaian',
                'process_steps' => [
                    [
                        'id' => 1,
                        'title' => 'Persiapan',
                        'description' => 'Verifikasi dokumen dan persiapan alat uji',
                        'detail' => 'Kami melakukan verifikasi dokumen peralatan, spesifikasi teknis, dan mempersiapkan alat uji serta simulator yang diperlukan untuk pengujian kesesuaian.',
                        'color' => 'blue'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Inspeksi Visual',
                        'description' => 'Pemeriksaan kondisi fisik dan label keselamatan',
                        'detail' => 'Teknisi melakukan inspeksi visual menyeluruh terhadap kondisi fisik, label keselamatan, grounding, dan kelengkapan aksesoris peralatan medis.',
                        'color' => 'cyan'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Pengujian Fungsi',
                        'description' => 'Pengujian performa dan akurasi parameter',
                        'detail' => 'Pelaksanaan serangkaian pengujian fungsi sesuai standar untuk memverifikasi akurasi, keamanan listrik, dan performa peralatan sesuai spesifikasi pabrik.',
                        'color' => 'indigo'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Sertifikat',
                        'description' => 'Penerbitan sertifikat uji kesesuaian',
                        'detail' => 'Anda akan menerima sertifikat uji kesesuaian lengkap dengan hasil pengujian, kesimpulan pass/fail, dan rekomendasi maintenance jika diperlukan.',
                        'color' => 'purple'
                    ]
                ],
                'cta_title' => 'Butuh Layanan Uji Kesesuaian?',
                'cta_description' => 'Pastikan peralatan medis Anda memenuhi standar. Hubungi kami untuk konsultasi dan jadwalkan uji kesesuaian.',
                'is_active' => true,
            ],
            // PPR (Pelatihan Petugas Radiasi)
            [
                'slug' => 'ppr',
                'name' => 'Pelatihan Petugas Radiasi (PPR)',
                'hero_title' => 'Pelatihan Petugas Radiasi',
                'hero_description' => 'Program pelatihan komprehensif untuk petugas proteksi radiasi di fasilitas kesehatan sesuai regulasi BAPETEN.',
                'intro_title' => 'Apa itu PPR?',
                'intro_description' => 'Pelatihan Petugas Radiasi (PPR) adalah program pelatihan yang dirancang khusus untuk membekali peserta dengan pengetahuan dan keterampilan dalam pengelolaan radiasi di fasilitas kesehatan. Program ini sesuai dengan regulasi BAPETEN dan standar keselamatan radiasi internasional.',
                'intro_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=400&h=500&fit=crop', 'label' => 'Materi Pelatihan', 'badge' => 'Komprehensif'],
                    ['url' => 'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?q=80&w=400&h=500&fit=crop', 'label' => 'Instruktur Ahli', 'badge' => 'Berpengalaman'],
                    ['url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=400&h=500&fit=crop', 'label' => 'Praktik Lapangan', 'badge' => 'Praktikal'],
                    ['url' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=400&h=500&fit=crop', 'label' => 'Sertifikat', 'badge' => 'Terakreditasi'],
                ],
                'services_title' => 'Informasi Lengkap',
                'process_title' => 'Alur Layanan PPR',
                'cta_title' => 'Daftar Sekarang',
                'cta_description' => 'Jangan lewatkan kesempatan untuk mengikuti program Pelatihan Petugas Radiasi. Daftar sekarang dan tingkatkan karir Anda di bidang radiasi medis!',
                'additional_data' => [
                    'pricing' => [
                        'regular' => 5000000,
                        'early_bird' => 4500000,
                        'group_rate' => 4250000,
                        'group_min' => 5
                    ],
                    'duration' => '5 Hari',
                    'schedule' => 'Setiap bulan',
                    'max_participants' => 30,
                    'facilities' => [
                        'Modul & Materi Lengkap',
                        'Coffee Break & Makan Siang',
                        'Sertifikat Resmi',
                        'Training Kit',
                        'Akses Lab Praktikum'
                    ],
                    'requirements' => [
                        'Fotokopi KTP',
                        'Fotokopi Ijazah Terakhir',
                        'Pas Foto 3x4 (2 lembar)',
                        'Surat Tugas dari Instansi'
                    ],
                    'target_participants' => [
                        'Radiografer',
                        'Dokter Radiologi',
                        'Fisikawan Medis',
                        'Petugas Proteksi Radiasi'
                    ],
                    'benefits' => [
                        ['title' => 'Sertifikasi Resmi', 'description' => 'Sertifikat terakreditasi BAPETEN yang diakui nasional'],
                        ['title' => 'Peningkatan Karir', 'description' => 'Membuka peluang karir lebih baik di bidang radiasi'],
                        ['title' => 'Kompetensi Standar', 'description' => 'Memenuhi standar kompetensi petugas proteksi radiasi'],
                        ['title' => 'Networking', 'description' => 'Kesempatan networking dengan profesional lainnya']
                    ],
                    'materials' => [
                        'Dasar-dasar Fisika Radiasi',
                        'Biologi Radiasi & Efek Radiasi',
                        'Deteksi & Pengukuran Radiasi',
                        'Proteksi Radiasi Eksternal',
                        'Proteksi Radiasi Internal',
                        'Keselamatan Radiasi di Radiodiagnostik',
                        'Keselamatan Radiasi di Radioterapi',
                        'Keselamatan Radiasi di Kedokteran Nuklir',
                        'Manajemen Limbah Radioaktif',
                        'Aspek Regulasi & Perizinan',
                        'Kedaruratan Radiasi',
                        'Praktik Lapangan'
                    ]
                ],
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            VisilabPage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
