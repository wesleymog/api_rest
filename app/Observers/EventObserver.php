<?php

namespace App\Observers;

use App\Event;
use Carbon\Carbon;
use Log;
class EventObserver
{

    public static function created(Event $event)
    {
        if(!$event->event()->exists())
        {
            $recurrences = [
                'daily'     => [
                    'times'     => 365,
                    'function'  => 'addDay'
                ],
                'weekly'    => [
                    'times'     => 52,
                    'function'  => 'addWeek'
                ],
                'monthly'    => [
                    'times'     => 12,
                    'function'  => 'addMonth'
                ]
            ];
            $startTime = Carbon::parse($event->start_time);
            $endTime = Carbon::parse($event->end_time);
            $recurrence = $recurrences[$event->recurrence] ?? null;

            if($recurrence)
                for($i = 0; $i < $recurrence['times']; $i++)
                {
                    $startTime->{$recurrence['function']}();
                    $endTime->{$recurrence['function']}();
                    $event->events()->create([
                        'name'          => $event->name,
                        'start_time'    => $startTime,
                        'end_time'      => $endTime,
                        'recurrence'    => $event->recurrence,
                        'type'    => $event->type,
                        'category'    => $event->category,
                        'title'    => $event->title,
                        'code'    => $event->code,
                        'location'    => $event->location,
                        'description'    => $event->description,
                        'img'    => $event->img,
                        'value'    => $event->value,
                        'user_id'    => $event->user_id
                    ]);
                }
        }
    }

    public function updated(Event $event)
    {
        if ($event->events()->exists() || $event->event)
        {
            $startTime = Carbon::parse($event->getOriginal('start_time'))->diffInSeconds($event->start_time, false);
            $endTime = Carbon::parse($event->getOriginal('end_time'))->diffInSeconds($event->end_time, false);
            if($event->event)
                $childEvents = $event->event->events()->whereDate('start_time', '>', $event->getOriginal('start_time'))->get();
            else
                $childEvents = $event->events;

            foreach($childEvents as $childEvent)
            {

                if($startTime)
                    $childEvent->start_time = Carbon::parse($childEvent->start_time)->addSeconds($startTime);
                if($endTime)
                    $childEvent->end_time = Carbon::parse($childEvent->end_time)->addSeconds($endTime);
                if($event->isDirty()){
                    $childEvent->title = $event->title;
                    $childEvent->type = $event->type;
                    $childEvent->category = $event->category;
                    $childEvent->title = $event->title;
                    $childEvent->code = $event->code;
                    $childEvent->location = $event->location;
                    $childEvent->description = $event->description;
                    $childEvent->img = $event->img;
                    $childEvent->recurrence = $event->recurrence;
                    $childEvent->value = $event->value ? $event->value: 10;
                }
                $childEvent->saveQuietly();
            }
        }
        if($event->isDirty('recurrence') && $event->recurrence != 'none')
            self::created($event);
    }

    public function deleted(Event $event)
    {
        if($event->events()->exists())
            $events = $event->events()->pluck('id');
        else if($event->event)
            $events = $event->event->events()->whereDate('start_time', '>', $event->start_time)->pluck('id');
        else
            $events = [];

        Event::whereIn('id', $events)->delete();
    }

    /**
     * Handle the event "restored" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
