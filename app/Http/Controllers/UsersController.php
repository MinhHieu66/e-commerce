<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lấy danh sach tất cả ngùoi dùng
        $users = User::all();
        return view('user.user-list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email_address',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);


        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email_address' => $request->email_address,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),

        ]);
        //dd($user);

        return redirect()->route('user.user-list')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Hiển thị thông tin chi tiết của một người dùng
        $user = User::findOrFail($id);
        //return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Hiển thị form chỉnh sửa thông tin người dùng
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email_address,' . $id,
            'phone_number' => 'required|string|max:15',
        ]);

        $user = User::findOrFail($id);

        // Nếu có nhập password mới thì cập nhật, không thì giữ nguyên
        $data = [
            'name' => $request->name,
            'email_address' => $request->email_address,
            'phone_number' => $request->phone_number,
        ];
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('user.user-list')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     // Xóa người dùng
    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    // }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->delete()) {
                return redirect()->route('user.user-list')->with('success', 'Xóa người dùng thành công.');
            } else {
                return redirect()->route('user.user-list')->with('error', 'Xóa người dùng thất bại.');
            }

        } catch (ModelNotFoundException $e) {
            return redirect()->route('user.user-list')->with('error', 'Không tìm thấy user.');
        } catch (Exception $e) {
            return redirect()->route('user.user-list')->with('error', 'Đã xảy ra lỗi khi xóa user.');
        }
    }
}

