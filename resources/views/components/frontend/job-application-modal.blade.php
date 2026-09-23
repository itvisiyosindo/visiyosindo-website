{{-- Job Application Modal with Step Form --}}
<template x-teleport="body">
    <div 
        x-show="showApplyModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @@keydown.escape.window="closeApplyModal()"
        class="fixed inset-0 z-[9999] overflow-y-auto"
        style="display: none;"
        x-data="jobApplicationForm()"
    >
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/80 backdrop-blur-md z-[9998]" @@click="closeApplyModal()"></div>

        {{-- Modal Container --}}
        <div class="fixed inset-0 z-[9999] flex min-h-screen items-center justify-center p-4 py-8">
        <div 
            x-show="showApplyModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @@click.stop
            class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col"
        >
            {{-- Header --}}
            <div class="relative bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 text-white">
                <button 
                    @@click="closeApplyModal()"
                    class="absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-xl font-bold mb-1">Form Lamaran</h2>
                <p class="text-blue-100 text-sm" x-text="selectedJob ? selectedJob.title : ''"></p>

                {{-- Step Indicator --}}
                <div class="flex items-center justify-between mt-6">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex items-center" :class="index < steps.length - 1 ? 'flex-1' : ''">
                            {{-- Step Circle --}}
                            <div class="flex items-center gap-2">
                                <div 
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300"
                                    :class="currentStep > index + 1 ? 'bg-green-500 text-white' : 
                                            currentStep === index + 1 ? 'bg-white text-blue-600' : 
                                            'bg-blue-500/50 text-blue-200'"
                                >
                                    <template x-if="currentStep > index + 1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </template>
                                    <template x-if="currentStep <= index + 1">
                                        <span x-text="index + 1"></span>
                                    </template>
                                </div>
                                <span class="text-xs text-white/80 hidden sm:block" x-text="step.title"></span>
                            </div>
                            
                            {{-- Connector Line --}}
                            <template x-if="index < steps.length - 1">
                                <div 
                                    class="flex-1 h-0.5 mx-2 transition-colors duration-300"
                                    :class="currentStep > index + 1 ? 'bg-green-400' : 'bg-blue-500/50'"
                                ></div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Form Content --}}
            <form @@submit.prevent="submitApplication()" class="flex-1 overflow-y-auto p-6" novalidate>
                
                {{-- BANNER ALERT DI ATAS FORM JIKA VALIDASI GAGAL --}}
                <template x-if="globalErrorMessage || Object.keys(errors).length > 0">
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl dark:bg-red-950/30">
                        <div class="flex items-start gap-3">
                            <div class="text-red-500 mt-0.5 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-red-800 dark:text-red-400 mb-1">Gagal Mengirim Lamaran</h4>
                                <p x-show="globalErrorMessage" class="text-xs text-red-700 dark:text-red-300 font-medium mb-1" x-text="globalErrorMessage"></p>
                                <ul x-show="Object.keys(errors).length > 0" class="list-disc list-inside text-xs text-red-600 dark:text-red-400 space-y-0.5">
                                    <template x-for="(errorList, field) in errors" :key="field">
                                        <template x-for="msg in errorList">
                                            <li x-text="msg"></li>
                                        </template>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Step 1: Data Diri --}}
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Data Diri
                    </h3>

                    <div class="space-y-4">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    x-model="formData.fullName"
                                    @@input="clearError('full_name')"
                                    class="w-full px-4 py-3 rounded-xl border transition-all"
                                    :class="errors.full_name ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-slate-200 dark:border-slate-700 focus:ring-blue-500 focus:border-transparent'"
                                    class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2"
                                    placeholder="Masukkan nama lengkap"
                                    required
                                >
                                <template x-if="errors.full_name">
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.full_name[0]"></p>
                                </template>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email <span class="text-red-500">*</span></label>
                                <input 
                                    type="email" 
                                    x-model="formData.email"
                                    @@input="clearError('email')"
                                    class="w-full px-4 py-3 rounded-xl border transition-all"
                                    :class="errors.email ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-slate-200 dark:border-slate-700 focus:ring-blue-500 focus:border-transparent'"
                                    class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2"
                                    placeholder="email@example.com"
                                    required
                                >
                                <template x-if="errors.email">
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.email[0]"></p>
                                </template>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">No. Telepon <span class="text-red-500">*</span></label>
                                <input 
                                    type="tel" 
                                    x-model="formData.phone"
                                    @@input="clearError('phone')"
                                    class="w-full px-4 py-3 rounded-xl border transition-all"
                                    :class="errors.phone ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-slate-200 dark:border-slate-700 focus:ring-blue-500 focus:border-transparent'"
                                    class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                >
                                <template x-if="errors.phone">
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.phone[0]"></p>
                                </template>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <div class="relative" x-data="{ 
                                    showPicker: false,
                                    selectedYear: new Date().getFullYear() - 25,
                                    selectedMonth: new Date().getMonth(),
                                    viewMode: 'days',
                                    days: [],
                                    months: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                    monthsFull: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                    get displayDate() {
                                        if (!formData.birthDate) return '';
                                        const d = new Date(formData.birthDate + 'T00:00:00');
                                        return d.getDate() + ' ' + this.monthsFull[d.getMonth()] + ' ' + d.getFullYear();
                                    },
                                    init() { this.buildDays(); },
                                    buildDays() {
                                        const first = new Date(this.selectedYear, this.selectedMonth, 1);
                                        const last = new Date(this.selectedYear, this.selectedMonth + 1, 0);
                                        const startDay = first.getDay();
                                        this.days = [];
                                        for (let i = 0; i < startDay; i++) this.days.push(null);
                                        for (let d = 1; d <= last.getDate(); d++) this.days.push(d);
                                    },
                                    prevMonth() {
                                        if (this.selectedMonth === 0) { this.selectedMonth = 11; this.selectedYear--; }
                                        else this.selectedMonth--;
                                        this.buildDays();
                                    },
                                    nextMonth() {
                                        if (this.selectedMonth === 11) { this.selectedMonth = 0; this.selectedYear++; }
                                        else this.selectedMonth++;
                                        this.buildDays();
                                    },
                                    selectDay(day) {
                                        const m = String(this.selectedMonth + 1).padStart(2, '0');
                                        const d = String(day).padStart(2, '0');
                                        formData.birthDate = this.selectedYear + '-' + m + '-' + d;
                                        this.showPicker = false;
                                    },
                                    selectMonth(idx) {
                                        this.selectedMonth = idx;
                                        this.viewMode = 'days';
                                        this.buildDays();
                                    },
                                    selectYear(y) {
                                        this.selectedYear = y;
                                        this.viewMode = 'months';
                                    },
                                    isToday(day) {
                                        const t = new Date();
                                        return day === t.getDate() && this.selectedMonth === t.getMonth() && this.selectedYear === t.getFullYear();
                                    },
                                    isSelected(day) {
                                        if (!formData.birthDate) return false;
                                        const s = new Date(formData.birthDate + 'T00:00:00');
                                        return day === s.getDate() && this.selectedMonth === s.getMonth() && this.selectedYear === s.getFullYear();
                                    },
                                    yearRange() {
                                        const start = Math.floor(this.selectedYear / 12) * 12;
                                        return Array.from({length: 12}, (_, i) => start + i);
                                    }
                                }">
                                    <button 
                                        type="button"
                                        @@click="showPicker = !showPicker"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-left flex items-center justify-between"
                                    >
                                        <span :class="formData.birthDate ? 'text-slate-900 dark:text-white' : 'text-slate-400'" x-text="displayDate || 'Pilih tanggal lahir'"></span>
                                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </button>
                                    <div x-show="showPicker" @@click.away="showPicker = false" x-transition
                                        class="absolute z-50 mt-2 w-72 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-4">
                                        {{-- Header --}}
                                        <div class="flex items-center justify-between mb-3">
                                            <button type="button" @@click="viewMode === 'days' ? prevMonth() : (viewMode === 'months' ? selectedYear-- : null)" class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                                            <button type="button" @@click="viewMode = viewMode === 'days' ? 'months' : (viewMode === 'months' ? 'years' : 'years')" class="text-sm font-semibold text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700 px-3 py-1 rounded-lg transition-colors">
                                                <span x-show="viewMode === 'days'" x-text="monthsFull[selectedMonth] + ' ' + selectedYear"></span>
                                                <span x-show="viewMode === 'months'" x-text="selectedYear"></span>
                                                <span x-show="viewMode === 'years'" x-text="yearRange()[0] + ' - ' + yearRange()[11]"></span>
                                            </button>
                                            <button type="button" @@click="viewMode === 'days' ? nextMonth() : (viewMode === 'months' ? selectedYear++ : null)" class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                                        </div>
                                        {{-- Days View --}}
                                        <div x-show="viewMode === 'days'">
                                            <div class="grid grid-cols-7 gap-1 mb-2">
                                                <template x-for="d in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']" :key="d"><div class="text-center text-xs font-medium text-slate-400 py-1" x-text="d"></div></template>
                                            </div>
                                            <div class="grid grid-cols-7 gap-1">
                                                <template x-for="(day, i) in days" :key="i">
                                                    <button type="button" x-show="day" @@click="selectDay(day)" x-text="day"
                                                        class="h-8 w-8 rounded-lg text-sm font-medium transition-all mx-auto flex items-center justify-center"
                                                        :class="isSelected(day) ? 'bg-blue-600 text-white' : isToday(day) ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'"></button>
                                                </template>
                                            </div>
                                        </div>
                                        {{-- Months View --}}
                                        <div x-show="viewMode === 'months'" class="grid grid-cols-3 gap-2">
                                            <template x-for="(m, idx) in months" :key="idx">
                                                <button type="button" @@click="selectMonth(idx)" x-text="m" class="py-2 rounded-lg text-sm font-medium transition-all" :class="selectedMonth === idx ? 'bg-blue-600 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'"></button>
                                            </template>
                                        </div>
                                        {{-- Years View --}}
                                        <div x-show="viewMode === 'years'" class="grid grid-cols-3 gap-2">
                                            <template x-for="y in yearRange()" :key="y">
                                                <button type="button" @@click="selectYear(y)" x-text="y" class="py-2 rounded-lg text-sm font-medium transition-all" :class="selectedYear === y ? 'bg-blue-600 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700'"></button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <template x-if="errors.birth_date">
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.birth_date[0]"></p>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Alamat <span class="text-red-500">*</span></label>
                            <textarea 
                                x-model="formData.address"
                                @@input="clearError('address')"
                                rows="3"
                                class="w-full px-4 py-3 rounded-xl border transition-all resize-none"
                                :class="errors.address ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-slate-200 dark:border-slate-700 focus:ring-blue-500 focus:border-transparent'"
                                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2"
                                placeholder="Alamat lengkap"
                                required
                            ></textarea>
                            <template x-if="errors.address">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.address[0]"></p>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Pendidikan & Pengalaman --}}
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Pendidikan & Pengalaman
                    </h3>

                    <div class="space-y-4">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                                <select 
                                    x-model="formData.education"
                                    @@change="clearError('education')"
                                    class="w-full px-4 py-3 rounded-xl border transition-all bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent border-slate-200 dark:border-slate-700"
                                    :class="errors.education ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : ''"
                                    style="color-scheme: light dark;"
                                    required
                                >
                                    <option value="">Pilih pendidikan</option>
                                    <option value="sma">SMA/SMK</option>
                                    <option value="d1">D1</option>
                                    <option value="d2">D2</option>
                                    <option value="d3">D3</option>
                                    <option value="d4">D4</option>
                                    <option value="s1">S1</option>
                                    <option value="s2">S2</option>
                                    <option value="s3">S3</option>
                                </select>
                                <template x-if="errors.education">
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.education[0]"></p>
                                </template>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jurusan <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    x-model="formData.major"
                                    @@input="clearError('major')"
                                    class="w-full px-4 py-3 rounded-xl border transition-all"
                                    :class="errors.major ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-slate-200 dark:border-slate-700 focus:ring-blue-500 focus:border-transparent'"
                                    class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2"
                                    placeholder="Contoh: Teknik Elektro"
                                    required
                                >
                                <template x-if="errors.major">
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.major[0]"></p>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Institusi <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                x-model="formData.institution"
                                @@input="clearError('institution')"
                                class="w-full px-4 py-3 rounded-xl border transition-all"
                                :class="errors.institution ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-slate-200 dark:border-slate-700 focus:ring-blue-500 focus:border-transparent'"
                                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2"
                                placeholder="Nama universitas/sekolah"
                                required
                            >
                            <template x-if="errors.institution">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.institution[0]"></p>
                            </template>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tahun Lulus <span class="text-red-500">*</span></label>
                                <input 
                                    type="number" 
                                    x-model="formData.graduationYear"
                                    @@input="clearError('graduation_year')"
                                    min="1990"
                                    max="2030"
                                    class="w-full px-4 py-3 rounded-xl border transition-all"
                                    :class="errors.graduation_year ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-slate-200 dark:border-slate-700 focus:ring-blue-500 focus:border-transparent'"
                                    class="bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2"
                                    placeholder="2020"
                                    required
                                >
                                <template x-if="errors.graduation_year">
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.graduation_year[0]"></p>
                                </template>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pengalaman Kerja</label>
                                <select 
                                    x-model="formData.workExperience"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    style="color-scheme: light dark;"
                                >
                                    <option value="">Pilih pengalaman</option>
                                    <option value="fresh">Fresh Graduate</option>
                                    <option value="1-2">1-2 Tahun</option>
                                    <option value="2-5">2-5 Tahun</option>
                                    <option value="5-10">5-10 Tahun</option>
                                    <option value="10+">Lebih dari 10 Tahun</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pengalaman Kerja Terakhir</label>
                            <textarea 
                                x-model="formData.lastJob"
                                rows="3"
                                maxlength="200"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                placeholder="Jelaskan secara singkat posisi dan tanggung jawab terakhir Anda"
                            ></textarea>
                        </div>
                    </div>
                </div>

                {{-- Step 3: Upload Dokumen --}}
                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Upload Dokumen
                    </h3>

                    <div class="space-y-4">
                        {{-- CV Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">CV / Resume <span class="text-red-500">*</span></label>
                            <div 
                                class="relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-6 hover:border-blue-500 transition-colors cursor-pointer"
                                @@click="$refs.cvInput.click()"
                                @dragover.prevent="dragOver = 'cv'"
                                @dragleave.prevent="dragOver = null"
                                @drop.prevent="handleFileDrop($event, 'cv')"
                                :class="dragOver === 'cv' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : ''"
                            >
                                <input 
                                    type="file" 
                                    x-ref="cvInput"
                                    @@change="handleFileChange($event, 'cv')"
                                    accept=".pdf,.doc,.docx"
                                    class="hidden"
                                >
                                <div class="text-center" x-show="!formData.cv">
                                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Klik atau drag file ke sini</p>
                                    <p class="text-xs text-slate-500 mt-1">PDF, DOC, DOCX (Maks. <2MB)</p>
                                </div>
                                <div class="flex items-center gap-3" x-show="formData.cv">
                                    <svg class="w-10 h-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate" x-text="formData.cv ? formData.cv.name : ''"></p>
                                        <p class="text-xs text-slate-500" x-text="formData.cv ? formatFileSize(formData.cv.size) : ''"></p>
                                    </div>
                                    <button type="button" @@click.stop="formData.cv = null" class="p-1 hover:bg-red-100 rounded-lg text-red-500">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <template x-if="errors.cv">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.cv[0]"></p>
                            </template>
                        </div>

                        {{-- Transkrip Nilai Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Transkrip Nilai Terakhir <span class="text-red-500">*</span>
                                <span class="text-xs text-slate-500 font-normal ml-2">(Lebih aman & relevan daripada KTP)</span>
                            </label>
                            <div 
                                class="relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-6 hover:border-blue-500 transition-colors cursor-pointer"
                                @@click="$refs.transcriptInput.click()"
                                @dragover.prevent="dragOver = 'transcript'"
                                @dragleave.prevent="dragOver = null"
                                @drop.prevent="handleFileDrop($event, 'transcript')"
                                :class="dragOver === 'transcript' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : ''"
                            >
                                <input 
                                    type="file" 
                                    x-ref="transcriptInput"
                                    @@change="handleFileChange($event, 'transcript')"
                                    accept="image/*,.pdf"
                                    class="hidden"
                                >
                                <div class="text-center" x-show="!formData.transcript">
                                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Klik atau drag file ke sini</p>
                                    <p class="text-xs text-slate-500 mt-1">PDF, JPG, PNG (Maks. <2MB)</p>
                                </div>
                                <div class="flex items-center gap-3" x-show="formData.transcript">
                                    <svg class="w-10 h-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate" x-text="formData.transcript ? formData.transcript.name : ''"></p>
                                        <p class="text-xs text-slate-500" x-text="formData.transcript ? formatFileSize(formData.transcript.size) : ''"></p>
                                    </div>
                                    <button type="button" @@click.stop="formData.transcript = null" class="p-1 hover:bg-red-100 rounded-lg text-red-500">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <template x-if="errors.transcript">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.transcript[0]"></p>
                            </template>
                        </div>

                        {{-- Ijazah Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Ijazah Terakhir</label>
                            <div 
                                class="relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-6 hover:border-blue-500 transition-colors cursor-pointer"
                                @@click="$refs.ijazahInput.click()"
                                @dragover.prevent="dragOver = 'ijazah'"
                                @dragleave.prevent="dragOver = null"
                                @drop.prevent="handleFileDrop($event, 'ijazah')"
                                :class="dragOver === 'ijazah' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : ''"
                            >
                                <input 
                                    type="file" 
                                    x-ref="ijazahInput"
                                    @@change="handleFileChange($event, 'ijazah')"
                                    accept="image/*,.pdf"
                                    class="hidden"
                                >
                                <div class="text-center" x-show="!formData.ijazah">
                                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Klik atau drag file ke sini</p>
                                    <p class="text-xs text-slate-500 mt-1">JPG, PNG, PDF (Maks. <2MB)</p>
                                </div>
                                <div class="flex items-center gap-3" x-show="formData.ijazah">
                                    <svg class="w-10 h-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate" x-text="formData.ijazah ? formData.ijazah.name : ''"></p>
                                        <p class="text-xs text-slate-500" x-text="formData.ijazah ? formatFileSize(formData.ijazah.size) : ''"></p>
                                    </div>
                                    <button type="button" @@click.stop="formData.ijazah = null" class="p-1 hover:bg-red-100 rounded-lg text-red-500">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <template x-if="errors.ijazah">
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400" x-text="errors.ijazah[0]"></p>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Step 4: Review & Submit --}}
                <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Review & Submit
                    </h3>

                    <div class="space-y-6">
                        {{-- Data Summary --}}
                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 space-y-3">
                            <h4 class="font-semibold text-slate-900 dark:text-white">Data Diri</h4>
                            <div class="grid sm:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-slate-500">Nama:</span>
                                    <span class="text-slate-900 dark:text-white ml-2" x-text="formData.fullName || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Email:</span>
                                    <span class="text-slate-900 dark:text-white ml-2" x-text="formData.email || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Telepon:</span>
                                    <span class="text-slate-900 dark:text-white ml-2" x-text="formData.phone || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Tanggal Lahir:</span>
                                    <span class="text-slate-900 dark:text-white ml-2" x-text="formData.birthDate || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 space-y-3">
                            <h4 class="font-semibold text-slate-900 dark:text-white">Pendidikan</h4>
                            <div class="grid sm:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-slate-500">Pendidikan:</span>
                                    <span class="text-slate-900 dark:text-white ml-2 uppercase" x-text="formData.education || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Jurusan:</span>
                                    <span class="text-slate-900 dark:text-white ml-2" x-text="formData.major || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Institusi:</span>
                                    <span class="text-slate-900 dark:text-white ml-2" x-text="formData.institution || '-'"></span>
                                </div>
                                <div>
                                    <span class="text-slate-500">Pengalaman:</span>
                                    <span class="text-slate-900 dark:text-white ml-2" x-text="formData.workExperience || 'Fresh Graduate'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 space-y-3">
                            <h4 class="font-semibold text-slate-900 dark:text-white">Dokumen</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" :class="formData.cv ? 'text-green-500' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span :class="formData.cv ? 'text-slate-900 dark:text-white' : 'text-slate-400'">
                                        CV: <span x-text="formData.cv ? formData.cv.name : 'Belum diupload'"></span>
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" :class="formData.transcript ? 'text-green-500' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span :class="formData.transcript ? 'text-slate-900 dark:text-white' : 'text-slate-400'">
                                        Transkrip Nilai: <span x-text="formData.transcript ? formData.transcript.name : 'Belum diupload'"></span>
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" :class="formData.ijazah ? 'text-green-500' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span :class="formData.ijazah ? 'text-slate-900 dark:text-white' : 'text-slate-400'">
                                        Ijazah: <span x-text="formData.ijazah ? formData.ijazah.name : 'Tidak diupload'"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Agreement Checkbox --}}
                        <div class="flex items-start gap-3">
                            <input 
                                type="checkbox" 
                                id="agreement" 
                                x-model="formData.agreement"
                                class="w-5 h-5 mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                            >
                            <label for="agreement" class="text-sm text-slate-600 dark:text-slate-400">
                                Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan. Saya menyetujui data ini digunakan untuk proses rekrutmen di PT Visi Yosindo Medikal.
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <button 
                        type="button"
                        @@click="prevStep()"
                        x-show="currentStep > 1"
                        class="inline-flex items-center gap-2 px-6 py-3 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </button>
                    <div x-show="currentStep === 1"></div>

                    <button 
                        type="button"
                        @@click="nextStep()"
                        x-show="currentStep < 4"
                        :disabled="!validateCurrentStep()"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                    >
                        Selanjutnya
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <button 
                        type="submit"
                        x-show="currentStep === 4"
                        :disabled="!formData.agreement || isSubmitting"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                    >
                        <template x-if="!isSubmitting">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Kirim Lamaran
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mengirim...
                            </span>
                        </template>
                    </button>
                </div>
            </form>

            {{-- Success State --}}
            <div 
                x-show="submitSuccess"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="p-8 text-center"
            >
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Lamaran Terkirim!</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-6">Terima kasih telah mengirim lamaran Anda. Tim HR kami akan menghubungi Anda dalam 1-2 minggu.</p>
                <button 
                    @@click="closeApplyModal()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    function jobApplicationForm() {
        return {
            currentStep: 1,
            isSubmitting: false,
            submitSuccess: false,
            dragOver: null,
            errors: {},
            globalErrorMessage: '', // <-- Ditambahkan untuk banner alert
            steps: [
                { title: 'Data Diri' },
                { title: 'Pendidikan' },
                { title: 'Dokumen' },
                { title: 'Review' }
            ],
            formData: {
                // Step 1: Personal Data
                fullName: '',
                email: '',
                phone: '',
                birthDate: '',
                address: '',
                // Step 2: Education
                education: '',
                major: '',
                institution: '',
                graduationYear: '',
                workExperience: '',
                lastJob: '',
                // Step 3: Documents
                cv: null,
                transcript: null,
                ijazah: null,
                // Step 4: Agreement
                agreement: false
            },

            clearError(field) {
                delete this.errors[field];
                this.globalErrorMessage = ''; // <-- Clear error saat user mengetik
            },

            clearAllErrors() {
                this.errors = {};
                this.globalErrorMessage = ''; // <-- Clear global error state
            },

            nextStep() {
                if (this.validateCurrentStep() && this.currentStep < 4) {
                    this.currentStep++;
                }
            },

            prevStep() {
                if (this.currentStep > 1) {
                    this.currentStep--;
                }
            },

            validateCurrentStep() {
                switch (this.currentStep) {
                    case 1:
                        return this.formData.fullName && 
                               this.formData.email && 
                               this.formData.phone && 
                               this.formData.birthDate &&
                               this.formData.address;
                    case 2:
                        return this.formData.education && 
                               this.formData.major && 
                               this.formData.institution &&
                               this.formData.graduationYear;
                    case 3:
                        return this.formData.cv && this.formData.transcript;
                    case 4:
                        return this.formData.agreement;
                    default:
                        return true;
                }
            },

            handleFileChange(event, type) {
                const file = event.target.files[0];
                if (file) {
                    this.formData[type] = file;
                    this.clearError(type); // <-- Clear error saat upload ulang file
                }
            },

            handleFileDrop(event, type) {
                this.dragOver = null;
                const file = event.dataTransfer.files[0];
                if (file) {
                    this.formData[type] = file;
                    this.clearError(type); // <-- Clear error saat upload ulang file
                }
            },

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            },

            async submitApplication() {
                if (!this.formData.agreement) return;
                
                this.isSubmitting = true;
                this.clearAllErrors();

                try {
                    const selectedJob = window.currentCareerJob || null;

                    if (!selectedJob?.id) {
                        this.globalErrorMessage = 'Posisi lowongan belum dipilih.'; // <-- Menggunakan global message
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: this.globalErrorMessage } }));
                        this.isSubmitting = false;
                        return;
                    }

                    const formData = new FormData();
                    formData.append('job_vacancy_id', selectedJob.id);
                    formData.append('full_name', this.formData.fullName);
                    formData.append('email', this.formData.email);
                    formData.append('phone', this.formData.phone);
                    formData.append('birth_date', this.formData.birthDate);
                    formData.append('address', this.formData.address);
                    formData.append('education', this.formData.education);
                    formData.append('major', this.formData.major);
                    formData.append('institution', this.formData.institution);
                    formData.append('graduation_year', this.formData.graduationYear);
                    formData.append('work_experience', this.formData.workExperience || '');
                    formData.append('last_job', this.formData.lastJob || '');
                    
                    if (this.formData.cv) formData.append('cv', this.formData.cv);
                    if (this.formData.transcript) formData.append('transcript', this.formData.transcript);
                    if (this.formData.ijazah) formData.append('ijazah', this.formData.ijazah);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    const response = await fetch('{{ route("career.apply") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        credentials: 'same-origin',
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        this.submitSuccess = true;
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil!', message: data.message || 'Lamaran Anda berhasil dikirim!' } }));
                        setTimeout(() => {
                            this.closeApplyModal();
                            this.resetForm();
                        }, 4000);
                    } else if (response.status === 422 && data.errors) {
                        // Store validation errors for inline display
                        this.errors = data.errors;
                        
                        // Show banner & toast with summary
                        const errorCount = Object.keys(data.errors).length;
                        const firstError = Object.values(data.errors)[0][0];
                        this.globalErrorMessage = `${errorCount} kesalahan ditemukan. ${firstError}`; // <-- Diset untuk Alert UI
                        
                        window.dispatchEvent(new CustomEvent('toast', { 
                            detail: { 
                                type: 'error', 
                                title: 'Validasi Gagal', 
                                message: this.globalErrorMessage, 
                                duration: 5000 
                            } 
                        }));
                        
                        // Auto-navigate to step with first error
                        const errorFields = Object.keys(data.errors);
                        if (errorFields.some(f => ['full_name', 'email', 'phone', 'birth_date', 'address'].includes(f))) {
                            this.currentStep = 1;
                        } else if (errorFields.some(f => ['education', 'major', 'institution', 'graduation_year'].includes(f))) {
                            this.currentStep = 2;
                        } else if (errorFields.some(f => ['cv', 'transcript', 'ijazah'].includes(f))) {
                            this.currentStep = 3;
                        }
                    } else {
                        this.globalErrorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.'; // <-- Fallback server error
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: this.globalErrorMessage } }));
                    }
                } catch (error) {
                    this.globalErrorMessage = 'Terjadi kesalahan jaringan. Silakan coba lagi.'; // <-- Network error state
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Error', message: this.globalErrorMessage } }));
                } finally {
                    this.isSubmitting = false;
                }
            },

            resetForm() {
                this.currentStep = 1;
                this.isSubmitting = false;
                this.submitSuccess = false;
                this.clearAllErrors();
                this.formData = {
                    fullName: '',
                    email: '',
                    phone: '',
                    birthDate: '',
                    address: '',
                    education: '',
                    major: '',
                    institution: '',
                    graduationYear: '',
                    workExperience: '',
                    lastJob: '',
                    cv: null,
                    transcript: null,
                    ijazah: null,
                    agreement: false
                };
            }
        };
    }
</script>