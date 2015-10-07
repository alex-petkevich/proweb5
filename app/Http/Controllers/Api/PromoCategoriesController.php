<?php

use Illuminate\Http\Request;

class PromoCategoriesController extends BaseController {

   protected $category;

   public function __construct(PromoCategory $category) {
      $this->category = $category;
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request) {

      $active = $request->input('active');

      if ($active) {
         $categories = $this->category->where('active', '=', '1')->get();
      } else {
         $categories = $this->category->get();
      }

      return $categories;
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create() {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request) {
      $input = Input::all();
      $input['active'] = (int) ($input['active'] == 'true');
      $validation = Validator::make($input, BlogCategory::$rules);
      if ($validation->passes()) {
         $this->category->create($input);
         return array('status' => 'OK');
      }
      return array('status' => 'error', 'messages' => $validation->messages());
   }

   /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function show($id) {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id) {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id) {
      $input = Input::all();
      $category = $this->category->find($id);
      $rules = BlogCategory::$rules;
      if ($category->id) {
         $rules['name'] = $rules['name'] . ', ' . $category->id;
      }
      $input['active'] = (int) ($input['active'] == 'true');
      $validation = Validator::make($input, $rules);
      if ($validation->passes()) {
         if ($category->id) {
            $category->update($input);
            return array('status' => 'OK');
         } else {
            return array('status' => 'error', 'messages' => trans('blog_categories.id_not_found'));
         }
      }
      return array('status' => 'error', 'messages' => $validation->messages());
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id) {
      $cat = PromoCategory::find($id);
      if ($cat)
         $cat->delete();
      return array('status' => 'OK');
   }

}
