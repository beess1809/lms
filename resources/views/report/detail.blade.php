@if ($sub['sub']->training_type_id == 1)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-12">
                    <label>{{ $sub['sub']->question->question }}</label>

                </div>
            </div>
            <input class="form-check-input" type="hidden" name="question[]" value="{{ $sub['sub']->question->id }}">
            @if ($sub['sub']->type_answer == 1)
                @foreach ($sub['sub']->question->answer as $item)
                    <div class="form-check col-6">
                        <input
                            class="form-check-input answer-{{ $sub['sub']->exists ? 'quizz-' . $sub['sub']->id : 'quizz-0' }}"
                            type="radio" name="selected-{{ $sub['sub']->id }}" value="{{ $item->id }}"
                            {{ $question_answer[$sub['sub']->question->id] == $item->id ? 'checked' : '' }} disabled>
                        <label class="form-check-label">{{ $item->answer }}</label>
                    </div>
                @endforeach
                <label>Correct Answer : {{ $sub['sub']->question->correct->answer }}</label>
                <input class="form-check-input" type="hidden" name="answer[]"
                    value="{{ $question_answer[$sub['sub']->question->id] }}">
                <br>
                {!! $sub['sub']->question->correct->id == $question_answer[$sub['sub']->question->id]
                    ? '<label class="text-green">Correct</label>'
                    : '<label class="text-red">Incorrect</label>' !!}
            @else
                <label
                    class="form-check-label">{{ isset($question_answer[$sub['sub']->question->id]) ? $question_answer[$sub['sub']->question->id] : '' }}</label>
                <input type="hidden" name="answer[]"
                    value="{{ isset($question_answer[$sub['sub']->question->id]) ? $question_answer[$sub['sub']->question->id] : '' }}">
            @endif
            <input type="number" class="form-control w-25" onkeyup="totalNilai();maxValue(this)"
                onchange="totalNilai();maxValue(this)" min="0" max="100" name="score[]"
                value="{{ isset($score_answer[$sub['sub']->question->id]) ? $score_answer[$sub['sub']->question->id] : '' }}">
        </div>
    </div>
@else
    <div class="row justify-content-center ">
        <div class="col-md-12 mb-3" style="display: initial;justify-content: center;">
            @if ($sub['sub']->type_file == 3)
                <div class="file">
                    <video controls width="100%" height="500px" controlsList="nodownload">
                        <source src="{{ route('sub.view', ['file' => base64_encode($sub['sub']->file)]) }}"
                            type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @elseif($sub['sub']->type_file == 1)
                <div>
                    <embed src="{{ route('sub.view', ['file' => base64_encode($sub['sub']->file)]) }}#toolbar=0"
                        type="application/pdf" frameBorder="0" scrolling="auto" height="500px" width="100%">

                </div>
            @endif
        </div>
    </div>
@endif
