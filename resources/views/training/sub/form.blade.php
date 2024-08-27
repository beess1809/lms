@if ($data['sub']->training_type_id == 1)
    @include('training.sub.quizz', $data)
@else
    @include('training.sub.course', $data)
@endif
