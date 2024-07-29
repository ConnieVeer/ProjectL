<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {

            return view('users.index', ['users' => User::orderBy('name')->paginate(10)]);
        }

        return view('auth.login');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $tasksOwner = Task::where('user_id', '=', $user->id)->orderBy('name')->get();
        $taskMember = TaskUser::where('user_id', '=', $user->id)->with('task')->get();

        $companiesOwner = Company::where('user_id', '=', $user->id)->orderBy('name')->get();
        $companiesMember = CompanyUser::where('user_id', '=', $user->id)->with('company')->get();

        $projectsOwner = Project::where('user_id', '=', $user->id)->orderBy('name')->get();
        $projectsMember = ProjectUser::where('user_id', '=', $user->id)->with('project')->get();
        return view('users.show', [
            'user' => $user,
            'tasksOwner' => $tasksOwner,
            'tasksMember' => $taskMember,
            'companiesOwner' => $companiesOwner,
            'companiesMember' => $companiesMember,
            'projectsOwner' => $projectsOwner,
            'projectsMember' => $projectsMember
        ]);
    }

}