<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

abstract class BaseSettingsPage extends Page
{
    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationGroup = 'Ajustes';

    /** Keys that store JSON arrays (Repeater fields). Override in subclasses as needed. */
    protected const JSON_KEYS = [];

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::getAll();

        foreach (static::JSON_KEYS as $key) {
            if (isset($settings[$key]) && is_string($settings[$key])) {
                $decoded = json_decode($settings[$key], true);
                $settings[$key] = is_array($decoded) ? $decoded : [];
            }
        }

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form->schema([])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            $stored = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $stored]);
        }

        SiteSetting::flushCache();

        Notification::make()
            ->title('Configuración guardada')
            ->success()
            ->send();
    }
}
