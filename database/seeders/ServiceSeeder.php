<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'             => 'Examen Visual Integral',
                'slug'              => 'examen-visual-integral',
                'excerpt'           => 'Evaluación completa de tu salud visual con equipos de última generación. Detectamos problemas refractivos y oculares antes de que se conviertan en algo mayor.',
                'icon'              => 'heroicon-o-eye',
                'sort_order'        => 1,
                'cta_text'          => 'Agenda tu examen',
                'cta_whatsapp_text' => 'Hola, quisiera agendar un examen visual integral. ¿Cuál es su disponibilidad?',
                'meta_title'        => 'Examen Visual Integral en Tumbaco | Óptica Andina',
                'meta_description'  => 'Examen visual completo con equipos modernos en Tumbaco, Ecuador. Detección de miopía, astigmatismo, hipermetropía y más.',
                'faqs'              => [
                    ['question' => '¿Cuánto dura el examen visual?', 'answer' => 'El examen visual integral tiene una duración de aproximadamente 45 a 60 minutos, dependiendo de los procedimientos que se realicen.'],
                    ['question' => '¿Con qué frecuencia debo hacerme un examen?', 'answer' => 'Se recomienda un examen visual completo cada año. Si tienes factores de riesgo como diabetes o antecedentes familiares de glaucoma, puede ser necesario con mayor frecuencia.'],
                    ['question' => '¿El examen tiene algún costo?', 'answer' => 'El examen es sin costo cuando adquieres tus lentes con nosotros. Consulta nuestras tarifas actuales para más información.'],
                    ['question' => '¿Necesito hacer alguna preparación previa?', 'answer' => 'No es necesaria preparación especial. Si usas lentes de contacto, te pediremos que los retires antes del examen.'],
                ],
                'content'           => '<p>Nuestro <strong>examen visual integral</strong> es mucho más que una simple prueba de agudeza visual. Evaluamos todos los aspectos de tu salud ocular utilizando equipos de diagnóstico de última generación.</p>
<h2>¿Qué incluye el examen?</h2>
<ul>
<li><strong>Agudeza visual</strong>: medición de tu capacidad para ver detalles a distintas distancias</li>
<li><strong>Refracción</strong>: determinación de la graduación exacta para lentes</li>
<li><strong>Tonometría</strong>: medición de la presión intraocular (detección de glaucoma)</li>
<li><strong>Biomicroscopía</strong>: evaluación de la córnea, cristalino y humor vítreo</li>
<li><strong>Fondo de ojo</strong>: revisión de la retina, mácula y nervio óptico</li>
<li><strong>Visión binocular</strong>: coordinación entre ambos ojos y fusión visual</li>
</ul>
<h2>¿Por qué es importante?</h2>
<p>Muchos problemas visuales no presentan síntomas en etapas tempranas. El glaucoma, la degeneración macular y la retinopatía diabética pueden avanzar silenciosamente. Solo un examen profesional puede detectarlos a tiempo.</p>
<h2>Para todas las edades</h2>
<p>Realizamos exámenes visuales desde los 3 años hasta la tercera edad. Nuestros optometristas están capacitados para adaptar el protocolo a cada grupo de edad.</p>',
            ],
            [
                'title'             => 'Contactología y Lentes de Contacto',
                'slug'              => 'adaptacion-lentes-contacto',
                'excerpt'           => 'Adaptación personalizada de lentes de contacto blandos, tóricos para astigmatismo, multifocales y ortoqueratología para el control de miopía.',
                'icon'              => 'heroicon-o-adjustments-horizontal',
                'sort_order'        => 2,
                'cta_text'          => 'Consultar adaptación',
                'cta_whatsapp_text' => 'Hola, me interesa la adaptación de lentes de contacto. ¿Qué necesito para comenzar?',
                'meta_title'        => 'Adaptación de Lentes de Contacto en Tumbaco | Óptica Andina',
                'meta_description'  => 'Adaptación profesional de lentes de contacto en Tumbaco. Blandos, tóricos, progresivos y ortoqueratología.',
                'faqs'              => [
                    ['question' => '¿Puedo usar lentes de contacto si tengo astigmatismo?', 'answer' => 'Sí, existen lentes tóricos especialmente diseñados para corregir el astigmatismo con gran precisión y comodidad.'],
                    ['question' => '¿Puedo usar lentes de contacto si soy mayor de 40 años?', 'answer' => 'Claro. Existen lentes multifocales que permiten ver bien a todas las distancias, corrigiendo la presbicia.'],
                    ['question' => '¿Cuánto dura la consulta de adaptación?', 'answer' => 'La primera consulta dura aproximadamente 60-75 minutos. Incluye medición de la córnea, prueba del lente y enseñanza de manejo e higiene.'],
                    ['question' => '¿Qué pasa si un lente no me queda bien?', 'answer' => 'El proceso puede requerir una o dos visitas de revisión. Siempre ajustamos el tipo o parámetros del lente hasta lograr un ajuste cómodo y seguro.'],
                ],
                'content'           => '<p>La <strong>adaptación de lentes de contacto</strong> es un proceso personalizado. Requiere una evaluación detallada de la córnea y del estado de la película lagrimal para garantizar comodidad, agudeza visual óptima y salud ocular a largo plazo.</p>
<h2>Tipos de lentes que adaptamos</h2>
<h3>Lentes blandos desechables</h3>
<p>Los más utilizados. Disponibles en modalidad diaria, quincenal y mensual. Ideales para quienes desean mayor libertad sin gafas.</p>
<h3>Lentes tóricos para astigmatismo</h3>
<p>Diseño especial que se orienta con precisión en el ojo para corregir el astigmatismo.</p>
<h3>Lentes multifocales</h3>
<p>Para personas con presbicia que desean ver bien de cerca y lejos sin gafas.</p>
<h3>Ortoqueratología (Orto-K)</h3>
<p>Lentes de uso nocturno que remodelan suavemente la córnea durante el sueño, permitiendo ver sin corrección durante el día. Ideal para control de miopía en niños.</p>',
            ],
            [
                'title'             => 'Terapia Visual',
                'slug'              => 'terapia-visual',
                'excerpt'           => 'Programa personalizado de ejercicios para mejorar la eficiencia del sistema visual. Tratamos convergencia, estrabismo funcional, ambliopía y dificultades de aprendizaje.',
                'icon'              => 'heroicon-o-academic-cap',
                'sort_order'        => 3,
                'cta_text'          => 'Evalúa si necesitas terapia',
                'cta_whatsapp_text' => 'Hola, me interesa conocer más sobre la terapia visual. ¿A quiénes está dirigida?',
                'meta_title'        => 'Terapia Visual en Tumbaco | Óptica Andina',
                'meta_description'  => 'Terapia visual para niños y adultos en Tumbaco. Tratamiento de convergencia, ambliopía y estrabismo funcional.',
                'faqs'              => [
                    ['question' => '¿La terapia visual puede reemplazar a la cirugía de estrabismo?', 'answer' => 'En algunos tipos de estrabismo funcional, la terapia visual puede ser suficiente para corregir la desviación sin cirugía.'],
                    ['question' => '¿Cuánto tiempo dura el programa?', 'answer' => 'Dependiendo de la condición, entre 3 y 12 meses. Se requiere constancia en las sesiones y en los ejercicios domiciliarios.'],
                    ['question' => '¿A partir de qué edad se puede hacer terapia visual?', 'answer' => 'Se puede comenzar desde los 4-5 años. Cuanto antes se inicie, especialmente en ambliopía, mejores serán los resultados.'],
                ],
                'content'           => '<p>La <strong>terapia visual</strong> es un programa de rehabilitación visual supervisado. Su objetivo es mejorar las habilidades visuales que no se corrigen simplemente con gafas.</p>
<h2>¿Qué condiciones trata?</h2>
<h3>Insuficiencia de convergencia</h3>
<p>Dificultad para mantener los ojos alineados al leer. Causa dolores de cabeza, visión doble y dificultad de concentración. Es una de las condiciones mejor tratadas con terapia visual.</p>
<h3>Ambliopía (ojo vago)</h3>
<p>Cuando el cerebro ignora la imagen de un ojo. La terapia visual estimula activamente el ojo ambliope para recuperar su función.</p>
<h3>Problemas de aprendizaje relacionados con la visión</h3>
<p>Muchos niños con dificultades lectoras tienen un problema visual no diagnosticado. La terapia visual puede ser transformadora en estos casos.</p>',
            ],
            [
                'title'             => 'Control Visual Infantil',
                'slug'              => 'control-visual-infantil',
                'excerpt'           => 'Revisiones visuales especializadas adaptadas a cada etapa del desarrollo del niño. Detectamos miopía, ambliopía y problemas que afectan el aprendizaje escolar.',
                'icon'              => 'heroicon-o-face-smile',
                'sort_order'        => 4,
                'cta_text'          => 'Agendar cita para mi hijo/a',
                'cta_whatsapp_text' => 'Hola, quisiera agendar un control visual para mi hijo/a. ¿Desde qué edad atienden?',
                'meta_title'        => 'Control Visual Infantil en Tumbaco | Óptica Andina',
                'meta_description'  => 'Exámenes visuales para niños desde 3 años en Tumbaco. Detección de miopía, ambliopía y problemas que afectan el aprendizaje.',
                'faqs'              => [
                    ['question' => '¿A qué edad se recomienda el primer examen visual?', 'answer' => 'Alrededor de los 3 años, antes del inicio de la etapa preescolar. Cuanto antes se detecten los problemas, más fácil es tratarlos.'],
                    ['question' => '¿Pueden examinar un niño que no sabe leer?', 'answer' => 'Sí. Usamos métodos que no requieren que el niño sepa leer, como optotipos con formas o el método LEA symbols.'],
                    ['question' => '¿Cada cuánto debe ir el niño al optometrista?', 'answer' => 'Sin problemas conocidos, una revisión anual es suficiente. Con lentes o en tratamiento, puede ser más frecuente.'],
                ],
                'content'           => '<p>La visión infantil está en desarrollo continuo. Un problema no detectado puede impactar el aprendizaje y el desarrollo del niño. Realizamos evaluaciones visuales adaptadas a cada etapa del desarrollo.</p>
<h2>Evaluaciones según la edad</h2>
<h3>3 a 5 años (preescolar)</h3>
<p>Evaluación de agudeza visual, alineación ocular y refracción. Usamos métodos adaptados para niños pequeños.</p>
<h3>6 a 12 años (escolar)</h3>
<p>Además, evaluamos vergencias, acomodación y movimientos oculares. Un problema en estas habilidades puede manifestarse como dislexia o déficit de atención.</p>
<h3>Señales de alerta para padres</h3>
<ul>
<li>Se acerca mucho a pantallas o libros</li>
<li>Entrecierra los ojos o inclina la cabeza</li>
<li>Un ojo se va hacia adentro o hacia afuera</li>
<li>Bajo rendimiento escolar inexplicado</li>
</ul>',
            ],
            [
                'title'             => 'Asesoría en Monturas y Estilo',
                'slug'              => 'asesoria-monturas-estilo',
                'excerpt'           => 'Te ayudamos a elegir la montura perfecta según tu forma de rostro, tono de piel y estilo personal. Nuestros asesores tienen formación en imagen y moda óptica.',
                'icon'              => 'heroicon-o-sparkles',
                'sort_order'        => 5,
                'cta_text'          => 'Reservar asesoría',
                'cta_whatsapp_text' => 'Hola, me gustaría recibir asesoría para elegir una montura. ¿Cuándo puedo visitarlos?',
                'meta_title'        => 'Asesoría en Monturas de Gafas | Óptica Andina Tumbaco',
                'meta_description'  => 'Encuentra las gafas perfectas para tu rostro en Tumbaco. Asesoría personalizada en monturas ópticas y de sol.',
                'faqs'              => [
                    ['question' => '¿Cómo sé qué forma de montura me queda mejor?', 'answer' => 'La montura debe contrastar con la forma de tu rostro. Nuestros asesores analizan tu morfología facial para recomendarte las mejores opciones.'],
                    ['question' => '¿Puedo probarme las monturas antes de decidir?', 'answer' => 'Por supuesto. Te invitamos a probarte todas las que desees sin ningún compromiso.'],
                    ['question' => '¿Tienen monturas para todos los presupuestos?', 'answer' => 'Sí. Contamos con monturas en diferentes rangos de precio, desde opciones económicas hasta marcas premium.'],
                ],
                'content'           => '<p>Las gafas son uno de los accesorios más visibles de tu imagen personal. Una montura bien elegida puede realzar tus rasgos y hacerte sentir más seguro/a.</p>
<h2>Nuestra metodología</h2>
<h3>Análisis de la forma del rostro</h3>
<p>Identificamos si tu rostro es ovalado, redondo, cuadrado, rectangular, corazón o diamante. Cada forma tiene estilos que la favorecen.</p>
<h3>Análisis del colorido personal</h3>
<p>El tono de piel, ojos y cabello determinan qué colores de montura te favorecen más.</p>
<h3>Ajuste facial profesional</h3>
<p>Una montura mal ajustada genera incomodidad y puede afectar la calidad óptica. Realizamos ajustes sin costo adicional.</p>',
            ],
            [
                'title'             => 'Lentes Oftálmicos y Tratamientos',
                'slug'              => 'lentes-oftalmicos',
                'excerpt'           => 'Lentes monofocales, bifocales y progresivos con tratamientos avanzados: antirreflejante, fotosensible, filtro de luz azul, endurecido y polarizado.',
                'icon'              => 'heroicon-o-swatch',
                'sort_order'        => 6,
                'cta_text'          => 'Consultar lentes',
                'cta_whatsapp_text' => 'Hola, me interesa información sobre lentes oftálmicos. ¿Qué opciones tienen?',
                'meta_title'        => 'Lentes Oftálmicos en Tumbaco | Óptica Andina',
                'meta_description'  => 'Lentes monofocales, bifocales y progresivos con antirreflejante y filtro de luz azul en Tumbaco, Ecuador.',
                'faqs'              => [
                    ['question' => '¿Qué diferencia hay entre un lente básico y uno premium?', 'answer' => 'Los lentes premium tienen mayor índice de refracción (más delgados), mejores diseños (progresivos) y tratamientos de superficie superiores.'],
                    ['question' => '¿Vale la pena el antirreflejante?', 'answer' => 'Sí, especialmente si pasas muchas horas frente a pantallas o conduces de noche. Mejora la claridad y reduce la fatiga visual.'],
                    ['question' => '¿Cuánto tiempo tarda en estar listo mi lente?', 'answer' => 'Los lentes stock en 24-48 horas. Lentes especiales pueden tardar 5-10 días hábiles.'],
                ],
                'content'           => '<p>El material, el diseño y los tratamientos de un lente oftálmico determinan su calidad visual y durabilidad. No todos los lentes son iguales.</p>
<h2>Tipos de lentes</h2>
<h3>Monofocales</h3>
<p>Una única graduación. Para miopía, hipermetropía o astigmatismo sin presbicia.</p>
<h3>Progresivos</h3>
<p>Contienen la graduación para todas las distancias. La mejor opción para personas con presbicia.</p>
<h2>Tratamientos disponibles</h2>
<ul>
<li><strong>Antirreflejante</strong>: elimina reflejos, mejora la nitidez</li>
<li><strong>Filtro de luz azul</strong>: reduce la exposición de pantallas digitales</li>
<li><strong>Fotosensible</strong>: se oscurece al exterior y se aclara en interiores</li>
<li><strong>Polarizado</strong>: elimina el deslumbramiento</li>
<li><strong>Endurecido e hidrófugo</strong>: mayor resistencia y fácil limpieza</li>
</ul>',
            ],
            [
                'title'             => 'Gafas de Sol con Protección UV',
                'slug'              => 'gafas-sol-proteccion-uv',
                'excerpt'           => 'En Ecuador la radiación UV es muy intensa. Contamos con gafas certificadas UV400 que protegen de cataratas, pterigion y degeneración macular.',
                'icon'              => 'heroicon-o-sun',
                'sort_order'        => 7,
                'cta_text'          => 'Ver colección',
                'cta_whatsapp_text' => 'Hola, me interesa conocer su colección de gafas de sol. ¿Tienen opciones con graduación?',
                'meta_title'        => 'Gafas de Sol UV400 en Tumbaco | Óptica Andina',
                'meta_description'  => 'Gafas de sol certificadas UV400 en Tumbaco. Monturas graduadas, polarizadas y de moda. Protege tu visión con estilo.',
                'faqs'              => [
                    ['question' => '¿Puedo poner mi graduación en gafas de sol?', 'answer' => 'Sí. Podemos adaptar lentes graduados en la mayoría de monturas de sol.'],
                    ['question' => '¿Qué significa UV400?', 'answer' => 'Bloquea el 99-100% de la radiación ultravioleta hasta 400 nanómetros, cubriendo UVA y UVB.'],
                    ['question' => '¿Los lentes más oscuros protegen más?', 'answer' => 'No. La oscuridad no determina la protección UV. Lo que importa es el tratamiento aplicado al material.'],
                ],
                'content'           => '<p>En Ecuador, la altitud y la posición geográfica hacen que la radiación UV sea más intensa que en muchos otros países. Usar gafas de sol adecuadas es una necesidad para la salud ocular, no solo una cuestión de moda.</p>
<h2>¿Qué daños previenen?</h2>
<ul>
<li><strong>Cataratas</strong>: la exposición UV acumulada es uno de los principales factores de riesgo</li>
<li><strong>Pterigion</strong>: crecimiento sobre la córnea relacionado con la exposición solar</li>
<li><strong>Degeneración macular</strong>: la luz azul y UV aceleran el daño retinal</li>
</ul>
<h2>Nuestra colección</h2>
<p>Gafas para todos los estilos: deportivas, casual, clásicas y de moda. Todas con certificación UV400 garantizada.</p>',
            ],
            [
                'title'             => 'Control de Miopía Infantil',
                'slug'              => 'control-miopia-infantil',
                'excerpt'           => 'La miopía progresa más en la infancia. Ofrecemos estrategias efectivas: ortoqueratología, lentes blandas de control y lentes oftálmicos especiales para frenar su avance.',
                'icon'              => 'heroicon-o-eye-dropper',
                'sort_order'        => 8,
                'cta_text'          => 'Consultar para mi hijo/a',
                'cta_whatsapp_text' => 'Hola, mi hijo/a tiene miopía y quisiera información sobre cómo controlar su progresión.',
                'meta_title'        => 'Control de Miopía Infantil en Tumbaco | Óptica Andina',
                'meta_description'  => 'Tratamientos para frenar la miopía en niños en Tumbaco. Ortoqueratología, lentes de control y lentes especiales.',
                'faqs'              => [
                    ['question' => '¿A partir de qué graduación se recomienda el control?', 'answer' => 'Se recomienda cuando hay progresión rápida (más de 0.50D por año), independientemente del grado actual.'],
                    ['question' => '¿Es segura la ortoqueratología para niños?', 'answer' => 'Sí. Está aprobada para niños y adolescentes con amplia evidencia de seguridad y eficacia.'],
                    ['question' => '¿Cuándo se estabiliza la miopía?', 'answer' => 'Generalmente alrededor de los 18-25 años. El control busca reducir la progresión durante los años de mayor riesgo.'],
                ],
                'content'           => '<p>La miopía es considerada una epidemia global. Las miopías altas aumentan significativamente el riesgo de problemas graves en la adultez. El control de miopía busca reducir la velocidad de progresión.</p>
<h2>Estrategias disponibles</h2>
<h3>Ortoqueratología (Orto-K)</h3>
<p>Lentes de uso nocturno que remodelan la córnea. Ha demostrado reducir la progresión hasta en un 50%.</p>
<h3>Lentes de contacto de control</h3>
<p>Diseños como MiSight que producen desenfoque periférico para frenar el crecimiento axial del ojo.</p>
<h3>Lentes oftálmicos especiales</h3>
<p>Diseños DIMS o similares, en formato de gafas, ideales para niños que aún no usan lentes de contacto.</p>
<h3>Atropina de baja concentración</h3>
<p>Colirio al 0.01% que ha demostrado frenar la progresión, generalmente combinado con otras estrategias.</p>',
            ],
            [
                'title'             => 'Baja Visión y Rehabilitación',
                'slug'              => 'baja-vision',
                'excerpt'           => 'Evaluación y ayudas ópticas para personas con discapacidad visual que no puede corregirse completamente. Mejoramos la funcionalidad y calidad de vida.',
                'icon'              => 'heroicon-o-magnifying-glass',
                'sort_order'        => 9,
                'cta_text'          => 'Consultar',
                'cta_whatsapp_text' => 'Hola, me interesa el servicio de baja visión. ¿Podrían darme más información?',
                'meta_title'        => 'Baja Visión y Rehabilitación Visual | Óptica Andina Tumbaco',
                'meta_description'  => 'Rehabilitación visual para personas con baja visión en Tumbaco. Ayudas ópticas y estrategias para mejorar la calidad de vida.',
                'faqs'              => [
                    ['question' => '¿Qué se considera baja visión?', 'answer' => 'Cuando la agudeza visual en el mejor ojo, con la mejor corrección posible, es inferior a 3/10, o el campo visual es menor a 20 grados.'],
                    ['question' => '¿Qué tipo de ayudas existen?', 'answer' => 'Lupas de mano y de stand, telescopios para distancia, filtros de alto contraste y tecnologías de asistencia digital.'],
                ],
                'content'           => '<p>La baja visión no puede corregirse completamente con gafas ni cirugía. Con la evaluación y las ayudas adecuadas, sin embargo, la calidad de vida puede mejorar significativamente.</p>
<h2>¿Qué hacemos?</h2>
<h3>Evaluación del potencial visual residual</h3>
<p>Medimos agudeza visual, campo visual, sensibilidad al contraste y visión cromática para conocer con exactitud las capacidades visuales del paciente.</p>
<h3>Prescripción de ayudas ópticas</h3>
<p>Lupas, telescopios montados en gafas, filtros espectrales que mejoran el contraste.</p>
<h3>Entrenamiento y orientación familiar</h3>
<p>Enseñamos la técnica correcta de uso de las ayudas y orientamos a la familia sobre cómo adaptar el entorno doméstico.</p>',
            ],
            [
                'title'             => 'Examen Visual para Conducir',
                'slug'              => 'examen-visual-conducir',
                'excerpt'           => 'Evaluación de los requisitos visuales para conducir con seguridad. Emitimos el certificado oficial requerido para la licencia de conducir en Ecuador.',
                'icon'              => 'heroicon-o-truck',
                'sort_order'        => 10,
                'cta_text'          => 'Agendar evaluación',
                'cta_whatsapp_text' => 'Hola, necesito un examen visual para la licencia de conducir. ¿Qué necesito?',
                'meta_title'        => 'Examen Visual para Conducir en Tumbaco | Óptica Andina',
                'meta_description'  => 'Examen visual para licencia de conducir en Tumbaco. Certificado oficial, campo visual, visión nocturna y más.',
                'faqs'              => [
                    ['question' => '¿Cuáles son los requisitos visuales para conducir en Ecuador?', 'answer' => 'Agudeza visual de al menos 5/10 en cada ojo con corrección, campo visual adecuado y ausencia de visión doble.'],
                    ['question' => '¿El certificado tiene validez?', 'answer' => 'Sí. Te indicamos la vigencia según la normativa vigente al momento del examen.'],
                ],
                'content'           => '<p>Conducir requiere habilidades visuales específicas: percepción de profundidad, visión periférica, visión nocturna y recuperación del deslumbramiento.</p>
<h2>¿Qué evaluamos?</h2>
<ul>
<li>Agudeza visual (requisitos legales)</li>
<li>Visión binocular y estereopsis</li>
<li>Campo visual periférico</li>
<li>Visión nocturna y deslumbramiento</li>
<li>Visión cromática para señales de tráfico</li>
</ul>
<h2>Certificado oficial</h2>
<p>Emitimos el certificado visual para la obtención o renovación de la licencia de conducir, cumpliendo los requisitos del Ministerio de Transporte del Ecuador.</p>',
            ],
            [
                'title'             => 'Reparación y Mantenimiento de Gafas',
                'slug'              => 'reparacion-mantenimiento-gafas',
                'excerpt'           => 'Reparamos y ajustamos todo tipo de monturas. Cambio de plaquetas, soldaduras, ajuste de bisagras y limpieza ultrasónica profesional.',
                'icon'              => 'heroicon-o-wrench-screwdriver',
                'sort_order'        => 11,
                'cta_text'          => 'Traer mis gafas',
                'cta_whatsapp_text' => 'Hola, necesito reparar mis gafas. ¿Pueden revisarlas?',
                'meta_title'        => 'Reparación de Gafas en Tumbaco | Óptica Andina',
                'meta_description'  => 'Reparamos y ajustamos monturas en Tumbaco. Cambio de plaquetas, soldadura, ajuste y limpieza ultrasónica profesional.',
                'faqs'              => [
                    ['question' => '¿Pueden reparar cualquier tipo de montura?', 'answer' => 'Reparamos la mayoría de monturas de metal, acetato y materiales especiales. Algunas reparaciones complejas requieren taller especializado.'],
                    ['question' => '¿Cuánto tarda una reparación?', 'answer' => 'Ajustes menores se realizan en el momento. Soldaduras y reparaciones mayores pueden tomar 24-72 horas.'],
                ],
                'content'           => '<p>Las gafas son instrumentos de precisión que requieren mantenimiento regular para funcionar correctamente y durar mucho tiempo.</p>
<h2>Servicios disponibles</h2>
<h3>Ajuste de montura</h3>
<p>Ajustamos el puente nasal, las patillas y la alineación para máxima comodidad y calidad óptica.</p>
<h3>Cambio de plaquetas nasales</h3>
<p>Las plaquetas deterioradas generan marcas e incomodidad. El cambio regular prolonga la vida de las gafas.</p>
<h3>Soldadura y reparación</h3>
<p>Reparamos fracturas en monturas de metal y algunos materiales especiales.</p>
<h3>Limpieza ultrasónica</h3>
<p>Proceso profesional que elimina sarro, suciedad y bacterias de lugares inaccesibles con limpieza manual.</p>',
            ],
            [
                'title'             => 'Nutrición para la Salud Ocular',
                'slug'              => 'nutricion-salud-ocular',
                'excerpt'           => 'La alimentación impacta directamente en tus ojos. Orientamos sobre los nutrientes que protegen la visión y reducen el riesgo de enfermedades oculares.',
                'icon'              => 'heroicon-o-heart',
                'sort_order'        => 12,
                'cta_text'          => 'Consultar',
                'cta_whatsapp_text' => 'Hola, me interesa la asesoría nutricional para la salud visual. ¿En qué consiste?',
                'meta_title'        => 'Nutrición para la Salud Ocular | Óptica Andina Tumbaco',
                'meta_description'  => 'Consejos de nutrición para proteger tu visión en Tumbaco. Luteína, omega-3 y vitaminas para la salud ocular.',
                'faqs'              => [
                    ['question' => '¿La alimentación realmente afecta la visión?', 'answer' => 'Sí. Dietas ricas en luteína, zeaxantina, omega-3 y antioxidantes reducen significativamente el riesgo de degeneración macular y cataratas.'],
                    ['question' => '¿Debo tomar suplementos para la visión?', 'answer' => 'No necesariamente. Si tu dieta es variada, puede ser suficiente. Los suplementos están indicados con deficiencias específicas o en degeneración macular inicial.'],
                ],
                'content'           => '<p>El ojo es uno de los órganos con mayor actividad metabólica. Su salud depende, en parte, de los nutrientes que recibe.</p>
<h2>Nutrientes clave</h2>
<h3>Luteína y zeaxantina</h3>
<p>Se acumulan en la mácula y actúan como filtro contra la luz azul. Mayor evidencia en prevención de degeneración macular. Fuentes: espinacas, kale, yema de huevo.</p>
<h3>Omega-3 (DHA y EPA)</h3>
<p>El DHA es el principal ácido graso de la retina. Mejoran la calidad lagrimal. Fuentes: salmón, sardinas, nueces, chía.</p>
<h3>Vitaminas C y E</h3>
<p>Antioxidantes que protegen el cristalino y reducen el riesgo de cataratas. Fuentes: naranja, kiwi, almendras, aceite de oliva.</p>
<h3>Zinc y vitamina A</h3>
<p>Esenciales para la función retinal y visión nocturna. Fuentes: zanahoria, hígado, semillas de calabaza.</p>',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                array_merge($service, ['is_active' => true])
            );
        }
    }
}
