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

    public static function matchUserWithCode($userId, $verificationCode)
    {
        $match_check = self::where(['user_id' => $userId, 'verification_code' => $verificationCode])->exists();
        if ($match_check) VerificationModel::where(['user_id' => $userId])->delete();
        return $match_check;
    }

    public static function checkResendAndRetries($userModel)
    {
        $cannot_resend = true;
        if($userModel->sms_can_resend_date <= date('Y-m-d H:i:s') && $userModel->sms_can_resend_date) {
            $userModel->sms_retries = 0;
            $userModel->sms_can_resend_date = null;
            $userModel->save();
            $cannot_resend = false;
        }

        if($userModel->sms_retries >= 4 && $cannot_resend) {
            if(!$userModel->sms_can_resend_date) {
                $userModel->sms_can_resend_date = date('Y-m-d H:i:s', strtotime('+1 day', time()));
                $userModel->save();
            }
            return false;
        }
        return true;
    }
}
