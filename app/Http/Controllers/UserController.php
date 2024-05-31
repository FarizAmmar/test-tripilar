<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public $user_model;
    public $role_model;

    public function __construct(User $user, Role $role)
    {
        $this->user_model = $user;
        $this->role_model = $role;
    }

    // View User
    public function index(Request $request)
    {
        $user = auth()->user();
        $role = $this->role_model->all();
        $data = $this->user_model->GetRecordByRole($user);

        // Menambahkan nomor urut
        $data = $data->map(function ($item, $key) {
            $item->row_number = $key + 1;
            return $item;
        });

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('row_number', function ($row) {
                    return $row->row_number;
                })
                ->rawColumns(['row_number', 'action'])
                ->make(true);
        }

        return view('pages.user.index', compact('user', 'role'));
    }

    public function fetch_user(string $id)
    {
        $data = User::where('id', $id)->first();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        // Simpan data ke dalam database
        try {
            DB::table('users')
                ->insert([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt('password'), //Password di buat default
                    'role_id' => $request->input('role'),
                    'company_id' => auth()->user()->company_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'email_verified_at' => Carbon::now(),
                ]);

            return response()->json(['success', 'User created successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()], 400);
        }
    }

    public function update($id, Request $request)
    {
        // Update data ke dalam database
        try {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'role_id' => $request->input('role'),
                    'updated_at' => Carbon::now(),
                ]);

            return response()->json(['success', 'User updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        // Delete data dari database
        try {
            DB::table('users')
                ->where('id', $id)
                ->delete();

            return response()->json(['success', 'User deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()], 400);
        }
    }
}
