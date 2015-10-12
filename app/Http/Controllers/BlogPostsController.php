<?php

class BlogPostsController extends BaseController
{

   protected $post;

   const UPLOAD_DIR = '/storage/blog_posts';

   public function __construct(Post $post)
   {
      $this->post = $post;
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $filter = array_fill_keys($this->post->getAllColumnsNames(), "");
      $stop_fields = array('filter', 'user_id');
      $input = Input::all();

      if (isset($input['filter']) && $input['filter'] == 'apply') {
         $filter = array_merge($filter, $input);
         Session::put("BLOGPOSTS_FILTER", $filter);
      }

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('BLOGPOSTS_FILTER');
      }
      if (isset($input['sort_value'])) {
         $sort = $input['sort_value'];
         $sort_dir = $input['sort_dir'];
         Session::put("BLOGPOSTS_SORT", array('value' => $sort, 'dir' => $sort_dir));
      }
      $sort = Session::get('BLOGPOSTS_SORT');

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('BLOGPOSTS_FILTER');
      }

      if (Session::has('BLOGPOSTS_FILTER')) {
         $filter = Session::get('BLOGPOSTS_FILTER');

         $posts = $this->post->where('id', '>', '0');

         foreach ($filter as $k => $v) {
            if (!in_array($k, $stop_fields) && $v != '') {
               $posts = $posts->where($k, 'like', '%' . $v . '%');
            }
         }
         if ($filter['user_id']) {
            $users = User::where('username', 'like', '%' . $filter['user_id'] . '%')->get();
            $posts = $posts->whereIn('user_id', $users->pluck('id')->all());
         }

         if (Session::has('BLOGPOSTS_SORT') && $sort['value'] != '') {
            $posts = $posts->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : '');
         }

         $posts = $posts->paginate(Settings::getValue('TABLE_ELEMENTS'));
      } else {
         if (Session::has('BLOGPOSTS_SORT') && $sort['value'] != '') {
            $posts = $this->post->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : 'asc');
         } else {
            $posts = $this->post;
         }
         $posts = $posts->paginate(Settings::getValue('TABLE_ELEMENTS'));
      }

      $sort_options = Post::getSortOptions();

      return View::make('backend.blog.posts.index', compact("posts", 'filter', 'sort_options', 'sort'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $post = $this->post;

      if (Input::old('image') != '') {
         $post->avatar = Input::old('image');
      }
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
   public function store(Request $request)
   {
      $input = array_except(Input::all(), array('categories', 'file', 'categories_ids'));
      if (empty($input['name'])) {
         $input['name'] = str_slug($input['title'], '-');
      }
      $validation = Validator::make($input, Post::$rules);
      if ($validation->passes()) {
         $input['active'] = isset($input['active']) ? (int)$input['active'] : 0;
         if (!$input['publishied_at'])
            $input['publishied_at'] = date("Y-m-d H:i:s");
         $input['user_id'] = Auth::user()->id;
         $post = $this->post->create($input);

         $categories = array();
         foreach (explode(',', Input::get('categories_ids')) as $cat_id) {
            if ($cat = \BlogCategory::where('id', '=', $cat_id)->first()) {
               $categories[] = $cat->id;
            }
         }
         $post->categories()->sync($categories);

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
   public function show($id)
   {
      return View::make('frontend.blog.posts.show');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
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
   public function update(Request $request, $id)
   {
      $input = array_except(Input::all(), array('_method', '_token', 'categories', 'file', 'categories_ids'));
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
         $input['active'] = isset($input['active']) ? (int)$input['active'] : 0;
         if (!$input['publishied_at'])
            $input['publishied_at'] = date("Y-m-d H:i:s");
         $input['user_id'] = Auth::user()->id;
         $post->update($input);

         $categories = array();
         foreach (explode(',', Input::get('categories_ids')) as $cat_id) {
            if ($cat = \BlogCategory::where('id', '=', $cat_id)->first()) {
               $categories[] = $cat->id;
            }
         }
         $post->categories()->sync($categories);

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
   public function destroy($id)
   {
      $this->post->find($id)->delete();

      return Redirect::route('posts.index')
         ->with('message', trans('validation.success'));
   }

   /**
    * Save uploaded avatar image
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function uploadAvatarImage()
   {
      $rules = array('file' => 'mimes:jpeg,png');
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
         return Response::json(array('message' => $validator->messages()->first('file')));
      }
      $dir = self::UPLOAD_DIR . '/images' . date('/Y/m/d/');
      do {
         $filename = str_random(30) . '.jpg';
      } while (File::exists(public_path() . $dir . $filename));
      Input::file('file')->move(public_path() . $dir, $filename);
      return Response::json(array('filelink' => $dir . $filename));
   }

   public function updateState()
   {
      $rules = array('id' => 'numeric');
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
         return Response::json(array('status' => 'error',
            'message' => $validator->messages()->first('id')));
      }
      $input = Input::all();

      $post = $this->post->findOrFail($input['id']);
      if ($post->id) {
         $post->active = !$post->active;
         $post->save();
      }

      return Response::json(array('status' => 'ok'));
   }

}
