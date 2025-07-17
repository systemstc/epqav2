<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        // return $user;

        if (!$user) {
            // return back()->withErrors(['email' => 'No user found with this email address.']);
            return back()->with('error', 'No user found with this email address.');
        }

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $link = route('password.reset', ['token' => $token, 'email' => $request->email]);
        // return $link;

        // Send email
        Mail::send('auth.emails.password', ['link' => $link], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetForm($token)
    {
    	// return $token;
        return view('auth.passwords.reset')->with('token',$token);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $passwordReset = DB::table('password_resets')->where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Invalid token!']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where([
            ['email', $request->email]
        ])->delete();

        return redirect('/customer/login')->with('status', 'Password has been reset!');
    }
}
