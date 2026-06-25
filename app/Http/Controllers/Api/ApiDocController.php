<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Mini CRM API',
    version: '1.0.0',
    description: 'RESTful API for Mini CRM — lead management, notes, and user authentication.',
    contact: new OA\Contact(email: 'admin@minicrm.test')
)]
#[OA\Server(url: L5_SWAGGER_CONST_HOST, description: 'API Server')]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Enter your Sanctum token in the format: Bearer {token}'
)]
#[OA\Schema(
    schema: 'UserResource',
    properties: [
        new OA\Property(property: 'id',    type: 'integer', example: 1),
        new OA\Property(property: 'name',  type: 'string',  example: 'Admin User'),
        new OA\Property(property: 'email', type: 'string',  format: 'email', example: 'admin@minicrm.test'),
        new OA\Property(property: 'role',  type: 'string',  enum: ['admin', 'user'], example: 'admin'),
    ]
)]
#[OA\Schema(
    schema: 'LeadResource',
    properties: [
        new OA\Property(property: 'id',           type: 'integer', example: 1),
        new OA\Property(property: 'name',         type: 'string',  example: 'John Doe'),
        new OA\Property(property: 'email',        type: 'string',  format: 'email', example: 'john@example.com'),
        new OA\Property(property: 'phone',        type: 'string',  example: '+1-555-0100'),
        new OA\Property(property: 'status',       type: 'string',  enum: ['new', 'contacted', 'converted'], example: 'new'),
        new OA\Property(property: 'status_label', type: 'string',  example: 'New'),
        new OA\Property(
            property: 'assigned_to',
            description: 'User the lead is assigned to, or null if unassigned',
            oneOf: [new OA\Schema(ref: '#/components/schemas/UserResource'), new OA\Schema(type: 'null')],
            nullable: true
        ),
        new OA\Property(property: 'created_by',   ref: '#/components/schemas/UserResource', description: 'User who created the lead'),
        new OA\Property(property: 'notes_count',  type: 'integer', example: 3, description: 'Number of notes attached (included on list endpoints)'),
        new OA\Property(
            property: 'notes',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/LeadNoteResource'),
            description: 'Full notes list (only included on show endpoint)'
        ),
        new OA\Property(property: 'created_at',  type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at',  type: 'string', format: 'date-time'),
        new OA\Property(property: 'deleted_at',  type: 'string', format: 'date-time', nullable: true, description: 'Set when the lead is soft-deleted; null for active leads'),
    ]
)]
#[OA\Schema(
    schema: 'LeadNoteResource',
    properties: [
        new OA\Property(property: 'id',         type: 'integer', example: 1),
        new OA\Property(property: 'note',       type: 'string',  example: 'Called the client, left a voicemail.'),
        new OA\Property(property: 'author',     ref: '#/components/schemas/UserResource', description: 'User who wrote the note'),
        new OA\Property(property: 'created_at', type: 'string',  format: 'date-time'),
    ]
)]
#[OA\Schema(
    schema: 'PaginationMeta',
    properties: [
        new OA\Property(property: 'total',        type: 'integer', example: 100),
        new OA\Property(property: 'per_page',     type: 'integer', example: 15),
        new OA\Property(property: 'current_page', type: 'integer', example: 1),
        new OA\Property(property: 'last_page',    type: 'integer', example: 7),
    ]
)]
class ApiDocController {}
