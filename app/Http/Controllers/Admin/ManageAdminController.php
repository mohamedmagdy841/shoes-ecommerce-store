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
        try {
            $admins = Admin::where('id', '!=', Auth::guard('admin')->user()->id)->paginate(5);
            return view('admin.manageAdmin.index', compact('admins'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while fetching the admin list.');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $roles = Role::where('guard_name', 'admin')->get();
            return view('admin.manageAdmin.create', compact('roles'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the create form.');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        try {
            $data = $request->validated();
            $admin = Admin::create($data);

            if (isset($data['role'])) {
                $admin->assignRole($data['role']);
            }

            notyf()->success('Admin has been created');
            return redirect(route('admin.admins.index'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while creating the admin.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        try {
            $roles = Role::where('guard_name', 'admin')->get();
            return view('admin.manageAdmin.edit', compact('admin', 'roles'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while loading the edit form.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        try {
            $data = $request->validated();
            if ($data['password'] == null) unset($data['password']);
            $admin->update($data);
            $admin->syncRoles([$data['role']]);
            notyf()->success('Admin has been updated');
            return redirect(route('admin.admins.index'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred while updating the admin.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        try {
            $admin->syncRoles([null]);
            $admin->delete();
            return response()->json('Admin has been deleted');
        } catch (\Exception $e) {
            return response()->json('An error occurred while deleting the admin.', 500);
        }
    }

    public function changeStatus($id)
    {
        try {
            $user = Admin::findOrFail($id);
            $user->update([
                'status' => $user->status == 1 ? 0 : 1,
            ]);
            $message = $user->status == 1 ? 'Admin Is Active Now!' : 'Admin Blocked Successfully!';
            notyf()->success($message);
            return redirect()->back();
        } catch (\Exception $e) {
            notyf()->error('An error occurred while changing the admin status.');
            return redirect()->back();
        }
    }
}
