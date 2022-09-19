<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
       /** 
     * * @OA\Get( * path="/allusers", 
     * *operationId="List Of Users",
     * *tags={"List Of Users"},
     * *summary="List Of Users",
     * *description="List Of Users here",
     * * @OA\Response( * response="200", * description="Fetching users data from database", * ),
     * * @OA\Response( * response="401", * description="Unauthenticated", * ),
     * * @OA\Response( * response="400", * description="Bad Request", * ), 
     * * @OA\Response( * response="404", * description="not found", * ), 
     * * @OA\Response( * response="403", * description="Forbidden", * )
     * * ) * */ 

    public function index()
    {        
        return User::all();
    }

/**
        * @OA\Post(
        * path="/createusers",
        * operationId="Register",
        * tags={"Register"},
        * summary="User Register",
        * description="User Register here",
        *     @OA\Parameter(
        *          ref="#/components/parameters/apiId",
        *     ),
        *     @OA\Parameter(
        *          ref="#/components/parameters/apiKey",
        *     ),
        *     @OA\Parameter(
        *          ref="#/components/parameters/hashKey",
        *     ),
        * security={
        *           {"passport": {}}
        *       },
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","email", "password", "phonenumber","firstname","lastname"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="phonenumber", type="phonenumber"),
        *               @OA\Property(property="firstname", type="firstname"),
        *               @OA\Property(property="lastname", type="lastname")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
    public function store(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $phonenumber = $request->phonenumber;
        $firstname = $request->firstname;
        $lastname = $request->lastname;

        // Check if field is not empty
        if (empty($name) or empty($email) or empty($password) or empty($phonenumber) or empty($firstname) or empty($lastname)) {
            return response()->json(['status' => 'error', 'message' => 'You must fill all the fields']);
        }

        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 'error', 'message' => 'You must enter a valid email']);
        }

        // Check if password is greater than 5 character
        if (strlen($password) < 6) {
            return response()->json(['status' => 'error', 'message' => 'Password should be min 6 character']);
        }

        // Check if user already exist
        if (User::where('email', '=', $email)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'User already exists with this email']);
        }

        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'phonenumber' =>'required|numeric|min:10',
            'firstname' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'lastname' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
             ]);

        // Create new user
        try {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = app('hash')->make($password);
            $user->phonenumber = $phonenumber;
            $user->firstname = $firstname;
            $user->lastname = $lastname;

            if ($user->save()) {
                // Will call login method
                return $this->login($request);
                // return response()->json(['status' => 'success', 'message' => 'User created successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

     /**
        * @OA\Post(
        * path="/login",
        * operationId="login",
        * tags={"Login"},
        * summary="User Login",
        * description="User Login here",
        *     @OA\Parameter(
        *          ref="#/components/parameters/apiId",
        *     ),
        *     @OA\Parameter(
        *          ref="#/components/parameters/apiKey",
        *     ),
        *     @OA\Parameter(
        *          ref="#/components/parameters/hashKey",
        *     ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"email", "password"},
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="password", type="password"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="User Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="User Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
     public function login(Request $request)
     {
 
          // Validate passed parameter
         $this->validate($request, [
             'email' => 'required',
             'password' => 'required'
         ]);
 
 
         // Get the user with the email
         $user = User::where('email', $request['email'])->first();
 
         // check is user exist
         if (!isset($user)) {
             return response()->json(
                 [
                     'status' => false,
                     'message' => 'User does not exist with this details'
                 ]
             );
         }
 
         // confirm that the password matches
         if (!Hash::check($request['password'], $user['password'])) {
             return response()->json(
                 [
                     'status' => false,
                     'message' => 'Incorrect user credentials'
                 ]
             );
         }
 
         return response()->json(
             [
                 'status' => true,
                 'message' => 'User login successfully',
             ]
         );
     }

          /**
        * @OA\Post(
        * path="/logout",
        * operationId="logout",
        * tags={"Logout"},
        * summary="User Logout",
        * description="User Logout here",
        *     @OA\Parameter(
        *          ref="#/components/parameters/apiId",
        *     ),
        *     @OA\Parameter(
        *          ref="#/components/parameters/apiKey",
        *     ),
        *     @OA\Parameter(
        *          ref="#/components/parameters/hashKey",
        *     ),
        * security={
        *           {"passport": {}}
        *       },
        *      @OA\Response(
        *          response=201,
        *          description="User Logout Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="User Logout Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
     public function logout(Request $request)
     {
        return redirect('/login'); 
     }

}
