<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Laravel\Jetstream\Actions\ValidateTeamDeletion;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\RedirectsActions;
use App\Models\User;
class UserController extends Controller
{
    use RedirectsActions;

    /**
     * Show the team management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        // $team = Jetstream::newUserModel();

        // Gate::authorize('view', $team);

        // return Jetstream::inertia()->render($request, 'Users/Show', [
        //     'users' => User::all()->map(function ($user) {
        //         return [
        //             'id' => $user->id,
        //             'name' => $user->name,
        //             'email' => $user->email,
        //             'edit_url' => URL::route('users.edit', $user),
        //         ];
        //     }),
        //     'availableRoles' => array_values(Jetstream::$roles),
        //     'availablePermissions' => Jetstream::$permissions,
        //     'defaultPermissions' => Jetstream::$defaultPermissions,
        //     'permissions' => [
        //         'canAddTeamMembers' => Gate::check('addTeamMember', $team),
        //         'canDeleteTeam' => Gate::check('delete', $team),
        //         'canRemoveTeamMembers' => Gate::check('removeTeamMember', $team),
        //         'canUpdateTeam' => Gate::check('update', $team),
        //     ],
        //     'fddfsf' => 'fsddf'
        // ]);

        $usersList = User::orderBy('id', 'desc')
        ->paginate(6);

            return Inertia::render('Users/Show', [
            'users' => $usersList
            ]);
    }

    /**
     * Show the team creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Jetstream::newTeamModel());
        return Inertia::render('Teams/Create');
    }

    /**
     * Create a new team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $creator = app(CreatesTeams::class);

        $creator->create($request->user(), $request->all());
        $request->session()->flash('flash.banner', 'Team Added');
        $request->session()->flash('flash.bannerStyle', 'success');
        return $this->redirectPath($creator);
    }

    /**
     * Update the given team's name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        app(UpdatesTeamNames::class)->update($request->user(), $team, $request->all());

        return back(303);
    }

    /**
     * Delete the given team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        app(ValidateTeamDeletion::class)->validate($request->user(), $team);

        $deleter = app(DeletesTeams::class);

        $deleter->delete($team);

        return $this->redirectPath($deleter);
    }
}
