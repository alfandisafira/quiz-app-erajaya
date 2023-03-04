@extends('template')

@section('content')

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">ADMIN</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-flex-lg justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="#exercises">Exercises</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#scores">Scores</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="tab-content mx-auto col-sm-8">
      <div class="tab-pane active" id="exercises">
        <table class="table table-striped" id="exercisesTable">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Question Amount</th>
              <th scope="col">Working Time</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>          

        <div class="d-flex justify-content-end mt-4">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exerciseModal">Add Exercise</button>
        </div>
      </div>
      <div class="tab-pane" id="scores">
        <table class="table table-striped" id="scoresTable">
          <thead>
            <tr>
              <th scope="col">Username</th>
              <th scope="col">Exercises Name</th>
              <th scope="col">Score</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Modals Section --}}
  <!-- Modal -->
  <div class="modal fade" id="exerciseModal" tabindex="-1" role="dialog" aria-labelledby="exerciseModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exerciseModalTitle">Add Exercise</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form action="exercise/create" method="POST">
            @csrf
            <div class="modal-body">
              <div class="form-row mb-4">
                <div class="form-group col-8">
                  <label for="description">Descrition Exercise</label>
                  <input type="text" class="form-control" name="desccription" id="desccription" required>
                </div>
                <div class="form-group col-4">
                  <label for="workingTime">Working Time</label>
                  <input type="number" min="15" class="form-control" name="working_time" id="workingTime" placeholder="in minutes" required>
                </div>
              </div>
              @for ($i = 1; $i <= 10; $i++)
              @php
                if($i % 2 == 0){
                  $color = 'bg-light';
                } else {
                  $color = 'bg-dark text-white';
                }
              @endphp
                <div class="{{ $color }} p-1 mb-3 question">
                  <div class="form-group">
                    <input type="text" class="form-control" name="question[{{ $i }}][sentence]" placeholder="Question {{ $i }}" required>
                  </div>
                  <div class="form-row">
                    @for($j = 1; $j <= 4; $j++)
                      <div class="form-group col-3">
                        <label for="question[{{ $i }}][options][{{ $j }}]">Opt. {{ $j }}</label>
                        <input type="text" class="form-control" name="question[{{ $i }}][options][{{ $j }}]" required>
                      </div>
                    @endfor
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="answerOptions{{ $i }}">Right Answer</label>
                    </div>
                    <select class="custom-select" name="question[{{ $i }}][right_answer]" id="answerOptions{{ $i }}" required>
                      <option value="">Choose option...</option>
                      <option value="1">Option 1</option>
                      <option value="2">Option 2</option>
                      <option value="3">Option 3</option>
                      <option value="4">Option 4</option>
                    </select>
                  </div>
                </div>
              @endfor
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success add-question">Add 1</button>
              <button type="button" class="btn btn-danger d-none delete-question">Delete 1</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </form>
      </div>
    </div>
  </div>

@endsection