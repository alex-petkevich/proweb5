<?php

class UsersController extends BaseController
{

   /**
    * User Repository
    *
    * @var User
    */
   protected $user;
   protected $dates = ['deleted_at'];

   const UPLOAD_DIR = '/storage/users';

   public function __construct(User $user)
   {
      $this->user = $user;
   }

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
      $filter = array_fill_keys($this->user->getAllColumnsNames(), "");
      $stop_fields = array('filter');

      $input = Input::all();
      if (isset($input['filter']) && $input['filter'] == 'apply') {
         $filter = array_merge($filter, $input);
         Session::put("USER_FILTER", $filter);
      }

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('USER_FILTER');
      }
      if (isset($input['sort_value'])) {
         $sort = $input['sort_value'];
         $sort_dir = $input['sort_dir'];
         Session::put("USER_SORT", array('value' => $sort, 'dir' => $sort_dir));
      }
      $sort = Session::get('USER_SORT');

      if (isset($input['filter']) && $input['filter'] == 'reset') {
         Session::forget('USER_FILTER');
      }

      if (Session::has('USER_FILTER')) {
         $filter = Session::get('USER_FILTER');

         $users = $this->user->where('id', '>', '0');

         foreach ($filter as $k => $v) {
            if (!in_array($k, $stop_fields) && $v != '') {
               $users = $users->where($k, 'like', '%' . $v . '%');
            }
         }

         if (Session::has('USER_SORT')) {
            $users = $users->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : '');
         }

         $users = $users->paginate(Settings::getValue('TABLE_ELEMENTS'));
      } else {
         if (Session::has('USER_SORT') && $sort['value'] != '') {
            $users = $this->user->orderBy($sort['value'], $sort['dir'] == '1' ? 'desc' : 'asc');
         } else {
            $users = $this->user;
         }
         $users = $users->paginate(Settings::getValue('TABLE_ELEMENTS'));
      }

      $sort_options = User::getSortOptions();

      return View::make('backend.users.index', compact('users', 'filter', 'sort_options', 'sort'));
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

      $user = $this->user->findOrFail($input['id']);
      if ($user->id) {
         $user->active = !$user->active;
         $user->save();
      }

      return Response::json(array('status' => 'ok'));
   }

   public function create()
   {
      $user = $this->user;

      return View::make('backend.users.edit.general', compact('user'));
   }

   /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return Response
    */
   public function show($id)
   {
      $user = $this->user->findOrFail($id);

      return View::make('backend.users.show', compact('user'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return Response
    */
   public function edit($id)
   {
      $user = $this->user->findOrFail($id);

      return View::make('backend.users.edit.general', compact('user'));
   }

   public function edit_profile($id)
   {
      $user = $this->user->findOrFail($id);

      return View::make('backend.users.edit.profile', compact('user'));
   }

   public function edit_notes($id)
   {
      $user = $this->user->findOrFail($id);

      return View::make('backend.users.edit.notes', compact('user'));
   }

   public function store()
   {
      $input = Input::all();
      $validation = Validator::make($input, User::$rules);

      if ($validation->passes()) {
         $user = new User;
         $user->email = Input::get('email');
         $user->username = Input::get('username');
         $user->password = Hash::make(Input::get('password'));
         $user->active = (isset($input['active']) && $input['active'] ? 1 : 0);
         $user->save();

         $roles = array();

         foreach (explode(', ', Input::get('roles')) as $role_name) {
            if ($role = Role::where('role', '=', $role_name)->first()) {
               $roles[] = $role->id;
            }
         }

         $user->roles()->sync($roles);

         Mail::send('emails.welcome', array('username' => $user->username), function ($message) use ($user) {
            $message->to($user->email, $user->username)->subject(trans('login.welcome_subj'));
         });

         return Redirect::route('users.index');
      }

      return Redirect::route('users.create')
         ->withInput()
         ->withErrors($validation)
         ->with('message', trans('validation.errors'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  int $id
    * @return Response
    */
   public function update($id)
   {
      $user = $this->user->findOrFail($id);
      $input = Input::all();
      //$validation = Validator::make($input, User::$rules);
      //if ($validation->passes()) {

      if (!empty($input['password'])) {
         $user->password = Hash::make($input['password']);
      }

      $user->active = (isset($input['active']) && $input['active'] ? 1 : 0);

      $user->save();

      $roles = array();
      foreach (explode(', ', Input::get('roles')) as $role_name) {
         if ($role = Role::where('role', '=', $role_name)->first()) {
            $roles[] = $role->id;
         }
      }
      $user->roles()->sync($roles);

      return Redirect::route('users.index');
   }

   public function update_user($id)
   {
      $user = $this->user->findOrFail($id);
      $input = array_except(Input::all(), array('_method', '_token', 'username'));
      $input['username'] = $user->username;

      $rules = User::$rules;

      if ($user->id) {
         $rules['username'] = $rules['username'] . ',' . $user->id;
         $rules['email'] = $rules['email'] . ',' . $user->id;
         $rules['password'] = 'alpha_num|between:0,50';
      }

      if ($user->avatar && $user->avatar != $input['image'] && File::exists($user->avatar)) {
         File::delete($user->avatar);
      }

      $validation = Validator::make($input, $rules);
      if ($validation->passes()) {

         if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
         } else {
            unset($input['password']);
         }
         $input['avatar'] = $input['image'];
         unset($input['image']);
         unset($input['file']);

         $user->update($input);

         return Redirect::route('user.profile');
      }

      return Redirect::route('user.profile')
         ->withInput()
         ->withErrors($validation)
         ->with('message', trans('validation.errors'));

   }
   
   /**
    * Update notes tab
    *
    * @param type $id
    * @return type
    */
   public function update_notes($id)
   {
      $user = $this->user->findOrFail($id);
      $input = Input::all();

      $user->description = $input['description'];
      $user->save();

      return Redirect::route('users.edit_notes', $id)
         ->withInput()
         ->with('message', trans('validation.success'));
   }

   /**
    *  Update profile tab
    *
    * @param type $id
    * @return type
    */
   public function update_profile($id)
   {
      $user = $this->user->findOrFail($id);
      $input = Input::all();

      if ($user->avatar && $user->avatar != $input['image'] && File::exists($user->avatar)) {
         File::delete($user->avatar);
      }

      $user->fullname = $input['fullname'];
      $user->birthdate = $input['birthdate'];
      $user->avatar = $input['image'];
      $user->notifications = (isset($input['notifications']) && $input['notifications'] ? 1 : 0);

      $user->save();

      return Redirect::route('users.edit_profile', $id)
         ->withInput()
         ->with('message', trans('validation.success'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return Response
    */
   public function destroy($id)
   {
      $this->user->findOrFail($id)->delete();

      return Redirect::route('users.index');
   }

   /**
    * show edit form for user profile
    */
   public function editProfile()
   {
      $user = Auth::user();
      if ($user == null) {
         return Redirect::to('login');
      }
      return View::make('backend.users.profile', compact("user"));
   }

}
