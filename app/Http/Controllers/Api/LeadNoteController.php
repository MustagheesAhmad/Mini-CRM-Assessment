<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\CreateNoteRequest;
use App\Http\Resources\LeadNoteResource;
use App\Models\Lead;
use App\Services\LeadNoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Lead Notes', description: 'Notes attached to leads')]
class LeadNoteController extends Controller
{
    public function __construct(private readonly LeadNoteService $noteService) {}

    #[OA\Get(
        path: '/api/leads/{lead}/notes',
        tags: ['Lead Notes'],
        summary: 'List all notes for a lead in chronological order',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'lead', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Notes retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Notes retrieved successfully'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/LeadNoteResource')),
                    ]
                )
            ),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Lead not found'),
        ]
    )]
    public function index(Request $request, Lead $lead): JsonResponse
    {
        $this->authorize('view', $lead);

        $notes = $this->noteService->listForLead($lead);

        return $this->success(
            LeadNoteResource::collection($notes),
            'Notes retrieved successfully'
        );
    }

    #[OA\Post(
        path: '/api/leads/{lead}/notes',
        tags: ['Lead Notes'],
        summary: 'Add a note to a lead',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'lead', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['note'],
                properties: [
                    new OA\Property(property: 'note', type: 'string', example: 'Followed up via phone. Client is interested.'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Note added successfully'),
            new OA\Response(response: 403, description: 'Forbidden — lead not assigned to you'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(CreateNoteRequest $request, Lead $lead): JsonResponse
    {
        $this->authorize('addNote', $lead);

        $note = $this->noteService->addNote($lead, $request->user(), $request->validated('note'));

        $note->load('author');

        return $this->created(new LeadNoteResource($note), 'Note added successfully');
    }
}
