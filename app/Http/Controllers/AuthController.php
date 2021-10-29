<?php
namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'checkUser']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['phone', 'password']);

        $validation = Validator::make($credentials, [
            'phone' => ['required', 'min:10', 'max:15', 'regex:/^(079|078|077)[0-9]{7}$/'],
            'password' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'error' => 'Unauthorized'
                ], 401);
        }
        $cookie = cookie('jwt-token', $token, 68 * 24); // 1 day
        return $this->respondWithToken($token)->withCookie($cookie);
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'unique:users', 'min:10', 'max:15', 'regex:/^(079|078|077)[0-9]{7}$/'],
            'password' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }
        $formattedPhone = '+962' . substr($request->phone, 1);
        $verificationCode = $s = substr(str_shuffle(str_repeat("0123456789", 5)), 0, 5);
        $message = "رمز التحقق الخاص بك هو {$verificationCode}";
        $this->sendVerificationCode($message, $formattedPhone);
        if ($user = User::registerUser($request)) {
            $credentials = request(['phone', 'password']);
            $token = auth('api')->attempt($credentials);
            $cookie = cookie('jwt-token', $token, 68 * 24); // 1 day
            return $this->respondWithToken($token)->withCookie($cookie);
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth('api')->user());
    }

    public function updateProfile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', Rule::unique('users')->ignore(auth('api')->user()->id, 'id'), 'min:10', 'max:15', 'regex:/^(079|078|077)[0-9]{7}$/'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }

        $user = new User();
        if ($user->updateProfile($request)) {
            return response()->json([
                'status' => true,
                'message' => "Update profile was successful updated!"
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "something wrong"
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'data' => auth('api')->user()
        ]);
    }

    public function checkUser(Request $request) {
        $validation = Validator::make($request->all(), [
            'phone' => ['required', 'exists:users,phone'],
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => "Done"
        ]);
    }

    private function sendMessage($message, $recipients) {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients,
            ['from' => $twilio_number, 'body' => $message]);
    }

    public function sendVerificationCode($message, $phone) {
        $this->sendMessage($message, $phone);
    }
}
