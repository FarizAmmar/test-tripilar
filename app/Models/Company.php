<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    // Save data
    public function SaveRecord($company_name)
    {
        $query = DB::table('companies')->insert([
            'company_name' => $company_name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $query;
    }

    // Get data by name
    public function FetchRecordByName($company_name)
    {
        $query = DB::table('companies')
            ->select('*')
            ->where('company_name', $company_name)
            ->first();

        return $query;
    }
}
