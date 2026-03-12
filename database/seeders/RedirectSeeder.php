<?php

namespace Database\Seeders;

use App\Models\Redirect;
use Illuminate\Database\Seeder;

class RedirectSeeder extends Seeder
{
    public function run(): void
    {
        $redirects = [
            ['/contaacutectanos.html',                                         '/contacto'],
            ['/examenes.html',                                                 '/servicios/examen-visual-integral'],
            ['/nuestros-servicios.html',                                       '/servicios'],
            ['/consejos-de-salud-visual.html',                                '/blog'],
            ['/store/c3/Lentes_de_Hombre.html',                               '/catalogo/lentes-hombre'],
            ['/store/c4/Lentes_de_Mujer.html',                                '/catalogo/lentes-mujer'],
            ['/gafas-de-sol.html',                                             '/catalogo/gafas-sol'],
            ['/lentes-deportivos1.html',                                       '/catalogo/lentes-deportivos'],
            ['/lentes-de-contacto-y-lentes-oftaacutelmicas.html',             '/catalogo/lentes-contacto'],
        ];

        foreach ($redirects as [$from, $to]) {
            Redirect::updateOrCreate(
                ['from_path' => $from],
                ['to_path' => $to, 'code' => 301, 'is_active' => true]
            );
        }
    }
}
