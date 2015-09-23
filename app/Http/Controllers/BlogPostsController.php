<?php

class PostsController extends BaseController {

   protected $post;

   public function __construct(Post $post) {
      $this->post = $post;
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index() {
      $posts = $this->post->getTreeArray();
      return View::make('backend.blog.posts.index', compact("posts"));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create() {
      $post = $this->post;
      /* if (!empty($request->input("category_id"))) {
        $post->category_id = $request->input("category_id");
        }

        $catalog = $Catalog->getDocumentTree(); */

      return View::make('backend.blog.posts.edit', compact('post'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request) {
      $input = Input::all();
      if (empty($input['name'])) {
         $input['name'] = str_slug($input['title'], '-');
      }
      $validation = Validator::make($input, Post::$rules);
      if ($validation->passes()) {
         $input['active'] = isset($input['active']) ? (int) $input['active'] : 0;
         $this->post->create($input);

         return Redirect::route('posts.index');
      }

      return Redirect::route('posts.create')
                  ->withInput()
                  ->withErrors($validation)
                  ->with('message', trans('validation.errors'));
   }

   /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function show($id) {
      return View::make('frontend.blog.posts.show');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id) {
      $post = $this->post->findOrFail($id);

//      $catalog = $this->getDocumentTree();

      return View::make('backend.blog.posts.edit', compact('post'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id) {
      $input = array_except(Input::all(), array('_method', '_token'));
      if (empty($input['name'])) {
         $input['name'] = str_slug($input['title'], '-');
      }
      $post = $this->post->find($id);
      $rules = Post::$rules;
      if ($post->id) {
         $rules['name'] = $rules['name'] . ', ' . $post->id;
      }
      $validation = Validator::make($input, $rules);
      if ($validation->passes()) {
         $input['active'] = isset($input['active']) ? (int) $input['active'] : 0;
         $post->update($input);

         return Redirect::route('posts.index');
      }

      return Redirect::route('posts.edit', $id)
                  ->withInput()
                  ->withErrors($validation)
                  ->with('message', trans('validation.errors'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id) {
      $this->page->find($id)->delete();

      return Redirect::route('pages.index')
                  ->with('message', trans('validation.success'));
   }

}
