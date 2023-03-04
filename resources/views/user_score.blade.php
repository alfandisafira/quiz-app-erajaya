@extends('template')

@section('content')

@include('navbar_user')

  <div class="container mt-5">
    <div class="row col-lg-5 col-6 mx-auto quiz-description">
      <div class="col text-center">
        <p>Selamat {{ $name }}, anda mendapatkan nilai</p>
        <p class="bg-dark mx-auto text-white item-quiz">{{ $score }}</p>
      </div>
    </div>
  </div>

@endsection