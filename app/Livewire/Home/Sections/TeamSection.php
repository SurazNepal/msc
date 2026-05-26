<?php

namespace App\Livewire\Home\Sections;

use App\Models\Admin\Team;
use Livewire\Component;

class TeamSection extends Component
{
    public $teamMembers;

    public function mount()
    {
        // Assuming your active status column matches 'published' or true
        $this->teamMembers = Team::where('status', 'published')
            ->oldest() // Orders members by creation layout or custom sort sequence
            ->get();
    }

    public function render()
    {
        return view('livewire.home.sections.team-section');
    }
}
