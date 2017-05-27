<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SessionController;
use Response;
use View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create(['remember_token' => $data['_token'],
            'username' => $data['username'],
            'fname' => $data['fname'],
            'mname' => $data['mname'],
            'lname' => $data['lname'],
            'accesslevel' => $data['accesslevel'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    public function getRegister(){
         return view('auth/register');
     }
     
     
     public function postRegister(Request $request){
         $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator);
        }
        else{
            $this->create($request->all());
          /*  $gradeLevel = $this->getCtlLevel($request->all());
            $accesslevel = $request['accesslevel'];
            $username=  $request['username'];
            $user = $this->getUser($username);
            $gradeDetails = $this->getGradeDetails($username);
            
            if(count($gradeDetails)>0){
                $subjectAssign = $this->getSubjectAssign($gradeDetails);
                
            }else{
                $subjectAssign = "";
            }
                */
            /*return View::make('auth/register2', compact('gradeLevel','accesslevel','username','user','gradeDetails','subjectAssign'));
             */
            
            return Redirect('auth/register');
        }
        
    }
    
    public function getUser($username){
        $getUser = DB::table('users')->where('username',$username)->first();
       // $accesslevel = $getUser->accesslevel;
        
       // $resultlevel = $this->getAccessLevelEquivalent($accesslevel);
        
       // $getUser  = array('resultlevel' => $resultlevel);
        
        return $getUser;
     
    }
    
    public function getGradeDetails($username){
        $getGradeDetails = DB::select('SELECT DISTINCT instructorid, bet.level, bet.section, cs.adviser FROM basicEdTeachers bet LEFT JOIN '
                . '(SELECT adviser, section FROM ctrSection WHERE adviser = "'.$username.'")cs '
                . 'ON bet.section = cs.section WHERE instructorid = "'.$username.'"');
        return $getGradeDetails;
        
    }

    

    public function getCtlLevel($request){
         switch( $request['accesslevel'] ) {
            case env('COLLEGE_TEACHER'): $department = "'College'"; break;
            case env('SENIOR_HIGH_SCHOOL'): $department = "'Senior High School'"; break;
            case env('JUNIOR_HIGH_TEACHER'): $department = "'Junior High School'"; break;
            case env('PRIMARY_TEACHER'): $department ="'Primary Education'"; break;
            case env('PRE_SCHOOL_TEACHER'): $department ="'Pre School'"; break;
            case env('DIPLOMA_TEACHER'): $department ="'Diploma'"; break;
         }
         
        $getGradeLevel = DB::select('select * from ctlLevel where department='.$department);
         return $getGradeLevel;
     }
     
     public function getAccessLevelEquivalent($accesslevel){
         switch( $accesslevel ) {
            case 10: $department = "'College'"; break;
            case 20: $department = "'Senior High School'"; break;
            case 30: $department = "'Junior High School'"; break;
            case 40: $department ="'Primary Education'"; break;
            case 60: $department ="'Pre School'"; break;
            case 70: $department ="'Diploma'"; break;
            
         }
         
         return $department;
     }
     
     public function getSection($level,$table){
         
         if($table == 'ctrSubjects'){
         $value = 'subject';}
         else{
         $value = 'section';
         }
         
         $data = DB::select(" select distinct ".$value." from ".$table." where level ="."'".$level."'");
         return Response::json($data);
     }
     
     public function getSubjectAssign($gradeDetails){
       foreach($gradeDetails as $gradeDetail){
            $section = $gradeDetail->section;
            $instructorid = $gradeDetail->instructorid;
       
            $subject[] = DB::select('SELECT section, subject FROM basicEdTeachers WHERE section = "'.$section.'" AND instructorid = "'.$instructorid.'"');
       
            
       }
        return $subject;
       
     }
     
     public function postGradeDetail(Request $request){
         $level = $request['gradeLevel'];
         $section = $request['section'];
         $assignment = $request['assignment'];
         $username = $request['username'];
        
        if($assignment == 'Adviser'){
            $check = DB::select(' select * from ctrSection where adviser ="'.$username.'" or (section = "'.$section.'" && level = "'.$level.'" && adviser ="'.$username.'" )');
                if(count($check)>0){
                    echo "Duplicate Data for Advisory";
               }else{
             echo 'ok';
                 DB::table('ctrSection')->where('level', $level)
                        ->where('section', $section)
                        ->update(array('adviser'=> $username));
                 
               $check = $this->insertBasicEdTeacher($request);
                
            }
        }else{
               $check = $this->insertBasicEdTeacher($request);
                   
            }
            
          if($check == true){
             $gradeLevel = $this->getCtlLevel($request);
            $accesslevel = $request['accesslevel'];
            $user = $this->getUser($username);
            $gradeDetails = $this->getGradeDetails($username);
            
            if(count($gradeDetails)>0){
                $subjectAssign = $this->getSubjectAssign($gradeDetails);
            }else{
                $subjectAssign = "";
            }
                
            return View::make('auth/register2', compact('gradeLevel','accesslevel','username','user','gradeDetails','subjectAssign'));
            
          }
             
      }
     
     
     
   
     public function insertBasicEdTeacher($request){
         $checkbox = $request['ch'];
         $username = $request['username'];
         foreach($checkbox as $checkboxes){
                $data = array('instructorid' => $username,
                    'level' => $request['gradeLevel'],
                    'section' => $request['section'],
                    'subject' => $checkboxes,
                );
                echo $request['gradeLevel'];
                echo $request['section'];
                echo $checkboxes;
                DB::table('basicEdTeachers')->Insert($data);
                
                
     }
     return true;
    }
  

     
        
     
     
     
     /*public function postRegister(Request $request){   
         $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator);
        } else{
                $data = DB::table('users')->where('username', array($request->username))->first();
                if($data != "")
                {
                    $accesslevel = array($data->accesslevel);

                    if($accesslevel== array($request->accesslevel)){
                        User::where('username', $request->username)->update(array(
                            'username' => $request->username,
                            'fname' => $request->fname,
                            'mname' => $request->mname,
                            'lname' => $request->lname,
                            'accesslevel' => $request->accesslevel,
                            'password' => bcrypt($request->password),
                    ));
                        return view('auth/successful');
                    }else{
                            echo 'Duplicate username with different level access';
                    }
                }else{
                    User::create(array(
                        'remember_token' => $request-> _token,
                        'username' => $request->username,
                        'fname' => $request->fname,
                        'mname' => $request->mname,
                        'lname' => $request->lname,
                        'accesslevel' => $request->accesslevel,
                        'password' => bcrypt($request->password),
                       ));

                   return redirect($this->redirectPath());
                }
         }
     }*/
     
    
}
