@extends('layouts.app')

@section('content')
    <h3>{{ $question->question_text }}</h3>
    <ul>
        @foreach($question->answers as $answer)
            <li>{{ $answer->answer_text }} {{ $answer->is_correct ? '(Правильный)' : '' }}</li>
        @endforeach
    </ul>
@endsection
