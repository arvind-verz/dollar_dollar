<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validatorFields = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'password' => 'required|min:8|confirmed',
            'tel_phone' => '',
        ];

        if (User::where('email', $data['email'])->where('delete_status', 0)->exists()) {
            $validatorFields = array_add($validatorFields, 'email', "required|email|max:255|unique:users");
        } else {
            $validatorFields = array_add($validatorFields, 'email', "required|email|max:255");
        }
        return Validator::make($data, $validatorFields);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {

        /*set mail sending function in speedo\vendor\laravel\framework\src\Illuminate\Foundation\Auth\RegistersUsers.php  Line no 40.*/

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'tel_phone' => $data['tel_phone'],
            'company' => $data['company'],
            'subscribe' => $data['subscribe'],
        ]);
    }
}
