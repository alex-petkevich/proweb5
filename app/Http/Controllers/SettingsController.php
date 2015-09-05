<?php

class SettingsController extends BaseController
{

   /**
    * Settings Repository
    *
    * @var Setings
    */
   protected $settings;

   public function __construct(Setings $settings)
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
      $settings = $this->settings->get();

      return View::make('backend.settings.index', compact('settings'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  int $id
    * @return Response
    */
   public function update($id)
   {
      $input = array_except(Input::all(), '_method');
      $validation = Validator::make($input, Role::$rules);

      if ($validation->passes()) {
         $settings = $this->settings->find($id);
         $settings->update($input);

         return Redirect::route('roles.index', $id);
      }
      return Redirect::route('roles.index', $id)
         ->withInput()
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
