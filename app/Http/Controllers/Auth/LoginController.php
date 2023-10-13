<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller



{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $input = $request->get('login');
        $field = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $request->merge([$field => $input]);

        $user = User::where($field, $request->$field)->first();

        if ($user) {
            switch ($user->status) {
                case 'pending':
                 
                    return back()->withErrors(['login' => 'Your account is not confirmed yet.']);
                case 'disabled':
                  
                    return back()->withErrors(['login' => 'Your account is disabled.']);
                case 'enabled':
                    if (auth()->attempt($request->only($field, 'password'))) {
                        return redirect()->intended();
                    } else {
                      
                        return back()->withErrors(['login' => 'The provided credentials do not match our records.']);
                    }
                default:
                    dd('invalid status error'); // Для отладки
                    return back()->withErrors(['login' => 'Account status is invalid.']);
            }
        } else {
            
            return back()->withErrors(['login' => 'No account found with this login credentials.']);
        }




        $attempt = auth()->attempt($request->only($field, 'password'));



        if ($attempt) {
            return redirect()->intended();
        }

        return back()->withError('Login details are not valid.');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|exists:users,phone',
            'email' => 'nullable|exists:users,email',
            'password' => 'required|string',
        ], [
            'phone.exists' => 'The phone number is not registered.',
            'email.exists' => 'The email address is not registered.'
        ]);
    }




    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
