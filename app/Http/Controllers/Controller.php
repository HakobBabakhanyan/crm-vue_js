<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Crm",
 *      description="crm vue jwt",
 *      @OA\Contact(
 *          email="info@digex"
 *      ),
 *     @OA\License(
 *         name="crm",
 *         url="http://crm.loc/"
 *     )
 * )
 */
/**
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="crm  host server"
 *  )
 */
/**
 * @OA\Tag(
 *     name="login",
 *     description="login user" ,
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 *
 * @OA\Tag(
 *     name="user",
 *     description="Operations about user",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about",
 *         url="http://swagger.io"
 *     )
 * )
 *   @OA\Tag(
 *     name="companies",
 *     description="companies",

 * )
 * @OA\ExternalDocumentation(
 *     description="Find out more about Swagger",
 *     url="http://swagger.io"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
