<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /* 
    ========================
    || Auth Controller    ||
    ========================
    || callback           ||
    || checkCookie        ||
    ========================
    */
    
    public function callback(Request $req)
    {
        
        $body = [
            'username' => $req->username,
            'password' => $req->password,
            'code' => Config::get('utils.CLIENT_ID'),
        ];
        
        // return response()->json([
            //      "SSO_URL" => Config::get('utils.SSO_URL'),
            //      "body" => $body,
            // ]);
            
            //post ke sso backend
            try {
                // $response = Http::post("https://ssov2.jamkrida-jabar.co.id/response/auth/login-sso", $body);
                
                $response = Http::withoutVerifying()->post(Config::get('utils.SSO_URL') . "auth/login-sso", $body); //simpen di env
                // $response = Http::withoutVerifying()->post("https://ssov2.jamkrida-jabar.co.id/response/auth/login-sso", $body); //simpen di env
                } catch (\Exception $e) {
                    return response()->json([
                        "status" => 0,
                        "message" => $e->getMessage()
                    ]);
                }
                
                $data = json_decode($response->body());
                $status = $response->status();
                //kalo password nya salah return 403 permission denied
                if ($status == 403) {
                    return response()->json([
                        "status" => $data->status,
                        "success" => $data->success,
                        "error" => $data->error
                    ], 403);
                };
                
                
                //kalo bener return cookies ke frontend sama url redirect
                $cookies = $response->header('Set-Cookie');
                
                $url = $data->data->app_url;
                
                $response = response()->json([
                    "success" => 1,
                    "data" =>  [
                        "cookies" => $cookies,
                        "url" => $url
                        ]
                    ], 201);
                    // $response->cookie('accessCode', $cookies);
                    // $response->header('accessCode', $cookies);
                    
                    return $response;
                }
                
                public function checkCookie(Request $req)
                {
                    
                    //get cookies yang di kirim dari frontend id header 
                    $header = $req->header('accessCode');
                    
                    //checking session di sso-be
                    try {
                        $response = Http::withoutVerifying()->withHeaders([
                            "Cookie" => $header,
                            "client_id" => Config::get('utils.CLIENT_ID')
                            ])->get(Config::get('utils.SSO_URL') . "/auth/protected"); //simpen di env
                            // $response = Http::withoutVerifying()->withHeaders([
                                //      "Cookie" => $header,
                                //      "client_id" => Config::get('utils.CLIENT_ID')
                                // ])->get('https://ssov2.jamkrida-jabar.co.id/response/' . "/auth/protected"); //simpen di env
                            } catch (\Exception $e) {
                                return response()->json([
                                    "status" => 0,
                                    "message" => $e,
                                    "url" => Config::get("utils.REDIRECT_SSO") . "=" . Config::get('utils.CLIENT_ID'), //simpen di env
                                    
                                ], 501);
                            }
                            
                            $data = json_decode($response->body());
                            $status = $response->status();
                            
                            //sesion udah ga aktif return 403 permission denied
                            if ($status == 403) {
                                return response()->json([
                                    "status" => $data->status,
                                    "success" => $data->success,
                                    "error" => $data->error
                                ], 403);
                            };
                            
                            
                            //token jwt dari ssobe (butuh buat edit profile seperti email,phone,password,dob,image)
                            $token = $data->access_code;
                            //kalo session nya ada dan masi aktif maka lanjut
                            //Get Informasi User
                            $user = $data->user;
                            
                            
                            
                            
                            
                            $module = [];
                            if (is_array($user->permission)) {
                                foreach ($user->permission as $item) {
                                    $item->group_id = $user->group_id;
                                    array_push($module, $item);
                                }
                            }
                            
                            
                            $userdata = (object)[
                                "nip" => $user->username,
                                "fullname" => $user->fullname,
                                "email" => $user->email
                            ];
                            
                            return response()->json([
                                'token' => $token,
                                'module' => $module,
                                'data' => $userdata
                            ], 201);
                            
                            
                            
                            /**
                            * user_id
                            * email
                            * username
                            * fullname
                            * phone_number
                            * password
                            * dob
                            * image
                            * app_id
                            * app_url
                            * group_id
                            * group_name
                            * permission {
                                *      permission_id
                                *      isupdate
                                *      isread
                                *      isdelete
                                *      isprint
                                *      iscreate
                                *      module_id
                                *      module_name
                                * }
                                */
                                
                                
                                
                                /**
                                * Kebawahnya Logic Sendiri Sesuai Kebutuhan
                                */
                                
                                
                                
                                //Contoh Create JWT Pake JwtAuth
                                /**  try {
                                    *     $sign = [
                                        *         'email' => email,
                                        *         'password' => password
                                        *     ];
                                        *    
                                        *     if (! $token = JWTAuth::attempt($sign)) {
                                            *         return response()->json([
                                                *             'status' => 0,
                                                *             'message' => 'Login credentials are invalid.',
                                                *         ], 400);
                                                *     }
                                                * } catch (JWTException $e) {
                                                    * return $e;
                                                    *     return response()->json([
                                                        *             'status' => 0,
                                                        *             'message' => 'Could not create token.'
                                                        *         ], 500);
                                                        *  }
                                                        */
                                                        
                                                        return response()->json([
                                                            "status" => 1,
                                                            "data" => $user
                                                        ]);
                                                    }
                                                    
                                                    public function check()
                                                    {
                                                        return resJSON(1, 'login', null, 200);
                                                    }
                                                }