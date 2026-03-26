<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use App\Services\ConversionTracker;
use Livewire\Component;

class AppointmentForm extends Component
{
    public $name = '';

    public $email = '';

    public $phone = '';

    public $service_slug = '';

    public $appointment_date = '';

    public $appointment_time = '';

    public $message = '';

    public $services = [];

    public $submitted = false;

    public $successMessage = '';

    public $errorMessage = '';

    public function mount()
    {
        $this->services = Service::active()->ordered()->get();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'service_slug' => 'required|string|exists:services,slug',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'message' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Ingresa un email válido.',
            'phone.required' => 'El teléfono es obligatorio.',
            'service_slug.required' => 'Selecciona un servicio.',
            'service_slug.exists' => 'El servicio seleccionado no existe.',
            'appointment_date.required' => 'La fecha es obligatoria.',
            'appointment_date.after' => 'La fecha debe ser en el futuro.',
            'appointment_time.required' => 'La hora es obligatoria.',
            'appointment_time.date_format' => 'El formato de hora no es válido.',
            'message.max' => 'El mensaje no debe exceder 500 caracteres.',
        ];
    }

    public function submit()
    {
        $this->validate();

        try {
            // Save appointment
            Appointment::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'service_slug' => $this->service_slug,
                'appointment_date' => $this->appointment_date,
                'appointment_time' => $this->appointment_time,
                'message' => $this->message,
                'status' => 'pending',
            ]);

            ConversionTracker::track('appointment_form_submitted', request(), [
                'service_slug' => $this->service_slug,
            ], 'lead');

            // Reset form
            $this->reset();
            $this->submitted = true;
            $this->successMessage = '¡Cita agendada exitosamente! Nos pondremos en contacto para confirmar.';

            // Hide success message after 5 seconds
            $this->dispatch('appointment-submitted');
        } catch (\Exception $e) {
            $this->errorMessage = 'Ocurrió un error al agendar la cita. Por favor, intenta de nuevo.';
        }
    }

    public function render()
    {
        return view('livewire.appointment-form', [
            'services' => $this->services,
        ]);
    }
}
