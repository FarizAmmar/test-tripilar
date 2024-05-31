<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'email_verified_at',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function SaveRecord($data)
    {
        $query = DB::table('users')->insert([
            'company_id' => $data->company_id,
            'name' => $data->name,
            'email' => $data->email,
            'role_id' => $data->role_id,
            'password' => $data->password,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $query;
    }

    public function GetRoleName($role_id)
    {
        $query = DB::table('roles')
            ->select('role_name')
            ->where('id', $role_id)
            ->first();

        return $query;
    }

    public function GetRecordByRole($user)
    {
        $query = DB::table('users as U')
            ->select('U.id', 'U.name', 'U.email', 'R.role_name as role_name', 'C.company_name as company_name')
            ->join('roles as R', 'R.id', '=', 'U.role_id')
            ->join('companies as C', 'C.id', '=', 'U.company_id')
            ->orderBy('U.created_at', 'desc');

        if ($user->role->role_name == 'ADMIN') {
            $query->where('U.company_id', $user->company_id);
        } elseif ($user->role->role_name == 'MANAGER' && $user->company_id == 1) {
            $query->where('U.role_id', 3);
            $query->whereIn('U.company_id', [2, 3]);
        } elseif ($user->role->role_name == 'SUPERVISOR' && $user->company_id == 1) {
            $query->where('U.company_id', $user->company_id);
        } elseif ($user->role->role_name == 'MANAGER' && $user->company_id == 2 || $user->company_id == 3) {
            $query->where('U.company_id', $user->company_id);
        } elseif ($user->role->role_name == 'SUPERVISOR' && $user->company_id == 2 || $user->company_id == 3) {
            $query->where('U.company_id', $user->company_id);
        }

        return $query->get();
    }
}
