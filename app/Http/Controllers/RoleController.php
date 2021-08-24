<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    /*** Display a listing of the resource.
     * ** @return \Illuminate\Http\Response*/
    public function __construct()
    {
        $this->middleware('permission:صلاحيات المستخدمين', ['only' => ['index', 'store']]);
        $this->middleware('permission:اضافة صلاحية', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل صلاحية', ['only' => ['edit', 'update']]);
        $this->middleware('permission:عرض صلاحية', ['only' => 'show']);
        $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    }

    /*** Display a listing of the resource.
     ** @return \Illuminate\Http\Response*/
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /*** Show the form for creating a new resource.
     * ** @return \Illuminate\Http\Response*/
    public function create()
    {
        $permission = Permission::get();

        return view('admin.roles.create', compact('permission'));
    }

    /*** Store a newly created resource in storage.
     * ** @param  \Illuminate\Http\Request  $request* @return \Illuminate\Http\Response*/
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles,name', 'permission' => 'required'], [], ["permission" => 'الصلاحيات']);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        request()->session()->flash('msgSuccess', "تم اضافة الصلاحية بنجاح");
        return redirect(adminUrl('roles'));
    }

    /*** Display the specified resource.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    /*** Show the form for editing the specified resource.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /*** Update the specified resource in storage.
     * ** @param  \Illuminate\Http\Request  $request* @param  int  $id* @return \Illuminate\Http\Response*/
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));

        request()->session()->flash('msgSuccess', "تم تعديل الصلاحية بنجاح");
        return redirect(adminUrl('roles'));
    }

    /*** Remove the specified resource from storage.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();

        request()->session()->flash('msgSuccess', "تم حذف الصلاحية بنجاح");
        return redirect(adminUrl('roles'));
    }
}
