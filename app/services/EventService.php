<?php
namespace App\Services;
use App\Models\Event;
use Illuminate\Support\Str;

class EventService
{
    public function __construct()
    {

    }
    
    public function getIndex(String $userUuid)
    {
        $events = Event::select('uuid','name','description','hour','location')
        ->where('user_uuid', $userUuid)->simplePaginate(4);

        return $events;
    }

    public function getEvent(String $uuid)
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();

        return $event;
    }

    public function storeEvent(Array $reqInfo, String $userUuid): void
    {
        $event = Event::create([
            'uuid' => Str::uuid(),
            'name' => $reqInfo['name'],
            'description' => $reqInfo['description'],
            'event_type' => $reqInfo['event_type'],
            'location' => $reqInfo['location'],
            'hour' => $reqInfo['hour'],
            'user_uuid' => $userUuid,
        ]);

        return;
    }

    public function editEvent(Event $event, Array $reqInfo): void
    {
        $event->update([
            'name' => $reqInfo['name'],
            'description' => $reqInfo['description'],
            'event_type' => $reqInfo['event_type'],
            'location' => $reqInfo['location'],
            'hour' => $reqInfo['hour'],
        ]);
        
        return;
    }
    
    public function deleteEvent(String $uuid): void
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();
        $event->delete();

        return;
    }
}