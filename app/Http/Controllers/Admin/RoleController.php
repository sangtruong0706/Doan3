<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest('id')->paginate(5);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::all()->groupBy('group');
        return view('admin.roles.create', compact('permission'));
    }

    public function store(CreateRoleRequest $request)
    {
        $dataCreate = $request->all();
        // dd($dataCreate);
        $dataCreate['guard_name']= 'web';
        $role = Role::create($dataCreate);
        $role->permissions()->attach($dataCreate['permission_ids']);
        return to_route('roles.index')->with(['messages'=> 'Create successfully']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permission = Permission::all()->groupBy('group');
        return view('admin.roles.edit', compact('role', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $dataUpdate = $request->all();
        $role->update($dataUpdate);
        $role->permissions()->sync($dataUpdate['permission_ids']);
        return to_route('roles.index')->with(['messages'=> 'Update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);
        return to_route('roles.index')->with(['messages'=> 'Delete successfully']);
    }
}
