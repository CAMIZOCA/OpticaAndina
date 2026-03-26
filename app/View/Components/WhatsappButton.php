<?php

namespace App\View\Components;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WhatsappButton extends Component
{
    public string $url;

    public function __construct(
        public string $message = '',
        public string $label = 'Consultar por WhatsApp',
        public bool $floating = false,
        public string $eventName = 'whatsapp_click',
        public string $eventLocation = '',
    ) {
        $number = SiteSetting::get('whatsapp_number', '593999000000');
        $text = $message ?: SiteSetting::get('whatsapp_message', 'Hola, me gustaría obtener más información.');
        $this->url = 'https://wa.me/'.$number.'?text='.urlencode($text);
    }

    public function render(): View|Closure|string
    {
        return view('components.whatsapp-button');
    }
}
