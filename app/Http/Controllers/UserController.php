<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function login(Request $request){
        $username       = $request->input("username");
        $password       = $request->input("password");

        $Users = DB::table('ref_users as users')
            ->select(
                'users.token as token_user',
                'users.username',
                'users.email',
                'users.password',
                'users.no_induk',
                'users.nama_lengkap',
                'users.jabatan',
                'users.satuan_kerja',
                'users.unit_kerja'
            )
            ->where('users.username', '=', $username)
            ->where('users.is_active', '=', 1)
            ->first();
        


        if ($Users && Hash::check($password, $Users->password)) {
            $Data_Users = DB::table('ref_users as users')
                        ->select(
                            'users.token as token_user',
                            'users.username',
                            'users.email',
                            'users.password',
                            'users.no_induk',
                            'users.nama',
                            'users.jabatan_id',
                            'users.jabatan',
                            'users.satuan_kerja',
                            'users.unit_kerja',
                            'users.role_id',
                            'users.jabatan_pembantu_id',
                            'users.jabatan_pembantu',
                            'users.role_id_pembantu', 
                            'users.id'
                        )
                        ->where('users.username', '=', $username)
                        ->where('users.is_active', '=', 1)
                        ->get();

            $UsersToArray = $Data_Users->toArray();

            if ($UsersToArray !== []) {
                return response()->json([
                    'code' => 200,
                    'dataUsers' => $Data_Users
                ], 200);
            } else {
                return response()->json([
                    'code' => 201,
                    'message' => 'Tidak ada data user, silahkan periksa username dan password anda'
                ], 200);
            }
        } elseif ($Users == null) {
            return response()->json([
                'code' => 201,
                'message' => 'Tidak ada data user, silahkan periksa username dan password anda'
            ], 200);
        } else {
            return response()->json([
                'code' => 201,
                'message' => 'Tidak ada data user, silahkan periksa username dan password anda'
            ], 200);
        }
    }
}
