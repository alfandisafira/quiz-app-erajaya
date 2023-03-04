@extends('template')

@section('content')

@include('navbar_user')

<div class="container mt-5">
  @php
    $i = 0;   
  @endphp

  @foreach ($data as $exercise)
    <div class="row col-lg-5 col-6 mx-auto quiz-description">
      <div class="col text-center">
        <p>Description</p>
        <p class="bg-dark mx-auto text-white item-quiz">{{ $exercise->description }}</p>
        <p>Working time</p>
        <p class="bg-dark mx-auto text-white item-quiz">{{ $exercise->working_time / 60000 }} minutes</p>
        <p>Question Amount</p>
        <p class="bg-dark mx-auto text-white item-quiz">{{ $exercise->question_amount }}</p>
        <button type="button" class="btn btn-primary mt-3 btn-exe" data-content="{{ $exercise }}">Start Quiz!</button>
      </div>
    </div>

    @php
      $i++;   
    @endphp
  @endforeach
    
</div>

<form action="/start-quiz" method="POST" id="formNewExercise">
  @csrf
  <input type="hidden" name="new_exercise" value="" id="newExercise">
</form>


@endsection