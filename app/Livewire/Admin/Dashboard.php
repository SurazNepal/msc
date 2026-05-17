<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public function toastPop(){
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Category Created Successfully!.']);
          }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
