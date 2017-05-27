<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('/auth/register', 'Auth\AuthController@getRegister');
Route::get('/register/grades/{level}/{table}','Auth\AuthController@getSection');
Route::post('/auth/register/', 'Auth\AuthController@postRegister');
Route::get('auth/changepassword', 'RecordingController@getReset');
Route::post('auth/changepassword', 'RecordingController@postReset');
Route::post('/auth/register/update','Auth\AuthController@postGradeDetail');


Route::get('/', 'RecordingController@index');
Route::get('viewgrade/{id}/{currentsubject}','RecordingController@viewgrade');
Route::get('get/subject/sched','RecordingController@getSubjectSched');
Route::post('update/subject/sched','RecordingController@updateSubjectSched');
Route::get('update/attendance/status/{studentId}/{scheduleId}/{attendanceStatus}','RecordingController@updateAttendanceStatus');
Route::get('/viewgradeApprover/{id}/{currentsubject}/{edit}','RecordingController@viewgradeApprover');
Route::get('/viewgradeApprover1/{id}/{level}/{section}/{currentsubject}/{instructorid}/{edit}','RecordingController@viewgradeApprover1');

//Route::post('/viewgradeApprover/{id}/{currentsubject}/{edit}','RecordingController@viewgradeApprover');

Route::get('recording/update/{id}/{type}/{value}', 'RecordingController@encodegrade');
Route::get('viewgrade1/{level}/{section}/{subject}/{schedid}','RecordingController@viewgrade1');
Route::get('recording1/update/{id}/{type}/{value}', 'RecordingController@encodegrade1');
Route::get('viewNotification/{id}/{name}','RecordingController@viewNotification');

Route::post('recording/update/', 'RecordingController@updateSubmission');
Route::get('/recording/setEdit/', 'RecordingController@setEdit');
//Route::get('/recording/approver/', 'RecordingController@viewgradeApprover')->name('approver');


//SETUP
Route::get('/setup/quarterly/{department}', 'RecordingController@setupQuarterly');
Route::post('/setup/quarterly/', 'RecordingController@updateQuarterly');

Route::get('/add/school/attended', 'RecordingController@getSchoolAttended');
Route::post('/add/school/attended', 'RecordingController@insertStudentSchool');
Route::get('/get/student/school/{studentId}', 'RecordingController@getStudentSchool');
Route::delete('/delete/schoolrecord/{studentId}/{id}','RecordingController@deleteStudentSchool');
Route::get('/test', function(){

    // this returns the contents of the rendered template to the client as a string
    return View::make("/reporting/search")
        ->render();

});

Route::get('/get/user','RecordingController@getUser');
Route::post('/add/user','RecordingController@addUser');


Route::get('/view/upload/photo/{studentid}/{department}','RecordingController@viewUploadPhoto');
Route::post('/save/upload/photo/{studentid}/{department}','RecordingController@saveUploadPhoto');

//REPORT
Route::get('/tor/elementary/{studentid}/{level}/{department}','ReportController@showElementary');
Route::get('/tor/highschool/{studentid}/{department}','ReportController@showHighschool');
Route::get('/tor/college/{studentid}/{department}','ReportController@showCollege');
Route::get('/view/tor/{department}/{studentName}','ReportController@viewTOR');
Route::get('/view/tor/result/{studentId}','ReportController@viewstudentTOR');

Route::get('/view/gradesheet/college/{id}','ReportController@viewGradeSheetCollege');
Route::get('/view/gradesheet/highelem/{id}','ReportController@viewGradeSheetHighElem');
Route::get('/view/teacher/search','ReportController@getGradeList');
Route::get('/view/teacher/list/{teacher}','ReportController@searchGradeList');
Route::get('/view/teacher/gradeList/{id}','ReportController@viewGradeList');
Route::get('/view/grade/{grade}','ReportController@getGrade');
Route::get('/view/grade','ReportController@getGrade');
Route::get('/view/grade/record/{grade}','ReportController@getGradeRecord');
Route::get('/view/grade/record/list/{id}','ReportController@getGradeRecordList');
Route::get('/view/certificate/','ReportController@viewCertificate');
Route::get('/search/certificate/{studentName}/{department}/{schoolyear}','ReportController@searchCertificate');
Route::get('/view/certificate/list/{studentid}/{departmen}/{semester}/{schoolyear}','ReportController@viewCertificateList');


