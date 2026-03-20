<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; color: #333; }
        .wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .header { background: #1e40af; padding: 24px 32px; }
        .header h1 { color: #ffffff; margin: 0; font-size: 20px; }
        .body { padding: 32px; }
        .field { margin-bottom: 20px; }
        .label { font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; font-weight: bold; margin-bottom: 4px; }
        .value { font-size: 15px; color: #111827; padding: 10px 14px; background: #f9fafb; border-radius: 6px; border: 1px solid #e5e7eb; }
        .message-value { white-space: pre-wrap; }
        .footer { padding: 20px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; font-size: 12px; color: #9ca3af; }
        .cta { margin-top: 24px; }
        .cta a { display: inline-block; background: #1e40af; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-size: 14px; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>📩 Nuevo mensaje de contacto</h1>
    </div>
    <div class="body">
        <div class="field">
            <div class="label">Nombre</div>
            <div class="value">{{ $contactMessage->name }}</div>
        </div>
        <div class="field">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div>
        </div>
        @if($contactMessage->phone)
        <div class="field">
            <div class="label">Teléfono</div>
            <div class="value">{{ $contactMessage->phone }}</div>
        </div>
        @endif
        @if($contactMessage->subject)
        <div class="field">
            <div class="label">Asunto</div>
            <div class="value">{{ $contactMessage->subject }}</div>
        </div>
        @endif
        <div class="field">
            <div class="label">Mensaje</div>
            <div class="value message-value">{{ $contactMessage->message }}</div>
        </div>
        <div class="cta">
            <a href="{{ config('app.url') }}/admin/contact-messages">Ver en el panel de administración</a>
        </div>
    </div>
    <div class="footer">
        Este mensaje fue enviado desde el formulario de contacto de <strong>{{ config('app.name') }}</strong>.
        Recibido el {{ now()->timezone('America/Guayaquil')->format('d/m/Y H:i') }}.
    </div>
</div>
</body>
</html>
