<?php

namespace App\Livewire\Pages;

use App\Models\Admin\Team;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest.main', ['title' => 'Teams Page', 'withFilters' => false, 'breadcrumbs' => ''])]

class TeamsPage extends Component
{
    public function render()
    {
// Gather active team members sorted by creation order or custom priorities
        $teamMembers = Team::Published()->get();

        // Isolate the Managing Director explicitly for the top feature box
        $managingDirector = $teamMembers->first(function ($member) {
            return strtolower($member->job_post) === 'managing director';
        });

        // Get core team members (excluding the Managing Director)
        $coreTeam = $teamMembers->filter(function ($member) use ($managingDirector) {
            return !$managingDirector || $member->id !== $managingDirector->id;
        });

        return view('livewire.pages.teams-page', [
            'managingDirector' => $managingDirector,
            'coreTeam'         => $coreTeam,
        ]);
    }
}
