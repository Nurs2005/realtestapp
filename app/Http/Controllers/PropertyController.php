<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('has_photo') && $request->has_photo) {
            $query->whereNotNull('image');
        }

        if ($request->filled('rooms')) {
            $query->whereIn('rooms', $request->rooms);
        }

        if ($request->filled('area_min') && $request->filled('area_max')) {
            $query->whereBetween('area', [$request->area_min, $request->area_max]);
        }

        $properties = $query->paginate(10);

        return Inertia::render('Properties/Index', [
            'properties' => $properties,
            'filters' => $request->all(['title', 'has_photo', 'rooms', 'area_min', 'area_max'])
        ]);
    }

}
