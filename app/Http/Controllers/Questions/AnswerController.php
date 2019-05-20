<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Http\Requests\Answers\CreateAnswerRequest;
use App\Repositories\Contracts\AnswerRepositoryInterface as AnswerInterface;
use App\Notifications\AnswerQuestion;
use Auth;

class AnswerController extends Controller
{
    private $answerRepository;

    public function __construct(AnswerInterface $answerRepository)
    {
        $this->middleware('auth');
        $this->answerRepository = $answerRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAnswerRequest $request, Question $question)
    {
        $this->answerRepository->store($request, $question);
        if (Auth::user()->id !== $question->user_id) {
            $question->user->notify(new AnswerQuestion(Auth::user(), $question));
        }

        return redirect()->route('questions.show', ['question' => $question->id]);
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
