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

    public static function phoneWithCountryCode($phone)
    {
        if (substr($phone, 0, 3) == "079" || substr($phone, 0, 3) == "078" || substr($phone, 0, 3) == "077") {
            return '+962' . substr($phone, 1);
        }

        if (substr($phone, 0, 2) == "05" || substr($phone, 0, 2) == "01" || substr($phone, 0, 2) == "08") {
            return '+966' . substr($phone, 1);
        }
        return null;
    }

    private static function sendSmsMessage($message, $recipients) {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $msid = getenv("MESSAGING_SERVICE_ID");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients,
            [
                'from' => "MyBill",
                'body' => $message,
                'messagingServiceSid' => $msid
            ]);
    }

    public static function sendForgetPasswordCode($code, $phone) {
        $message = "MyBill - رمز تغيير كلمة السر الخاص بك هو {$code}";
        if (substr($phone, 0, 4) == "+962") {
            self::sendNGTSmsMessage($phone, $message);
        } else {
            self::sendSmsMessage($message, $phone);
        }
    }

    public static function sendVerificationCode($verification_code, $phone) {
        $message = "MyBill - رمز التحقق الخاص بك هو {$verification_code}";
        if (substr($phone, 0, 4) == "+962") {
            self::sendNGTSmsMessage($phone, $message);
        } else {
            self::sendSmsMessage($message, $phone);
        }
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

    public static function sendNGTSmsMessage($phone, $message)
    {
        $url = getenv("NGT_SMS_URL");
        $name = getenv("NGT_SMS_NAME");
        $password = getenv("NGT_SMS_PASSWORD");

        $data = [
            'login_name' => $name,
            'login_password' => $password,
            'msg' => $message,
            'mobile_number' => $phone,
            'charset' => 'UTF-8',
            'from' => "MyBill"
        ];

        $data = http_build_query($data);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . '?' . $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=fadc87dd7e819709fc1a0c1cc0687965'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response != "I01-Job 2 queued for processing." || $response != "I02-Job (Job ID) has been scheduled.") {
            return false;
        }

        return true;
    }
}
