<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function registerAction()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create(request(['name', 'email', 'password']));

        return redirect()->back();
    }

    public function loginAction(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('home');
        }
    }

    public function logoutAction()
    {
        session()->flush();

        return redirect('/user');
    }

    public function home()
    {
        $data = app('App\Http\Controllers\ExerciseController')->index(true);

        return view('home')->with([
            'data' => $data
        ]);
    }

    public function startQuiz(Request $request)
    {
        $new_exercise = json_decode($request->new_exercise);

        return view('quiz')->with([
            'data' => $new_exercise
        ]);
    }

    public function finishQuiz(Request $request)
    {
        $questions = Question::where('exercise_id', $request->exercise_id)->get();

        $score = 0;

        if ($request->input('answers')) {
            foreach ($questions as $q) {
                foreach ($request->answers as $key => $value) {
                    if ($key == $q->id and $value == $q->answer_id) {
                        $score++;
                    }
                }
            }
        }

        $score = ($score / $request->question_amount) * 100;

        $me = auth()->user();

        return view('user_score')->with([
            'name' => $me->name,
            'score' => $score,
        ]);
    }
}
