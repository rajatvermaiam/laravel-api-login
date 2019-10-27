<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Response;
use App\Notifications\PasswordResetRequest;
use App\Notifications\VerifyApiEmail;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use VerifiesEmails, Notifiable;

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string'
        ]);

        if ($validator->fails())
            return response()->json(Response::getErrorMessage(collect($validator->messages())->first()[0], array(), 422), 422);

        if (auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $data['user'] = $user = $request->user();
            $data['token'] = auth()->user()->createToken('login')->accessToken;
            return response()->json(Response::getSuccessMessage("Successfully logged In", $data, 200), 200);
        } else {
            return response()->json(Response::getErrorMessage("Invalid Credetials", array(), 401), 401);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails())
            return response()->json(Response::getErrorMessage(collect($validator->messages())->first()[0], array(), 422), 422);


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $this->notify(new VerifyApiEmail($user));

        return response()->json(Response::getSuccessMessage("Check Inbox to activate account", array(), 200), 200);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(Response::getErrorMessage("User already have verified email!", array(), 422), 422);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json(Response::getSuccessMessage("Check Inbox again to activate account", array(), 200), 200);
    }

    public function verify(Request $request)
    {
        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return response()->json(Response::getSuccessMessage("Email verified!", array(), 200), 200);
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        if ($validator->fails())
            return response()->json(Response::getErrorMessage(collect($validator->messages())->first()[0], array(), 422), 422);

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json(Response::getErrorMessage("No User found with this email!", array(), 422), 422);

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str::random(60)
            ]
        );

        if ($user && $passwordReset)
            $user->notify(new PasswordResetRequest($passwordReset->token));
        return response()->json(Response::getSuccessMessage("We have e-mailed your password reset link!", array(), 200), 200);
    }

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json(Response::getErrorMessage("This password reset token is invalid!", array(), 422), 422);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json(Response::getErrorMessage("This password reset token is expired. Send again!", array(), 422), 422);
        }
        return response()->json(Response::getSuccessMessage("Valid reset link!", $passwordReset, 200), 200);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        if ($validator->fails())
            return response()->json(Response::getErrorMessage(collect($validator->messages())->first()[0], array(), 422), 422);

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
        return response()->json(Response::getErrorMessage("This password reset token is invalid.", array(), 422), 422);

        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
        return response()->json(Response::getErrorMessage("We can't find a user with that e-mail address.", array(), 422), 422);

        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        return response()->json(Response::getSuccessMessage("Password changed. Login again with new password!", array(), 200), 200);

    }
}
