<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\OtpEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Otp;

class SendOtpEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        $user_otp = $event->user_otp;

        // Generate OTP code
        $otp = rand(100000, 999999);
        $user_otp = Otp::create([
            'otp' => $otp,
            'email' => $user->email,
            'generated_at' => time(),
        ]);
        // $user_otp->otp = $otp;
        // $user_otp->email = $user->email;

        // Save OTP to the user or a separate table
        $user->email_verified_received_at = Carbon::now()->toDateTimeString();
        $user->save();

        // Send OTP email
        Mail::to($user->email)->send(new OtpEmail($otp));
    }
}
