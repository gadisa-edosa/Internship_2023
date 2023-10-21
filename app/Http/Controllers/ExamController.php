<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use Illuminate\Support\Facades\Auth;




use Carbon\Carbon;

class ExamController extends Controller
{

    public function loadExamDashboard($id)
    {
        $qnaExam = Exam::where('enterance_id', $id)->with('getQnaExam')->inRandomOrder()->get();
        //start
        /* if($count($qnaExam) > 0){


            if(getQnaExam[0]['date'] == date('Y-m-d')){
                if(count(getQnaExam[0]['getQnaExam'])>0){

                }else{
                    return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam is not availabile for now','exam'=>$qnaExam]);

                }
            }
            else if(getQnaExam[0]['date'] >date('Y-m-d')){
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam will be start on'.$qnaExam[0]['date'],'exam'=>$qnaExam]);

            }else{
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam has been expiered on'.$qnaExam[0]['date'],'exam'=>$qnaExam]);


            }
            }
            else{return view('404');} */
        //end

        $attemptCount = 0; // Initialize the variable with a default value

        if (!empty($qnaExam[0]) && $attemptCount >= $qnaExam[0]['attempt']) {
            return view('/student.exam-dashboard', ['success' => false, 'msg' => 'Your exam attempt has been completed', 'exam' => $qnaExam]);
        }

        if (count($qnaExam) > 0) {
            $qna = QnaExam::where('exam_id', $qnaExam[0]['id'])
                ->with('question', 'answers')
                ->get();

            return view('student.exam-dashboard', [
                'success' => true,
                'exam' => $qnaExam,
                'qna' => $qna
            ]);
        } else {
            // Handle the case when $qnaExam is empty or doesn't have any elements
            return view('student.exam-dashboard', [
                'success' => false,
                'msg' => 'Exam not found'
            ]);
        }
    }
    public function examSubmit(Request $request)
    {


        $attempt_id = ExamAttempt::insertGetId([

            'exam_id' => $request->exam_id,
            'user_id' => Auth::user()->id
        ]);


        $qcount = count($request->q);
        if ($qcount > 0) {
            for ($i = 0; $i <= $qcount; $i++) {
                if (isset($request->q[$i])) {
                    ExamAnswer::insert([
                        'attempt_id' => $attempt_id,
                        'question_id' => $request->q[$i],
                        'answer_id' => $request->input('ans_' . ($i + 1))
                    ]);
                }
            }
        }


        return view('thank-you');
    }


    public function resultDashboard()
    {
        $attempts = ExamAttempt::where('user_id', Auth()->user()->id)->with('exam')->orderBy('updated_at')->get();




        return view('student.results', compact('attempts'));
    }
    public function reviewQna(Request $request)
    {
        try {
            $attemptData = ExamAnswer::where('attempt_id', $request->attempt_id)->with('question', 'answers')->get();
            return response()->json(['success' => true, 'msg' => 'Q$A Data', 'data' => $attemptData]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
