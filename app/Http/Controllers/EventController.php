<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Http\Services\WeatherForecastService;

class EventController extends Controller
{
    protected $weatherForecastService;

    public function __construct(WeatherForecastService $weatherForecastService)
    {
        $this->weatherForecastService = $weatherForecastService;
    }

    public function store(EventRequest $request)
    {
        try {
            Event::create($request->validated());
            return response()->json(['message' => 'Event created successfully'], 201);
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => 'You are not authorized to create events.'], 403);
        }
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $event = Event::select('id','name','description','latitude','longitude','date')->find($request->get('id'));
        if ($event){
            $forecast = $this->weatherForecastService->getForecast($event->latitude, $event->longitude, $event->date);
            return response()->json(
                [
                    'event_data'=>$event,
                    'weather_data' => $forecast
                ], 200);
        }
        return response()->json(['message' => 'Events is not present.'], 403);

    }

    public function search(Request $request)
    {
        $query = Event::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('latitude')) {
            $query->where('latitude', 'like', '%' . $request->input('latitude') . '%');
        }

        if ($request->filled('longitude')) {
            $query->where('longitude', 'like', '%' . $request->input('longitude') . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        $perPage = $request->input('per_page', env('PER_PAGE'));
        $events = $query->paginate($perPage);

        if ($events){
            return response()->json(['data' => $events], 200);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $event = Event::find($request->get('id'));
        if(isset($event)){
            $event->update($request->all());
            return response()->json(['message' => 'Event updated successfully', 'event' => $event]);
        }
        return response()->json(['message' => 'Event not fount']);  
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $event = Event::find($request->get('id'));
        
        if(isset($event)){
            $event->delete();
            return response()->json(['message' => 'Event deleted successfully']);    
        }
        return response()->json(['message' => 'Event not fount']);    
        
    }
}
