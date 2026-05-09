<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EventResource;
use App\Services\EventService;

class TicketCategoryController extends Controller
{   
    public function __construct(EventService $EventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request): JsonResponse
    {
        $userId = $accessToken->user_uuid;
        $events = $this->eventService->getIndex($userId);

        return response()->json([
            'events' => new EventResource($events)
        ], 200);
    }

    public function show(Request $request, $uuid): JsonResponse
    {
        $event = $this->eventService->getEvent($uuid);

        return response()->json([
            'event' => new EventResource($event)
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $reqInfo = $request->validate([
            'name' => ['required','string'],
            'description' => ['required','string'],
            'hour' => ['required','string'],
            'location' => ['required','string'],
        ]);

        $user = $request->user();
        $uuid = $user->uuid;      

        $this->eventService->storeEvent($reqInfo, $userUuid);

        return response()->json([
            'message' => 'successfully created a new event'
        ], 201);
    }

    public function editEvent(Request $request, $uuid): JsonResponse
    {

        $reqInfo = $request->validate([
            'name' => ['required','string'],
            'description' => ['required','string'],
            'hour' => ['required','string'],
            'location' => ['required','string'],
        ]);

        $event = $this->eventService->getEvent($uuid);
        $this->eventService->editEvent($event);

        return response()->json([
            'message' => 'Successfully edited category'
        ], 200);
    }

    public function delete(Request $request, $uuid): JsonResponse
    {
        $this->eventService->deleteEvent($uuid);

        return response()->json([
            'message' => 'Successfully deleted event'
        ], 200);
    }
}