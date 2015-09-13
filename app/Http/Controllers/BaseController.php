<?php

use Illuminate\Contracts\Auth\Guard;

class BaseController extends Controller {

    protected $auth;
    
    protected $auth_user;
    
    protected $config;
    
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->config = objectify(config('blogify'));
        $this->auth_user = $this->auth->check() ? $this->auth->user() : false;
    }
    
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * Creates a view
     *
     * @param String $path path to the view file
     * @param Array $data all the data
     * @return void
     */
    protected function view($path, array $data = [])
    {
        $this->layout->content = View::make($path, $data);
    }

    /**
     * Redirect back with input and with provided data
     *
     * @param Array $data all the data
     * @return void
     */
    protected function redirectBack($data = [])
    {
        return Redirect::back()->withInput()->with($data);
    }

    /**
     * Redirect to the previous url
     *
     * @return void
     */
    public function redirectReferer()
    {
        $referer = Request::server('HTTP_REFERER');
        return Redirect::to($referer);
    }

    /**
     * Redirect to a given route, with optional data
     *
     * @param String $route route name
     * @param Array $data optional data
     * @return void
     */
    protected function redirectRoute($route, $data = [])
    {
        return Redirect::route($route, $data);
    }

}