@extends('layouts.app')

@section('title', 'Pertanyaan Gejala')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Langkah 2: Jawab Pertanyaan Gejala</h2>
                    <p class="mt-2 text-sm text-gray-600">Pilih tingkat keyakinan Anda untuk setiap gejala di bawah ini.</p>

                    <!-- Progress Indicator -->
                    <div class="mt-4 flex items-center justify-center space-x-2">
                        <div class="h-2 w-8 bg-indigo-600 rounded"></div>
                        <div class="h-2 w-8 bg-indigo-600 rounded"></div>
                        <div class="h-2 w-8 bg-gray-200 rounded"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Langkah 2 dari 3</p>
                </div>

                <!-- Data Summary Card -->
                @if (session('nama_anak'))
                    <div class="mt-6 bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-indigo-800">Data Anak:</h3>
                        <p class="text-sm text-indigo-600">
                            {{ session('nama_anak') }} ({{ session('usia_anak') }} bulan) - {{ session('jenis_kelamin') }}
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('diagnosa.proses') }}" id="formDiagnosa" class="mt-8">
                    @csrf
                    <div class="space-y-6">
                        @forelse($gejalas as $index => $gejala)
                            <div class="p-5 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors">
                                <p class="text-base font-medium text-gray-900 mb-4">
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded-full mr-3">
                                        {{ $index + 1 }}
                                    </span>
                                    Apakah anak Anda mengalami <strong
                                        class="text-indigo-600">{{ strtolower($gejala->nama) }}</strong>?
                                </p>

                                <div class="space-y-3">
                                    <label for="ya_{{ $gejala->kode }}"
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition group">
                                        <input type="radio" name="gejala[{{ $gejala->kode }}][jawaban]"
                                            id="ya_{{ $gejala->kode }}" value="1.0" required
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3 flex-1">
                                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Ya,
                                                sangat yakin</span>
                                            <p class="text-xs text-gray-500">Saya 100% yakin gejala ini ada</p>
                                        </div>
                                        <div
                                            class="h-2 w-2 bg-green-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                    </label>

                                    <label for="ragu_{{ $gejala->kode }}"
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition group">
                                        <input type="radio" name="gejala[{{ $gejala->kode }}][jawaban]"
                                            id="ragu_{{ $gejala->kode }}" value="0.5" required
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3 flex-1">
                                            <span
                                                class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Mungkin
                                                / Ragu-ragu</span>
                                            <p class="text-xs text-gray-500">Saya tidak terlalu yakin, tapi mungkin ada</p>
                                        </div>
                                        <div
                                            class="h-2 w-2 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                    </label>

                                    <label for="tidak_{{ $gejala->kode }}"
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition group">
                                        <input type="radio" name="gejala[{{ $gejala->kode }}][jawaban]"
                                            id="tidak_{{ $gejala->kode }}" value="0.0" required
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3 flex-1">
                                            <span
                                                class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Tidak</span>
                                            <p class="text-xs text-gray-500">Gejala ini sama sekali tidak ada</p>
                                        </div>
                                        <div
                                            class="h-2 w-2 bg-red-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-8">
                                <i class="fas fa-exclamation-triangle fa-3x text-gray-300 mb-4"></i>
                                <p>Tidak ada data gejala untuk ditampilkan.</p>
                                <p class="text-sm mt-2">Silakan hubungi administrator.</p>
                            </div>
                        @endforelse
                    </div>

                    @if (!$gejalas->isEmpty())
                        <div class="mt-8 pt-5 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                                <a href="{{ route('diagnosa.data') }}"
                                    class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 bg-white py-3 px-8 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                    ← Kembali ke Data
                                </a>
                                <button type="submit" id="submitBtn"
                                    class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-3 px-8 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span id="submitText">Lihat Hasil Diagnosa →</span>
                                    <span id="loadingText" class="hidden">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formDiagnosa').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');

            // Disable button and show loading
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');
        });

        // Form validation - ensure at least one symptom is selected with non-zero value
        document.getElementById('formDiagnosa').addEventListener('submit', function(e) {
            const formData = new FormData(this);
            let hasSelectedSymptoms = false;

            // Check if at least one symptom has value > 0
            for (let [key, value] of formData.entries()) {
                if (key.includes('[jawaban]') && (value === '1.0' || value === '0.5')) {
                    hasSelectedSymptoms = true;
                    break;
                }
            }

            if (!hasSelectedSymptoms) {
                e.preventDefault();
                alert('Silakan pilih minimal satu gejala dengan jawaban "Ya" atau "Mungkin".');

                // Reset button state
                const submitBtn = document.getElementById('submitBtn');
                const submitText = document.getElementById('submitText');
                const loadingText = document.getElementById('loadingText');

                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            }
        });
    </script>
@endsection
