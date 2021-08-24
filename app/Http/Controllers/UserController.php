<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use DB;use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:قائمة المستخدمين', ['only' => 'index']);

        $this->middleware('permission:اضافة مستخدم', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => 'destroy']);
    }

    /*** Display a listing of the resource.** @return \Illuminate\Http\Response*/
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('users'));
    }

    /*** Show the form for creating a new resource.** @return \Illuminate\Http\Response*/
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('roles'));
    }

    /*** Store a newly created resource in storage.
     ** @param  \Illuminate\Http\Request  $request* @return \Illuminate\Http\Response*/
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['roles_name'] = $request->roles_name;

        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));

        $request->session()->flash('msgSuccess', "تم اضافة المستخدم بنجاح");
        return redirect(adminurl('users'));
    }

    /*** Display the specified resource.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }

    /*** Show the form for editing the specified resource.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /*** Update the specified resource in storage.
     * ** @param  \Illuminate\Http\Request  $request* @param  int  $id* @return \Illuminate\Http\Response*/
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles_name' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles_name'));

        $request->session()->flash('msgSuccess', "تم تعديل المستخدم بنجاح");
        return redirect(adminUrl('users'));
    }

    /*** Remove the specified resource from storage.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function destroy($id)
    {
        if ($id != 1) {
            User::find($id)->delete();
        } else {
            return redirect('notFound');
        }

        request()->session()->flash('msgSuccess', 'تم حذف العضو بنجاح');
        return redirect(adminUrl('users'));
    }
}
