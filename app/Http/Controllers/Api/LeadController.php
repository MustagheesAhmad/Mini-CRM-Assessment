<?php

namespace App\Http\Controllers\Api;

use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\AssignLeadRequest;
use App\Http\Requests\Lead\CreateLeadRequest;
use App\Http\Requests\Lead\UpdateLeadRequest;
use App\Http\Requests\Lead\UpdateStatusRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Leads', description: 'Lead management endpoints')]
class LeadController extends Controller
{
    public function __construct(private readonly LeadService $leadService) {}

    #[OA\Get(
        path: '/api/leads',
        tags: ['Leads'],
        summary: 'List leads (paginated, filterable by status and assigned user)',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'status',      in: 'query', required: false, description: 'Filter by lead status',           schema: new OA\Schema(type: 'string', enum: ['new', 'contacted', 'converted'])),
            new OA\Parameter(name: 'assigned_to', in: 'query', required: false, description: 'Filter by assigned user ID',      schema: new OA\Schema(type: 'integer', example: 2)),
            new OA\Parameter(name: 'per_page',    in: 'query', required: false, description: 'Results per page (default 15)',   schema: new OA\Schema(type: 'integer', default: 15)),
            new OA\Parameter(name: 'page',        in: 'query', required: false, description: 'Page number (default 1)',         schema: new OA\Schema(type: 'integer', default: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paginated lead list'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $leads = $this->leadService->list(
            $request->user(),
            $request->only(['status', 'assigned_to']),
            (int) $request->input('per_page', 15)
        );

        return $this->success([
            'leads'      => LeadResource::collection($leads),
            'pagination' => [
                'total'        => $leads->total(),
                'per_page'     => $leads->perPage(),
                'current_page' => $leads->currentPage(),
                'last_page'    => $leads->lastPage(),
            ],
        ], 'Leads retrieved successfully');
    }

    #[OA\Post(
        path: '/api/leads',
        tags: ['Leads'],
        summary: 'Create a new lead',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'phone'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'john@example.com'),
                    new OA\Property(property: 'phone', type: 'string', example: '+1-555-0100'),
                    new OA\Property(property: 'status', type: 'string', enum: ['new', 'contacted', 'converted'], example: 'new'),
                    new OA\Property(property: 'assigned_to', type: 'integer', example: 2),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Lead created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function store(CreateLeadRequest $request): JsonResponse
    {
        $lead = $this->leadService->create($request->validated(), $request->user());

        return $this->created(new LeadResource($lead->load(['assignee', 'creator'])), 'Lead created successfully');
    }

    #[OA\Get(
        path: '/api/leads/{id}',
        tags: ['Leads'],
        summary: 'Get a single lead with full details including notes',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lead details retrieved'),
            new OA\Response(response: 403, description: 'Forbidden — not your lead'),
            new OA\Response(response: 404, description: 'Lead not found'),
        ]
    )]
    public function show(Request $request, Lead $lead): JsonResponse
    {
        $this->authorize('view', $lead);

        $lead->load(['assignee', 'creator', 'notes.author']);

        return $this->success(new LeadResource($lead), 'Lead retrieved successfully');
    }

    #[OA\Put(
        path: '/api/leads/{id}',
        tags: ['Leads'],
        summary: 'Update a lead',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                    new OA\Property(property: 'phone', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Lead updated successfully'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(UpdateLeadRequest $request, Lead $lead): JsonResponse
    {
        $this->authorize('update', $lead);

        $lead = $this->leadService->update($lead, $request->validated());

        return $this->success(new LeadResource($lead), 'Lead updated successfully');
    }

    #[OA\Delete(
        path: '/api/leads/{id}',
        tags: ['Leads'],
        summary: 'Soft-delete a lead (Admin only) — sets deleted_at, excluded from all future queries',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lead deleted successfully'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Lead not found'),
        ]
    )]
    public function destroy(Request $request, Lead $lead): JsonResponse
    {
        $this->authorize('delete', $lead);

        $this->leadService->delete($lead);

        return $this->noContent('Lead deleted successfully');
    }

    #[OA\Patch(
        path: '/api/leads/{id}/assign',
        tags: ['Leads'],
        summary: 'Assign a lead to a user (Admin only)',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['assigned_to'],
                properties: [
                    new OA\Property(property: 'assigned_to', type: 'integer', example: 2),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Lead assigned successfully'),
            new OA\Response(response: 403, description: 'Forbidden — Admin only'),
        ]
    )]
    public function assign(AssignLeadRequest $request, Lead $lead): JsonResponse
    {
        $this->authorize('assign', $lead);

        $lead = $this->leadService->assign($lead, $request->validated('assigned_to'));

        return $this->success(new LeadResource($lead), 'Lead assigned successfully');
    }

    #[OA\Patch(
        path: '/api/leads/{id}/status',
        tags: ['Leads'],
        summary: 'Update lead status. Triggers a background job when status is set to "converted".',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status'],
                properties: [
                    new OA\Property(property: 'status', type: 'string', enum: ['new', 'contacted', 'converted']),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status updated successfully'),
            new OA\Response(response: 403, description: 'Forbidden'),
        ]
    )]
    public function updateStatus(UpdateStatusRequest $request, Lead $lead): JsonResponse
    {
        $this->authorize('updateStatus', $lead);

        $lead = $this->leadService->updateStatus(
            $lead,
            LeadStatus::from($request->validated('status')),
            $request->user()
        );

        return $this->success(new LeadResource($lead), 'Lead status updated successfully');
    }
}
