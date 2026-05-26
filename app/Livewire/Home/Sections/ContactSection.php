<?php

namespace App\Livewire\Home\Sections;

use App\Mail\ContactFormSubmitted;
use App\Models\Admin\ContactSetting;
use App\Models\Admin\About\AboutSetting;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactSection extends Component
{
    // Livewire Data Mappings for Form Elements
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $message = '';

    // Properties for Dynamic Admin Settings Data
    public $contactSetting;
    public $aboutSetting;

    protected function rules(): array
    {
        return [
            'name'    => 'required|string|min:2|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:30',
            'subject' => 'required|string|min:3|max:200',
            'message' => 'required|string|min:10|max:5000',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'name'    => 'full name',
            'email'   => 'email address',
            'message' => 'message',
        ];
    }

    public function mount()
    {
        // Load settings tables dynamically or assign blank models to prevent object properties exceptions
        $this->contactSetting = ContactSetting::first() ?? new ContactSetting([
            'address' => 'Dhumbarahi Height, Dhumbarahi, Kathmandu-10, Nepal',
            'phone'   => '01-4474158',
            'email'   => 'info@mindshareconnect.com.np'
        ]);

        $this->aboutSetting = AboutSetting::first() ?? new AboutSetting([
            'registration_number'    => '81657/067/68',
            'registration_date_text' => '20 March 2011 (2067/12/6 B.S.)',
            'pan_vat_number'         => '304957020'
        ]);
    }

    public function submitMessage()
    {
        $validatedData = $this->validate();

        try {
            // Uses the dynamic email managed by the admin panel settings row
            $targetInboxEmail = $this->contactSetting->email ?? 'info@mindshareconnect.com.np';

            // Deliver form data details safely via dynamic Mailable class setup
            Mail::to($targetInboxEmail)->send(new ContactFormSubmitted($validatedData));

            $this->dispatch('swalToast', [
                'icon'    => 'success',
                'message' => 'Your message has been sent successfully!'
            ]);

            $this->reset(['name', 'email', 'phone', 'subject', 'message']);

        } catch (\Exception $exception) {
            $this->dispatch('swalToast', [
                'icon'    => 'error',
                'message' => 'Failed to transmit message. Please try again later.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.home.sections.contact-section');
    }
}
