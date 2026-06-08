<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use OpenApi\Attributes as OA;

class MaintenanceController extends Controller
{
    #[OA\Get(
        path: "/api/v1/maintenance",
        summary: "Get all maintenance data",
        security: [["IAEApiKey" => []]],
        tags: ["Maintenance"],
        responses: [
            new OA\Response(response: 200, description: "Data retrieved successfully"),
            new OA\Response(response: 401, description: "Invalid API Key")
        ]
    )]
    public function index()
    {
        $data = Maintenance::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $data
        ]);
    }

    #[OA\Get(
        path: "/api/v1/maintenance/{id}",
        summary: "Get maintenance by ID",
        security: [["IAEApiKey" => []]],
        tags: ["Maintenance"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "Maintenance ID",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Data retrieved successfully"),
            new OA\Response(response: 404, description: "Data not found"),
            new OA\Response(response: 401, description: "Invalid API Key")
        ]
    )]
    public function show($id)
    {
        $data = Maintenance::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found',
                'errors' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => $data
        ]);
    }

    #[OA\Post(
        path: "/api/v1/maintenance",
        summary: "Create maintenance data",
        security: [["IAEApiKey" => []]],
        tags: ["Maintenance"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["vehicle_id", "fuel_limit", "last_service_date"],
                properties: [
                    new OA\Property(property: "vehicle_id", type: "string", example: "K001"),
                    new OA\Property(property: "fuel_limit", type: "number", example: 500000),
                    new OA\Property(property: "last_service_date", type: "string", format: "date", example: "2026-06-08"),
                    new OA\Property(property: "operational_coupon", type: "string", example: "CPN001"),
                    new OA\Property(property: "notes", type: "string", example: "Servis rutin dan pengecekan BBM")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Maintenance data created successfully"),
            new OA\Response(response: 401, description: "Invalid API Key")
        ]
    )]
    public function store(Request $request)
    {
        $maintenance = Maintenance::create([
            'vehicle_id' => $request->vehicle_id,
            'fuel_limit' => $request->fuel_limit,
            'last_service_date' => $request->last_service_date,
            'operational_coupon' => $request->operational_coupon,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance data created successfully',
            'data' => $maintenance
        ], 201);
    }
}