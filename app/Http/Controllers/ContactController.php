<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $seo = SeoService::forPage('contacto');
        return view('pages.contacto', compact('seo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.required'    => 'El nombre es obligatorio.',
            'email.required'   => 'El email es obligatorio.',
            'email.email'      => 'Introduce un email válido.',
            'message.required' => 'El mensaje es obligatorio.',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', '¡Mensaje enviado! Te contactaremos pronto.');
    }
}
