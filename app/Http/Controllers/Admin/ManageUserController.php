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
        try {
            $users = User::paginate(5);
            return view('admin.user.index', compact('users'));
        } catch (\Exception $e) {
            notyf()->error('Failed to load users.');
            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response('User deleted successfully.', 200);
        } catch (\Exception $e) {
            notyf()->error('Failed to delete user.');
            return response('Failed to delete user.', 500);
        }
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

            $user->update([
                'status' => $user->status == 1 ? 0 : 1,
            ]);

            $message = $user->status == 1 ?
                'User activated successfully.' :
                'User deactivated successfully.';

            notyf()->success($message);

        return redirect()->back();
    }
}
