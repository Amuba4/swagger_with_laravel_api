<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
        /** * @OA\Info( * title="User Lumen API With Swagger", * version="1.0", 
     * @OA\Contact( 
     * * email="xyz@gamil.com"
     *  * ) 
     * * ), 
     * * @OA\Get( * path="/", 
     * * @OA\Response( * response="200", * description="Fetching users data from database", * ) 
     * * )
     * @OA\Server(
     *      url=SWAGGER_LUME_CONST_HOST,
     *      description="Demo API Server"
     * ) * */ 

    public function index() {

    }


    //
}
