<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DateTime;

//use Request;

class RecordingController extends Controller {

    //
    public function __construct() {
        $this->middleware('auth');
    }

    //

    public function index() {
        if (\Auth::user()->accesslevel == '10') {
            $loads = \Illuminate\Support\Facades\DB::select('select * from ctrSubjectOffered where instructorid =?', array(\Auth::user()->username));
            $message = DB::select('SELECT * FROM gradeNotification '
                    . 'WHERE createdat IN (SELECT MAX( createdat ) AS "Max Date" '
                    . 'FROM gradeNotification gn INNER JOIN ctrSubjectOffered cs '
                    . 'ON gn.scheduleid = cs.scheduleid WHERE instructorid = ? '
                    . 'GROUP BY gn.scheduleid) GROUP BY scheduleid', array(\Auth::user()->username));
            return view('recording.index', compact('loads','message'));
        } elseif (\Auth::user()->accesslevel == '20') {
            $loads = \Illuminate\Support\Facades\DB::select('select level, subject from basicEdGradeTB  where teacherid =? group by level, subject', array(\Auth::user()->username));
            return view('recording.index1', compact('loads'));
        } elseif (\Auth::user()->accesslevel == env('HIGHEST_APPROVER')) {
            $loads = DB::select('SELECT DISTINCT instructorid, status FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
            $data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
            return view('recording.approver', compact('loads','data'));
        }
    }

    public function getReset() {

        return view('auth/reset');
    }

    public function postReset(Request $request) {
        if ($request->password === $request->password_confirmation) {
            $user = \Auth::user();
            $user->password = bcrypt($request->password);
            $user->update();
            return view('auth/successful');
        }

        return redirect('auth/changepassword')->withErrors("Not Matched");
    }

    public function viewgrade($id, $currentsubject) {

        $loads = \Illuminate\Support\Facades\DB::select('select *  from ctrSubjectOffered where instructorid =?', array(\Auth::user()->username));
        $subjects = \Illuminate\Support\Facades\DB::select("select *  , collegeGradeTB.id as id2 "
                        . "from collegeGradeTB, studentInfo where studentInfo.studentId = collegeGradeTB.studentid AND scheduleid='" . $id . "'"
                        . "order by studentInfo.lastName, studentInfo.firstName ");
        $gradeStat = DB::table('gradeStatus')->where('scheduleid', $id)->first();
        $message = DB::select('SELECT * FROM gradeNotification '
                    . 'WHERE createdat IN (SELECT MAX( createdat ) AS "Max Date" '
                    . 'FROM gradeNotification gn INNER JOIN ctrSubjectOffered cs '
                    . 'ON gn.scheduleid = cs.scheduleid WHERE instructorid = ? '
                    . 'GROUP BY gn.scheduleid) GROUP BY scheduleid', array(\Auth::user()->username));
            
        
        return view('recording/index', compact('loads', 'subjects', 'currentsubject', 'gradeStat', 'id','message'));
    }

    public function viewgradeApprover($id, $currentsubject) {

        $loads = DB::select('SELECT DISTINCT instructorid, status FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
        $data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
            
        $subjects = \Illuminate\Support\Facades\DB::select("select *  , collegeGradeTB.id as id2 "
                        . "from collegeGradeTB, studentInfo where studentInfo.studentId = collegeGradeTB.studentid AND scheduleid='" . $id . "'"
                        . "order by studentInfo.lastName, studentInfo.firstName ");
        $gradeStat = DB::table('gradeStatus')->where('scheduleid', $id)->first();
        
        return view('recording/approver', compact('loads','data', 'subjects', 'currentsubject', 'gradeStat', 'id'));
    }
    
    public function viewgrade1($level, $subject) {
        $loads = \Illuminate\Support\Facades\DB::select('select level, subject from basicEdGradeTB  where teacherid =? group by level, subject', array(\Auth::user()->username));
        $subjects = \Illuminate\Support\Facades\DB::Select("select * , basicEdGradeTB.id as id2  "
                        . "from basicEdGradeTB, studentInfo where studentInfo.studentId = basicEdGradeTB.studentid and "
                        . "basicEdGradeTB.level = '$level' AND basicEdGradeTB.subject = '$subject' AND basicEdGradeTB.teacherid = '" . \Auth::user()->username . "'");
        return view('recording.index1', compact('subjects', 'subject', 'loads'));
    }
    

    public function viewNotification($id){
        
    }
    
    public function encodegrade($id, $type, $value1) {
        $period = [1 => "prelim", 2 => "midterm", 3 => "semifinals", 4 => "finals"];
        \Illuminate\Support\Facades\DB::table('collegeGradeTB')
                ->where('id', $id)
                ->update(array($period[$type] => $value1));


        return true;
    }

    public function encodegrade1($id, $type, $value1) {
        $period = [1 => "firstQTRN", 2 => "secondQTRN", 3 => "thirdQTRN", 4 => "fourthQTRN", 5 => "finalMarkN"];
        \Illuminate\Support\Facades\DB::table('basicEdGradeTB')
                ->where('id', $id)
                ->update(array($period[$type] => $value1));


        return true;
    }

    public function updateSubmission() {
        $postData = Input::all();
        echo $postData['schedid'];
        $data = DB::table('gradeStatus')->where('scheduleid', array('scheduleid' => $postData['schedid']))->first();
       //INSERTION OF DATA IF NO RECORD YET
        if ($data == "") {
            $data = array('scheduleid' => $postData['schedid'],
                'status' => env('FOR_APPROVAL'),
                'createdat' => new DateTime(),
            );
            $check = DB::table('gradeStatus')->Insert($data);
            $checkNotification = insertNotification($postData);
            
             
            echo $check;
            if ($check > 0 && $checkNotification > 0) {
               $message = "Thank you for your registration";
                return Redirect::to('/')->with('message', $message);
            }
        } else {
            //UPDATING DATA IF EXISTING
            $data = array('createdat' => new DateTime(),
                );
            if($postData['button']=="approve"){
                $data = array('assessby' => \Auth::user()->username,
                'status' => env('APPROVE'),);
            }elseif($postData['button']=="disapprove"){
                $data = array('assessby' => \Auth::user()->username,
                'status' => env('DISAPPROVE'),); 
            }else{
                $data = array('status' => env('FOR_APPROVAL'),); 
            }
            
            $check = DB::table('gradeStatus')->where('scheduleid', array('scheduleid' => $postData['schedid']))->update($data);
            $checkNotification = insertNotification($postData);
            
             
            echo $check;
            if ($check > 0 && $checkNotification > 0) {
                $message = "Data updated but for approval";
                return Redirtrueect::to('/');
           }
    }


    
    
    
    function insertNotification($postData){
        if(isset($postData['comment'])!=""){
                $data = array('scheduleid' => $postData['schedid'],
                'comment' => $postData['comment'],
                'status' => env('UNREAD'),
                'createdat' => new DateTime(),
            );
             $checkNotification =   DB::table('gradeNotification')->Insert($data);
             
                return $checkNotification;
            }
        }
    }
    
 }

