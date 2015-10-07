<?php

use Illuminate\Http\Request;

class PromosController extends Controller {

   protected $promo;

   const UPLOAD_DIR = '/storage/promos';

   public function __construct(Promo $promo) {
      $this->promo = $promo;
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index() {
      $filter = array_fill_keys($this->promo->getAllColumnsNames(), "");
      $stop_fields = array('filter');
      $input = Input::all();

      if (isset($input['filter']) && $input['filter'] == 'apply') {
         $filter = array_merge($filter, $input);
         Session::put("PROMOS_FILTER", $filter);
      }

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('PROMOS_FILTER');
      }
      if (isset($input['sort_value'])) {
         $sort = $input['sort_value'];
         $sort_dir = $input['sort_dir'];
         Session::put("PROMOS_SORT", array('value' => $sort, 'dir' => $sort_dir));
      }
      $sort = Session::get('PROMOS_SORT');

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('PROMOS_FILTER');
      }

      if (Session::has('PROMOS_FILTER')) {
         $filter = Session::get('PROMOS_FILTER');

         $promos = $this->promo->where('id', '>', '0');

         foreach ($filter as $k => $v) {
            if (!in_array($k, $stop_fields) && $v != '') {
               $promos = $promos->where($k, 'like', '%' . $v . '%');
            }
         }

         if (Session::has('PROMOS_SORT') && $sort['value'] != '') {
            $promos = $promos->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : '');
         }

         $promos = $promos->paginate(Settings::getValue('TABLE_ELEMENTS'));
      } else {
         if (Session::has('PROMOS_SORT') && $sort['value'] != '') {
            $promos = $this->promo->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : 'asc');
         } else {
            $promos = $this->promo;
         }
         $promos = $promos->paginate(Settings::getValue('TABLE_ELEMENTS'));
      }

      $sort_options = Promo::getSortOptions();

      return View::make('backend.promos.index', compact("promos", 'filter', 'sort_options', 'sort'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create() {
      $promo = $this->promo;

      if (Input::old('image') != '') {
         $promo->img = Input::old('image');
      }

      return View::make('backend.promos.edit', compact('promo'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request) {
      $input = array_except(Input::all(), array('category', 'file'));
      $validation = Validator::make($input, Promo::$rules);
      if ($validation->passes()) {
         $input['active'] = isset($input['active']) ? (int) $input['active'] : 0;
         $promo = $this->promo->create($input);

         return Redirect::route('promos.index');
      }

      return Redirect::route('promos.create')
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
      return View::make('frontend.promos.show');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id) {
      $promo = $this->promo->findOrFail($id);

      return View::make('backend.promos.edit', compact('promo'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id) {
      $input = array_except(Input::all(), array('_method', '_token', 'category', 'file'));
      $promo = $this->promo->find($id);
      $rules = Promo::$rules;
      if ($promo->id) {
         $rules['name'] = $rules['name'] . ', ' . $promo->id;
      }
      $validation = Validator::make($input, $rules);
      if ($validation->passes()) {
         $input['active'] = isset($input['active']) ? (int) $input['active'] : 0;
         $promo->update($input);

         return Redirect::route('promos.index');
      }

      return Redirect::route('promos.edit', $id)
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
      $this->promo->find($id)->delete();

      return Redirect::route('promos.index')
                  ->with('message', trans('validation.success'));
   }

   /**
    * Save uploaded avatar image
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function uploadImage() {
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

   public function updateState() {
      $rules = array('id' => 'numeric');
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
         return Response::json(array('status' => 'error',
                  'message' => $validator->messages()->first('id')));
      }
      $input = Input::all();

      $promo = $this->promo->findOrFail($input['id']);
      if ($promo->id) {
         $promo->active = !$promo->active;
         $promo->save();
      }

      return Response::json(array('status' => 'ok'));
   }

}
