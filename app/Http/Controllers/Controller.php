<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title=" Mojo Api",
 *      description="MOJO API Descrição",
 *      @OA\Contact(
 *          email="wesleymotabr@gmail.com"
 *      )
 * )
 */
/**
 *
 *  @OA\Server(
*      url="https://localhost:8000/api/",
 *      description="Server Mojo"
 * )
 */





