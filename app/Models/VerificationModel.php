<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class VerificationModel extends Model
{
    use HasFactory;
    const ACTIVE = 1;
    const DISABLED = 0;
    protected $table = 'member_verification';
    protected $fillable = [
        'user_id',
        'verification_code'
    ];

    public static function generateRandomVerificationCode($allowedChars = "0123456789") {
        return substr(str_shuffle(str_repeat($allowedChars, 5)), 0, 5);
    }

    private static function sendSmsMessage($message, $recipients) {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $msid = getenv("MESSAGING_SERVICE_ID");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients,
            [
                'from' => $twilio_number,
                'body' => $message,
                'messagingServiceSid' => $msid
            ]);
    }

    public static function sendForgetPasswordCode($code, $phone) {
        $message = "MyBill - رمز تغيير كلمة السر الخاص بك هو {$code}";
        self::sendSmsMessage($message, $phone);
    }

    public static function sendVerificationCode($verification_code, $phone) {
        $message = "MyBill - رمز التحقق الخاص بك هو {$verification_code}";
        self::sendSmsMessage($message, $phone);
    }

    public static function verificationSent($userId, $verificationCode) {
        $verification = self::updateOrCreate(
            ['user_id' => $userId],
            ['verification_code' => $verificationCode]
        );
        return $verification->save();
    }

    public static function matchUserWithCode($userId, $verificationCode) {
        return self::where(['user_id' => $userId, 'verification_code' => $verificationCode])->exists();
    }
}
