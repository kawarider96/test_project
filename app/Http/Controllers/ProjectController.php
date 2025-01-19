<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ProjectTime;
use Illuminate\Support\Facades\DB;
use DateTime;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*HA LENNE AUTHENTIKÁCIÓ
            $user = auth()->user();

            Szűrjük a projekteket a created_by mező alapján
            $projects = Project::where('created_by', $user->id)->paginate(10);
        */

        //Vissza adja a kezdőoldalt a projectek listázásával 10 es lapozóval
        $projects = Project::paginate(10);
        return view('projects.index', compact('projects'));
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
    public function store(StoreProjectRequest $request)
    {
        //létrehoz egy új projectet
        Project::create([
            'project_name' => $request->input('project_name'),
        ]);

        // válasz
        return redirect()->route('projects.index')->with('success', 'Projekt sikeresen mentve!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
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
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export()
    {

        $times = ProjectTime::with('project')
            ->select('project_id', 'project_start as start', 'project_end as finish', 'project_comment', DB::raw('TIMEDIFF(project_end, project_start) as duration'))
            ->get()
            ->map(function ($time) {
                return [
                    'project_name' => $time->project->project_name,
                    'start' => $time->start,
                    'finish' => $time->finish,
                    'duration' => $time->duration,
                    'comment' => $time->project_comment,
                ];
            });

        $projectTotals = Project::with('projectTime')
            ->get()
            ->map(function ($project) {
                $totalTime = $project->projectTime->reduce(function ($carry, $time) {
                    $start = new DateTime($time->project_start);
                    $end = new DateTime($time->project_end);
                    return $carry + $end->getTimestamp() - $start->getTimestamp();
                }, 0);

                return [
                    'name' => $project->project_name,
                    'total_time' => gmdate('H:i:s', $totalTime),
                ];
            });

        $exportPeriod = [
            'start' => ProjectTime::min('project_start'),
            'end' => ProjectTime::max('project_end'),
        ];

        return view('projects.export', compact('times', 'projectTotals', 'exportPeriod'));
    }

}
