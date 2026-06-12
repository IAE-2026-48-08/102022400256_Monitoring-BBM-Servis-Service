<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Http;
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

        $m2mToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6ImlhZS1jZW50cmFsLTIwMjYifQ.eyJpc3MiOiJpYWUtY2VudHJhbC1tb2NrIiwic3ViIjoiS0VZLU1IUy0zNDIiLCJpYXQiOjE3ODEyNzc0MTUsImV4cCI6MTc4MTI4MTAxNSwiZ3JhbnRfdHlwZSI6ImNsaWVudF9jcmVkZW50aWFscyIsInRva2VuX3R5cGUiOiJtMm0iLCJhcHAiOnsiY2xpZW50X2lkIjoiS0VZLU1IUy0zNDIiLCJuYW1lIjoiTGFyYXZlbCBTZXJ2aWNlIFx1MjAxNCBHcm91cCA3ICgxMDIwMjI0MDAyNTYpIiwidGVhbSI6IlRFQU0tMDcifX0.HroG4w9VEoU3H7-OAY103QDePgMcOSJxAOop60daHVvCyWoGGXhcSSxAQ863jlRVMm5Y-WMMwUhalxs27GSLV8qwH2969Zd7o_LBJaRzGsINpO94yyizGQIpzQs27zh_E8ZbbeLdn9QL-GXMQC0zmPIZ-z5epzgc3vMsQvdNKrL7GscMzgB0HU0DhMI6sUZBtPLsx_x_ZRR1nlEt1lBi0EAHIz8GvmhuWe_X0puzMxcwuJKJ_tebGHL21Y9c3Fj4d2sg1tzdfb6mrlDrri_bWfSubzUgsVCnF-Em3sf78yhiIZudjv7qMn-Lpzq7ZFk0S_FZAkvdfcrtEhWNo4fG_w';

        $xmlBody = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:iae="http://iae.central/audit">
            <soap:Body>
                <iae:AuditRequest>
                    <iae:TeamID>TEAM-07</iae:TeamID>
                    <iae:ActivityName>MaintenanceCreated</iae:ActivityName>
                    <iae:LogContent><![CDATA[
        {
            "vehicle_id":"{$maintenance->vehicle_id}",
            "fuel_limit":"{$maintenance->fuel_limit}",
            "last_service_date":"{$maintenance->last_service_date}"
        }
                    ]]></iae:LogContent>
                </iae:AuditRequest>
            </soap:Body>
        </soap:Envelope>
        XML;

        $soapResponse = Http::withToken($m2mToken)
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ])
            ->send('POST',
                'https://iae-sso.virtualfri.id/soap/v1/audit',
                [
                    'body' => $xmlBody
                ]
            );
        
        $rabbitResponse = Http::withToken($m2mToken)
        ->withHeaders([
            'Content-Type' => 'application/json'
        ])
        ->post('https://iae-sso.virtualfri.id/api/v1/messages/publish', [
            'exchange' => 'iae.central.exchange',
            'routing_key' => 'maintenance.created',
            'payload' => [
                'event_name' => 'maintenance.created',
                'service_name' => 'Monitoring BBM Servis',
                'team' => 'TEAM-07',
                'vehicle_id' => $maintenance->vehicle_id,
                'fuel_limit' => $maintenance->fuel_limit,
                'last_service_date' => $maintenance->last_service_date,
                'operational_coupon' => $maintenance->operational_coupon,
            ]
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance data created successfully',
            'data' => $maintenance,
            'integration' => [
            'soap_status' => $soapResponse->status(),
            'rabbitmq_status' => $rabbitResponse->status()
            ]
        ], 201);
    }
}