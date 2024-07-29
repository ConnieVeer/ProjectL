<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Workbench\App\Models\User as ModelsUser;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            //$projects = Project::where('user_id', Auth::user()->id)->get();
            $tasks = Task::all();

            return view('tasks.index', ['tasks' => $tasks]);
        }
        return view('auth.login');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id = null)
    {
        $projects = null;
        if (!$project_id) {
            $projects = Project::where('user_id', Auth::user()->id)->get();
        }
        return view('tasks.create', ['project_id' => $project_id, 'projects' => $projects]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

 
    {
            if (Auth::check()) {

            $task = Task::create([

                'name' => $request->input('name'),

                'description' => $request->input('description'),

                'project_id' => $request->input('project_id'),

                'hours'=> $request->input('hours'),

                'user_id' => Auth::id()
                

            ]);

            if ($task) {


                $taskUser = TaskUser::create([

                    'task_id' => $task->id,

                    'user_id' => $task->user_id

                ]);


                if ($taskUser) {

                    return redirect()->route('task.index')

                        ->with('success', 'Task added successful');
                } else {

                    return back()->withInput()

                        ->with('error', 'ERROR: check formulier for user');
                }
            } else {

                return back()->withInput()

                    ->with('error', 'ERROR: check formulier');
            }
            
            if ($task) {
                return redirect()->route('task.index', )
                    ->with('success', 'Task created successfully');
            }
        }
        return back()->withInput()->with('error', 'task could not be created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', ['task'=> $task,  'users' => User::all(), 'comments' => $task->comments]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]); // als dit niet voldoet wordt $errors geset ( zie errro.blade.php)


        $companyUpdate = $task->update($request->toArray());

        if ($companyUpdate) {
            return redirect()->route('task.show', ['task' => $task->id])
                ->with('success', 'Task updated successfull '); //success hangt weer samen met de alert in succes.blade.php
        } else {
            return back()->withInput()->with('errors', 'ERROR: Check formulier'); //withInput wat je gezijzijgsd heb stuutrt hij mee
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $findTask = Task::find($task->id);
        if ($findTask->delete()) {
            return redirect()->route('task.index')
                ->with('success', 'Task deleted successfully');
        }
        return back()->withInput()->with('error', 'Task could not be deleted');
    }

    
    public function adduser(Request $request)

        {
    
            if (Auth::check()) {
    
                $task = Task::find($request->input('task_id'));
    
    
                if (Auth::id() === $task->user_id) { //user_id is de eigenaar van het [roject]
    
                    $user = User::where('id', $request->input('user_id'))->first(); // zoek user op
    
                    if (!$user) {
    
                        return redirect()->route('task.show', ['task' => $task->id])
    
                            ->with('error', 'You can not add unknown users to this task');
                    }
    
    
                    // check for doubles
    
                    $taskUser = TaskUser::where('user_id', $user->id)
    
                        ->where('task_id', '=', $task->id)
    
                        ->first();
    
                    if ($taskUser) {
    
                        return redirect()->route('task.show', ['task' => $task])
    
                            ->with('error', $user->name . ' is already linked to this task');
                    }
    
    
                    if ($task) {
    
                        $taskInsert = DB::insert(
                            'insert into task_users (task_id, user_id) VALUES (?,?)',
    
                            [$task->id, $user->id]
                        );
    
    
                        if ($taskInsert) {
    
                            return redirect()->route('task.show', ['task' => $task->id])
    
                                ->with('success', $user->name . ' is now linked to this task');
                        }
                    }
                }
    
    
                return redirect()->route('task.show', ['task' => $task->id])
    
                    ->with('error', 'You can not add users to this task');
            }
    
    
            return redirect()->route('auth.login');
        } 
        

}
