<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function edit()
    {
        try {
            $admin = auth('admin')->user();

            if (!$admin) {
                throw new \Exception('Admin not found or not authenticated.');
            }

            return view('admin.profile.edit', compact('admin'));
        } catch (\Exception $e) {
            notyf()->error('An error occurred: ' . $e->getMessage());
            return redirect()->route('admin.login'); // Redirect to login if not authenticated
        }
    }

    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        try {
            $data = $request->validated();

            if ($data['password'] == null) {
                unset($data['password']);
            }

            $updateResult = $admin->update($data);

            if (!$updateResult) {
                throw new \Exception('Failed to update the profile.');
            }

            notyf()->success('Profile has been updated');
            return redirect()->route('admin.profile.edit');
        } catch (\Exception $e) {
            notyf()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
