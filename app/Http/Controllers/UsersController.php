<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DataTables\UsersDataTable;
use App\Notifications\UserCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Button;
use QrCode;
// use Datatables;
class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = User::query()->with("roles");
        $roles_column = [
            'name' => 'roles.name',
            'data' => 'roles',
            'title' =>  __("master.role"),
            'searchable' => true,
            'orderable' => false,
            'render' => '[, ].name',
            'footer' => __("role"),
            'exportable' => true,
            'printable' => true,
        ];

        // $id_Column = ['title' => __("Id"), 'data' => 'id', 'name'=> 'users.id'];
        $buttons[] = Button::make('create')->name(__("master.create"));
        $actionColumn = [];
        $columns = [[ 'title' => __("master.name"), 'data'=> 'name'], 
                [ 'title' => __("master.email"), 'data'=> 'email'],
                [ 'title' => __("master.created_at"), 'data'=> 'created_at'],
                $roles_column];
        $dataTable = new UsersDataTable($columns, $query,  $buttons, "users");
        
        return $dataTable->render('dashboard.admin.usersList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('dashboard.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['token' => str_random(16)]);
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:128',
            'email'      => 'required|email|unique:users,email',
            'token'      => 'required|unique:users,token'
        ]);

        $password = str_random(8);
        $fields = $request->except(['id', 'roles']);
        $password_hash = Hash::make($password);
        $fields['password'] = $password_hash;

        // \Storage::disk('public')
        // ->put('test.png',base64_decode(QrCode::getBarcodePNG($request->token, "PDF417")));

        $user = new User();
        foreach ($fields as $key => $value) {
            if( substr($key, 0, 1) != '_')
                $user[$key] = $value;
        }
        $user->save();
        $user->syncRoles($request->input('roles'));
        $user->password = $password;
        $user->notify(new UserCreated);
        QrCode::size(500)
        ->format('svg')
        ->generate('HDTuto.com', public_path("qrcodes/$user->token.svg"));
        $request->session()->flash('message', __('master.edited_successfully'));
        $request->session()->flash('alert-class', 'success');
        return  redirect()->route('users.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $userRoles = $user->getRoles()->pluck("name")->toArray();
        $userRoles = implode(',', $userRoles);
        return view('dashboard.admin.userShow', compact( 'user', 'userRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRoles = $user->getRoles()->pluck("id")->toArray();
        return view('dashboard.admin.userEditForm', compact( 'user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256'
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        $user->save();
        $user->syncRoles($request->input('roles'));
        QrCode::size(250)
        ->format('svg')
        ->generate(route("attendance.guestAttendance", $user->token), public_path("qrcodes/$user->token.svg"));
        $request->session()->flash('message', __('master.edited_successfully'));
        $request->session()->flash('alert-class', 'success');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if($user){
            $user->delete();
        }
        // return redirect()->route('users.index');
    }


    public function changPassword(Request $request){
        $validatedData = $request->validate([
            'current_password'      => 'required',
            'password'      => 'required|min:8|max:20|confirmed'
        ]);

        if(Hash::check($request->current_password, Auth::user()->password) ){
            Auth::user()->password = Hash::make($request->password);
            Auth::user()->save();
            $request->session()->flash('message', __('master.edited_successfully'));
            $request->session()->flash('alert-class', 'success');
            return redirect()->route('home');

        }else{
            $request->session()->flash('message', __('master.current_password_not_valid'));
            $request->session()->flash('alert-class', 'danger');
            return redirect()->back()->withInput();
        }
    }
}
