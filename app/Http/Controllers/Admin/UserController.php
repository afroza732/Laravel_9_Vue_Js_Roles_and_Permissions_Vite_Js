<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user list', ['only' => ['index', 'show']]);
        $this->middleware('can:user create', ['only' => ['create', 'store']]);
        $this->middleware('can:user edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:user delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = (new User)->newQuery();
        $users->latest();
        $users = $users->paginate(100)->onEachSide(2)->appends(request()->query());
        //return Inertia::render('Dashboard');
        return Inertia::render('Admin/User/Index', [
            'users' => $users,
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ]
        ]);
    }

    public function create(){
        return Inertia::render('Admin/User/Create', [
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ],
           
        ]);
    }

    public function store(Request $request){
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'c_password' => ['required'],
        ])->validate();
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user.index')
        ->with('message', 'User created successfully.');
    }
    
    public function edit(User $user)
    {
        return Inertia::render('Admin/User/Edit', [
            'user' => $user,
            'can' => [
                'create' => Auth::user()->can('user create'),
                'edit' => Auth::user()->can('user edit'),
                'delete' => Auth::user()->can('user delete'),
            ],
        ]);
    }
    public function update(Request $request,$id){
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
        ])->validate();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = ($request->password) ? Hash::make($request->password) : $user->password;
        $user->save();
        return redirect()->route('user.index')
        ->with('message', 'User updated successfully.');
    }
    public function destroy($id){
        User::findOrFail($id)->delete();
        return redirect()->route('user.index');
    }
}
