<?php

use Illuminate\Http\Request;

class ProposalsController extends Controller
{

   protected $proposal;

   const UPLOAD_DIR = '/storage/proposals';

   public function __construct(Proposal $proposal)
   {
      $this->proposal = $proposal;
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $filter = array_fill_keys($this->proposal->getAllColumnsNames(), "");
      $stop_fields = array('filter');
      $input = Input::all();

      if (isset($input['filter']) && $input['filter'] == 'apply') {
         $filter = array_merge($filter, $input);
         Session::put("PROPOSALS_FILTER", $filter);
      }

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('PROPOSALS_FILTER');
      }
      if (isset($input['sort_value'])) {
         $sort = $input['sort_value'];
         $sort_dir = $input['sort_dir'];
         Session::put("PROPOSALS_SORT", array('value' => $sort, 'dir' => $sort_dir));
      }
      $sort = Session::get('PROPOSALS_SORT');

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('PROPOSALS_FILTER');
      }

      if (Session::has('PROPOSALS_FILTER')) {
         $filter = Session::get('PROPOSALS_FILTER');

         $proposals = $this->proposal->where('id', '>', '0');

         foreach ($filter as $k => $v) {
            if (!in_array($k, $stop_fields) && $v != '') {
               $proposals = $proposals->where($k, 'like', '%' . $v . '%');
            }
         }

         if (Session::has('PROPOSALS_SORT') && $sort['value'] != '') {
            $proposals = $proposals->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : '');
         }

         $proposals = $proposals->paginate(Settings::getValue('TABLE_ELEMENTS'));
      } else {
         if (Session::has('PROPOSALS_SORT') && $sort['value'] != '') {
            $proposals = $this->proposal->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : 'asc');
         } else {
            $proposals = $this->proposal;
         }
         $proposals = $proposals->paginate(Settings::getValue('TABLE_ELEMENTS'));
      }

      $sort_options = Proposal::getSortOptions();

      return View::make('backend.proposals.index', compact("proposals", 'filter', 'sort_options', 'sort'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $proposal = $this->proposal;

      return View::make('backend.proposals.edit', compact('proposal'));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $input = array_except(Input::all(), array());
      $validation = Validator::make($input, Proposal::$rules);
      if ($validation->passes()) {
         if (!$input['published_at'])
            $input['published_at'] = date("Y-m-d H:i:s");
         $input['user_id'] = Auth::user()->id;
         $proposal = $this->proposal->create($input);

         return Redirect::route('proposals.index');
      }

      return Redirect::route('proposals.create')
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
      return View::make('frontend.proposals.show');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $proposal = $this->proposal->findOrFail($id);

      return View::make('backend.proposals.edit', compact('proposal'));
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
      $input = array_except(Input::all(), array('_method', '_token'));
      $proposal = $this->proposal->find($id);
      $rules = Proposal::$rules;
      $validation = Validator::make($input, $rules);
      if ($validation->passes()) {
         if (!$input['published_at'])
            $input['published_at'] = date("Y-m-d H:i:s");
         $input['user_id'] = Auth::user()->id;
         $proposal->update($input);

         return Redirect::route('proposals.index');
      }

      return Redirect::route('proposals.edit', $id)
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
      $this->proposal->find($id)->delete();

      return Redirect::route('proposals.index')
         ->with('message', trans('validation.success'));
   }

   /**
    * Save uploaded avatar image
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function uploadImage()
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
}
