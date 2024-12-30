<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ManageAdminController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('role:Super Admin,admin'),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('id', '!=', Auth::guard('admin')->user()->id)->paginate(5);
        return view('admin.manageAdmin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.manageAdmin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::create($data);
        if (isset($data['role']))
        {
            $admin->assignRole($data['role']);
        }
        notyf()->success('Admin has been created');
        return redirect(route('admin.admins.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.manageAdmin.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $data = $request->validated();
        if ($data['password'] == null) unset($data['password']);
        $admin->update($data);
        $admin->syncRoles([$data['role']]);
        notyf()->success('Admin has been updated');
        return redirect(route('admin.admins.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->syncRoles([null]);
        $admin->delete();
        return response()->json('Admin has been deleted');
    }

    public function changeStatus($id)
    {
        $user = Admin::findOrFail($id);

        if ($user->status == 1) {
            $user->update([
                'status' => 0,
            ]);
            notyf()->success('Admin Blocked Successfully!');
        } else {
            $user->update([
                'status' => 1,
            ]);
            notyf()->success('Admin Is Active Now!');
        }
        return redirect()->back();
    }
}
