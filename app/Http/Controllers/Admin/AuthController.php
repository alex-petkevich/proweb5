<?php

use Illuminate\Contracts\Auth\Guard;

class AuthController extends BaseController
{
    
    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @param \jorenvanhocht\Tracert\Tracert $tracert
     */
    public function __construct(Guard $auth, Tracert $tracert)
    {
        parent::__construct($auth);
    }

    ///////////////////////////////////////////////////////////////////////////
    // View methods
    ///////////////////////////////////////////////////////////////////////////

    /**
     * Show the login view
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Login methods
    ///////////////////////////////////////////////////////////////////////////

    /**
     * @param \jorenvanhocht\Blogify\Requests\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $this->auth->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], isset($request->rememberme) ? true : false);

        if ($credentials) {
            
            return redirect('/admin');
        }

        session()->flash('message', 'Wrong credentials');

        return redirect()->route('admin.login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $user_id = $this->auth_user->id;
        $this->auth->logout();
        
        return redirect()->route('admin.login');
    }
}