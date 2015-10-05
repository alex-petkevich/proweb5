<?php

class SettingsController extends BaseController
{

   protected $settings;

   public function __construct(Settings $settings)
   {
      $this->settings = $settings;
   }

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
      $settings = $this->settings->whereNull('group')->get();

      return View::make('backend.settings.index', compact('settings'));
   }

   public function index_payment()
   {
      $settings = $this->settings->where('group', '=', 'payment')->get();
      return View::make('backend.settings.index', compact('settings'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
      $i = 1;
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  Request $request
    * @return Response
    */
   public function store(Request $request)
   {
      $i = 1;
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return Response
    */
   public function edit($id)
   {
      $i = 1;
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  Request $request
    * @param  int $id
    * @return Response
    */
   public function update(Request $request)
   {
      $input = array_except(Input::all(), '_method');

      if (isset($input['name'])) {
         foreach ($input['name'] as $k => $v) {
            $setting = $this->settings->where('name', '=', $k)->first();
            if (!empty($setting->id)) {
               $setting->value = $v;
               $validation = Validator::make($setting->toArray(), Settings::$rules);
               if ($validation->passes()) {
                  $setting->save();
               }
            }
         }
      }

      if (!isset($validation) || $validation->passes()) {
         Settings::clearCache();

         return Redirect::route('settings.index')
            ->with('message', trans('validation.success'));
      }

      return Redirect::route('settings.index')
         ->withErrors($validation)
         ->with('message', trans('validation.errors'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return Response
    */
   public function destroy($id)
   {
      $this->settings->find($id)->delete();

      return Redirect::route('settings.index');
   }

}
