<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;



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
            'is_anonymous' => 'sometimes|boolean',
            'answer_type' => 'required|in:radio,checkbox',
        ]);

        $question = new Question;
        $question->question_text = $request->input('question_text');
        $question->is_anonymous = $request->input('is_anonymous', false);  // Сохраняем значение чекбокса
        $question->answer_type = $request->input('answer_type'); // Сохранить тип ответа
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
        return view('dashboards.dashboard', [
            'question' => $question,
            'uniqueKey' => $question->unique_key 
        ]);
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

    // Если опрос анонимный
    if ($question->is_anonymous) {
        $userId = User::where('name', 'Anonym')->firstOrCreate(['name' => 'Anonym'])->id;
    }
    // Если опрос не анонимный и пользователь авторизован
    else if (auth()->check()) {
        $userId = auth()->user()->id;
    }
    // Если опрос не анонимный и пользователь не авторизован
    else {
        // Получаем имя из запроса
        $name = $request->input('name');

        // Ищем пользователя по имени
        $user = User::where('name', $name)->first();

        // Если пользователя с таким именем нет, создаем новую запись
        if (!$user) {
            $generatedPassword = bcrypt(Str::random(10));  // Генерация случайного пароля
        
            $user = User::create([
                'name' => $name,
                'password' => $generatedPassword,
                // Остальные поля можете заполнить по умолчанию или на основе других данных
            ]);
        }

        // // Авторизуем пользователя
        // auth()->login($user);

        $userId = $user->id;
    }

    // Сохраняем ответы пользователя
    foreach ($selectedAnswers as $selectedAnswerId) {
        UserAnswer::create([
            'user_id' => $userId,
            'question_id' => $question->id,
            'answer_id' => $selectedAnswerId
        ]);
    }

    return redirect()->route('questions.enterKey')->with('message', 'Спасибо за ответ!');
}





public function getAnswersData(Question $question)
{
    $answers = $question->answers;

    $dataForChart = [];
    foreach ($answers as $answer) {
        $dataForChart[] = [
            'answer_text' => $answer->answer_text,
            'count' => UserAnswer::where('answer_id', $answer->id)
                ->whereDate('created_at', now())
                ->count()
        ];
    }

    // Получение ответов за текущий день
    $today = Carbon::today();
    $answersToday = UserAnswer::whereHas('answer', function ($query) use ($question) {
        $query->where('question_id', $question->id);
    })->whereDate('created_at', $today)->get();

    $respondentsData = $answersToday->map(function ($userAnswer) {
        return [
            'user' => optional($userAnswer->user)->name,  // предположим, что у вас есть связь с моделью User
            'answer' => $userAnswer->answer->answer_text,
            'time' => $userAnswer->created_at->toTimeString(),
        ];
    });

    return response()->json([
        'chartData' => $dataForChart,
        'respondentsData' => $respondentsData,
    ]);
}




    public function dashboard($uniqueKey)
    {
        $question = Question::where('unique_key', $uniqueKey)->first();

        if (!$question) {
            return redirect('/')->with('error', 'Вопрос не найден!');
        }

        return view('dashboards.dashboard', compact('question'));
    }



    public function generateQRCode($unique_key)
    {
        $question = Question::where('unique_key', $unique_key)->firstOrFail();
        
        $url = route('questions.showByKey', ['unique_key' => $question->unique_key]); 
    
        $qrImage = QrCode::format('png')->size(300)->generate($url);
    
        return response($qrImage)->header('Content-Type', 'image/png');
    }
    
    

    
    


    


    private function authorizeUserAction(Question $question)
    {
        if (auth()->id() !== $question->user_id && !auth()->user()->is_admin) {
            abort(403, "Unauthorized action.");
        }
    }
}
