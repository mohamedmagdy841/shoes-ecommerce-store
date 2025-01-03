<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManageUserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:delete_user,admin', only: ['destroy', 'changeStatus']),
        ];
    }

    public function index()
    {
        $users = User::paginate(5);
        return view('admin.user.index', compact('users'));
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response('User deleted successfully.', 200);
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->status == 1) {
            $user->update([
                'status' => 0,
            ]);
            notyf()->success('User Blocked Successfully!');
        } else {
            $user->update([
                'status' => 1,
            ]);
            notyf()->success('User Is Active Now!');
        }
        return redirect()->back();
    }
}
