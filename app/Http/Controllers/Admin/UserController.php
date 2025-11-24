<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function mustSuperAdmin()
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {
        $this->mustSuperAdmin();

        $users = User::orderBy('role', 'asc')
                    ->orderBy('name', 'asc')
                    ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->mustSuperAdmin();

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->mustSuperAdmin();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', 'in:admin,super_admin'],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->mustSuperAdmin();

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->mustSuperAdmin();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'in:admin,super_admin'],
            'password' => ['nullable', 'min:6'],
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->mustSuperAdmin();

        if (auth()->id() === $user->id) {
            return back()->with('success', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'super_admin' && auth()->user()->role !== 'super_admin') {
            return back()->with('success', 'Anda tidak memiliki izin untuk menghapus Super Admin.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
