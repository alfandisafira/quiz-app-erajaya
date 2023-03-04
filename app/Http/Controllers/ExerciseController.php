<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exercise;
use App\Models\Question;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($return_array = false)
    {
        $data = Exercise::with('questions')->get();
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]['questions']); $j++) {
                $q_id = $data[$i]['questions'][$j]->id;
                $data[$i]['questions'][$j] = Question::where('id', $q_id)->with('answers')->first();
                $data[$i]['questions'][$j]->options = $data[$i]['questions'][$j]->answers;
                unset($data[$i]['questions'][$j]->answers);
                foreach ($data[$i]['questions'][$j]->options as $option) {
                    if ($option->id === $data[$i]['questions'][$j]->answer_id) {
                        $data[$i]['questions'][$j]->answer = $option;
                    }
                }
            }
        }

        if ($return_array) {
            return $data;
        } else {
            return response()->json($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->input());
        // dd($request->input('question'));

        $exercise = new Exercise;
        $exercise->description = $request->input('desccription');
        $exercise->working_time = intval($request->input('working_time')) * 60000;
        $exercise->question_amount = count($request->input('question'));
        $exercise->save();


        foreach ($request->input('question') as $q) {
            $question = new Question;
            $question->question_sentence = $q['sentence'];
            $question->exercise_id = $exercise->id;
            $question->answer_id = 0;
            $question->save();

            foreach ($q['options'] as $key => $val) {
                // dd($key, $val);
                $answer = new Answer;
                $answer->answer_sentence = $val;
                $answer->question_id = $question->id;
                $answer->save();
                if (intval($q['right_answer']) == $key) {
                    $question->answer_id = $answer->id;
                }
            }
            $question->save();
        }

        return "Exercise Saved Successfully!";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
