<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();
        return view('questions.index', ['questions' => $questions]);
    }

    

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $question = new Question;
        $question->question_text = $request->input('question_text');
        $question->unique_key = substr(md5(uniqid(rand(), true)), 0, 10);  // генерация ключа
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
        $answers = $question->answers;
        return view('questions.edit', compact('question', 'answers'));
    }
    public function update(Request $request, Question $question)
    {
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
        $question->answers()->delete(); // Удаляем все связанные ответы
        $question->delete();

        return redirect()->route('questions.index')->with('status', 'Вопрос успешно удален!');
    }


    public function enterKey() {
        return view('questions.enterKey');
    }
    public function showByKey(Request $request) {
        $unique_key = $request->input('unique_key');
        $question = Question::where('unique_key', $unique_key)->first();
    
        if (!$question) {
            return redirect('/enterKey')->with('error', 'Такого вопроса не существует!');
        }
    
        return view('questions.show', compact('question'));
    }
    
    
    
}
