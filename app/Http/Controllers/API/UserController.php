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
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
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


    public function register(Request $request)
    {
        // dd($request->all());
        $nik = User::select('nik')->get()->last();

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
                'job_level' => ['required'],
                'division' => ['required'],
                'departement' => ['required'],
                'organization' => ['required'],
                'location' => ['required'],
                'schedule' => ['required'],
            ]);

            User::create([
            'name' => $request->name,
            'nik' => $nik->nik+1,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'job_level_id' => $request->job_level,
            'departement_id' => $request->departement,
            'division_id' => $request->division,
            'organization_id' => $request->organization,
            'approval_line' => $request->approval_line,
            'manager' => $request->manager,
            'location_id' => $request->location,
            'schedule_id' => $request->schedule,
            'phone' => $request->phone,
            'mobile_phone' => $request->mobile_phone,
            'job_potition' => $request->job_potition,
            'join_date' => $request->join_date,
            'resign_date' => $request->resign_date,
            'status_employee' => $request->status_employee,
            'end_date' => $request->end_date,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'citizen_id_address' => $request->citizen_id_address,
            'resindtial_address' => $request->resindtial_address,
            'NPWP' => $request->NPWP,
            'PKTP_status' => $request->PKTP_status,
            'employee_tax_status' => $request->employee_tax_status,
            'tax_config' => $request->tax_config,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'bank_account_holder' => $request->bank_account_holder,
            'bpjs_ketenagakerjaan' => $request->bpjs_ketenagakerjaan,
            'bpjs_kesehatan' => $request->bpjs_kesehatan,
            'citizen_id' => $request->citizen_id,
            'religion' => $request->religion,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'nationality_code' => $request->nationality_code,
            'currency' => $request->currency,
            'length_of_service' => $request->length_of_service,
            'payment_schedule' => $request->payment_schedule,
            'approval_line' => $request->approval_line,
            'manager' => $request->manager,
            'grade' => $request->grade,
            'class' => $request->class,
            ]);

            $user = User::where('email', $request->email)->first();

            // $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                // 'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ],'Authentication Failed', 500);
        }
        //     return ResponseFormatter::success([
        //         'access_token' => $tokenResult,
        //         'token_type' => 'Bearer',
        //         'user' => $user
        //     ],'User Registered');
        // } catch (Exception $error) {
        //     return ResponseFormatter::error([
        //         'message' => 'Something went wrong',
        //         'error' => $error,
        //     ],'Authentication Failed', 500);
        // }
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




}
