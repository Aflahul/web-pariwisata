<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Lock hanya super admin
     */
    private function mustSuperAdmin()
    {
        $u = auth()->User();
        if (!$u || $u->role !== 'super_admin') {
            abort(403, 'Akses ditolak. Hanya Super Admin.');
        }
    }

    /**
     * LIST USER
     */
    public function index()
    {
        $this->mustSuperAdmin();

        $users = User::orderBy('role')
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $this->mustSuperAdmin();
        return view('admin.users.create');
    }

    /**
     * STORE USER
     */
    public function store(Request $request)
    {
        $this->mustSuperAdmin();

        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,super_admin',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * EDIT USER
     */
    public function edit(User $user)
    {
        $this->mustSuperAdmin();
        return view('admin.users.edit', compact('user'));
    }

    /**
     * UPDATE USER
     */
    public function update(Request $request, User $user)
    {
        $this->mustSuperAdmin();

        // Tidak boleh turunkan role sendiri
        if ($user->id === auth()->id() && $request->role !== 'super_admin') {
            return back()->withErrors([
                'role' => 'Anda tidak dapat mengubah role Anda sendiri.'
            ]);
        }

        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,super_admin',
            'password' => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * DELETE USER
     */
    public function destroy(User $user)
    {
        $this->mustSuperAdmin();

        // Tidak boleh hapus diri sendiri
        if (auth()->id() === $user->id) {
            return back()->withErrors([
                'delete' => 'Anda tidak dapat menghapus akun Anda sendiri.'
            ]);
        }

        // Tidak boleh hapus super admin lain
        if ($user->role === 'super_admin') {
            return back()->withErrors([
                'delete' => 'Anda tidak memiliki izin untuk menghapus Super Admin lain.'
            ]);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
