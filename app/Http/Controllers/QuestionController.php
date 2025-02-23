<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Question;
use App\Models\Scores;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $title = "Trips";
        
        $driverList = Driver::get();
        $vehicles = Vehicle::all();

        return view('question', [
            'user' => $request->user(),
            'title' => $title,
            'driverList' => $driverList,
            'vehicles' => $vehicles,
        ]);
    }

    public function page(Request $request, $driver_id, $license_number): View
    {
        $questionsPerPage = 10;
        $sessionKey = "quiz_driver_{$driver_id}";
        $answersKey = "answers_driver_{$driver_id}";

        // Validasi apakah pengemudi ada
        $driver = Driver::where('id', $driver_id)->where('license_number', $license_number)->firstOrFail();

        // Cek apakah sesi sudah memiliki soal untuk pengemudi ini
        if (!Session::has($sessionKey)) {
            $questionList = Question::inRandomOrder()->limit($questionsPerPage)->get();
            Session::put($sessionKey, $questionList);
        } else {
            $questionList = Session::get($sessionKey);
        }

        // Ambil index saat ini dari parameter URL, default ke 0
        $currentIndex = $request->query('index', 0);

        // Jika soal terakhir sudah terjawab, hitung nilai
        if ($currentIndex >= count($questionList)) {
            return redirect()->route('quiz.finish', [$driver_id, $license_number]);
        }

        $currentQuestion = $questionList[$currentIndex];
        $savedAnswers = Session::get($answersKey, []);

        return view('formQuestion.questionPage', [
            'user' => $request->user(),
            'driver' => $driver,
            'question' => $currentQuestion,
            'index' => $currentIndex,
            'totalQuestions' => count($questionList),
            'savedAnswers' => $savedAnswers,
        ]);
    }

    // Simpan jawaban pengguna
    public function saveAnswer(Request $request)
    {
        $driver_id = $request->input('driver_id');
        $index = $request->input('index');
        $answer = $request->input('answer');

        $answersKey = "answers_driver_{$driver_id}";
        $answers = Session::get($answersKey, []);
        $answers[$index] = $answer;
        Session::put($answersKey, $answers);

        return response()->json(['status' => 'success', 'savedAnswers' => $answers]);
    }

    // Hitung skor & simpan ke database
    public function finishQuiz($driver_id, $license_number)
    {
        $sessionKey = "quiz_driver_{$driver_id}";
        $answersKey = "answers_driver_{$driver_id}";

        // Ambil soal dan jawaban pengguna dari sesi
        $questionList = Session::get($sessionKey, []);
        $userAnswers = Session::get($answersKey, []);

        if (empty($questionList)) {
            return redirect()->route('quiz.page', [$driver_id, $license_number]); // Jika tidak ada soal, kembali ke awal
        }

        $correctAnswers = 0;
        $totalQuestions = count($questionList);

        // Cek jawaban benar
        foreach ($questionList as $index => $question) {
            if (isset($userAnswers[$index]) && $userAnswers[$index] == $question->correct_answer) {
                $correctAnswers++;
            }
        }

        // Hitung nilai
        $scoreValue = round(($correctAnswers / $totalQuestions) * 100);

        // Simpan skor ke database
        Scores::updateOrCreate(
            ['driver_id' => $driver_id],
            ['score' => $scoreValue]
        );

        // Hapus sesi setelah selesai
        Session::forget($sessionKey);
        Session::forget($answersKey);

        return view('formQuestion.resultPage', [
            'driver' => Driver::find($driver_id),
            'score' => $scoreValue
        ]);
    }
}
