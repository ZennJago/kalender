<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index(Request $request)
    {
  
        if($request->ajax()) {
       
             $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end','nama_ruang','baju']);
  
             return response()->json($data);
        }
  
        return view('welcome');
    }
 
    public function manageEvent(Request $request)
    {
 
        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'nama_ruang'=>$request->nama_ruang,
                    'baju'=>$request->baju,
                ]);
    
                return response()->json($event);
                break;
    
            case 'update':
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'nama_ruang'=>$request->nama_ruang,
                    'baju'=>$request->baju,
                ]);
    
                return response()->json($event);
                break;
    
            case 'delete':
                $event = Event::find($request->id)->delete();
    
                return response()->json($event);
                break;
                
            default:
                
                break;
        }
    }

    public function search(Request $request)
    {
        $query = Event::query();
    
        if ($request->has('title') && !empty($request->input('title'))) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
    
        if ($request->has('start_date') && !empty($request->input('start_date'))) {
            $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
            $query->whereDate('start', '>=', $startDate);
        }
    
        if ($request->has('end_date') && !empty($request->input('end_date'))) {
            $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');
            $query->whereDate('end', '<=', $endDate);
        }
    
        if ($request->has('nama_ruang') && !empty($request->input('nama_ruang'))) {
            $query->where('nama_ruang', 'like', '%' . $request->input('nama_ruang') . '%');
        }
    
        if ($request->has('baju') && !empty($request->input('baju'))) {
            $query->where('baju', 'like', '%' . $request->input('baju') . '%');
        }
    
        $events = $query->get();
    
        foreach ($events as $event) {
            // Log the event attributes to check available properties
            Log::info($event->getAttributes());
    
            if (isset($event->end)) {
                $event->end = Carbon::parse($event->end)->subDay()->format('Y-m-d');
            }
        }
    
        return view('search', compact('events'));
    }
}    