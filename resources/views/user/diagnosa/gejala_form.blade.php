@extends('layouts.app')

@section('content')
<style>
    .card {
        margin-top: 80px;
        border-radius: 12px;
    }

    .form-check-label {
        padding: 10px 15px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        cursor: pointer;
        display: block;
        margin-bottom: 10px;
        transition: background-color 0.3s, color 0.3s;
    }

    .form-check-input {
        display: none;
    }

    /* Warna aktif saat dipilih */
    .form-check-input:checked + .form-check-label {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    .step {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container d-flex justify-content-center align-items-start">
    <div class="card shadow-sm p-4 w-100" style="max-width: 450px;">
        <form method="POST" action="{{ route('diagnosa.proses') }}" id="formDiagnosa">
            @csrf
            <h5 class="text-center mb-4">Pilih Gejala yang Dialami</h5>

            <div id="stepContainer">
                @forelse($gejalas as $index => $gejala)
                    <div class="step {{ $index === 0 ? 'd-block' : 'd-none' }}">
                        <p><strong>{{ $index + 1 }}. Apakah anak Anda mengalami {{ $gejala->nama }}?</strong></p>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                name="gejala[{{ $gejala->kode }}][jawaban]" 
                                id="ya_{{ $gejala->kode }}" value="1.0" required onchange="autoNextStep()">
                            <label class="form-check-label" for="ya_{{ $gejala->kode }}">Ya</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                name="gejala[{{ $gejala->kode }}][jawaban]" 
                                id="ragu_{{ $gejala->kode }}" value="0.5" required onchange="autoNextStep()">
                            <label class="form-check-label" for="ragu_{{ $gejala->kode }}">Ragu-ragu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" 
                                name="gejala[{{ $gejala->kode }}][jawaban]" 
                                id="tidak_{{ $gejala->kode }}" value="0.0" required onchange="autoNextStep()">
                            <label class="form-check-label" for="tidak_{{ $gejala->kode }}">Tidak</label>
                        </div>
                    </div>
                @empty
                    <p class="text-danger">Tidak ada data gejala.</p>
                @endforelse
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-success d-none" id="submitButton">Proses Diagnosa</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const submitButton = document.getElementById('submitButton');
        const form = document.getElementById('formDiagnosa');

        window.autoNextStep = function () {
    if (steps.length === 0) return;

    const currentStepDiv = steps[currentStep];
    const radios = currentStepDiv.querySelectorAll('input[type="radio"]');

    let radioChecked = false;
    radios.forEach(radio => {
        if (radio.checked) radioChecked = true;
    });
    if (!radioChecked) return;

    currentStepDiv.classList.remove('d-block');
    currentStepDiv.classList.add('d-none');
    currentStep++;

    if (currentStep < steps.length) {
        steps[currentStep].classList.remove('d-none');
        steps[currentStep].classList.add('d-block');
    } else {
        // Cek semua gejala sudah dijawab sebelum submit
        const allAnswered = Array.from(document.querySelectorAll('.step')).every(step => {
            return Array.from(step.querySelectorAll('input[type="radio"]')).some(r => r.checked);
        });

        if (allAnswered) {
            form.submit();
        } else {
            alert('Mohon jawab semua pertanyaan sebelum submit.');
        }
    }
}
    });
</script>
@endsection
