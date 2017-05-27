<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Redirect;
use View;
use Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function viewTOR($department, $studentName){
        //echo 'department'.$department;
        //echo 'studentName'.$studentName;
        $data = DB::select('SELECT distinct s.studentid, concat(upper( lastName ) ," ", CONCAT( UCASE( LEFT( firstName, 1 ) ) , 
                    SUBSTRING( firstName, 2 ) ) , " ", CONCAT( UCASE( LEFT( middleName, 1 ) ) , 
                    SUBSTRING( middleName, 2 ) ) ) as name, department, max( level ) as level
                    FROM studentInfo si INNER JOIN statusTB s ON s.studentid = si.studentid
                    WHERE department like "%'.$department.'%" AND (
                    lastName LIKE "%'.$studentName.'%" OR firstname LIKE "%'.$studentName.'%"
                    OR middleName LIKE "%'.$studentName.'%" OR concat( lastName, " ", firstname ) LIKE "%'.$studentName.'%"
                    OR concat( lastName, " ", middleName, " ", firstname ) LIKE "%'.$studentName.'%"
                    OR concat( lastName, " ", firstname, " ", middlename ) LIKE "%'.$studentName.'%") GROUP BY studentid');
    
        return Response::json($data);
    }
    
    public function viewstudentTOR($studentid){
        $data = DB::select('select department, level from statusTB where studentid ='.$studentid);
        foreach($data as $datas){
            
            $department = $datas->department;
            $level = $datas->level;
         }
        if($department == 'College' || $department == 'Diploma'){
           return $this->showCollege($studentid);
        }elseif($department == 'Junior High School' || $department == 'Senior High School'){
           return $this->showHighschool($studentid);
        }else{
           return $this->showElementary($studentid, $level);
        }
    }
    
    public function showElementary($studentid,$level,$department)
    {
        $schoolyear = $this->getSchoolYear('Primary Education');
        $studentInfo = DB::select('SELECT * FROM studentInfo WHERE studentid ='.$studentid);
        $schoolRecord = DB::select('SELECT * FROM schoolInfoTB where studentid = '.$studentid);
        $grade = DB::select('SELECT g. * FROM ctrSubjects s
                            LEFT OUTER JOIN basicEdGradeTB g ON s.subject = g.subject
                            WHERE s.level = g.level 
                            AND g.schoolyear = s.schoolyear AND s.level = "'.$level.'" AND s.schoolyear = "'.$schoolyear.'" AND studentid = "'.$studentid.'"');
        
        return view('reporting.elementaryTOR',compact('studentInfo','schoolRecord','grade','schoolyear','level','studentid','department'));
        
        //
    }
    
    public function showHighschool($studentid,$department)
    {
       // $schoolyear = $this->getSchoolYear('Junior High School');
        
        $studentInfo = DB::select('SELECT * FROM studentInfo WHERE studentid ='.$studentid);
        $schoolRecord = DB::select('SELECT * FROM schoolInfoTB where studentid = '.$studentid);
        
        /*$subject = DB::select('SELECT DISTINCT * FROM (
                            SELECT s.subject, s.level, s.schoolyear
                            FROM ctrSubjects s, schoolInfoTB si
                            WHERE s.level = si.level
                            AND s.schoolyear = si.schoolyearis
                            AND si.studentid ="'.$studentid.'"
                            UNION ALL
                            SELECT s.subject, s.level, s.schoolyear
                            FROM ctrSubjects s, basicEdGradeTB g
                            WHERE s.level = g.level
                            AND s.schoolyear = g.schoolyear
                            AND g.studentid ="'.$studentid.'"
                            )a');*/
        
        $subject = DB::select('SELECT Distinct s.subject
                            FROM ctrSubjects s, basicEdGradeTB g
                            WHERE s.level = g.level
                            AND s.schoolyear = g.schoolyear
                            AND g.studentid ="'.$studentid.'" ORDER BY s.sortnumber');
        
        $grade = DB::select('SELECT DISTINCT s.subject, g. *
FROM ctrSubjects s, basicEdGradeTB g
WHERE s.level = g.level
AND s.schoolyear = g.schoolyear
AND g.studentid = "'.$studentid.'"
AND s.subject = g.subject
ORDER BY s.sortnumber');
        
        $gradeLevel = DB::select('SELECT Distinct level
FROM basicEdGradeTB 
WHERE studentid = "'.$studentid.'" order by level');
        
        
        
        return view('reporting.highschoolTOR',compact('studentInfo','schoolRecord','grade','studentid','department','subject','gradeLevel'));
        
        //
    }
    
    public function showCollege($studentid,$department)
    {   $studentInfo = DB::select('SELECT si. * , pst.semester, pst.schoolyear, min( pst.enrolldate ) enrolldate
                            FROM studentInfo si INNER JOIN (SELECT *
                            FROM previousstatusTB UNION ALL SELECT *
                            FROM statusTB  )pst ON si.studentid = pst.studentid
                            WHERE si.studentid ='.$studentid);
        
        $schoolRecord = DB::select('SELECT * FROM schoolInfoTB where studentid = '.$studentid.' order by schoolyear');
        
        
        $SYrecord = DB::select('SELECT DISTINCT collegeGradeTB.schoolyear, collegeGradeTB.semester
                            FROM collegeGradeTB
                            WHERE collegeGradeTB.studentid = "'.$studentid.'"
                            ORDER BY schoolyear ASC , semester ASC ');
        
        $records = DB::select('SELECT DISTINCT collegeGradeTB . * , studentInfo . * , collegeGradeTB.id AS id2,
                            CASE
                            WHEN collegeGradeTB.subject = ctrSubjectOffered.subject
                            THEN ctrSubjectOffered.subjectcode
                            else ""
                            END AS subjcode
                            FROM collegeGradeTB, studentInfo, ctrSubjectOffered
                            WHERE studentInfo.studentId = collegeGradeTB.studentid
                            AND collegeGradeTB.studentid = "'.$studentid.'"
                            AND ctrSubjectOffered.subject
                            IN (

                            SELECT DISTINCT subject
                            FROM collegeGradeTB
                            WHERE collegeGradeTB.studentid = "'.$studentid.'"
                            )
                            ORDER BY `subject` asc, subjcode desc ');
        
        return view('reporting.collegeTOR',compact('studentInfo','records','SYrecord','schoolRecord','department','studentid'));
        
        //
    }
    
    public static function getSchoolYear($department){
        $schoolYear = DB::select('Select schoolYear from ctrSY where department = "'.$department.'"');
        $sy = "";
        foreach($schoolYear as $sys){
            $sy = $sys->schoolYear;
        }
        return $sy;
    }
    
     public static function getSemester($department){
        $semester = DB::select('Select semester from ctrSY where department = "'.$department.'"');
        $sem1 = "";
        foreach($semester as $sem){
            $sem1 = $sem->semester;
        }
        return $sem1;
    }

    public function viewGradeSheetCollege($id){
        $details = DB::select("SELECT fname, lname, subject, course, scheduleday, scheduletime, room
                            FROM ctrSubjectOffered so INNER JOIN ctrBatchSchedule bs ON so.scheduleid = bs.scheduleid
                            INNER JOIN ctrSubjectSchedule ss ON ss.scheduleid = bs.scheduleid
                            INNER JOIN users u ON u.username = so.instructorid
                            WHERE so.scheduleid = '".$id."'");
        $subjects = DB::select("select *  , collegeGradeTB.id as id2 "
                        . "from collegeGradeTB, studentInfo where studentInfo.studentId = collegeGradeTB.studentid and attendanceStatus = 0 AND scheduleid='" . $id . "'"
                        . "order by studentInfo.lastName, studentInfo.firstName ");
        
        return view('reporting.collegeGradeSheet',compact('subjects','details'));
    }
    
    public function viewGradeSheetHighElem($id){
        $details = DB::select("SELECT lname, mname, fname, a. *
                        FROM `basicEdTeachers` a INNER JOIN users u ON a.instructorid = u.username
                        WHERE a.id = '".$id."'");
        $subjects = DB::select("SELECT DISTINCT si.lastname, si.firstname, b. *
                        FROM statusTB st, studentInfo si, basicEdGradeTB b, basicEdTeachers t, sectionTB se
                        WHERE st.studentID = si.studentID   AND st.studentID = b.studentID
                        AND st.studentID = se.studentid AND b.level = t.level
                        AND se.section = t.section  AND st.status =2
                        AND b.schoolyear = t.schoolyear AND b.subject = t.subject
                        AND t.id = '".$id."'");

        return view('reporting.highschoolGradeSheet',compact('subjects','details'));
    }
    
    
    
    public function getGradeList(){
        return View::make("/reporting/searchPerSubject")
        ->render();
    }
    
    
    
    public function searchGradeList($teacher){
        $details = DB::select('SELECT t.id, instructorid, fname, lname, subject, level, section
                        FROM `basicEdTeachers` t INNER JOIN users u ON t.instructorid = u.username
                        WHERE u.username LIKE "%'.$teacher.'%" OR fname LIKE "%'.$teacher.'%"
                        OR lname LIKE "%'.$teacher.'%" OR concat( fname," ", lname ) LIKE "%'.$teacher.'%"
                        OR concat( lname," ", fname ) LIKE "%'.$teacher.'%" ORDER BY level');
        
        return Response::json($details);
    }
    
    public function viewGradeList($id){
        $details = DB::select("SELECT lname, mname, fname, a. *
                    FROM `basicEdTeachers` a INNER JOIN users u ON a.instructorid = u.username
                    WHERE a.id = '".$id."'");
        $subjects = DB::select("SELECT DISTINCT si.lastname, si.firstname, b. *
            FROM statusTB st, studentInfo si, basicEdGradeTB b, basicEdTeachers t, sectionTB se
            WHERE st.studentID = si.studentID   AND st.studentID = b.studentID
            AND st.studentID = se.studentid AND b.level = t.level
            AND se.section = t.section  AND st.status =2
            AND b.schoolyear = t.schoolyear AND b.subject = t.subject
            AND t.id = '".$id."'");
        return View::make("reporting.gradeList",compact('subjects','details'));
        //->render();
        
        //return response()
         //   ->view('reporting.gradeList', compact('subjects', 'details'));
            
    }
    
    public function getGrade(){
        $details = DB::select('select distinct level from ctrSection');
        
        return View::make("reporting.searchGrade", compact('details'));
        
        
    }
    
    public function getGradeRecord($grade){
        $details = DB::select('SELECT fname, lname, s . *
FROM `ctrSection` s
INNER JOIN users u ON s.adviser = u.username
WHERE level LIKE "'.$grade.'"');
        
        return Response::json($details);
    }
    
    public function getGradeRecordList($id){
        $teachersDetail = DB::select('SELECT fname, lname, s . * FROM `ctrSection` s
                            INNER JOIN users u ON s.adviser = u.username
                            WHERE s.id LIKE "'.$id.'"');
        
         
        $subject = DB::select('SELECT subject FROM `ctrSubjects` s
                            INNER JOIN ctlLevel l ON s.level = l.level
                            INNER JOIN ctrSY sy ON l.department = sy.department
                            INNER JOIN ctrSection cs ON l.level = cs.level
                            WHERE cs.id LIKE "'.$id.'"
                            AND s.schoolyear = sy.schoolyear
                            ORDER BY s.sortNumber ASC ');
        
        
        
        $student = DB::select('SELECT DISTINCT g.studentid, si.lastname, si.firstname
                    FROM basicEdGradeTB g
                    INNER JOIN sectionTB s ON g.studentid = s.studentid
                    INNER JOIN ctrSection cs ON s.level = cs.level
                    inner join studentInfo si ON s.studentid = si.studentid
                    WHERE cs.section = s.section
                    AND cs.schoolyear = s.schoolyear
                    AND s.schoolyear = g.schoolyear
                    AND cs.id = "'.$id.'"');
        
    
        $gradeDetails = DB::select('SELECT g.studentid, subject, (firstQTRN + secondQTRN + 
                    thirdQTRN + fourthQTRN) /4 AS final FROM basicEdGradeTB g
                    INNER JOIN sectionTB s ON g.studentid = s.studentid
                    INNER JOIN ctrSection cs ON s.level = cs.level
                    WHERE cs.section = s.section
                    AND cs.schoolyear = s.schoolyear
                    AND s.schoolyear = g.schoolyear
                    AND cs.id = "'.$id.'"');
       
        
        return View::make("reporting.summaryGradeList", compact('teachersDetail','subject','student','gradeDetails'));
   
    }
    
     public function viewCertificate(){
        return View::make('/reporting/searchCertificate');
    }
    
    public function searchCertificate($studentName, $department, $schoolyear){
        $data = DB::SELECT('SELECT distinct s.studentid, concat(upper( lastName ) ," ", CONCAT( UCASE( LEFT( firstName, 1 ) ) , 
                    SUBSTRING( firstName, 2 ) ) , " ", CONCAT( UCASE( LEFT( middleName, 1 ) ) , 
                    SUBSTRING( middleName, 2 ) ) ) as name, department, c.semester, s.schoolyear 
                    FROM studentInfo si INNER JOIN statusTB s ON s.studentid = si.studentid 
                    INNER JOIN collegeGradeTB c ON c.studentid = s.studentid
                    WHERE department like "%'.$department.'%" AND s.schoolyear LIKE "%'.$schoolyear.'%"  and  
                    (
                    lastName LIKE "%'.$studentName.'%" OR firstname LIKE "%'.$studentName.'%"
                    OR middleName LIKE "%'.$studentName.'%" OR concat( lastName, " ", firstname ) LIKE "%'.$studentName.'%"
                    OR concat( lastName, " ", middleName, " ", firstname ) LIKE "%'.$studentName.'%"
                    OR concat( lastName, " ", firstname, " ", middlename ) LIKE "%'.$studentName.'%") ORDER BY name ASC , s.schoolyear DESC ');
        
        return Response::json($data);
    }
    
    public function viewCertificateList($studentid, $department, $semester, $schoolyear){
        $studentInfo = DB::select('SELECT st.studentid,si.lastName, si.firstName,'
                . ' si.middleName, st.course'
                . ' FROM studentInfo si inner join statusTB st'
                . ' ON si.studentid = st.studentid WHERE si.studentid ='.$studentid.' '
                . ' and st.semester like "%'.$semester.'%" and st.schoolyear like "%'.$schoolyear.'%"');
        
        $records = DB::select('SELECT c.studentid, c.subject, ((prelim + midterm + finals) /3) AS finalGrade, c.unit
                FROM collegeGradeTB c INNER JOIN statusTB s ON c.studentid = s.studentid
                WHERE c.studentid = "'.$studentid.'" AND s.department LIKE "%'.$department.'%"
                AND c.semester = s.semester AND s.semester LIKE "%'.$semester.'%"
                AND c.schoolyear = s.schoolyear AND s.schoolyear LIKE "%'.$schoolyear.'%"');
        
        return view::make('reporting/gradeCertificate',compact('studentInfo','records','semester','schoolyear'));
    }
    
    
    public static function getWordNumber($number){
        
        $words = array ('zero',
		'one',
		'two',
		'three',
		'four',
		'five',
		'six',
		'seven',
		'eight',
		'nine',
		'ten',
		'eleven',
		'twelve',
		'thirteen',
		'fourteen',
		'fifteen',
		'sixteen',
		'seventeen',
		'eighteen',
		'nineteen',
		'twenty');
        $level = substr($number,-1);
        $word1 = $words[$level];
        
        
        return $word1;
    }
    
    public static function getCourseName($courseCode){
        
        $courses = array('BSIT' => 'Bachelor of Science in Information Technology'  ,
            'BSCS' => 'Bachelor of Science in Computer Science',
            'BSIS' => 'Bachelor of Science in Information Systems',
            'BSCoE' => 'Bachelor of Science in Computer Engineering',
            'BSEE' => 'Bachelor of Science in Electronics Engineering',
            'BSIE' => 'Bachelor of Science in Industrial Engineering',
            'BSA' => 'Bachelor of Science in Accountancy',
            'BSBA' => 'Bachelor of Science in Business Administration',
            'BAMC' => 'Bachelor of Arts in Mass Communication',
            'BAE' => 'Bachelor of Arts in English',
            'BAPolsci' => 'Bachelor of Arts in Political Science',
            'BAPsych' => 'Bachelor of Arts in Psychology',
            'BAEco' => 'Bachelor of Arts in Economics',
            'BEEd' => 'Bachelor of Elementary Education',
            'BSEd' => 'Bachelor of Science in Secondary Education',
            'BSE' => 'Bachelor of Science in Education',
            'BSB' => 'Bachelor of Science in Business',
            'BSAT' => 'Bachelor of Science in Accounting Technology',
            'BSBA HRDM' => 'Bachelor of Science in Business Administration major in Human Resource Development Management',
            'IT' => 'Information Technology',
            'BSBA BF' => 'Bachelor of Science in Business Administration major in Banking and Finance ',
            'HRM' => 'Hotel and Restaurant Management',
            'BSREM' => 'Bachelor of Science in Railway Engineering and Management',
            'BSEd Math' =>'Bachelor of Secondary Education Major in Mathematics',
            'BSEd English' =>'Bachelor of Secondary Education Major in English',
            'BSEd Filipino' =>'Bachelor of Secondary Education Major in Filipino',
            'BSEd MAPEH' =>'Bachelor of Secondary Education Major in Music, Arts, Physical Education and Health program',
            'BSEd Social Studies' =>'Bachelor of Secondary Education Major in Social Studies',
            'BSEd CE' =>'Bachelor of Secondary Education Major in CE',
            );
        
        
        
        $course = $courses[$courseCode];
        
        return $course;
        
    }
    
}

