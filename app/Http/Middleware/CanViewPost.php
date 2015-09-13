<?php

use Closure;
use Illuminate\Contracts\Auth\Guard;

class CanViewPost
{
    protected $auth;
    
    protected $post;
    
    public function __construct(Guard $auth, Post $post)
    {
        $this->auth = $auth;
        $this->post = $post;
    }
    
    public function handle($request, Closure $next)
    {
        if (! $this->checkIfUserCanViewPost($request)) {
            return redirect()->route('/');
        }

        return $next($request);
    }
    
    private function checkIfUserCanViewPost($request)
    {
        $post = $this->post->byHash($request->segment(3));
        $user_id = $this->auth->user()->getAuthIdentifier();

        if ($post->visibility_id == 'Private') {
            if (! $post->user_id == $user_id) {
                return false;
            }
        }

        return true;
    }

}
