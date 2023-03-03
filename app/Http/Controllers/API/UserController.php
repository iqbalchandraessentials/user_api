<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\seqno;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(),'Data profile user berhasil diambil');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ],'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();
            if ( ! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */

        function getRomawiInMonth($bln)
        {
            switch ($bln) {
                case 1:
                    return "I";
                    break;
                case 2:
                    return "II";
                    break;
                case 3:
                    return "III";
                    break;
                case 4:
                    return "IV";
                    break;
                case 5:
                    return "V";
                    break;
                case 6:
                    return "VI";
                    break;
                case 7:
                    return "VII";
                    break;
                case 8:
                    return "VIII";
                    break;
                case 9:
                    return "IX";
                    break;
                case 10:
                    return "X";
                    break;
                case 11:
                    return "XI";
                    break;
                case 12:
                    return "XII";
                    break;
            }
        }


        function createNumber($lno, $add, $type, $digits, $year)
        {
            $find = seqno::where('lno', '=', $lno)->where('type', '=', $type)->where('year', $year)->first();

            if ($find == null) {
                $data = array(
                    'lno'   => $lno, 'cno' => 1, 'type' => $type, 'year' => $year,
                );
                Seqno::create($data);
            } else {
                $new = $find["cno"] + 1;
                $update = Seqno::findOrfail($find["id"]);
                $update->cno = $new;
                $update->save();
            }

            $get = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->where('year', $year)->first();
            $no = $get["cno"];
            if ($no >= 1 && $no <= 9) {
                $no = (($digits == 3) ?  '00' . $no . $lno . $add : (($digits == 4) ?  '000' . $no . $lno . $add : (('0000' . $no . $lno . $add))));
            } elseif ($no >= 10 && $no <= 99) {
                $no = (($digits == 3) ?  '0' . $no . $lno . $add : (($digits == 4) ?  '00' . $no . $lno . $add  : (('000' . $no . $lno . $add))));
            } elseif ($no >= 100 && $no <= 999) {
                $no = (($digits == 3) ? '' . $no . $lno . $add : (($digits == 4) ? '0' . $no . $lno . $add : (('00' . $no . $lno . $add))));
            }

            return $no;
        }

    public function register(Request $request)
    {
        $NIK = User::select('NIK')->get()->last();
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
                'jabatan' => ['required'],
                'departement' => ['required'],
                'PT' => ['required'],
                'owners' => ['required'],
                'location' => ['required'],

            ]);

            User::create([
                'name' => $request->name,
                'NIK' => $NIK->NIK+1,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'jabatan' => $request->jabatan,
                'departement' => $request->departement,
                'PT' => $request->PT,
                'owners' => $request->owners,
                'location' => $request->location,
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token,'Token Revoked');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user,'Profile Updated');
    }
}
