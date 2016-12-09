<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return User::create([
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
     }
     
    
}
