@extends('layouts.app')

@section('content-header')
    <div class="content-header-background">
        <div class="center-content">
            <h2>{{ $model->title }}</h2>
            <h5>Started At : {{ sqlindo_datetime_to_datetime($started_at) }}</h5>
            <h5>Duration : {{ $model->duration . ' minutes' }}</h5>
            <h5>Remain : <span id="countdown">{{ $remain_minutes . ':' . $remain_seconds }}</span>
            </h5>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Tentang Training
                </div>
                <div class="card-body">
                    {{ $model->description }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form action="{{ route('trainee.submit') }}" method="post">
                @csrf
                <input type="hidden" name="training_id" value="{{ $model->id }}">
                <input type="hidden" name="module_id" value="{{ base64_encode($model->module_id) }}">
                <input type="hidden" name="created_at" value="{{ date('Y-m-d H:i:s') }}">
                @foreach ($training->shuffle()->shift($model->number_questions) as $key => $sub)
                    @if ($sub->training_type_id == 1)
                        @if ($sub->type_answer == 1)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{ $sub->question->question }}</label>
                                        </div>
                                    </div>
                                    <input class="form-check-input" type="hidden" name="answer[{{ $sub->question->id }}]"
                                        value="{{ $sub->question->answer_id }}">
                                    @foreach ($sub->question->answer->shuffle() as $item)
                                        <div class="form-check col-6">
                                            <input
                                                class="form-check-input answer-{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                                                type="radio" name="question[{{ $sub->question->id }}]"
                                                value="{{ $item->id }}">
                                            <label class="form-check-label">{{ $item->answer }}</label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @elseif($sub->type_answer == 2)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>{{ $sub->question->question }}</label>
                                        </div>
                                    </div>
                                    <textarea name="answer[{{ $sub->question->id }}]" class="form-control" rows="3"></textarea>
                                    <input
                                        class="form-check-input answer-{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                                        type="hidden" name="question[{{ $sub->question->id }}]"
                                        value="{{ $sub->question->id }}">
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="row justify-content-center ">
                            <div class="col-md-12 mb-3" style="display: initial;justify-content: center;">
                                @if ($sub->type_file == 3)
                                    <div class="file">
                                        <video controls width="100%" height="500px" controlsList="nodownload">
                                            <source src="{{ route('sub.view', ['file' => base64_encode($sub->file)]) }}"
                                                type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @elseif($sub->type_file == 1)
                                    <div>
                                        <embed
                                            src="{{ route('sub.view', ['file' => base64_encode($sub->file)]) }}#toolbar=0"
                                            type="application/pdf" frameBorder="0" scrolling="auto" height="500px"
                                            width="100%">

                                    </div>
                                @endif


                            </div>
                        </div>
                    @endif
                @endforeach
                <hr>
                <div>
                    <button type="submit" id="submitTraining" class="btn btn-phintraco float-right">Submit</button>
                </div>
            </form>
        </div>

    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('.file').on('contextmenu', function(e) {
                return false;
            });
        });
    </script>

    <script>
        let totalTime = {{ $remain_minutes * 60 + $remain_seconds }}; // 60 menit dalam detik
        let countdownDisplay = document.getElementById('countdown');
        let submitTraining = document.getElementById("submitTraining");

        function startCountdown() {
            let interval = setInterval(function() {
                let minutes = Math.floor(totalTime / 60);
                let seconds = totalTime % 60;

                // Tambahkan nol di depan angka di bawah 10
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                countdownDisplay.textContent = minutes + ':' + seconds;

                // Kurangi total waktu, hentikan saat mencapai 0
                totalTime--;
                if (totalTime < 0) {
                    clearInterval(interval);
                    countdownDisplay.textContent = "Waktu Habis!";
                    submitTraining.click();
                }
            }, 1000); // Update setiap 1 detik
        }

        // Mulai hitung mundur saat halaman dimuat
        window.onload = startCountdown;
    </script>
@endpush
