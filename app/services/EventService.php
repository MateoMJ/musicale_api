<?php

class EventService
{
    public function __construct()
    {

    }
    
    public function getIndex(String $userId)
    {
        $events = Event::select('uuid','name','description','hour','location')
        ->where('user_uuid', $userId)->simplePaginate(4);

        return $events;
    }

    public function getEvent(String $userId)
    {
        $event = Event::where('user_uuid', $userId)->firstOrFail();

        return $event;
    }

    public function storeEvent(Array $reqInfo, String $uuid): void
    {
        $event->create([
            'uuid' => Str::fastUuid(),
            'name' => $reqInfo['name'],
            'description' => $reqInfo['description'],
            'event_type' => $reqInfo['event_type'],
            'location' => $reqInfo['location'],
            'hour' => $reqInfo['hour'],
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