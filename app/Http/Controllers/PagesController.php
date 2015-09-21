<?php

use Illuminate\Http\Request;

class PagesController extends BaseController {

   protected $page;

   public function __construct(Page $page) {
      $this->page = $page;
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index() {
      $pages = $this->page->getTreeArray();
      return View::make('backend.pages.index', compact("pages"));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request) {
      $page = $this->page;
      if (!empty($request->input("parent_id"))) {
         $page->parent_id = $request->input("parent_id");
      }

      $catalog = $this->getDocumentTree();

      return View::make('backend.pages.edit', compact('catalog', 'page'));
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
      $validation = Validator::make($input, Page::$rules);
      if ($validation->passes()) {
         $input['active'] = isset($input['active']) ? (int) $input['active'] : 0;
         $input['show_title'] = isset($input['show_title']) ? (int) $input['show_title'] : 0;
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
   public function show($id) {
      return View::make('frontend.pages.show');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id) {
      $page = $this->page->findOrFail($id);

      $catalog = $this->getDocumentTree();

      return View::make('backend.pages.edit', compact('catalog', 'page'));
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
      $validation = Validator::make($input, Page::$rules);
      if ($validation->passes()) {
         $input['active'] = isset($input['active']) ? (int)$input['active'] : 0;
         $input['show_title'] = isset($input['show_title']) ? (int)$input['show_title'] : 0;
         $page = $this->page->find($id);
         $page->update($input);

         return Redirect::route('pages.index');
      }

      return Redirect::route('pages.edit')
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
      $this->page->where('parent_id', '=', $id)->delete();
      $this->page->find($id)->delete();

      return Redirect::route('pages.index')
                  ->with('message', trans('validation.success'));
   }

   private function getDocumentTree() {
      $pages = $this->page->getTreeArray();
      $pages = alignTreeArray($pages, '&nbsp;');
      $pages = flattenTreeArray($pages);

      $catalog = array(0 => trans('pages.no'));
      foreach ($pages as $k => $v) {
         $catalog[$v['id']] = $v['title'];
      }
      return $catalog;
   }

}
