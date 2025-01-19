<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectTimeRequest;
use App\Http\Requests\UpdateProjectTimeRequest;
use App\Models\ProjectTime;
use App\Models\Project;

class ProjectTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        //Az adott project össze időtartamát listázza
        $times = $project->projectTime;
        return response()->json($times);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectTimeRequest $request, Project $project)
    {
        //Ment egy új rekordot az adott projecthez
        try {
            $projectTime = ProjectTime::create([
                'project_id' => $request->validated()['project_id'],
                'project_start' => null,
                'project_end' => null,
                'project_comment' => null,
            ]);
    
            return response()->json(['id' => $projectTime->id], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hiba történt a mentés során: ' . $e->getMessage()], 500);
        }
    }    

    /**
     * Display the specified resource.
     */
    public function show(ProjectTime $projectTime)
    {
        //
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectTimeRequest $request, $id)
    {
         // Keressük meg a rekordot az ID alapján
        $projectTime = ProjectTime::findOrFail($id);

        // Frissítsük a rekordot validált adatokkal
        $projectTime->update($request->validated());

        return response()->json(['message' => 'ProjectTime updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
