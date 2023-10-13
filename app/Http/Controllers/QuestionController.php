<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class QuestionController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->check() && auth()->user()->is_admin;

        if ($isAdmin) {
            $questions = Question::all();
        } else {
            $questions = Question::where('user_id', auth()->id())->get();
        }

        return view('questions.index', ['questions' => $questions, 'isAdmin' => $isAdmin]);
    }





    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:65535',
            'answers' => 'required|array|min:1',
            'answers.*' => 'required|string|max:255',
            'correct_answers.*' => 'required|boolean',
        ]);

        $question = new Question;
        $question->question_text = $request->input('question_text');
        $question->unique_key = substr(md5(uniqid(rand(), true)), 0, 10);  // генерация ключа
        $question->user_id = auth()->id();
        $question->save();

        $answers = $request->input('answers');
        $correct_answers = $request->input('correct_answers', []);
        $order_ids = $request->input('order_ids', []);

        foreach ($answers as $index => $answer_text) {
            if (trim($answer_text) != "") {
                $answer = new Answer;
                $answer->answer_text = $answer_text;
                $answer->is_correct = isset($correct_answers[$index]) ? true : false;
                $answer->order_id = $order_ids[$index] ?? 0;
                $question->answers()->save($answer);
            }
        }
        return redirect('/questions');
    }

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }





    public function edit(Question $question)
    {
        $this->authorizeUserAction($question);
        $answers = $question->answers;
        return view('questions.edit', compact('question', 'answers'));
    }




    public function update(Request $request, Question $question)
    {
        $this->authorizeUserAction($question);
        $question->question_text = $request->input('question_text');
        $question->save();

        // Обновить существующие ответы
        $answers = $request->input('answers');
        $correct_answers = $request->input('correct_answers', []);
        $order_ids = $request->input('order_ids');

        foreach ($answers as $answer_id => $answer_text) {
            $answer = Answer::find($answer_id);
            if ($answer) {
                $answer->answer_text = $answer_text;
                $answer->is_correct = isset($correct_answers[$answer_id]) ? 1 : 0;
                $answer->order_id = $order_ids[$answer_id] ?? 0;
                $answer->save();
            }
        }

        // Добавить новые ответы
        $new_answers = $request->input('new_answers', []);
        $new_correct_answers = $request->input('new_correct_answers', []);
        foreach ($new_answers as $index => $new_answer_text) {
            $answer = new Answer;
            $answer->answer_text = $new_answer_text;
            $answer->is_correct = isset($new_correct_answers[$index]) ? 1 : 0;
            $question->answers()->save($answer);
        }


        return redirect()->route('questions.index')->with('status', 'Вопрос успешно обновлен!');
    }







    public function destroy(Question $question)
    {
        $this->authorizeUserAction($question);
        $question->answers()->delete(); // Удаляем все связанные ответы
        $question->delete();

        return redirect()->route('questions.index')->with('status', 'Вопрос успешно удален!');
    }






    public function enterKey()
    {
        return view('questions.enterKey');
    }
    public function showByKey(Request $request)
    {
        $unique_key = $request->input('unique_key');
        $question = Question::where('unique_key', $unique_key)->first();

        if (!$question) {
            return redirect('/enterKey')->with('error', 'Такого вопроса не существует!');
        }

        return view('questions.take', compact('question'));
    }


    public function answer(Request $request, Question $question)
    {
        $selectedAnswers = $request->input('selected_answers', []);

        foreach ($selectedAnswers as $selectedAnswerId) {
            UserAnswer::create([
                'user_id' => auth()->user()->id,
                'question_id' => $question->id,
                'answer_id' => $selectedAnswerId
            ]);
        }

        return redirect()->route('questions.enterKey')->with('message', 'Спасибо за ответ!');
    }



    public function getAnswersData(Question $question)
    {
        $answers = $question->answers;

        $data = [];
        foreach ($answers as $answer) {
            $data[] = [
                'answer_text' => $answer->answer_text,
                'count' => UserAnswer::where('answer_id', $answer->id)
                    ->whereDate('created_at', now()->toDateString())
                    ->count()
            ];
        }

        return response()->json($data);
    }


    public function dashboard($uniqueKey)
    {
        $question = Question::where('unique_key', $uniqueKey)->first();

        if (!$question) {
            return redirect('/')->with('error', 'Вопрос не найден!');
        }

        return view('dashboards.dashboard', compact('question'));
    }





    private function authorizeUserAction(Question $question)
    {
        if (auth()->id() !== $question->user_id && !auth()->user()->is_admin) {
            abort(403, "Unauthorized action.");
        }
    }
}
