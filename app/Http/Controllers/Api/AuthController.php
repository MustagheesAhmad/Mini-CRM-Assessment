<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Authentication', description: 'Login and logout endpoints')]
class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    #[OA\Post(
        path: '/api/auth/login',
        tags: ['Authentication'],
        summary: 'Authenticate a user and return a Sanctum token',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'admin@minicrm.test'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password'),
                    new OA\Property(property: 'device_name', type: 'string', example: 'web'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login successful',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Login successful'),
                        new OA\Property(property: 'data', type: 'object', properties: [
                            new OA\Property(property: 'user', ref: '#/components/schemas/UserResource'),
                            new OA\Property(property: 'token', type: 'string', example: '1|abc123...'),
                        ]),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Invalid credentials'),
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login(
                $request->email,
                $request->password,
                $request->input('device_name', 'api')
            );

            return $this->success([
                'user'  => new UserResource($result['user']),
                'token' => $result['token'],
            ], 'Login successful');
        } catch (ValidationException $e) {
            return $this->error('The provided credentials are incorrect.', 422, $e->errors());
        }
    }

    #[OA\Post(
        path: '/api/auth/logout',
        tags: ['Authentication'],
        summary: 'Revoke the current user token',
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logged out successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Logged out successfully'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logged out successfully');
    }

    #[OA\Get(
        path: '/api/auth/me',
        tags: ['Authentication'],
        summary: 'Get the authenticated user profile',
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Authenticated user',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Success'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/UserResource'),
                    ]
                )
            ),
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        return $this->success(new UserResource($request->user()));
    }
}
