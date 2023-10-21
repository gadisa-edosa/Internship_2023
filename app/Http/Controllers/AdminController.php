<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\ExamAttempt;
use App\Models\Exam;
use App\Exports\ExportStudent;
use App\Models\ExamAnswer;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\User;
use App\Imports\QnaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;


use Illuminate\Support\Str;

class AdminController extends Controller
{
    //add subject
    public function addSubject(Request $request)
    {
        try {
            subject::insert([
                'subject' => $request->subject

            ]);
            return response()->json(['success' => true, "msg" => 'subject is added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, "msg" => $e->getMessage()]);
        };
    }

    //edit subject
    public function editSubject(Request $request)
    {
        try {
            $subject = Subject::find($request->id);
            $subject->subject = $request->subject;
            $subject->save();
            return response()->json(['success' => true, 'msg' => 'subject is updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        };
    }

    //delete subject
    public function deleteSubject(Request $request)
    {
        try {
            Subject::where('id', $request->id)->delete();
            return response()->json(['success' => true, "msg" => 'subject is deleted ssuccessfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, "msg" => $e->getMessage()]);
        };
    }
    protected function examDashboard()
    {



        $subjects = Subject::all();
        $exams = Exam::with('subjects')->get();
        return view("admin.Exam-dashboard", ['subjects' => $subjects, 'exams' => $exams]);
    }
    public function addExam(Request $request)
    {
        try {
            $unique_id = uniqid('exid');


            Exam::insert([
                'exam_name' => $request->exam_name,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
                'time' => $request->time,
                'attempt' => $request->attempt,
                'enterance_id' => $unique_id


            ]);
            return response()->json(['success' => true, "msg" => 'Exam added ssuccessfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, "msg" => $e->getMessage()]);
        };
    }
    //edit exam
    public function getExamDetail($id)
    {
        try {
            $exam = Exam::where('id', $id)->get();
            return response()->json(['success' => true, "data" => '$exam']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        };
    }
    public function editExam(Request $request)
    {
        try {
            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id;
            $exam->date = $request->date;
            $exam->time = $request->time;
            $exam->attempt = $request->attempt;

            $exam->save();
            return response()->json(['success' => true, 'msg' => 'exam is updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        };
    }
    //delete exam
    public function deleteExam(Request $request)
    {
        try {
            Exam::where('id', $request->exam_id)->delete();
            return response()->json(['success' => true, 'msg' => 'exam is deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        };
    }
    public function qnaDashboard()
    {
        $questions = Question::with('Answers')->get();
        return view('admin.qnaDashboard', compact('questions'));
    }
    //add Q&A
    public function addQna(Request $request)
    {

        try {
            $explanation = null;
            if (isset($request->explanation)) {
                $explanation = $request->explanation;
            }

            $questionId = Question::insertGetId([
                'question' => $request->question,
                'explanation' => $explanation
            ]);

            foreach ($request->answers as $answer) {
                $is_correct = 0;
                if ($request->is_correct == $answer) {
                    $is_correct = 1;
                }
                Answer::insert([
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'is_correct' => $is_correct
                ]);
            }
            return response()->json(['success' => true, 'msg' => 'exam is deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        };
    }
    public function getQnaDetails(Request $request)
    {
        $qna = Question::where('id', $request->qid)->with('answers')->get();
        return response()->json(['data' => $qna]);
    }
    public function deleteAns(Request $request)
    {
        Answer::where('id', $request->id)->delete();
        return response()->json(['success' => true, 'msg' => 'answer is deleted succcessfully']);
    }
    public function updateQna(Request $request)
    {
        try {
            $explanation = null;
            if (isset($request->explanation)) {
                $explanation = $request->explanation;
            }

            Question::where('id', $request->question_id)->update([
                'question' => $request->question,
                'explanation' => $explanation
            ]);

            // Old answer update
            if (isset($request->answers)) {
                foreach ($request->answers as $key => $value) {
                    $is_correct = 0;
                    if ($request->is_correct == $key) {
                        $is_correct = 1;
                    }
                    Answer::where('id', $key)
                        ->update([
                            'question_id' => $request->question_id,
                            'answer' => $value,
                            'is_correct' => $is_correct,
                        ]);
                }
            }

            // New answer is added
            if (isset($request->new_answers)) {
                foreach ($request->new_answers as $answer) {
                    $is_correct = 0;
                    if ($request->is_correct == $answer) {
                        $is_correct = 1;
                    }
                    Answer::insert([
                        'question_id' => $request->question_id,
                        'answer' => $answer,
                        'is_correct' => $is_correct,
                    ]);
                }
            }

            return response()->json(['success' => true, 'msg' => 'Q&A updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function deleteQna(Request $request)
    {
        Question::where('id', $request->id)->delete();
        Question::where('question_id', $request->id)->delete();
        return response()->json(['success' => true, 'msg' => 'Q&A is deleted successfully!']);
    }
    public function  importQna(Request $request)
    {
        try {
            Excel::import(new QnaImport, $request->file('file'));
            return response()->json(['success' => true, 'msg' => 'import Q&A is succcessfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    //student dashboard
    public function studentsDashboard()
    {
        $students = User::where('is_admin', 0)->get();
        return view('admin.studentsDashboard', compact('students'));
    }


    //add student

    public function addStudent(Request $request)
    {
        try {
            $password = Str::random();

            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password)
            ]);

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = $password;
            $data['title'] = "Student Registration on Quiz";

            Mail::send('registrationMail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['success' => true, 'msg' => 'Student is added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    //edit student
    public function editStudent(Request $request)
    {
        try {


            $user = User::find($request->id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['title'] = "updated Student profile on Quiz";

            Mail::send('updateProfileMail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return response()->json(['success' => true, "msg" => 'Student profile is updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, "msg" => $e->getMessage()]);
        }
    }

    //Delete Student
    public function deleteStudent(Request $request)
    {
        try {
            User::where('id', $request->id)->delete();
            return response()->json(['success' => true, 'msg' => 'Student is deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        };
    }

    public function exportStudents()
    {
        return Excel::download(new ExportStudent, 'students.xlsx');
    }

    //get questions
    public function getQuestions(Request $request)
    {
        try {
            $questions = Question::all();
            if (count($questions) > 0) {

                $data = [];
                $counter = 0;

                foreach ($questions as $question) {
                    $qnaExam = QnaExam::where(['exam_id' => $request->exam_id, 'question_id' => $question->id])->get();
                    if (count($qnaExam) == 0) {
                        $data[$counter]['id'] = $question->id;
                        $data[$counter]['questions'] = $question->question;
                        $counter++;
                    }
                }
                return response()->json(['success' => true, 'msg' => 'Questions data!', 'data' => $data]);
            } else {
                return response()->json(['success' => false, 'msg' => 'question is not found!']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        };
    }

    //add questions
    public function addQuestions(Request $request)
    {
        try {
            if (isset($request->questions_ids)) {
                $exam_id = $request->exam_id;

                foreach ($request->questions_ids as $qid) {
                    QnaExam::insert([
                        'exam_id' => $exam_id,
                        'question_id' => $qid,
                    ]);
                }
            }

            return response()->json(['success' => true, 'msg' => 'Question is added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    //see questions
    public function getExamQuestions(Request $request)
    {
        try {
            $data = QnaExam::where('exam_id', $request->exam_id)->with('question')->get();
            return response()->json(['success' => true, 'msg' => 'Question details!', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    //delete questions
    public function deleteExamQuestions(Request $request)
    {
        try {
            $id = $request->id;
            error_log("Deleting question with ID: " . $id); // Log message for debugging
            QnaExam::where('id', $id)->delete();
            return response()->json(['success' => true, 'msg' => 'Question is deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'id', 'subject_id');
    }

    public function getQnaExam()
    {
        return $this->hasMany(QnaExam::class, 'exam_id', 'id');
    }
    public function loadMarks()
    {
        $exams = Exam::with('getQnaExam')->get();
        return view('admin.marksDashboard', compact('exams'));
    }

    //edit marks
    public function updateMarks(Request $request)
    {
        try {
            Exam::where('id', $request->exam_id)->update([
                'marks' => $request->marks,
                'pass_marks' => $request->pass_marks
            ]);
            return response()->json(['success' => true, 'msg' => 'Marks are Updated']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function reviewExams()
    {
        $attempts = ExamAttempt::with(['user', 'exam'])->orderBy('id')->get();
        return view('admin.review-exams', compact('attempts'));
    }
    public function reviewQna(Request $request)
    {
        try {



            $attemptData = ExamAnswer::where('attempt_id', $request->attempt_id)->with(['question', 'answers'])->get();

            return response()->json(['success' => true, 'data' => $attemptData]);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }


    public function approvedQna(Request $request)
    {
        try {
            $attemptId = $request->attempt_id;
            $examData = ExamAttempt::where('id', $attemptId)->with('user', 'exam')->get();
            $marks = $examData[0]['exam']['marks'];
            $attemptData = ExamAnswer::where('attempt_id', $attemptId)->with(['answers'])->get();
            $totalMarks = 0;
            if (count($attemptData) > 0) {
                foreach ($attemptData as $attempt) {
                    if ($attempt->answers->is_correct == 1) {
                        $totalMarks += $marks;
                    }
                }
            }
            ExamAttempt::where('id', $attemptId)->update([
                'status' => 1,
                'marks' => $totalMarks
            ]);
            $url = URL::to('/');
            $data['url'] = $url . '/results';
            $data['name'] = $examData[0]['user']['name'];
            $data['email'] = $examData[0]['user']['email'];
            $data['exam_name'] = $examData[0]['exam']['exam_name'];
            $data['title'] = $examData[0]['exam']['exam_name'] . 'Result';
            Mail::send('result-mail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });


            return response()->json(['success' => true, 'msg' => 'approved successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
