<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'       => '¿Con qué frecuencia debes hacerte un examen visual?',
                'slug'        => 'frecuencia-examen-visual',
                'excerpt'     => 'Muchas personas se preguntan cada cuánto tiempo es necesario visitar al optometrista. La respuesta depende de tu edad, estado de salud y factores de riesgo.',
                'image'       => null,
                'tags'        => ['salud visual', 'examen visual', 'prevención'],
                'is_published'=> true,
                'published_at'=> now()->subDays(2),
                'meta_title'  => 'Frecuencia del Examen Visual – ¿Cada Cuánto? | Óptica Vista Andina',
                'meta_description' => 'Descubre con qué frecuencia necesitas un examen visual según tu edad. Consejos de nuestros especialistas en Tumbaco.',
                'content'     => '<h2>La importancia de los exámenes visuales regulares</h2>
<p>La visión es uno de nuestros sentidos más preciados, pero también uno de los más descuidados. Muchas personas solo visitan al optometrista cuando ya notan problemas evidentes: visión borrosa, dolores de cabeza frecuentes o dificultad para leer. Sin embargo, esperar a tener síntomas puede significar que la condición ya está avanzada.</p>

<h2>Frecuencia recomendada por grupo de edad</h2>
<h3>Niños (3 a 12 años)</h3>
<p>El primer examen visual completo debe realizarse alrededor de los 3 años, antes de iniciar la etapa preescolar. A partir de ahí, se recomienda un control anual. Los problemas de visión no corregidos en la infancia pueden afectar significativamente el rendimiento escolar y el desarrollo cognitivo.</p>

<h3>Adolescentes y adultos jóvenes (13 a 40 años)</h3>
<p>Si no usas lentes y no tienes factores de riesgo, un examen cada 2 años es suficiente. Si ya usas corrección óptica, el control debe ser anual para verificar cambios en tu graduación.</p>

<h3>Adultos mayores de 40 años</h3>
<p>A partir de los 40, el riesgo de desarrollar condiciones como cataratas, glaucoma o degeneración macular aumenta considerablemente. Por ello, el examen anual se vuelve imprescindible, independientemente de si usas gafas o no.</p>

<h2>Factores que requieren controles más frecuentes</h2>
<ul>
<li>Diabetes o hipertensión arterial</li>
<li>Historia familiar de glaucoma o degeneración macular</li>
<li>Uso de lentes de contacto</li>
<li>Trabajo prolongado frente a pantallas</li>
<li>Síntomas de ojo seco crónico</li>
</ul>

<h2>Conclusión</h2>
<p>En Óptica Vista Andina te recomendamos no esperar a tener molestias para hacerte revisar. Un examen visual preventivo puede detectar condiciones antes de que afecten tu calidad de vida. ¡Agenda tu cita hoy y cuida tu visión!</p>',
            ],
            [
                'title'       => 'Miopía en niños: señales de alerta y cómo actuar',
                'slug'        => 'miopia-ninos-senales-alerta',
                'excerpt'     => 'La miopía infantil está aumentando a nivel mundial. Aprende a identificar las señales tempranas y qué puedes hacer para proteger la visión de tus hijos.',
                'image'       => null,
                'tags'        => ['miopía', 'salud infantil', 'niños', 'prevención'],
                'is_published'=> true,
                'published_at'=> now()->subDays(5),
                'meta_title'  => 'Miopía en Niños: Señales y Tratamiento | Óptica Vista Andina Tumbaco',
                'meta_description' => '¿Tu hijo se acerca mucho a la pantalla o al libro? Puede ser miopía. Conoce las señales de alerta y cómo actuar.',
                'content'     => '<h2>¿Qué es la miopía y por qué está aumentando?</h2>
<p>La miopía, o vista corta, es una condición en la que los objetos lejanos se ven borrosos mientras que los cercanos se perciben con claridad. En las últimas décadas, su prevalencia ha aumentado dramáticamente, especialmente en niños. Los expertos atribuyen este incremento al mayor tiempo frente a pantallas y la reducción de actividades al aire libre.</p>

<h2>Señales de alerta en niños</h2>
<p>Los niños rara vez se quejan de ver mal, porque no saben que su visión no es normal. Por eso, los padres deben estar atentos a estas señales:</p>
<ul>
<li>Se acerca mucho al televisor, tablet o libro</li>
<li>Entrecierra los ojos para ver de lejos</li>
<li>Se queja de dolores de cabeza frecuentes, especialmente al final del día escolar</li>
<li>Rinde menos en actividades deportivas que requieren ver de lejos</li>
<li>No copia bien del pizarrón</li>
<li>Se distrae fácilmente o muestra desinterés en la escuela</li>
</ul>

<h2>¿Cómo se diagnostica?</h2>
<p>El diagnóstico se realiza mediante un examen visual completo. En niños, es importante la evaluación con dilatación pupilar (cicloplejía) para obtener la graduación real, ya que el ojo infantil tiene gran capacidad de acomodación que puede enmascarar la condición.</p>

<h2>Opciones de tratamiento y control</h2>
<h3>Corrección convencional</h3>
<p>Las gafas graduadas o los lentes de contacto corrigen la visión, pero no detienen la progresión de la miopía.</p>
<h3>Control de miopía</h3>
<p>Existen estrategias específicas para reducir la velocidad de progresión de la miopía en niños: lentes de contacto de ortoceratoligía (uso nocturno), lentes blandas de control de miopía, y lentes oftálmicos con diseños especiales.</p>
<h3>Hábitos de vida</h3>
<p>Se recomienda pasar al menos 90 minutos diarios al aire libre, mantener una distancia adecuada al leer (30-40 cm), y tomar descansos regulares de las pantallas.</p>

<h2>¿Cuándo consultar?</h2>
<p>Si identificas alguna de las señales mencionadas, no esperes. En Óptica Vista Andina contamos con especialistas en control de miopía infantil. Cuanto antes se detecte y trate, mejores serán los resultados a largo plazo.</p>',
            ],
            [
                'title'       => 'Síndrome de visión por computadora: síntomas y soluciones',
                'slug'        => 'sindrome-vision-computadora',
                'excerpt'     => 'El trabajo frente a pantallas durante horas puede causar fatiga visual, dolores de cabeza y ojo seco. Conoce el síndrome de visión por computadora y cómo prevenirlo.',
                'image'       => null,
                'tags'        => ['fatiga visual', 'pantallas', 'trabajo digital', 'ojo seco'],
                'is_published'=> true,
                'published_at'=> now()->subDays(9),
                'meta_title'  => 'Síndrome de Visión por Computadora: Cómo Prevenirlo | Óptica Vista Andina',
                'meta_description' => 'Fatiga visual, dolores de cabeza y ojo seco por usar pantallas. Descubre el síndrome de visión digital y cómo combatirlo.',
                'content'     => '<h2>¿Qué es el síndrome de visión por computadora?</h2>
<p>El síndrome de visión por computadora (SVC), también llamado fatiga visual digital, es un conjunto de síntomas oculares y visuales causados por el uso prolongado de dispositivos electrónicos con pantalla: computadoras, tablets, smartphones y televisores.</p>
<p>Se estima que más del 70% de las personas que trabajan con pantallas más de 4 horas diarias experimentan alguno de sus síntomas.</p>

<h2>Síntomas más comunes</h2>
<ul>
<li><strong>Ojos cansados o pesados</strong> al final del día</li>
<li><strong>Visión borrosa</strong> temporal, especialmente al cambiar de distancia</li>
<li><strong>Ojo seco e irritado</strong>, sensación de arenilla</li>
<li><strong>Dolores de cabeza</strong>, frecuentemente en la frente o sienes</li>
<li><strong>Dolor de cuello y hombros</strong> asociado a la postura frente a la pantalla</li>
<li><strong>Sensibilidad a la luz</strong> (fotofobia)</li>
</ul>

<h2>¿Por qué ocurre?</h2>
<p>Cuando miramos pantallas, parpadeamos hasta un 66% menos de lo normal. El parpadeo es esencial para humedecer la superficie ocular. Además, los pixeles de las pantallas no son tan nítidos como el texto impreso, lo que obliga al ojo a hacer un mayor esfuerzo de enfoque (acomodación).</p>

<h2>Soluciones prácticas</h2>
<h3>La regla 20-20-20</h3>
<p>Cada 20 minutos, mira un objeto a 20 pies (6 metros) de distancia durante 20 segundos. Esto relaja los músculos del ojo.</p>
<h3>Lentes con filtro de luz azul</h3>
<p>Los lentes con tratamiento de luz azul reducen la fatiga visual y pueden mejorar el confort, especialmente en jornadas largas frente a pantallas.</p>
<h3>Ajustes en la pantalla</h3>
<p>Reduce el brillo de la pantalla al nivel del ambiente, aumenta el tamaño de la fuente y posiciona la pantalla ligeramente por debajo del nivel de los ojos.</p>
<h3>Lágrimas artificiales</h3>
<p>En casos de ojo seco, las lágrimas artificiales sin conservantes pueden aliviar la irritación. Consulta con tu optometrista cuál es la más adecuada.</p>

<h2>¿Cuándo visitar al especialista?</h2>
<p>Si los síntomas persisten a pesar de seguir estas recomendaciones, visítanos en Óptica Vista Andina. Podemos evaluar si necesitas corrección óptica específica para trabajo con pantallas o si existe alguna condición subyacente que deba tratarse.</p>',
            ],
            [
                'title'       => 'Glaucoma: el ladrón silencioso de la visión',
                'slug'        => 'glaucoma-ladrón-silencioso-vision',
                'excerpt'     => 'El glaucoma puede robar tu visión sin avisar. Es la segunda causa de ceguera en el mundo y no tiene síntomas en sus etapas iniciales. Solo un examen visual puede detectarlo.',
                'image'       => null,
                'tags'        => ['glaucoma', 'prevención', 'enfermedades oculares', 'adultos'],
                'is_published'=> true,
                'published_at'=> now()->subDays(14),
                'meta_title'  => 'Glaucoma: Prevención y Detección Temprana | Óptica Vista Andina',
                'meta_description' => 'El glaucoma destruye el nervio óptico sin síntomas previos. Descubre los factores de riesgo y la importancia de los controles regulares.',
                'content'     => '<h2>¿Qué es el glaucoma?</h2>
<p>El glaucoma es un grupo de enfermedades oculares que dañan progresivamente el nervio óptico, responsable de transmitir la información visual al cerebro. Es la segunda causa de ceguera irreversible en el mundo, y lo más alarmante es que en la mayoría de los casos no produce síntomas hasta que ya existe un daño considerable.</p>

<h2>¿Por qué se llama "el ladrón silencioso de la visión"?</h2>
<p>El tipo más común, el glaucoma de ángulo abierto, destruye lentamente el campo visual periférico (visión lateral) sin causar dolor ni cambios perceptibles en la visión central. Para cuando el paciente nota algo, puede haber perdido hasta el 40% de su campo visual. Y lo que se pierde no se recupera.</p>

<h2>Factores de riesgo</h2>
<ul>
<li>Mayor de 40 años</li>
<li>Antecedentes familiares de glaucoma</li>
<li>Presión intraocular elevada (hipertensión ocular)</li>
<li>Miopía alta</li>
<li>Uso prolongado de corticosteroides</li>
<li>Diabetes o hipertensión arterial sistémica</li>
<li>Origen africano o hispano (mayor prevalencia)</li>
</ul>

<h2>¿Cómo se detecta?</h2>
<p>La detección requiere un examen ocular completo que incluye:</p>
<ul>
<li>Medición de la presión intraocular (tonometría)</li>
<li>Evaluación del nervio óptico (campimetría)</li>
<li>Revisión del ángulo de drenaje del humor acuoso</li>
</ul>

<h2>Tratamiento</h2>
<p>El glaucoma no tiene cura, pero puede controlarse para detener su progresión. Los tratamientos incluyen colirios reductores de presión, láser o cirugía en casos avanzados.</p>

<h2>La detección temprana es tu mejor defensa</h2>
<p>Si tienes más de 40 años o cualquiera de los factores de riesgo mencionados, un examen visual anual que incluya tonometría es fundamental. En Óptica Vista Andina realizamos evaluaciones completas que incluyen la medición de presión ocular. No esperes a tener síntomas: cuando aparecen, el daño ya está hecho.</p>',
            ],
            [
                'title'       => 'Alimentación y salud visual: los nutrientes que cuidan tus ojos',
                'slug'        => 'alimentacion-salud-visual-nutrientes',
                'excerpt'     => 'Lo que comes tiene un impacto directo en la salud de tus ojos. Descubre qué nutrientes son esenciales para mantener una buena visión y en qué alimentos encontrarlos.',
                'image'       => null,
                'tags'        => ['nutrición', 'salud visual', 'alimentación', 'prevención'],
                'is_published'=> true,
                'published_at'=> now()->subDays(18),
                'meta_title'  => 'Alimentación para una Buena Visión | Óptica Vista Andina Tumbaco',
                'meta_description' => 'Vitaminas, antioxidantes y ácidos grasos que protegen tu visión. Guía de nutrición para la salud ocular.',
                'content'     => '<h2>Tus ojos también se alimentan</h2>
<p>La retina es uno de los tejidos con mayor demanda metabólica del cuerpo. Una alimentación deficiente puede aumentar el riesgo de degeneración macular, cataratas y ojo seco. Por el contrario, una dieta rica en nutrientes específicos puede reducir significativamente estos riesgos.</p>

<h2>Nutrientes clave para la salud ocular</h2>

<h3>Luteína y zeaxantina</h3>
<p>Estos dos carotenoides se concentran en la mácula (zona central de la retina) y actúan como un filtro natural contra la luz azul y los radicales libres. Reducen el riesgo de degeneración macular hasta en un 25%. Se encuentran en: espinacas, kale, brócoli, maíz, yema de huevo y pimientos.</p>

<h3>Vitamina A y beta-caroteno</h3>
<p>Esenciales para la producción de rodopsina, el pigmento visual necesario para ver en condiciones de poca luz. La deficiencia de vitamina A puede causar ceguera nocturna. Fuentes: zanahoria, batata, hígado, leche entera, mango, papaya.</p>

<h3>Ácidos grasos omega-3</h3>
<p>El DHA, un tipo de omega-3, constituye el 50% de los ácidos grasos de la retina. Los omega-3 también reducen la inflamación y alivian el ojo seco. Fuentes: salmón, sardinas, atún, nueces, semillas de chía y lino.</p>

<h3>Vitamina C</h3>
<p>Potente antioxidante que protege el cristalino y reduce el riesgo de cataratas. Fuentes: guayaba, kiwi, naranja, limón, fresa, pimiento rojo.</p>

<h3>Vitamina E</h3>
<p>Junto con la vitamina C, forma la primera línea de defensa antioxidante del ojo. Fuentes: almendras, aceite de oliva, aguacate, semillas de girasol.</p>

<h3>Zinc</h3>
<p>Facilita el transporte de vitamina A al ojo y contribuye a la formación de pigmento protector en la retina. Fuentes: carne roja, mariscos, semillas de calabaza, legumbres.</p>

<h2>El patrón que mejor protege tus ojos</h2>
<p>La dieta mediterránea, rica en frutas, verduras, pescado, aceite de oliva y frutos secos, es el patrón alimentario con más evidencia científica en la protección de la salud ocular a largo plazo.</p>

<h2>¿Y los suplementos?</h2>
<p>En pacientes con degeneración macular en etapa inicial o intermedia, la fórmula AREDS2 (con luteína, zeaxantina, vitaminas C y E, y zinc) ha demostrado reducir el riesgo de progresión. Sin embargo, siempre consulta con tu especialista antes de tomar suplementos.</p>',
            ],
            [
                'title'       => 'Cataratas: qué son, cuándo operarse y qué esperar',
                'slug'        => 'cataratas-cuando-operarse',
                'excerpt'     => 'Las cataratas son la principal causa de ceguera reversible en el mundo. Son tratables con cirugía. Conoce sus síntomas, cuándo es el momento de operar y cómo es la recuperación.',
                'image'       => null,
                'tags'        => ['cataratas', 'cirugía ocular', 'adultos mayores', 'visión'],
                'is_published'=> true,
                'published_at'=> now()->subDays(22),
                'meta_title'  => 'Cataratas: Síntomas, Cirugía y Recuperación | Óptica Vista Andina',
                'meta_description' => 'Todo lo que necesitas saber sobre las cataratas: síntomas, diagnóstico, cirugía y recuperación. Información de nuestros especialistas.',
                'content'     => '<h2>¿Qué son las cataratas?</h2>
<p>El cristalino es el lente natural del ojo, transparente en condiciones normales. Con los años, las proteínas que lo componen se pueden agrupar y opacificar, creando una "nube" que bloquea el paso de la luz. Eso es una catarata.</p>
<p>Es la principal causa de ceguera en el mundo, pero también la más tratable: la cirugía tiene una tasa de éxito superior al 95%.</p>

<h2>Síntomas</h2>
<ul>
<li>Visión nublada, borrosa o con "niebla"</li>
<li>Colores que se ven apagados o amarillentos</li>
<li>Mayor sensibilidad a la luz y reflejos molestos (halos alrededor de las luces)</li>
<li>Visión doble en un ojo</li>
<li>Necesidad frecuente de cambiar la graduación de las gafas</li>
<li>Dificultad para conducir de noche</li>
</ul>

<h2>Factores de riesgo</h2>
<p>El envejecimiento es el principal factor, pero también influyen: exposición solar sin protección, diabetes, tabaquismo, uso prolongado de corticoides y antecedentes familiares.</p>

<h2>¿Cuándo es el momento de operarse?</h2>
<p>No existe un momento único para todos. La decisión depende de cómo la catarata está afectando tu calidad de vida: si ya no puedes conducir con seguridad, leer con comodidad o realizar tus actividades habituales, es el momento de considerar la cirugía.</p>

<h2>La cirugía de cataratas</h2>
<p>La técnica más utilizada es la facoemulsificación: el cristalino opacificado se fragmenta con ultrasonido y se retira por una pequeña incisión (menor a 3mm). Luego se implanta una lente intraocular artificial permanente. La cirugía dura aproximadamente 15 minutos y se realiza con anestesia local.</p>

<h2>Recuperación</h2>
<p>La mayoría de los pacientes nota mejoría visual al día siguiente de la cirugía. La recuperación completa toma entre 4 y 6 semanas. Es necesario usar colirios durante ese período y evitar actividades de riesgo.</p>

<h2>Prevención</h2>
<p>Usa gafas de sol con protección UV, no fumes, controla la diabetes y el azúcar en sangre, y realiza controles visuales anuales a partir de los 50 años.</p>',
            ],
            [
                'title'       => 'Lentes de contacto: mitos y realidades',
                'slug'        => 'lentes-contacto-mitos-realidades',
                'excerpt'     => '¿Los lentes de contacto dañan los ojos? ¿Puedo usarlos si tengo astigmatismo? ¿Es seguro dormir con ellos? Respondemos las preguntas más frecuentes sobre contactología.',
                'image'       => null,
                'tags'        => ['lentes de contacto', 'contactología', 'mitos', 'cuidado ocular'],
                'is_published'=> true,
                'published_at'=> now()->subDays(27),
                'meta_title'  => 'Lentes de Contacto: Mitos y Realidades | Óptica Vista Andina',
                'meta_description' => 'Resolvemos los mitos más comunes sobre los lentes de contacto. ¿Son seguros? ¿Para quién son? Guía completa.',
                'content'     => '<h2>Los lentes de contacto tienen mala fama injustificada</h2>
<p>Hay muchos mitos alrededor de los lentes de contacto que llevan a las personas a rechazarlos sin fundamento. La realidad es que, usados correctamente y bajo supervisión profesional, son una excelente opción para corregir problemas de visión con alta comodidad y libertad.</p>

<h2>Mito 1: "Los lentes de contacto se pueden quedar atrapados detrás del ojo"</h2>
<p><strong>Falso.</strong> La conjuntiva (membrana que recubre el ojo) forma una bolsa cerrada que impide que cualquier objeto pase detrás del globo ocular. En el peor caso, un lente puede desplazarse bajo el párpado, pero se puede extraer fácilmente.</p>

<h2>Mito 2: "No puedo usar lentes de contacto porque tengo astigmatismo"</h2>
<p><strong>Falso.</strong> Existen lentes de contacto tóricos específicamente diseñados para corregir el astigmatismo. Hoy la gran mayoría de personas con astigmatismo puede usar lentes de contacto.</p>

<h2>Mito 3: "Los lentes de contacto dañan los ojos con el tiempo"</h2>
<p><strong>Solo si se usan mal.</strong> Los problemas oculares asociados a los lentes de contacto casi siempre se deben a mal uso: dormir con ellos puestos, no cambiarlos cuando corresponde, no limpiarlos correctamente o usar soluciones inadecuadas. Con el uso correcto, son muy seguros.</p>

<h2>Mito 4: "Es peligroso dormirse con los lentes"</h2>
<p><strong>Verdad a medias.</strong> Dormir con la mayoría de los lentes de contacto blandos diarios o mensuales reduce el aporte de oxígeno a la córnea y aumenta el riesgo de infecciones. Sin embargo, existen lentes de uso continuo (silicona hidrogel) específicamente aprobados para usar hasta 30 días sin retirar, bajo prescripción.</p>

<h2>Mito 5: "Los lentes de contacto solo son para jóvenes"</h2>
<p><strong>Falso.</strong> Personas de todas las edades pueden usar lentes de contacto. Para la presbicia (vista cansada), existen lentes multifocales o progresivos que permiten ver bien a todas las distancias.</p>

<h2>¿Cómo sé si soy candidato/a?</h2>
<p>La adaptación de lentes de contacto requiere una evaluación profesional. En Óptica Vista Andina realizamos un estudio completo de la córnea para determinar el tipo y diámetro de lente más adecuado para ti. ¡Agenda tu cita!</p>',
            ],
            [
                'title'       => 'Ojo seco: causas, síntomas y tratamiento',
                'slug'        => 'ojo-seco-causas-sintomas-tratamiento',
                'excerpt'     => 'El ojo seco afecta a millones de personas y puede volverse crónico si no se trata. Conoce sus causas, síntomas y las opciones de tratamiento disponibles.',
                'image'       => null,
                'tags'        => ['ojo seco', 'lágrima', 'confort ocular', 'tratamiento'],
                'is_published'=> true,
                'published_at'=> now()->subDays(32),
                'meta_title'  => 'Ojo Seco: Causas y Tratamiento | Óptica Vista Andina Tumbaco',
                'meta_description' => 'Síntomas de ojo seco, por qué ocurre y qué tratamientos existen. Información de nuestros especialistas en Tumbaco.',
                'content'     => '<h2>¿Qué es el ojo seco?</h2>
<p>El síndrome de ojo seco ocurre cuando los ojos no producen suficientes lágrimas, o cuando las lágrimas producidas son de mala calidad y se evaporan demasiado rápido. Es una de las consultas más frecuentes en optometría y afecta significativamente la calidad de vida.</p>

<h2>La película lagrimal: más compleja de lo que parece</h2>
<p>La lágrima no es simplemente agua. Está compuesta por tres capas: la capa lipídica (exterior, evita la evaporación), la capa acuosa (intermedia, nutre y lubrica) y la capa mucínica (interior, adhiere la lágrima a la córnea). Un problema en cualquiera de estas capas puede causar ojo seco.</p>

<h2>Síntomas</h2>
<ul>
<li>Sensación de arenilla o cuerpo extraño</li>
<li>Ardor o picazón ocular</li>
<li>Enrojecimiento</li>
<li>Visión borrosa intermitente que mejora al parpadear</li>
<li>Lagrimeo excesivo (paradójico, pero frecuente)</li>
<li>Intolerancia a lentes de contacto o al viento</li>
<li>Fotosensibilidad</li>
</ul>

<h2>Causas más frecuentes</h2>
<ul>
<li>Envejecimiento (la producción lagrimal disminuye con la edad)</li>
<li>Uso prolongado de pantallas (parpadeo reducido)</li>
<li>Ambientes secos, con aire acondicionado o calefacción</li>
<li>Uso de lentes de contacto</li>
<li>Medicamentos: antihistamínicos, antidepresivos, anticonceptivos orales</li>
<li>Enfermedades autoinmunes (síndrome de Sjögren, artritis reumatoide)</li>
<li>Menopausia</li>
<li>Cirugías oculares previas (LASIK)</li>
</ul>

<h2>Tratamiento</h2>
<h3>Lágrimas artificiales</h3>
<p>El primer paso es la lubricación con lágrimas artificiales sin conservantes. Existen diferentes formulaciones según el tipo de deficiencia lagrimal.</p>
<h3>Tapones lagrimales</h3>
<p>En casos moderados a severos, se pueden colocar pequeños tapones (punctal plugs) en los conductos lagrimales para retener la lágrima natural más tiempo.</p>
<h3>Cambios de hábitos</h3>
<p>Aumentar el parpadeo consciente, tomar descansos frecuentes de las pantallas, usar humidificadores y gafas protectoras en ambientes ventosos.</p>

<h2>La importancia del diagnóstico profesional</h2>
<p>No todos los ojos secos son iguales. El tipo de tratamiento depende de cuál capa lagrimal está afectada. En Óptica Vista Andina evaluamos la calidad y cantidad de tu lágrima para recomendar el tratamiento más adecuado para tu caso.</p>',
            ],
            [
                'title'       => 'Cómo elegir las gafas perfectas según tu forma de rostro',
                'slug'        => 'elegir-gafas-forma-rostro',
                'excerpt'     => 'La forma de tu rostro es el factor más importante para elegir unas gafas que te queden bien. Descubre qué estilos de montura favorecen a cada tipo de rostro.',
                'image'       => null,
                'tags'        => ['monturas', 'estilo', 'moda óptica', 'asesoría'],
                'is_published'=> true,
                'published_at'=> now()->subDays(37),
                'meta_title'  => 'Gafas según tu Forma de Rostro | Óptica Vista Andina Tumbaco',
                'meta_description' => 'Guía para elegir las gafas perfectas según la forma de tu rostro: ovalado, redondo, cuadrado, corazón.',
                'content'     => '<h2>La montura correcta puede transformar tu imagen</h2>
<p>Elegir unas gafas no es solo una decisión visual: es una decisión estética que impacta directamente en tu imagen. La regla de oro es encontrar una montura cuya forma contraste armónicamente con la tuya.</p>

<h2>¿Cómo determinar la forma de tu rostro?</h2>
<p>Recoge el cabello, mírate en el espejo y traza mentalmente el contorno de tu cara. Las formas básicas son: ovalada, redonda, cuadrada, rectangular, corazón (o triangular invertido) y diamante.</p>

<h2>Rostro ovalado</h2>
<p>Es considerada la forma "ideal" porque se adapta a casi todos los estilos. El equilibrio entre frente y mandíbula, con pómulos ligeramente marcados, permite usar desde monturas cuadradas hasta redondas. Recomendación: cualquier estilo, aunque los cuadrados y rectangulares suelen favorecerles especialmente.</p>

<h2>Rostro redondo</h2>
<p>Las mejillas llenas y la frente y mentón de anchura similar necesitan monturas que aporten ángulos y alarguen el rostro visualmente. Recomendación: monturas rectangulares, angulares o geométricas. Evitar: monturas redondas o muy pequeñas.</p>

<h2>Rostro cuadrado</h2>
<p>La frente ancha, mandíbula marcada y mejillas rectas son sus características. Las monturas que suavizan los ángulos del rostro son las más favorecedoras. Recomendación: monturas ovaladas, redondas o con esquinas suavizadas. Evitar: monturas cuadradas o muy angulares.</p>

<h2>Rostro corazón</h2>
<p>Frente ancha que se estrecha hacia un mentón puntiagudo. El objetivo es equilibrar la parte inferior. Recomendación: monturas más anchas en la parte inferior, como los ojo de gato invertidos o las aviador. Evitar: monturas demasiado anchas en la parte superior.</p>

<h2>Rostro rectangular o alargado</h2>
<p>La longitud del rostro es mayor que su anchura. Las monturas profundas (con mucha altura) y anchas ayudan a "acortar" visualmente el rostro. Recomendación: monturas grandes, redondas o cuadradas con suficiente altura. Evitar: monturas muy pequeñas o estrechas.</p>

<h2>Más allá de la forma</h2>
<p>El color de la montura también importa. Los tonos que contrastan con el tono de piel suelen ser los más favorecedores. Considera también tu estilo de vida: las monturas de acetato grueso son más resistentes para el uso diario activo.</p>

<h2>Tu asesor en Óptica Vista Andina</h2>
<p>En nuestra óptica en Tumbaco te asesoramos personalmente para encontrar la montura que mejor realce tus rasgos. ¡Visítanos y pruébate cuantas quieras sin compromiso!</p>',
            ],
            [
                'title'       => 'Protección solar para tus ojos: por qué importa todo el año',
                'slug'        => 'proteccion-solar-ojos',
                'excerpt'     => 'La radiación UV no solo daña la piel: también puede causar cataratas, pterigion y degeneración macular. Aprende a proteger tus ojos del sol correctamente.',
                'image'       => null,
                'tags'        => ['protección UV', 'gafas de sol', 'prevención', 'cataratas'],
                'is_published'=> true,
                'published_at'=> now()->subDays(42),
                'meta_title'  => 'Protección Solar para los Ojos | Óptica Vista Andina Tumbaco',
                'meta_description' => 'La radiación UV daña los ojos a largo plazo. Cómo elegir gafas de sol con protección real y por qué usarlas todo el año.',
                'content'     => '<h2>El sol y tus ojos: una relación de largo plazo</h2>
<p>En Ecuador, con su posición geográfica cerca de la línea ecuatorial y las elevaciones de la sierra, la radiación UV es significativamente más intensa que en muchos otros países. Quito y sus valles como Tumbaco y Cumbayá presentan índices UV extremos gran parte del año.</p>

<h2>¿Qué daño puede causar la radiación UV en los ojos?</h2>
<h3>Cataratas</h3>
<p>La exposición acumulada al sol es uno de los principales factores de riesgo para el desarrollo de cataratas. La protección desde jóvenes puede retrasar su aparición significativamente.</p>
<h3>Pterigion</h3>
<p>Es un crecimiento anormal de tejido conjuntival sobre la córnea, directamente relacionado con la exposición UV. Es más frecuente en personas que trabajan al aire libre.</p>
<h3>Degeneración macular</h3>
<p>La luz azul y UV aceleran el daño oxidativo en la mácula (la zona central de la retina), aumentando el riesgo de degeneración macular asociada a la edad.</p>
<h3>Fotoqueratitis</h3>
<p>Es la "quemadura solar" de la córnea. Causa dolor intenso, lagrimeo y fotosensibilidad. Ocurre después de exposiciones sin protección en nieve, playas o ambientes con mucho reflejo solar.</p>

<h2>¿Cómo elegir gafas de sol con protección real?</h2>
<p>No todas las gafas de sol protegen igual. Para que sean efectivas deben cumplir:</p>
<ul>
<li><strong>Certificación UV400</strong>: bloquean el 99-100% de la radiación UVA y UVB</li>
<li><strong>Lente de calidad</strong>: sin distorsiones ni burbujas que alteren la visión</li>
<li><strong>Cobertura adecuada</strong>: las formas wrap-around o grandes protegen mejor la zona periocular</li>
<li><strong>Oscurecimiento no equivale a protección</strong>: una lente muy oscura sin filtro UV puede ser peor que una sin gafas, porque dilata la pupila y deja entrar más radiación UV</li>
</ul>

<h2>Los niños también necesitan protección</h2>
<p>El cristalino de los niños es más transparente y transmite más UV hacia la retina que el de los adultos. Acostumbrarlos a usar gafas de sol desde pequeños es una inversión en su salud visual futura.</p>

<h2>No solo en verano ni en días soleados</h2>
<p>Las nubes no bloquean el UV: hasta el 80% de la radiación penetra en días nublados. Además, la nieve y el agua reflejan y amplifican la radiación. Las gafas de sol son necesarias todo el año.</p>',
            ],
            [
                'title'       => 'Terapia visual: ejercicios para mejorar la visión sin cirugía',
                'slug'        => 'terapia-visual-ejercicios',
                'excerpt'     => 'La terapia visual es un programa personalizado de ejercicios que mejora la eficiencia del sistema visual. Descubre para qué sirve y quiénes se pueden beneficiar.',
                'image'       => null,
                'tags'        => ['terapia visual', 'estrabismo', 'convergencia', 'visión binocular'],
                'is_published'=> true,
                'published_at'=> now()->subDays(48),
                'meta_title'  => 'Terapia Visual: Ejercicios para una Mejor Visión | Óptica Vista Andina',
                'meta_description' => 'Qué es la terapia visual, para quién es y qué condiciones trata. Especialistas en terapia visual en Tumbaco.',
                'content'     => '<h2>¿Qué es la terapia visual?</h2>
<p>La terapia visual es un programa supervisado de ejercicios y actividades diseñados para mejorar el sistema visual más allá de la simple corrección óptica. A diferencia de las gafas, que compensan los problemas de refracción, la terapia visual busca mejorar las habilidades visuales que afectan la eficiencia visual en tareas cotidianas como leer, conducir o practicar deportes.</p>

<h2>¿Qué condiciones trata?</h2>
<h3>Problemas de visión binocular</h3>
<p>La insuficiencia de convergencia (dificultad para acercar los ojos al leer) es una de las condiciones más comunes y mejor tratadas con terapia visual. Causa síntomas como dolores de cabeza, visión doble al leer y dificultad de concentración.</p>
<h3>Estrabismo funcional</h3>
<p>En ciertos tipos de estrabismo (ojos desviados), la terapia visual puede mejorar o eliminar la desviación sin necesidad de cirugía.</p>
<h3>Ambliopía (ojo vago)</h3>
<p>Cuando el cerebro "ignora" uno de los ojos, la terapia visual junto con el oclusor es el tratamiento de elección para recuperar la agudeza visual del ojo ambliope.</p>
<h3>Dificultades de aprendizaje relacionadas con la visión</h3>
<p>Muchos niños diagnosticados con problemas de atención o dificultades lectoras tienen, subyacente, un problema de eficiencia visual no diagnosticado. La terapia visual puede marcar una diferencia significativa en su rendimiento escolar.</p>

<h2>¿Cómo funciona?</h2>
<p>El programa se diseña individualmente para cada paciente tras una evaluación exhaustiva de las habilidades visuales. Consiste en sesiones semanales en consulta y ejercicios diarios en casa. La duración varía entre 3 y 12 meses dependiendo de la condición.</p>

<h2>¿Tiene evidencia científica?</h2>
<p>Sí. La American Optometric Association y múltiples estudios clínicos, incluyendo el CITT (Convergence Insufficiency Treatment Trial), demuestran la eficacia de la terapia visual para las condiciones binoculares.</p>

<h2>¿Quiénes se benefician más?</h2>
<p>Niños con problemas escolares no explicados por otros factores, adultos con fatiga visual crónica que no mejora con gafas, y pacientes en rehabilitación tras traumatismos craneoencefálicos o accidentes cerebrovasculares.</p>',
            ],
            [
                'title'       => 'Lentes progresivos: guía completa para nuevos usuarios',
                'slug'        => 'lentes-progresivos-guia-nuevos-usuarios',
                'excerpt'     => '¿Tu médico te ha recetado lentes progresivos y no sabes qué esperar? Esta guía te explica cómo funcionan, cómo acostumbrarse y por qué valen la pena.',
                'image'       => null,
                'tags'        => ['presbicia', 'lentes progresivos', 'vista cansada', 'adultos'],
                'is_published'=> true,
                'published_at'=> now()->subDays(54),
                'meta_title'  => 'Lentes Progresivos: Guía para Principiantes | Óptica Vista Andina',
                'meta_description' => 'Todo sobre los lentes progresivos: cómo funcionan, período de adaptación, ventajas y consejos para nuevos usuarios.',
                'content'     => '<h2>¿Qué son los lentes progresivos?</h2>
<p>Los lentes progresivos son lentes multifocales que incorporan en una misma lente la graduación para ver de lejos (parte superior), de cerca (parte inferior) y distancias intermedias como la pantalla del computador (zona de transición). A diferencia de los bifocales, no tienen línea visible, lo que los hace más estéticos y naturales.</p>

<h2>¿Para quién son?</h2>
<p>Para las personas que han desarrollado presbicia, la llamada "vista cansada". A partir de los 40-45 años, el cristalino pierde elasticidad y se hace más difícil enfocar de cerca. Los progresivos permiten ver bien a todas las distancias sin necesidad de ponerse y quitarse las gafas.</p>

<h2>El período de adaptación</h2>
<p>Es normal que las primeras semanas requieran un período de adaptación. Algunos experimentan:</p>
<ul>
<li>Leve mareo o inestabilidad al caminar</li>
<li>Distorsiones en los bordes del campo visual</li>
<li>Necesidad de mover más la cabeza para enfocar</li>
</ul>
<p>Esto es completamente normal y suele resolverse en 1-2 semanas. Si los síntomas persisten o son muy intensos, consulta a tu óptico para verificar la graduación y la posición de montaje.</p>

<h2>Consejos para adaptarse más rápido</h2>
<ul>
<li>Úsalos todo el día desde el principio, sin alternar con gafas antiguas</li>
<li>Para leer, baja ligeramente la cabeza en lugar de solo los ojos</li>
<li>Para la pantalla, posiciona el monitor ligeramente por debajo del nivel de los ojos</li>
<li>Al bajar escaleras, baja la cabeza para usar la parte superior del lente</li>
<li>Evita usarlos inicialmente para actividades que requieran mucho movimiento lateral</li>
</ul>

<h2>No todos los progresivos son iguales</h2>
<p>La tecnología del diseño del lente progresivo hace una gran diferencia en la facilidad de adaptación y el confort visual. Los diseños de última generación (diseño libre o "free-form") están optimizados digitalmente para cada paciente, con zonas de visión más amplias y distorsiones mínimas.</p>

<h2>¿Vale la pena la inversión?</h2>
<p>Los progresivos de calidad requieren una inversión mayor, pero la diferencia en confort y facilidad de adaptación es significativa. En Óptica Vista Andina te ayudamos a elegir el diseño adecuado para tu graduación y estilo de vida.</p>',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
