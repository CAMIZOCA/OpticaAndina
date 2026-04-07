<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormReceived;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use App\Services\ConversionTracker;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $seo = SeoService::forPage('contacto');
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $seo['schema'] = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'url' => route('contacto'),
            'name' => 'Contacto – '.$siteName,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Contacto', 'url' => route('contacto')],
        ]);
        $seo = SeoService::applyDefaults($seo);

        return view('pages.contacto', compact('seo'));
    }

    public function store(Request $request)
    {
        if ($request->filled('website')) {
            return back()->with('success', '¡Mensaje enviado! Te contactaremos pronto.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Introduce un email válido.',
            'message.required' => 'El mensaje es obligatorio.',
        ]);

        $contactMessage = ContactMessage::create($validated);

        ConversionTracker::track('contact_form_submitted', $request, [
            'subject' => $contactMessage->subject,
        ], 'lead');

        $adminEmail = SiteSetting::get('email', config('mail.from.address'));
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new ContactFormReceived($contactMessage));
            } catch (\Throwable $e) {
                Log::error('Error enviando email de contacto: '.$e->getMessage());
            }
        }

        return back()
            ->with('success', '¡Mensaje enviado! Te contactaremos pronto.')
            ->with('tracked_conversion_events', [
                [
                    'event_name' => 'contact_form_submitted',
                    'event_category' => 'lead',
                    'meta' => [
                        'page_path' => route('contacto', absolute: false),
                    ],
                ],
            ]);
    }
}
