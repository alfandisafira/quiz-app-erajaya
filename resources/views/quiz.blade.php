@extends('template')

@section('content')

@include('navbar_user')

<div class="container">
  <div class="row col-sm-10 col-lg-3 mx-auto ">
    <form action="/finish-quiz" method="POST" class="p-3" id="quizForm">
      @csrf
      <div class="quiz-header pl-3">
        <div class="form-group row">
          <label>Quiz {{ $data->description }}</label>
        </div>
        <div class="form-group row">
          <label>Time remaining: <span id="workingTime">{{ $data->working_time }}</span></label>
        </div>
      </div>
      <input type="hidden" name="exercise_id" value="{{ $data->id }}">
      <input type="hidden" name="question_amount" value="{{ $data->question_amount }}">
      <div id="questions">
        @foreach ($data->questions as $q)
          <div class="question mb-5 px-2 py-2 d-none">
            <div class="form-group row px-4 col-lg-10">
              <label>{{ $q->question_sentence }}</label>
            </div>
            <div class="form-group row px-2 options">
              @foreach ($q->options as $o)
                <div class="col-lg-10">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" id="opt{{ $o->id }}" value="{{ $o->id }}">
                    <label class="form-check-label" for="id{{ $q->id }}">
                      {{ $o->answer_sentence }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
            <div class="d-flex justify-content-between btn-group-quiz">
              <button type="button" class="btn btn-primary btn-prev">Previous</button>
              <button type="button" class="btn btn-primary btn-next">Next</button>
            </div>
          </div>
        @endforeach
      </div>
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-danger">Finish</button>
      </div>
    </form>
  </div>
</div>

@endsection