<?php

class HomeController extends BaseController {
   
   public function index()
   {
      $title = trans('general.index_page');
      return View::make('frontend.home.index', compact('offers', 'title'));
   }
   
}