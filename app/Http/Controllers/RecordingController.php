<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Session;
use View;
use Response;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Request;
use Validator;
use App\User;


class RecordingController extends Controller {

    
    
    //
    public function __construct() {
        $this->middleware('auth');
    }

    //
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
    }
    
    

    public function index() {
        
        $department = "";
        
        if (\Auth::user()->accesslevel == '10') {
            $department = $this->getAccessLevelDepartment(\Auth::user()->accesslevel);  
            $loads = $this->selectSubjectOffered(); 
            $message = $this->selectNotification();
            $quarter = DB::Select("Select quarter from ctrSY where department = '".$department."'");
                
            return view('recording.index', compact('loads', 'message','quarter'));
       
        } elseif (\Auth::user()->accesslevel == '20'  || \Auth::user()->accesslevel == '30'||\Auth::user()->accesslevel == '40'|| \Auth::user()->accesslevel == '70') {
            $department = $this->getAccessLevelDepartment(\Auth::user()->accesslevel);  
            $loads = $this->getSubjectBasicEd($department);
            
            $schoolyear = ReportController::getSchoolYear($department);
            $data = DB::select('SELECT * FROM basicEdTeachers WHERE schoolyear = "'.$schoolyear.'" and instructorid = ?', array(\Auth::user()->username));
            $quarter = DB::Select("Select quarter from ctrSY where department = '".$department."'");
            
            return view('recording.index1', compact('loads','data','quarter'));
        
        } elseif (\Auth::user()->accesslevel == env('HIGHEST_APPROVER')) {
            $schoolyear = ReportController::getSchoolYear('College');
            //$loads = DB::select('SELECT DISTINCT instructorid, status FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE schoolyear = "'.$schoolyear.'" and gs.status =1');
            $loads = DB::select('SELECT DISTINCT instructor, gs.STATUS, concat( u.fname, " ", u.lname ) as name
                    FROM ctrSubjectOffered cs
                    INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid
                    INNER JOIN users u ON cs.instructor = u.username
                    WHERE schoolyear = "'.$schoolyear.'"
                    AND gs.status =1');
            $data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE  schoolyear = "'.$schoolyear.'" and  gs.status =1');
            
            $teacher = $this->selectDistinctTeacher('Junior High School');
            $subject1 = $this->selectDistinctSubject('Junior High School');
            $teacherdata = $this->selectTeacherData('Junior High School');
           
            return view('recording.approver', compact('loads', 'data', 'teacher', 'subject1', 'teacherdata'));
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

    public function getSubjectBasicEd($department){
        $schoolyear = ReportController::getSchoolYear($department);
        $loads = DB::select('SELECT Distinct subject FROM basicEdTeachers WHERE schoolyear = "'.$schoolyear.'" and instructorid = ?', array(\Auth::user()->username));
        return $loads;
        
    }
    
    public function getAccessLevelDepartment($accessLevel){
        $department = "";
        switch($accessLevel) {
            case env('COLLEGE_TEACHER'): $department = "College"; break;
            case env('SENIOR_HIGH_SCHOOL'): $department = "Senior High School"; break;
            case env('JUNIOR_HIGH_TEACHER'): $department = "Junior High School"; break;
            case env('PRIMARY_TEACHER'): $department ="Primary Education"; break;
            case env('PRE_SCHOOL_TEACHER'): $department ="Pre School"; break;
            case env('DIPLOMA_TEACHER'): $department ="Diploma"; break;
            case env('OTHERS'): $department ="Primary Education"; break;
         }
         return $department;
    }
    
    public function viewgrade($id, $currentsubject) {
 
        $department = $this->getAccessLevelDepartment(\Auth::user()->accesslevel);  
            
        
        $loads = $this->selectSubjectOffered();
        $subjects = DB::select("select *  , collegeGradeTB.id as id2 "
                        . "from collegeGradeTB, studentInfo where studentInfo.studentId = collegeGradeTB.studentid AND scheduleid='" . $id . "'"
                        . "order by studentInfo.lastName, studentInfo.firstName ");
        $gradeStat = DB::select('Select status from gradeStatus where scheduleid ='.$id);
        $message = $this->selectNotification();
        $quarter = DB::Select("Select * from ctrSY where department = '".$department."'");
        

        return view('recording/index', compact('loads', 'subjects', 'currentsubject', 'gradeStat', 'id', 'message','quarter'));
    }
    
    public function getSubjectSched(){
        
        $SubjectSched = $this->getSubjectSchedule();
        
        return Response::json($SubjectSched);
    }
    
    public function getSubjectSchedule(){
        $department = $this->getAccessLevelDepartment(\Auth::user()->accesslevel);  
        $schoolyear = DB::Select("Select schoolyear from ctrSY where department = '".$department."'");
        
        foreach($schoolyear as $schoolyears){
            $SY = $schoolyears->schoolyear;
        }
        
        $username = \Auth::user()->username;
        
        
        $data = DB::select('SELECT DISTINCT so.scheduleid, subject, max( scheduletime ) AS "scheduletime",
            scheduleday, room FROM ctrSubjectOffered so INNER JOIN ctrSubjectSchedule ss 
            ON so.scheduleid = ss.scheduleid WHERE so.instructor = "'.$username.'"'
            .' AND so.schoolyear = "'.$SY.'"
            GROUP BY so.scheduleid');
        
        return $data;
    }






    public function updateSubjectSched(){
          $data =  Input::all();
          $x = 0;
          $schedid = $data['schedid'];
          $StudentCount = DB::select("select count(studentInfo.studentId) as studentCount"
                        . " from collegeGradeTB, studentInfo where studentInfo.studentId = collegeGradeTB.studentid AND scheduleid='" . $data['schedid'] . "'"
                        . " order by studentInfo.lastName, studentInfo.firstName ");
          
          $subject = DB::select("select subject from ctrSubjectOffered where scheduleid = ".$data['schedid']);
          
          foreach($subject as $subjects){
              $subj = $subjects->subject;
          }
              
          
          foreach($StudentCount as $StudentCounts){
              $countStudent = $StudentCounts->studentCount;
          }
          while($x< $countStudent){
            $checked = $data['studentsCheck'];
            $subjectSched = $data['subjectSched'];
            
            if(array_key_exists($x, $checked)){
               $dataUpdate = array('subject' => $subj,
                   'scheduleid' => $subjectSched[$x],
                   'updateby'=> \Auth::user()->username,);
               
               DB::table('collegeGradeTB')
                       ->where('studentid',$checked[$x])
                       ->where('scheduleid',$schedid)
                       ->update($dataUpdate);
                       
               echo $checked[$x];
               echo $subjectSched[$x];
               echo $x;
            }
            $x = $x + 1;
          }
        
         $message1= 'Students subject transferred successfully!';
         Session::flash('message1', $message1);
          Redirect::to('/')->with('message1', $message1);
        //return "true";
    }

    public function viewgradeApprover($id, $currentsubject, $edit) {
        
        $schoolyear = ReportController::getSchoolYear('College');
            
    
        $loads = DB::select('SELECT DISTINCT instructor, gs.STATUS, concat( u.fname, " ", u.lname ) as name
                    FROM ctrSubjectOffered cs
                    INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid
                    INNER JOIN users u ON cs.instructor = u.username
                    WHERE schoolyear = "'.$schoolyear.'"
                    AND gs.status =1');
        
        //$loads = DB::select('SELECT DISTINCT instructorid, status FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
        $data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
        
        $teacher = $this->selectDistinctTeacher('Junior High School');
        $subject1 = $this->selectDistinctSubject('Junior High School');
        $teacherdata = $this->selectTeacherData('Junior High School');
             
        
        $subjects = DB::select("SELECT * ,collegeGradeTB.status as status2, collegeGradeTB.id AS id2
                    FROM collegeGradeTB, studentInfo, statusTB
                    WHERE studentInfo.studentId = collegeGradeTB.studentid
                    AND statusTB.studentId = studentInfo.studentid
                    AND scheduleid = '".$id."'
                    AND collegeGradeTB.schoolyear = statusTB.schoolyear
                    ORDER BY studentInfo.lastName, studentInfo.firstName ");
        $gradeStat = DB::table('gradeStatus')->where('scheduleid', $id)->first();
        
        return  View::make('recording/collegeBody', compact('teacher','subject1','teacherdata','loads', 'data', 'subjects', 'currentsubject', 'gradeStat', 'id', 'edit'));    
         
    }
    
    
    public function viewgradeApprover1($id, $level, $section, $currentsubject, $instructorid, $edit ) {
        
        $schoolyear1 = ReportController::getSchoolYear('College');
            
    
        $loads = DB::select('SELECT DISTINCT instructor, gs.STATUS, concat( u.fname, " ", u.lname ) as name
                    FROM ctrSubjectOffered cs
                    INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid
                    INNER JOIN users u ON cs.instructor = u.username
                    WHERE schoolyear = "'.$schoolyear1.'"
                    AND gs.status =1');
        
        $data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE  schoolyear = "'.$schoolyear1.'" and  gs.status =1');
        
       // $loads = DB::select('SELECT DISTINCT instructorid, status FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
        //$data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
            
        $teacher = $this->selectDistinctTeacher('Junior High School');
        $subject1 = $this->selectDistinctSubject('Junior High School');
        $teacherdata = $this->selectTeacherData('Junior High School');
            
        $schoolyear = ReportController::getSchoolYear('Junior High School');
        
           
        
        $subjects = DB::select('SELECT Distinct si.lastname, si.firstname, st.department, b . *  '
                .'FROM statusTB st, studentInfo si, basicEdGradeTB b, basicEdTeachers t WHERE b.schoolyear = "'.$schoolyear.'" and st.studentID = si.studentID '
                .'AND st.studentID = b.studentID and  b.level like "%'.$level.'%" AND '
                .'st.section = "'.$section.'" AND st.status = 2 AND b.subject = "'.$currentsubject.'"'
                . ' and t.instructorid = "'.$instructorid.'"');
        //$gradeStat = DB::table('gradeStatus')->where('scheduleid', $id)->first();
        return  View::make('recording/highelemEducation', compact('teacher','subject1','teacherdata','loads', 'data','level','section', 'subjects','instructorid', 'currentsubject', 'gradeStat', 'id', 'edit'));    
         
    }
    
    
    public function selectDistinctTeacher($department){
        $schoolyear = ReportController::getSchoolYear($department);
        $loads = DB::select('SELECT Distinct instructorid, concat( u.fname, " ", u.mname, " ", u.lname ) AS name, accesslevel FROM basicEdTeachers t INNER JOIN gradeStatus g ON '
                . 't.id = g.scheduleid INNER JOIN users u ON t.instructorid = u.username where schoolyear ="'.$schoolyear.'"');
                return $loads;
    }
    
    public function selectDistinctSubject($department){
        $schoolyear = ReportController::getSchoolYear($department);
        
        $loads = DB::select('SELECT Distinct subject, accesslevel, instructorid, department FROM basicEdTeachers t INNER JOIN gradeStatus g ON '
                . 't.id = g.scheduleid INNER JOIN users u ON t.instructorid = u.username INNER JOIN ctlLevel l ON t.level = l.level where schoolyear = "'.$schoolyear.'"');
           
                return $loads;
                
            
    }
    
    public function selectTeacherData($department){
        $schoolyear = ReportController::getSchoolYear($department);
        $loads = DB::select('SELECT * FROM basicEdTeachers t INNER JOIN gradeStatus g ON '
                . 't.id = g.scheduleid INNER JOIN users u ON t.instructorid = u.username where schoolyear = "'.$schoolyear.'"');
        
        return $loads;
    }

    public function viewgrade1($level, $section, $subject, $schedid) {
        $department = $this->getAccessLevelDepartment(\Auth::user()->accesslevel);  
        $schoolyear = ReportController::getSchoolYear($department);
           
        $loads = DB::select('SELECT Distinct subject FROM basicEdTeachers WHERE schoolyear = "'.$schoolyear.'" and  instructorid = ?', array(\Auth::user()->username));
        $data = DB::select('SELECT * FROM basicEdTeachers WHERE schoolyear = "'.$schoolyear.'" and  instructorid = ?', array(\Auth::user()->username));
        $gradeStat = DB::select('Select status from gradeStatus where scheduleid ='. $schedid);
        
            
        
       /* $subjects = DB::Select('SELECT Distinct si.lastname, si.firstname, b . *  '
                .'FROM statusTB st, studentInfo si, basicEdGradeTB b, basicEdTeachers t, sectionTB se WHERE st.studentID = si.studentID '
                .'AND st.studentID = b.studentID and st.studentID = se.studentid  and  b.level like "%'.$level.'%" AND '
                .'se.section like "%'.$section.'%" AND st.status = 2 AND b.schoolyear = "'.$schoolyear.'" and  b.subject = "'.$subject.'"'
                . ' and t.instructorid = ? ', array(\Auth::user()->username));
        */
       
         $subjects = DB::Select('SELECT Distinct si.lastname, si.firstname, b . *  '
                .'FROM statusTB st, studentInfo si, basicEdGradeTB b, basicEdTeachers t WHERE st.studentID = si.studentID '
                .'AND st.studentID = b.studentID   and  b.level like "%'.$level.'%" AND '
                .'st.section like "%'.$section.'%" AND st.status = 2 AND b.schoolyear = "'.$schoolyear.'" and  b.subject = "'.$subject.'"'
                . ' and t.instructorid = ? ', array(\Auth::user()->username));
       
        
        $quarter = DB::Select("Select * from ctrSY where department = '".$department."'");
        
        
        return view('recording.index1', compact('subjects', 'subject', 'loads','data','schedid', 'gradeStat','quarter'));
    }

    

    public function encodegrade($id, $type, $value1) {
        $period = [1 => "prelim", 2 => "midterm", 3 => "semifinals", 4 => "finals"];
        DB::table('collegeGradeTB')
                ->where('id', $id)
                ->update(array($period[$type] => $value1));


        return true;
    }

    public function encodegrade1($id, $type, $value1) {
        $period = [1 => "firstQTRN", 2 => "secondQTRN", 3 => "thirdQTRN", 4 => "fourthQTRN", 5 => "finalMarkN"];
        DB::table('basicEdGradeTB')
                ->where('id', $id)
                ->update(array($period[$type] => $value1));

        return true;
    }
    


    public function updateSubmission() {
        $postData = Input::all();
        
        $data = DB::table('gradeStatus')->where('scheduleid', array('scheduleid' => $postData['schedid']))->first();
        //INSERTION OF DATA IF NO RECORD YET
        if ($data == "") {
            $data = array('scheduleid' => $postData['schedid'],
                'status' => env('FOR_APPROVAL'),
                'createdat' => new DateTime(),
            );
            $check = DB::table('gradeStatus')->Insert($data);
            $checkNotification = $this->insertNotification($postData);


            if ($check > 0 || $checkNotification > 0) {
                $message1 = "Final grade submitted to registrar!";
                return Redirect::to('/')->with('message1', $message1);
            }
        } else {
            //UPDATING DATA IF EXISTING
            $data = array('createdat' => new DateTime(),
            );
            if ($postData['button'] == "close") {
                $message1 = "Closed!";
            
            } else {
                $data = array('status' => env('FOR_APPROVAL'),);
                $message1 = "Final grade submitted to registrar";
            
            }

            $check = DB::table('gradeStatus')->where('scheduleid', array('scheduleid' => $postData['schedid']))->update($data);
            $checkNotification = $this->insertNotification($postData);


            return Redirect::to('/')->with('message1', $message1);
            
        }

    }
    
    
   
    
    
        function selectSubjectOffered() {
            $schoolyear = ReportController::getSchoolYear('College');
            $semester = ReportController::getSemester('College');
            $selectSubjectOffered = DB::select('select *  from ctrSubjectOffered where schoolyear = "'.$schoolyear.'" AND semester = "'.$semester.'" and instructor = ?', array(\Auth::user()->username));

            return $selectSubjectOffered;
        }
        
        function updateAttendanceStatus($studentId,$scheduleId,$attendanceStatus){
            
            $attendStat = array('attendanceStatus' => $attendanceStatus,);
            
            DB::table('collegeGradeTB')
                       ->where('studentid',$studentId)
                       ->where('id',$scheduleId)
                       ->update($attendStat);
            
            return true;
            
            
               
        }

        public function viewNotification($id,$name) {
            
            $this->updateNotification($id);
            
            $loads = $this->selectSubjectOffered(); 
            $message = $this->selectNotification();
            $fetchsubjects = DB::table('ctrSubjectOffered')-> where('scheduleid',$id)->first();
            $notification = DB::select('SELECT * FROM gradeNotification gn '
                    . 'inner join ctrSubjectOffered cso on gn.scheduleid = cso.scheduleid WHERE gn.scheduleid ='.$id.' ORDER BY createdat asc');
            
            return view('recording.index', compact('loads', 'message', 'notification','fetchsubjects','name'));
        
            
        }
        
        public function updateNotification($id){
            $data = array('status' => env('READ'));
            
            DB::table('gradeNotification')->where('scheduleid',$id)->update($data);
            
            
        }
        
        public function selectNotification() {
            $selectNotification = DB::select('SELECT * , concat( fname, " ", mname, " ", lname ) AS name, gn.status as statuses '
                            . 'FROM gradeNotification gn '
                            . 'INNER JOIN ctrSubjectOffered cs ON gn.scheduleid = cs.scheduleid '
                            . 'INNER JOIN users ON sender = username '
                            . 'WHERE createdat IN (SELECT MAX( createdat ) AS "Max Date" '
                            . 'FROM gradeNotification gn INNER JOIN ctrSubjectOffered cs '
                            . 'ON gn.scheduleid = cs.scheduleid WHERE instructorid = ? '
                            . 'GROUP BY gn.scheduleid)GROUP BY gn.scheduleid', array(\Auth::user()->username));

            return $selectNotification;
        }

        public function insertNotification($postData) {
            if (isset($postData['comment']) != "") {
                $data = array('scheduleid' => $postData['schedid'],
                    'comment' => $postData['comment'],
                    'sender' => \Auth::user()->username,
                    'status' => env('UNREAD'),
                    'createdat' => new DateTime(),
                );
                $checkNotification = DB::table('gradeNotification')->Insert($data);

                return $checkNotification;
            }
        }
        
        
        public function setupQuarterly($department){
            $schoolyear = ReportController::getSchoolYear('College');
            
    
        $loads = DB::select('SELECT DISTINCT instructor, gs.STATUS, concat( u.fname, " ", u.lname ) as name
                    FROM ctrSubjectOffered cs
                    INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid
                    INNER JOIN users u ON cs.instructorid = u.username
                    WHERE schoolyear = "'.$schoolyear.'"
                    AND gs.status =1');
        $data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
            
            $teacher = $this->selectDistinctTeacher('Junior High School');
            $subject1 = $this->selectDistinctSubject('Junior High School');
            $teacherdata = $this->selectTeacherData('Junior High School');
           if($department == "college"){
                $status = DB::Select("Select * from ctrSY where department = 'College'");
                return View::make('recording/collegeSetup', compact('department','loads','status', 'data', 'teacher', 'subject1', 'teacherdata'));
            }elseif($department == "diploma"){
                $status = DB::Select("Select quarter from ctrSY where department = 'Diploma'");
                return View::make('recording/collegeSetup', compact('department','loads','status', 'data', 'teacher', 'subject1', 'teacherdata'));
            }
            elseif($department == "shs"){
                $status = DB::Select('Select quarter from ctrSY WHERE department = "Senior High School"');
            }elseif($department == "jhs"){
                $status = DB::Select('Select quarter from ctrSY  WHERE department = "Junior High School"');
            }else{
                $status = DB::Select('Select quarter from ctrSY  WHERE department = "Primary Education"');
            }
            return View::make('recording/highelemSetup', compact('department','loads','status', 'data', 'teacher', 'subject1', 'teacherdata'));
      
            
        }
       public function updateQuarterly(){
            $postData = Input::all();
            $data = array('quarter' => $postData['quarter'],
                'startDate' => date("Y-m-d h:i:s",strtotime($postData['startDate'])),
                'endDate' => date("Y-m-d h:i:s",strtotime($postData['endDate'])),);
            
           
               
            if($postData['department'] == "college"){
                $postData['department'] = 'College';
            }else if($postData['department'] == "diploma"){
                $postData['department'] = 'Diploma';
            }else if($postData['department'] == "shs"){
               $postData['department'] = 'Senior High School';
             }else if($postData['department'] == "jhs"){
                $postData['department'] = 'Junior High School';
             }else{
                $postData['department'] = 'Primary Educated';
             }
            
            DB::table('ctrSY')->where('department',  $postData['department'])->update($data);
            
            return Redirect::to('/')->with('message', 'Quarterly Exam successfully updated!');
        }
        
        public function getSchoolAttended(){
            
            $schoolyear = ReportController::getSchoolYear('College');
            
    
        $loads = DB::select('SELECT DISTINCT instructor, gs.STATUS, concat( u.fname, " ", u.lname ) as name
                    FROM ctrSubjectOffered cs
                    INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid
                    INNER JOIN users u ON cs.instructorid = u.username
                    WHERE schoolyear = "'.$schoolyear.'"
                    AND gs.status =1');
        $data = DB::select('SELECT * FROM ctrSubjectOffered cs INNER JOIN gradeStatus gs ON cs.scheduleid = gs.scheduleid WHERE gs.status =1');
            
            
        $teacher = $this->selectDistinctTeacher('Primary Education');
        $subject1 = $this->selectDistinctSubject('Primary Education');
        $teacherdata = $this->selectTeacherData('Primary Education');
            
            $level = DB::select('SELECT DISTINCT `level` FROM `ctlLevel` ');
            
            
            return view('recording.schoolsetup',compact('level','loads','data','teacher','subject1','teacherdata'));
        }
        
        public function getStudentSchool($studentId){
            $data = DB::select('select * from schoolInfoTB where studentId = "'.$studentId.'" order by schoolyear');
            
            return Response::json($data);
        }
        
         public function deleteStudentSchool($studentId,$id){
             DB::table('schoolInfoTB')->where('id',  $id)->delete();
             
             $data = DB::select('select * from schoolInfoTB where studentId = "'.$studentId.'" order by schoolyear');
            
            return Response::json($data);
        }
        
        public function insertStudentSchool(){
            $postData = Input::all();
            $schoolYear = $postData['fromYear']." - ".$postData['toYear'];
            $data = array('studentid' => $postData['studentId'],
                'schoolyear' => $schoolYear,
                'schoolAttended' => $postData['schoolAttended'],
                'level' => $postData['level'],
                'schoolDays' => $postData['schoolDays'],
                'presentDays' => $postData['presentDays'],
                'finalRating' => $postData['finalRating'],
                'dateadded' => new DateTime(),
                );
            
            DB::table('schoolInfoTB')->insert($data);
            
            return Redirect::to('/add/school/attended')->with('message', 'Student School Record successfully added!');
            
            
        }
        
        public function viewUploadPhoto($studentid, $department){
            $message = '';
            return View::make('recording.uploadPhoto',compact('message','studentid','department'));
        }
        
        public function saveUploadPhoto($studentid, $department){
            
           $destinationPath = public_path("images/studentphoto");//'/home/nephila/Desktop/photo';
            $extension = 'jpg';//Input::file('filePhoto')->getClientOriginalExtension();
            $fileName = $studentid.'-'.$department.'.'.$extension;
            Input::file('filePhoto')->move($destinationPath, $fileName);
            
            
//base_path(). '../home/nephila/Desktop/photo'
            /*$file = Request::file('filePhoto');
	    $extension = $file->getClientOriginalExtension();
            Storage::disk('custom')->put($file->getFilename().'.'.$extension, File::get($file));
            */
            
            $message = 'Succesfully uploaded!';
            
            
            return View::make('recording.uploadPhoto',compact('message','studentid','department'));
        }
        
        public function getUser(){
        return View::make("/recording/addUser")
        ->render();
        }
        
        public function addUser(){
            
            $postData = Input::all();
            
        $validator = $this->validator($postData);
        if ($validator->fails()) {
            $this->throwValidationException(
                $postData, $validator);
        }
        else{
            
            $check = DB::table('users')->where('username', array('username' => $postData['username']))->first();
       
            if(count($check) > 0){
            $message= 'Instructor\' username already exist with different access level!<\br>'
                    . 'Please specify another username!';
            $alert='danger';
            
            }else{
           
           
            
            
            User::create(['remember_token' => $postData['_token'],
            'username' => $postData['username'],
            'fname' => $postData['fname'],
            'mname' => $postData['mname'],
            'lname' => $postData['lname'],
            'accesslevel' => $postData['accesslevel'],
            'password' => bcrypt($postData['password']),
        ]);
            
            $message= 'Instructor Successfully Added!';
            $alert='success';
            
            }
            Session::flash('message', $message);
            Session::flash('alert',$alert);
            return Redirect::to('/')->with('message', $message);
        }
        
    
        }
}
    
   
       

