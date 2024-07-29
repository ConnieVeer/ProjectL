<?php


namespace App\Http\Controllers;


use App\Models\Company;

use App\Models\Project;

use App\Models\ProjectUser;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;


class ProjectController extends Controller

{

    /**

     * Display a listing of the resource.

     */

    public function index()

    {

        if (Auth::check()) {

            $projects = Project::where('user_id', Auth::id())

                ->orderBy('name')

                ->paginate(3);


            return view('project.index', ['projects' => $projects]);
        }


        return view('auth.login');
    }


    /**

     * Show the form for creating a new resource.

     */

    public function create()

    {


        if (Auth::check()) {

            $companies = Company::where('user_id', Auth::id())->orderBy('name')->get();

            $company_id = request()->get('company_id') ?? '';


            return view('project.create', ['company_id' => $company_id, 'companies' => $companies]);
        }


        return redirect()->route('auth.login');
    }


    /**

     * Store a newly created resource in storage.

     */

    public function store(Request $request)

    {

        if (Auth::check()) {


            $project = Project::create([

                'name' => $request->input('name'),

                'description' => $request->input('description'),

                'company_id' => $request->input('company_id'),

                'user_id' => Auth::id()

            ]);


            if ($project) {


                $projectUser = ProjectUser::create([

                    'project_id' => $project->id,

                    'user_id' => $project->user_id

                ]);


                if ($projectUser) {

                    return redirect()->route('project.index')

                        ->with('success', 'Project added successful');
                } else {

                    return back()->withInput()

                        ->with('error', 'ERROR: check formulier for user');
                }
            } else {

                return back()->withInput()

                    ->with('error', 'ERROR: check formulier');
            }
        }


        return redirect()->route('auth.login');
    }


    /**

     * Display the specified resource.

     */

    public function show(Project $project)

    {

        return view('project.show', [

            'project' => $project,

            'comments' => $project->comments,

            'users' => User::all(),

            'tasks' => $project->tasks,
            
            'taskTime' => $project->tasks()
            ->whereNotNull('hours')
            ->sum('hours')
        ]);
    }


    /**

     * Show the form for editing the specified resource.

     */

    public function edit(Project $project)

    {

        return view('project.edit', ['project' => $project]);
    }


    /**

     * Update the specified resource in storage.

     */

    public function update(Request $request, Project $project)

    {

        $projectUpdate = $project->update($request->toArray());


        if ($projectUpdate) {

            return redirect()->route('project.show', ['project' => $project->id])

                ->with('success', 'Project updated successful');
        } else {

            return back()->withInput()->with('error', 'ERROR: check formulier');
        }
    }


    /**

     * Remove the specified resource from storage.

     */

    public function destroy(Project $project)

    {


        if ($project->delete() && Auth::id() === $project->user_id) {

            return redirect()->route('project.index')

                ->with('success', 'Project deleted successfully');
        }


        return back()->withInput()->with('error', 'Project could not be deleted');
    }


    public function adduser(Request $request)

    {

        if (Auth::check()) {

            $project = Project::find($request->input('project_id'));


            if (Auth::id() === $project->user_id) { //user_id is de eigenaar van het [roject]

                $user = User::where('id', $request->input('user_id'))->first(); // zoek user op

                if (!$user) {

                    return redirect()->route('project.show', ['project' => $project->id])

                        ->with('error', 'You can not add unknown users to this project');
                }


                // check for doubles

                $projectUser = ProjectUser::where('user_id', $user->id)

                    ->where('project_id', '=', $project->id)

                    ->first();

                if ($projectUser) {

                    return redirect()->route('project.show', ['project' => $project])

                        ->with('error', $user->name . ' is already linked to this project');
                }


                if ($project) {

                    $projectInsert = DB::insert(
                        'insert into project_users (project_id, user_id) VALUES (?,?)',

                        [$project->id, $user->id]
                    );


                    if ($projectInsert) {

                        return redirect()->route('project.show', ['project' => $project->id])

                            ->with('success', $user->name . ' is now linked to this project');
                    }
                }
            }


            return redirect()->route('project.show', ['project' => $project->id])

                ->with('error', 'You can not add users to this project');
        }


        return redirect()->route('auth.login');
    }
}
