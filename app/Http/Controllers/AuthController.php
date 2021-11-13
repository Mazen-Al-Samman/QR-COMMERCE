<?php
namespace App\Http\Controllers;


use App\Models\User;
use App\Models\VerificationModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'checkUser', 'activateUser', 'forgetPassword', 'resetPassword', 'checkUserCode']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($userModel = null)
    {
        if (!empty($userModel)) {
            $token = auth('api')->login($userModel);
            $cookie = cookie('jwt-token', $token, 68 * 24); // 1 day
            return $this->respondWithToken($token)->withCookie($cookie);
        }

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
        $verificationCode = VerificationModel::generateRandomVerificationCode();
        VerificationModel::sendVerificationCode($verificationCode, $formattedPhone);

        if ($user = User::registerUser($request)) {
            VerificationModel::verificationSent($user->id, $verificationCode);
            $credentials = request(['phone', 'password']);
            $token = auth('api')->attempt($credentials);
            $cookie = cookie('jwt-token', $token, 68 * 24); // 1 day
            return $this->respondWithToken($token)->withCookie($cookie);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function activateUser(Request $request) {
        $validation = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'verification_code' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }
        $matchVerification = VerificationModel::matchUserWithCode($request->user_id, $request->verification_code);
        if (!$matchVerification) {
            return response()->json([
                'status' => false,
            ]);
        }
        $userModel = User::find($request->user_id);
        if (!$userModel) return;
        $userModel->actived = VerificationModel::ACTIVE;
        if ($userModel->save()) return $this->login($userModel);

        return response()->json([
            'status' => false,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPassword(Request $request) {
        $validation = Validator::make($request->all(), [
            'phone' => ['required', 'min:10', 'max:15', 'regex:/^(079|078|077)[0-9]{7}$/'],
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }

        if (!$this->checkUser($request)) return response()->json(['status' => false]);

        $formattedPhone = '+962' . substr($request->phone, 1);
        $code = VerificationModel::generateRandomVerificationCode();
        VerificationModel::sendForgetPasswordCode($code, $formattedPhone);
        $userModel = User::where(['phone' => $request->phone])->first();
        if (!$userModel) return response()->json(['status' => false, 'message' => 'User not found']);

        VerificationModel::verificationSent($userModel->id, $code);
        return response()->json([
            'status' => true,
            'message' => "Code sent successfully."
        ]);
    }

    public function checkUserCode(Request $request) {
        $validation = Validator::make($request->all(), [
            'phone' => ['required', 'min:10', 'max:15', 'regex:/^(079|078|077)[0-9]{7}$/'],
            'reset_code' => ['required', 'string']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }
        $userModel = User::where(['phone' => $request->phone])->first();
        if (!$userModel) return response()->json(['status' => false, 'message' => $validation->errors()]);

        return response()->json([
            'status' => (bool) VerificationModel::matchUserWithCode($userModel->id, $request->reset_code),
        ]);
    }

    public function resetPassword(Request $request) {
        $validation = Validator::make($request->all(), [
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
            'reset_code' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }

        $userModel = User::where(['phone' => $request->phone])->first();
        if (!$userModel) return;

        $matchVerification = VerificationModel::matchUserWithCode($userModel->id, $request->reset_code);
        if (!$matchVerification) {
            return response()->json([
                'status' => false,
            ]);
        }
        $reset = $userModel->resetPassword($request->phone, $request->password);
        return response()->json([
            'status' => $reset,
        ]);
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
}
