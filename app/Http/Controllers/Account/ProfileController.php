<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Head\Facades\Head;

class ProfileController extends Controller
{
    public function show(): Response
    {
        Head::title('Profile')
            ->description('Manage your Must Have Golf player profile.')
            ->hiddenFromRobots();

        return Inertia::render('Profile');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dexterity' => ['required', 'in:left,right'],
            'handicap' => ['nullable', 'numeric', 'between:-10,54'],
            'experience' => ['required', 'in:beginner,intermediate,advanced,pro'],
        ]);

        $request->user()->update($validated);

        $this->successToast('Profile saved', [
            'description' => 'Your golf profile has been updated.',
        ]);

        return to_route('account.profile.show');
    }
}
