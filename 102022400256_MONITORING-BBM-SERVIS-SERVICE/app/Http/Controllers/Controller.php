<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Monitoring BBM Servis Service API",
    version: "1.0.0",
    description: "Dokumentasi API untuk Service Monitoring BBM/Servis"
)]
#[OA\Server(
    url: "http://localhost:8003",
    description: "Local Server"
)]
#[OA\SecurityScheme(
    securityScheme: "IAEApiKey",
    type: "apiKey",
    in: "header",
    name: "X-IAE-KEY"
)]
abstract class Controller
{
    //
}