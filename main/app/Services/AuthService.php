<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//Models
use App\Models\User;

//Payloads
use App\DTOs\Payloads\UserPayload;

class AuthService
{
    public function createUser(array $data)
    {
        $validateUser = Validator::make($data, 
        [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'city' => 'required|string|max:50'
        ]);

        if($validateUser->fails()){
            return $validateUser->errors();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'city' => $data['city'],
        ]);

        return $user;
    }

    // **
    //  * @param UserPayload $userPayload
    //  * @return array|bool
    //  */
    public function loginUser(UserPayload $userPayload, bool $remember = false)
    {
        $validateUser = Validator::make((array) $userPayload, 
        [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validateUser->fails())
            return $validateUser->errors();

        $credentials = (array) $userPayload;

        if(!Auth::attempt($credentials, $remember)){
            return false;
        }

        $user = User::where('email', $userPayload->email)->first();

        return [
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user' => $user
        ];
    }

    public function logoutUser($user)
    {
        $user->currentAccessToken()->delete();
    }

    public function getUserInfo()
    {
        $user = Auth::user();

        return $user;
    }

    /**
     * Get all surveyors.
     *
     * @return array
     */
    public function getAvailableSurveyors()
    {
        $surveyors = User::get(['name', 'id']);

        $availableSurveyors = [];
        foreach ($surveyors as $surveyor) {
            $availableSurveyors[] = [
                'name' => $surveyor->name,
                'id' => $surveyor->id,
            ];
        }

        return $availableSurveyors;
    }
}