<?php

class PagesController extends BaseController
{
   protected $page;

   public function __construct(Page $page)
   {
      $this->page = $page;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $pages = $this->page->paginate(Settings::getValue('TABLE_ELEMENTS'));

      return View::make('backend.pages.index', compact("pages"));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $pages = $this->page->get();
      $catalog = array(0 => trans('pages.no'));
      foreach ($pages as $k => $v) {
         $catalog[$v['id']] = $v['title'];
      }
      return View::make('backend.pages.create', compact('catalog'));
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
      $validation = Validator::make($input, Page::$rules);
      if ($validation->passes()) {
         $this->page->create($input);

         return Redirect::route('pages.index');
      }

      return Redirect::route('pages.create')
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
      return View::make('frontend.pages.show');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      return View::make('backend.pages.edit');
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
      //
   }
}
