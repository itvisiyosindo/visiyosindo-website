<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Lowongan Kerja', 'url' => route('dashboard.careers.index')],
        ['label' => $vacancy->title, 'url' => route('dashboard.careers.applicants.index', $vacancy->encrypted_id)],
        ['label' => $applicant->full_name]
    ]"
    :title="'Detail Pelamar - ' . $applicant->full_name"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Detail Pelamar</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    Melamar: <span class="font-semibold text-surface-700 dark:text-surface-300">{{ $vacancy->title }}</span>
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.careers.applicants.index', $vacancy->encrypted_id) }}">
                    <x-dashboard.button variant="secondary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <div x-data="{
        previewModal: {
            show: false,
            title: '',
            type: '',
            downloadUrl: '',
            previewUrl: '',
            loading: true,
            error: false
        },
        previewDocument(doc) {
            this.previewModal = {
                show: true,
                title: doc.title,
                type: doc.type,
                downloadUrl: doc.downloadUrl,
                previewUrl: doc.previewUrl,
                loading: true,
                error: false
            };
        },
        closePreview() {
            this.previewModal.show = false;
        }
    }">
    <div class="grid lg:grid-cols-[1fr_300px] gap-5">
        {{-- Main Info --}}
        <div class="space-y-6">
            {{-- Data Diri --}}
            <x-dashboard.card>
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Data Diri
                </h2>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Nama Lengkap</p>
                        <p class="text-sm font-semibold text-surface-900 dark:text-white">{{ $applicant->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Email</p>
                        <p class="text-sm text-surface-700 dark:text-surface-300">
                            <a href="mailto:{{ $applicant->email }}" class="text-primary-600 hover:underline">{{ $applicant->email }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">No. Telepon</p>
                        <p class="text-sm text-surface-700 dark:text-surface-300">
                            <a href="tel:{{ $applicant->phone }}" class="text-primary-600 hover:underline">{{ $applicant->phone }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Tanggal Lahir</p>
                        <p class="text-sm text-surface-700 dark:text-surface-300">{{ $applicant->birth_date->format('d F Y') }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Alamat</p>
                        <p class="text-sm text-surface-700 dark:text-surface-300">{{ $applicant->address }}</p>
                    </div>
                </div>
            </x-dashboard.card>

            {{-- Pendidikan --}}
            <x-dashboard.card>
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Pendidikan & Pengalaman
                </h2>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Pendidikan Terakhir</p>
                        <p class="text-sm font-semibold text-surface-900 dark:text-white">{{ $applicant->education }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Jurusan</p>
                        <p class="text-sm text-surface-700 dark:text-surface-300">{{ $applicant->major }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Institusi</p>
                        <p class="text-sm text-surface-700 dark:text-surface-300">{{ $applicant->institution }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Tahun Lulus</p>
                        <p class="text-sm text-surface-700 dark:text-surface-300">{{ $applicant->graduation_year }}</p>
                    </div>
                    @if($applicant->last_job)
                        <div>
                            <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Pekerjaan Terakhir</p>
                            <p class="text-sm text-surface-700 dark:text-surface-300">{{ $applicant->last_job }}</p>
                        </div>
                    @endif
                    @if($applicant->work_experience)
                        <div class="sm:col-span-2">
                            <p class="text-xs text-surface-400 uppercase tracking-wide mb-1">Pengalaman Kerja</p>
                            <p class="text-sm text-surface-700 dark:text-surface-300 whitespace-pre-line">{{ $applicant->work_experience }}</p>
                        </div>
                    @endif
                </div>
            </x-dashboard.card>

            {{-- Dokumen --}}
            <x-dashboard.card>
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Dokumen
                </h2>

                <div class="grid sm:grid-cols-3 gap-4">
                    {{-- CV --}}
                    <div class="p-4 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800/50">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center text-primary-600 dark:text-primary-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-surface-900 dark:text-white">CV / Resume</p>
                                <p class="text-xs text-surface-400">{{ $applicant->cv_path ? 'Tersedia' : 'Tidak ada' }}</p>
                            </div>
                        </div>
                        @if($applicant->cv_path)
                            <div class="flex gap-2">
                                <button 
                                    @click="previewDocument({
                                        title: 'CV / Resume - {{ $applicant->full_name }}',
                                        type: 'CV',
                                        downloadUrl: '{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'cv']) }}',
                                        previewUrl: '{{ route('dashboard.careers.applicants.preview', [$vacancy->encrypted_id, $applicant->encrypted_id, 'cv']) }}'
                                    })"
                                    class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </button>
                                <a href="{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'cv']) }}" 
                                   class="inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-primary-600 hover:text-primary-700 border border-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <p class="text-xs text-surface-400 italic">Dokumen tidak tersedia</p>
                        @endif
                    </div>

                    {{-- Transkrip Nilai --}}
                    <div class="p-4 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800/50">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-surface-900 dark:text-white">Transkrip Nilai</p>
                                <p class="text-xs text-surface-400">{{ $applicant->transcript_path ? 'Tersedia' : 'Tidak ada' }}</p>
                            </div>
                        </div>
                        @if($applicant->transcript_path)
                            <div class="flex gap-2">
                                <button 
                                    @click="previewDocument({
                                        title: 'Transkrip Nilai - {{ $applicant->full_name }}',
                                        type: 'Transkrip',
                                        downloadUrl: '{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'transcript']) }}',
                                        previewUrl: '{{ route('dashboard.careers.applicants.preview', [$vacancy->encrypted_id, $applicant->encrypted_id, 'transcript']) }}'
                                    })"
                                    class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </button>
                                <a href="{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'transcript']) }}" 
                                   class="inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-green-600 hover:text-green-700 border border-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <p class="text-xs text-surface-400 italic">Dokumen tidak tersedia</p>
                        @endif
                    </div>

                    {{-- Ijazah --}}
                    <div class="p-4 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800/50">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-surface-900 dark:text-white">Ijazah</p>
                                <p class="text-xs text-surface-400">{{ $applicant->ijazah_path ? 'Tersedia' : 'Tidak ada' }}</p>
                            </div>
                        </div>
                        @if($applicant->ijazah_path)
                            <div class="flex gap-2">
                                <button 
                                    @click="previewDocument({
                                        title: 'Ijazah - {{ $applicant->full_name }}',
                                        type: 'Ijazah',
                                        downloadUrl: '{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'ijazah']) }}',
                                        previewUrl: '{{ route('dashboard.careers.applicants.preview', [$vacancy->encrypted_id, $applicant->encrypted_id, 'ijazah']) }}'
                                    })"
                                    class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-lg transition-colors"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </button>
                                <a href="{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'ijazah']) }}" 
                                   class="inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-600 hover:text-amber-700 border border-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <p class="text-xs text-surface-400 italic">Dokumen tidak tersedia</p>
                        @endif
                    </div>
                </div>
            </x-dashboard.card>

            {{-- Screening AI Result --}}
            <x-dashboard.card>
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Hasil Screening Otomatis
                </h2>

                @php
                    $score = $applicant->match_score ?? 0;
                    $badge = \App\Services\ApplicationScreeningService::getRecommendationBadge($applicant->recommendation ?? 'not_recommended');
                    $details = is_string($applicant->screening_details) ? json_decode($applicant->screening_details, true) : $applicant->screening_details;
                    $normalizeList = function ($value): array {
                        if (!is_array($value)) {
                            return [];
                        }

                        return array_values(array_filter(array_map(function ($item) {
                            if (is_scalar($item) || $item === null) {
                                return $item === null ? null : (string) $item;
                            }

                            return is_array($item) ? json_encode($item) : null;
                        }, $value), fn ($item) => $item !== null && $item !== ''));
                    };

                    $educationBreakdown = $details['education_breakdown'] ?? null;
                    if (is_array($educationBreakdown)) {
                        $educationBreakdown = implode(', ', $normalizeList($educationBreakdown));
                    } elseif (!is_string($educationBreakdown)) {
                        $educationBreakdown = null;
                    }

                    $majorKeywords = $normalizeList($details['major_keywords'] ?? []);
                    $matchedSkills = $normalizeList($details['matched_skills'] ?? []);
                    $missingSkills = $normalizeList($details['missing_skills'] ?? []);
                    $experienceYears = $details['experience_years'] ?? null;
                    if (is_array($experienceYears)) {
                        $experienceYears = implode(', ', $normalizeList($experienceYears));
                    } elseif (!is_scalar($experienceYears) && $experienceYears !== null) {
                        $experienceYears = null;
                    }
                @endphp

                {{-- Overall Score --}}
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-surface-600 dark:text-surface-400 mb-1">Skor Kesesuaian Keseluruhan</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($score, 1) }}%</span>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium {{ $badge['class'] }}">
                                    <span>{{ $badge['icon'] }}</span>
                                    <span>{{ $badge['label'] }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="relative w-24 h-24">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-surface-200 dark:text-surface-700" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                <path class="text-indigo-500" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="{{ $score }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                            </svg>
                            <span class="absolute inset-0 flex items-center justify-center text-sm font-bold text-surface-700 dark:text-surface-300">{{ number_format($score, 0) }}%</span>
                        </div>
                    </div>
                    @if($applicant->screened_at)
                        <p class="text-xs text-surface-500 dark:text-surface-400">
                            Screening otomatis dilakukan pada {{ $applicant->screened_at->format('d M Y H:i') }}
                        </p>
                    @endif
                </div>

                {{-- Detailed Scores --}}
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-surface-700 dark:text-surface-300 mb-3">Breakdown Penilaian</h3>
                    
                    {{-- Education Match --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-surface-700 dark:text-surface-300">Pendidikan</span>
                            <span class="text-sm font-semibold text-surface-900 dark:text-white">{{ number_format($applicant->education_match ?? 0, 0) }}%</span>
                        </div>
                        <div class="w-full bg-surface-200 dark:bg-surface-700 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full transition-all" style="width: {{ $applicant->education_match ?? 0 }}%"></div>
                        </div>
                        @if($educationBreakdown)
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">{{ $educationBreakdown }}</p>
                        @endif
                    </div>

                    {{-- Major Match --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-surface-700 dark:text-surface-300">Jurusan</span>
                            <span class="text-sm font-semibold text-surface-900 dark:text-white">{{ number_format($applicant->major_match ?? 0, 0) }}%</span>
                        </div>
                        <div class="w-full bg-surface-200 dark:bg-surface-700 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all" style="width: {{ $applicant->major_match ?? 0 }}%"></div>
                        </div>
                        @if(count($majorKeywords) > 0)
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">Kata kunci relevan: {{ implode(', ', array_slice($majorKeywords, 0, 5)) }}</p>
                        @endif
                    </div>

                    {{-- Skills Match --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-surface-700 dark:text-surface-300">Keterampilan</span>
                            <span class="text-sm font-semibold text-surface-900 dark:text-white">{{ number_format($applicant->skill_match ?? 0, 0) }}%</span>
                        </div>
                        <div class="w-full bg-surface-200 dark:bg-surface-700 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full transition-all" style="width: {{ $applicant->skill_match ?? 0 }}%"></div>
                        </div>
                        @if($details)
                            <div class="flex gap-4 mt-2">
                                @if(count($matchedSkills) > 0)
                                    <div class="flex-1">
                                        <p class="text-xs font-medium text-green-600 dark:text-green-400 mb-1">✓ Ditemukan ({{ count($matchedSkills) }})</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($matchedSkills, 0, 6) as $skill)
                                                <span class="inline-block px-2 py-0.5 text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded">{{ $skill }}</span>
                                            @endforeach
                                            @if(count($matchedSkills) > 6)
                                                <span class="text-xs text-surface-400">+{{ count($matchedSkills) - 6 }} lainnya</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if(count($missingSkills) > 0)
                                    <div class="flex-1">
                                        <p class="text-xs font-medium text-red-600 dark:text-red-400 mb-1">✗ Belum ditemukan ({{ count($missingSkills) }})</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($missingSkills, 0, 6) as $skill)
                                                <span class="inline-block px-2 py-0.5 text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded">{{ $skill }}</span>
                                            @endforeach
                                            @if(count($missingSkills) > 6)
                                                <span class="text-xs text-surface-400">+{{ count($missingSkills) - 6 }} lainnya</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Experience Match --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-surface-700 dark:text-surface-300">Pengalaman</span>
                            <span class="text-sm font-semibold text-surface-900 dark:text-white">{{ number_format($applicant->experience_match ?? 0, 0) }}%</span>
                        </div>
                        <div class="w-full bg-surface-200 dark:bg-surface-700 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full transition-all" style="width: {{ $applicant->experience_match ?? 0 }}%"></div>
                        </div>
                        @if($experienceYears !== null && $experienceYears !== '')
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">Pengalaman kerja: {{ $experienceYears }} tahun</p>
                        @endif
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-1">Tentang Screening Otomatis</p>
                            <p class="text-xs text-blue-700 dark:text-blue-400 leading-relaxed">
                                Sistem melakukan screening otomatis berdasarkan kesesuaian pendidikan (25%), jurusan (30%), keterampilan (30%), dan pengalaman kerja (15%). Skor di atas 80% dikategorikan sebagai <strong>"Sangat Direkomendasikan"</strong>, 65-79% sebagai <strong>"Direkomendasikan"</strong>, 50-64% sebagai <strong>"Pertimbangkan"</strong>, dan di bawah 50% sebagai <strong>"Tidak Direkomendasikan"</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </x-dashboard.card>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Management --}}
            <x-dashboard.card x-data="{
                status: '{{ $applicant->status }}',
                notes: '{{ addslashes($applicant->notes ?? '') }}',
                saving: false,
                saved: false,
                saveStatus() {
                    this.saving = true;
                    this.saved = false;
                    fetch('{{ route('dashboard.careers.applicants.update-status', [$vacancy->encrypted_id, $applicant->encrypted_id]) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: this.status, notes: this.notes })
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.saving = false;
                        if (data.success) {
                            this.saved = true;
                            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: 'Status dan catatan berhasil disimpan.' } }));
                        }
                        setTimeout(() => this.saved = false, 3000);
                    })
                    .catch(() => {
                        this.saving = false;
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal menyimpan status dan catatan.' } }));
                    });
                }
            }">
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Status & Catatan
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Status Lamaran</label>
                        <select 
                            x-model="status"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                            @foreach(\App\Models\JobApplication::STATUS_LABELS as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Catatan Internal</label>
                        <textarea 
                            x-model="notes" rows="4"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Catatan tentang pelamar ini..."
                        ></textarea>
                    </div>

                    <button 
                        @click="saveStatus()" :disabled="saving"
                        class="w-full px-4 py-2.5 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors disabled:opacity-50"
                    >
                        <span x-show="!saving && !saved">Simpan Perubahan</span>
                        <span x-show="saving">Menyimpan...</span>
                        <span x-show="saved" class="text-green-100">Tersimpan!</span>
                    </button>
                </div>
            </x-dashboard.card>

            {{-- Timeline --}}
            <x-dashboard.card>
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Info Waktu
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-surface-500 dark:text-surface-400">Tanggal Melamar</span>
                        <span class="font-medium text-surface-900 dark:text-white">{{ $applicant->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-surface-500 dark:text-surface-400">Update Terakhir</span>
                        <span class="font-medium text-surface-900 dark:text-white">{{ $applicant->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-surface-500 dark:text-surface-400">Sejak Melamar</span>
                        <span class="font-medium text-surface-900 dark:text-white">{{ $applicant->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </x-dashboard.card>

            {{-- Quick Actions --}}
            <x-dashboard.card>
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4">Aksi Cepat</h2>
                <div class="space-y-2">
                    <a href="mailto:{{ $applicant->email }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-surface-900 dark:text-white">Kirim Email</p>
                            <p class="text-xs text-surface-400">{{ $applicant->email }}</p>
                        </div>
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $applicant->phone) }}" target="_blank" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-surface-900 dark:text-white">WhatsApp</p>
                            <p class="text-xs text-surface-400">{{ $applicant->phone }}</p>
                        </div>
                    </a>
                </div>
            </x-dashboard.card>
        </div>
    </div>

    {{-- Document Preview Modal --}}
    <div 
        x-show="previewModal.show" 
        x-cloak
        @keydown.escape.window="closePreview()"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
        @click.self="closePreview()"
    >
        <div 
            class="bg-white dark:bg-surface-800 rounded-xl shadow-2xl w-full max-w-5xl h-[90vh] flex flex-col"
            @click.stop
        >
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-surface-200 dark:border-surface-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center text-primary-600 dark:text-primary-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white" x-text="previewModal.title"></h3>
                        <p class="text-xs text-surface-500 dark:text-surface-400" x-text="previewModal.type"></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a :href="previewModal.downloadUrl" 
                       class="p-2 rounded-lg text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                    <button 
                        @click="closePreview()"
                        class="p-2 rounded-lg text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-hidden relative">
                {{-- Loading State --}}
                <div 
                    x-show="previewModal.loading" 
                    class="absolute inset-0 flex flex-col items-center justify-center bg-surface-50 dark:bg-surface-900/50"
                >
                    <svg class="w-12 h-12 text-primary-600 dark:text-primary-400 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-sm text-surface-600 dark:text-surface-400">Memuat dokumen...</p>
                </div>

                {{-- Error State --}}
                <div 
                    x-show="previewModal.error" 
                    class="absolute inset-0 flex flex-col items-center justify-center bg-surface-50 dark:bg-surface-900/50"
                >
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Gagal Memuat Dokumen</h4>
                    <p class="text-sm text-surface-600 dark:text-surface-400 mb-4">Dokumen tidak dapat ditampilkan</p>
                    <button 
                        @click="closePreview()"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors"
                    >
                        Tutup
                    </button>
                </div>

                {{-- PDF Viewer --}}
                <iframe 
                    :src="previewModal.previewUrl" 
                    class="w-full h-full border-0"
                    @@load="previewModal.loading = false"
                    @@error="previewModal.error = true; previewModal.loading = false"
                ></iframe>
            </div>
        </div>
    </div>
    </div>
</x-layouts.dashboard>
