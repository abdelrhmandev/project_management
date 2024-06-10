<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Mail\PasswordReset;
use App\Models\PasswordReset as PR;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    public function _index()
    {
        return view('auth.passwords.reset');
    }

    public function _resetPassword(Request $req)
    {
        $query = User::where('email', trim($req['email']));
        $exist = $query->exists();
        if ($exist) :
            $userName = $query->first()->name;
            $userID = $query->first()->id;
            $hash = sha1($userName . $userID . uniqid(mt_rand(10, 100)));

            $mailData = [
                'userName' => $userName,
                'route'    => route('password.new', ['ID' => base64_encode($userID), 'email' => base64_encode($req['email']), 'token' => $hash])
            ];
            try {
                $mailSent = Mail::to(trim($req['email']))->send(new PasswordReset($mailData));
                if ($mailSent) :
                    $exist = PR::where('email', $req['email'])->exists();
                    if ($exist) :
                        PR::where('email', $req['email'])
                            ->update(
                                [
                                    "token" => $hash,
                                    "created_at"  => DB::raw('NOW()')
                                ]
                            );
                    else :
                        PR::insert(
                            [
                                'email' => $req['email'],
                                "token" => $hash,
                                "created_at"  => DB::raw('NOW()')
                            ]
                        );
                    endif;
                    return redirect('/login')->with("success", __("passwords.sent"));
                endif;
            } catch (\Exception $e) {
                return response()->json(["MSG" => $e->getMessage(), "code" => 401]);
            }
        else :
            return response()->json(["MSG" => 'هناك خطأ', "code" => 401]);
        endif;
    }

    public function _setNewPassword(Request $req)
    {
        $ID = (int)base64_decode($req['ID']);
        $email = (string)base64_decode($req['email']);
        $user = User::findOrFail($ID);
        $query = PR::selectRaw('HOUR(TIMEDIFF(NOW(),created_at)) AS sendtime')->where('email', $email)->firstOrFail();
        $sentTime = $query->sendtime;
        if ($sentTime >= 1) :
            $msg = "لقد انتهت صلاحية هذا الرابط ";
            return view('auth.passwords.expire', ['expireMsg' => $msg]);
        else :
            return view('auth.passwords.confirm', ['id' => $ID, 'email' => $email]);
        endif;
    }

    public function _changePassword(Request $req)
    {
        $this->validate($req, [
            "password" => 'bail|required|min:8|max:12|confirmed',
        ]);

        DB::beginTransaction();
        try {
            User::where('id', $req['idx'])
                ->where('email', $req['emailx'])
                ->update(['password' => Hash::make($req['password'])]);
            DB::commit();
            return redirect('/login')->with("success", "تم تغيير كلمة المرور بنجاح");
        } catch (\PDOEXception $e) {
            DB::rollBack();
            return response()->json(["MSG" => $e->getMessage()]);
        }
    }
}
