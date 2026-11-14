<?php
namespace Modules\UserManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\UserManagement\Http\Requests\UserRequest;

class UserManagementController extends Controller
{
    public function index() { return view('usermanagement::index', ['users' => User::latest()->paginate(8)]); }

    public function create() { return view('usermanagement::form', ['user' => new User(['role' => 'user'])]); }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user) { return view('usermanagement::form', compact('user')); }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        // Admin tidak boleh menurunkan role akunnya sendiri
        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return back()->withInput()->withErrors(['role' => 'Anda tidak dapat menurunkan role akun sendiri.']);
        }

        $data['password'] = filled($data['password'] ?? null) ? Hash::make($data['password']) : $user->password;
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
