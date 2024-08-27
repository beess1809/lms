@if ($sub->training_type_id == 1)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-12">
                    <label>{{ $sub->question->question }}</label>

                </div>
            </div>
            <input class="form-check-input" type="hidden" name="question[]" value="{{ $sub->question->id }}">
            @if ($sub->type_answer == 1)
                @foreach ($sub->question->answer as $item)
                    <div class="form-check col-6">
                        <input class="form-check-input answer-{{ $sub->exists ? 'quizz-' . $sub->id : 'quizz-0' }}"
                            type="radio" name="selected-{{ $sub->id }}" value="{{ $item->id }}"
                            {{ $question_answer[$sub->question->id] == $item->id ? 'checked' : '' }} disabled>
                        <label class="form-check-label">{{ $item->answer }}</label>
                    </div>
                @endforeach
                <label>Correct Answer : {{ $sub->question->correct->answer }}</label>
                <input class="form-check-input" type="hidden" name="answer[]"
                    value="{{ $question_answer[$sub->question->id] }}">

                <br>
                {!! $sub->question->correct->id == $question_answer[$sub->question->id]
                    ? '<label class="text-green">Correct</label>'
                    : '<label class="text-red">Incorrect</label>' !!}
            @else
                <label
                    class="form-check-label">{{ isset($question_answer[$sub->question->id]) ? $question_answer[$sub->question->id] : '' }}</label>
                <input type="hidden" name="answer[]"
                    value="{{ isset($question_answer[$sub->question->id]) ? $question_answer[$sub->question->id] : '' }}">
            @endif
            <input type="number" class="form-control w-25" onkeyup="totalNilai();maxValue(this)"
                onchange="totalNilai();maxValue(this)" min="0" max="100" name="score[]"
                value="{{ isset($score_answer[$sub->question->id]) ? $score_answer[$sub->question->id] : '' }}">
        </div>
    </div>
@else
    {{-- <div class="row justify-content-center">
        <div class="col-md-12" style="display: inline-flex;justify-content: center;">
            <iframe src="{{ route('sub.view', ['file' => base64_encode($sub->file)]) }}" frameBorder="10"
                scrolling="auto" height="900px" width="100%"></iframe>
        </div>
    </div> --}}
@endif
