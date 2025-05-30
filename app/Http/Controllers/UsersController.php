<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Http\Requests\GuestRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lấy danh sach tất cả ngùoi dùng
        $users = User::paginate(10);
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
    // public function store(GuestRequest $request)
    // {
    //     $validatedData = $request->validated();
    //     // Xác thực dữ liệu đầu vào
    //     // $request->validate([
    //     //     'name' => 'required|string|max:255',
    //     //     'email_address' => 'required|email|unique:users,email_address',
    //     //     'phone_number' => 'required|string|max:15',
    //     //     'password' => 'required|string|min:6|confirmed',
    //     // ]);

    //     // Lưu người dùng vào cơ sở dữ liệu
    //     User::create([
    //         'name' => $request->name,
    //         'email_address' => $request->email_address,
    //         'phone_number' => $request->phone_number,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     
    // }

    public function store(GuestRequest $request)
    {
        // Lấy dữ liệu đã được xác thực từ GuestRequest
        $validatedData = $request->validated();

        // Tạo người dùng mới với dữ liệu đã được xác thực
        User::create([
            'name' => $validatedData['name'],
            'email_address' => $validatedData['email_address'],
            'phone_number' => $validatedData['phone_number'],
            // 'password' => Hash::make($validatedData['password']),
            'password' => bcrypt( $validatedData['password']),
        ]);

       return redirect()->route('user.user-list')->with('success', 'Thêm người dùng thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = User::findOrFail($id);

        return view('user.info-user', compact('user'));
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
        

        // Lấy người dùng từ cơ sở dữ liệu
        $user = User::findOrFail($id);

        // Kiểm tra nếu dữ liệu đã thay đổi
        if ($request->has('updated_at') && $request->updated_at != $user->updated_at) {
            return redirect()->route('user.user-list')->with('error', 'Dữ liệu đã thay đổi. Vui lòng tải lại trang trước khi cập nhật.');
        }

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email_address,' . $id,
            'phone_number' => 'required|string|max:15',
        ]);

        // Cập nhật dữ liệu
        $data = [
            'name' => $request->name,
            'email_address' => $request->email_address,
            'phone_number' => $request->phone_number,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('user.user-list')->with('success', 'Cập nhật người dùng thành công.');

    }


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
            return redirect()->route('user.user-list')->with('error', 'Không thể xóa vì không tồn tại người dùng có ID ' . $id);
        } catch (Exception $e) {
            return redirect()->route('user.user-list')->with('error', 'Đã xảy ra lỗi khi xóa người dùng.');
        }
    }

}

