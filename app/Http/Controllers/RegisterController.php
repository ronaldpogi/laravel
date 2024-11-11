<?php
   
namespace App\Http\Controllers;
   
use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
   
class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if ($validator->fails()) {
            return ApiResponseClass::sendResponse($validator->errors(),'Validation Error.', 404);
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        
        // CREATE
        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return ApiResponseClass::sendResponse($success,'User register successfully.', 200);
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return ApiResponseClass::sendResponse($success,'User login successfully.', 200);
        } else { 
            return ApiResponseClass::sendResponse('Unauthorized', 'Unauthorised', 404);
        } 
    }
}
