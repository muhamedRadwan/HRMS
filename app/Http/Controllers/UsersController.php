<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DataTables\UsersDataTable;
use App\Notifications\UserCreated;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Button;

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
            'title' =>  __("role"),
            'searchable' => true,
            'orderable' => false,
            'render' => '[, ].name',
            'footer' => __("role"),
            'exportable' => true,
            'printable' => true,
        ];

        // $id_Column = ['title' => __("Id"), 'data' => 'id', 'name'=> 'users.id'];
        $buttons[] = Button::make('create');
        $columns = [[ 'title' => __("name"), 'data'=> 'name'], 
                [ 'title' => __("email"), 'data'=> 'email'],
                [ 'title' => __("created_at"), 'data'=> 'created_at'],
                $roles_column];
        $dataTable = new UsersDataTable($columns, $query,  $buttons);
        
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
       
        $user = new User();
        foreach ($fields as $key => $value) {
            if( substr($key, 0, 1) != '_')
                $user[$key] = $value;
        }
        $user->save();
        $user->syncRoles($request->input('roles'));
        $user->password = $password;
        $user->notify(new UserCreated);
        $request->session()->flash('message', 'User Created Successfuly');
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
        return view('dashboard.admin.userShow', compact( 'user' ));
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
        return view('dashboard.admin.userEditForm', compact('user'));
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
        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }
}
