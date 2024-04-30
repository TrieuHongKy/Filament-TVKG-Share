<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\CandidateService;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller{

    protected $candidateService;
    protected $companyService;

    //
    public function __construct(CandidateService $candidateService, CompanyService $companyService){
        $this->middleware(
            'auth:api',
            ['except' => ['login', 'register', 'provider-callback']]
        ); //login, register methods won't go through the api guard
        $this->candidateService = $candidateService;
        $this->companyService   = $companyService;
    }

    /**
     * login
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function login(UserRequest $request)
    : JsonResponse{
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function handleProviderCallback(Request $request){
        $id_token = $request->input('id_token');
        $client   = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]); // Specify the CLIENT_ID of the app that accesses the backend
        $payload  = $client->verifyIdToken($id_token);
        if ($payload){
            $userid = $payload['sub'];
            // If request specified a G Suite domain:
            //$domain = $payload['hd'];
            $user = User::where('google_id', $userid)->first();
            if ($user){
                $token = JWTAuth::fromUser($user);
                auth('api')->setUser($user);

                return $this->respondWithToken($token);
            }else{
                $newUser = User::create([
                    'name'      => $payload['name'],
                    'email'     => $payload['email'],
                    'google_id' => $userid,
                    'password'  => encrypt(Str::random(24))
                ]);

                $candidate = [
                    'user_id' => $newUser->id,
                ];

                $this->candidateService->createCandidate($candidate);

                $token = JWTAuth::fromUser($newUser);
                // return response()->json(['token' => $token]);
                auth('api')->setUser($newUser);

                return $this->respondWithToken($token);
            }
        }else{
            // Invalid ID token
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    /**
     * register
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function register(UserRequest $request)
    : JsonResponse{
        $data             = $request->validated();
        $data['password'] = Hash::make($data['password']);
        try{
            $user = User::create($data);

            // check if user is company or candidate by user_type
            if ($data['user_type'] == 'company'){
                $company = [
                    'user_id' => $user->id,
                ];
                $this->companyService->createCompany($company);
            }else{
                $candidate = [
                    'user_id' => $user->id,
                ];
                $this->candidateService->createCandidate($candidate);
            }

            $token = JWTAuth::fromUser($user);

            return response()->json(['user' => $user, 'token' => $token], 201);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to register user'], 500);
        }
    }

    public function profile()
    : JsonResponse{
        return response()->json(auth('api')->user());
    }


    public function logout()
    : JsonResponse{
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    : JsonResponse{
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    : JsonResponse{
        return response()->json([
            'access_token' => $token,
            'user'         => auth('api')->user(),
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')
                                  ->factory()
                                  ->getTTL() * 60 //mention the guard name inside the auth fn
        ]);
    }
}
