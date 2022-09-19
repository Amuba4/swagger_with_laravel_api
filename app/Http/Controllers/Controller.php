<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
   /** * @OA\Info( * title="User Lumen API With Swagger", * version="1.0", 
     * @OA\Contact( 
     * * email="xyz@gamil.com"
     *  * ) 
     * * ), 
     * * @OA\Get( * path="/", 
     * * @OA\Response( * response="200", * description="Fetching users data from database", * ) 
     * * ),
    * @OA\Parameter(
    *    name="apiId",
    *    in="header",
    *    description="apiId",
    *    required=true,
    *    schema={
    *    "type"="string",
        *    "default"="1001"
    *    },
    *    style="simple",
    * ),
    * @OA\Parameter(
    *    name="apiKey",
    *    in="header",
    *    description="apiKey",
    *    required=true,
    *    schema={
    *    "type"="string",
        *    "default"="ChCETzHM0tvy7sij9fNsAto3fo6by7j9Cr931cdgr52AfYm1yF"
    *    },
    *    style="simple",
    * ),
    * @OA\Parameter(
    *    name="hashKey",
    *    in="header",
    *    description="hashKey",
    *    required=true,
    *    schema={
    *    "type"="string",
    *    "default"="cc594f39c3d5c9d523e1658ce7ac6816"
    *    },
    *    style="simple",
    * ),
 */ 

class Controller extends BaseController
{
    //
}
