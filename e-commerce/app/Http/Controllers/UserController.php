<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // return response()->json(User::all());
        $users = User::all(); // Lấy tất cả dữ liệu từ bảng users
        return view('user.user-list', compact('users'));
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email_address' => 'required|email|unique:users,email_address',
        //     'password' => 'required|string|min:6',
        // ]);

        // $validated['password'] = bcrypt($validated['password']);

        // $user = User::create($validated);

        // return response()->json($user, 201);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email_address',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']); // Mã hóa mật khẩu

        User::create($validated); // Lưu vào database

        return redirect()->back()->with('success', 'Người dùng đã được thêm thành công!');
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user ? response()->json($user) : response()->json(['message' => 'User not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Người dùng không tồn tại!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email_address,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Người dùng đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Người dùng không tồn tại!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Người dùng đã được xóa thành công!');
    }
}
