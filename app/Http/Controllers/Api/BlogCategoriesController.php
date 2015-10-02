<?php

class BlogCategoriesController extends BaseController
{
   protected $category;

   public function __construct(BlogCategory $category)
   {
      $this->category = $category;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $categories = $this->category->getTreeArray(0, 1);
      return $categories;
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      echo "eee23";
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $input = Input::all();
      if (empty($input['name'])) {
         $input['name'] = str_slug($input['title'], '-');
      }
      $input['parent_id'] = (int)$input['parent_id'];
      $input['active'] = (int)($input['active'] == 'true');
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
   public function show($id)
   {
      echo "eee4";
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      echo "eee";
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      BlogCategory::where('parent_id', '=', $id)->delete();
      $cat = BlogCategory::find($id);
      if ($cat)
         $cat->delete();
      return array('status' => 'OK');
   }
}
