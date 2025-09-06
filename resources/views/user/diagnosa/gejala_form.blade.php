@extends('layouts.app')

@section('title', 'Pertanyaan Gejala')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Langkah 2: Jawab Pertanyaan Gejala</h2>
                    <p class="mt-2 text-sm text-gray-600">Pilih tingkat keyakinan Anda untuk setiap gejala di bawah ini.</p>
                </div>

                <form method="POST" action="{{ route('diagnosa.proses') }}" id="formDiagnosa" class="mt-8">
                    @csrf
                    <div class="space-y-8">
                        @forelse($gejalas as $index => $gejala)
                            <div class="p-5 border border-gray-200 rounded-lg">
                                <p class="text-base font-medium text-gray-900">
                                    {{ $index + 1 }}. Apakah anak Anda mengalami <strong
                                        class="text-indigo-600">{{ strtolower($gejala->nama) }}</strong>?
                                </p>
                                <div class="mt-4 space-y-3">
                                    <label for="ya_{{ $gejala->kode }}"
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                        <input type="radio" name="gejala[{{ $gejala->kode }}][jawaban]"
                                            id="ya_{{ $gejala->kode }}" value="1.0" required
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-3 text-sm font-medium text-gray-700">Ya, sangat yakin</span>
                                    </label>
                                    <label for="ragu_{{ $gejala->kode }}"
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                        <input type="radio" name="gejala[{{ $gejala->kode }}][jawaban]"
                                            id="ragu_{{ $gejala->kode }}" value="0.5" required
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-3 text-sm font-medium text-gray-700">Mungkin / Ragu-ragu</span>
                                    </label>
                                    <label for="tidak_{{ $gejala->kode }}"
                                        class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                        <input type="radio" name="gejala[{{ $gejala->kode }}][jawaban]"
                                            id="tidak_{{ $gejala->kode }}" value="0.0" required
                                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-3 text-sm font-medium text-gray-700">Tidak</span>
                                    </label>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">Tidak ada data gejala untuk ditampilkan.</p>
                        @endforelse
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-200">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="w-full md:w-auto inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-3 px-8 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                                Lihat Hasil Diagnosa
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
