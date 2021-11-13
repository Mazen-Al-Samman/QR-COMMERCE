<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'password',
        'actived'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function registerUser($request){
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->actived = VerificationModel::DISABLED;
        if($user->save()){
            return $user;
        }
        return false;
    }

    public function updateProfile($request)
    {
        $user = User::find(auth('api')->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        return $user->save();
    }

    public function activateUser($userId) {
        $userModel = self::find($userId) ?? null;
        if (!$userModel) return;
        $userModel->actived = VerificationModel::ACTIVE;
        return $userModel->save();
    }

    public static function getAllUsers(){
        return User::all();
    }

    public static function getUsersCount(){
        return User::all()->count();
    }

    public static function getVerifiedUsersCount(){
        return User::where(['actived' => 1])->count();
    }

    public static function getNotVerifiedUsersCount(){
        return User::where(['actived' => 0])->count();
    }

    public function checkUserFromPhone($phone) {
        return self::where(['phone' => $phone])->exists();
    }

    public function resetPassword($phone, $newPassword) {
        $userModel = self::where(['phone' => $phone])->first();
        if (empty($userModel)) return false;

        $userModel->password = Hash::make($newPassword);
        return $userModel->save();
    }
}
