<?php



// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Chatbot_Wp_Istg_Helpers
 *
 * This class contains repetitive functions that
 * are used globally within the plugin.
 *
 * @package		CHATBOTWP
 * @subpackage	Classes/Chatbot_Wp_Istg_Helpers
 * @author		Anderson Sinaluisa
 * @since		1.0.0
 */

 class Chatbot_Wp_Istg_Question{

    private $id;
    public $text;
    private $answers;

    private $table_name = 'chatbot_wp_istg_questions';

    public function __construct($id = null, $text = null, $answers = null){
        $this->id = $id;
        $this->text = $text;
        $this->answers = $answers;
    }


    public function get_id(){
        return $this->id;
    }

    public function get_text(){
        return $this->text;
    }

    public function get_answers(){
        return $this->answers;
    }

    public function set_id($id){
        $this->id = $id;
    }

    public function set_text($text){
        $this->text = $text;
    }

    public function set_answers($answers){
        $this->answers = $answers;
    }

    public static function get_all(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'chatbot_wp_istg_questions';
        $results = $wpdb->get_results("SELECT * FROM $table_name");
        //return instances of the class
        $list = array();
        foreach($results as $result){
            $question = new Chatbot_Wp_Istg_Question();
            $question->set_id($result->id);
            $question->set_text($result->text);
            $list[] = $question;
        }
        return $list;
    }

    public static function get_by_id($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'chatbot_wp_istg_questions';
        $result = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
        //return instances of the class
        $question = new Chatbot_Wp_Istg_Question();
        $question->set_id($result->id);
        $question->set_text($result->text);
        return $question;
    }


    public function save(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'chatbot_wp_istg_questions';
        $wpdb->insert(
            $table_name,
            array(
                'text' => $this->text,
                'answer' => $this->answers
            )
        );

        $this->id = $wpdb->insert_id;
    }

    public function update(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'chatbot_wp_istg_questions';
        $wpdb->update(
            $table_name,
            array(
                'text' => $this->text
            ),
            array(
                'id' => $this->id
            )
        );

        $this->id = $wpdb->insert_id;
    }


    public function delete(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'chatbot_wp_istg_questions';
        $wpdb->delete(
            $table_name,
            array(
                'id' => $this->id
            )
        );
    }

    public static function setup(){
        global $wpdb;
        error_log('setup function');

        $table_name = $wpdb->prefix . 'chatbot_wp_istg_questions';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            text VARCHAR(255) NOT NULL,
            answer VARCHAR(255) NOT NULL
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        
        if ($wpdb->last_error) {
            echo "Error al crear la tabla: " . $wpdb->last_error;
        }

        Chatbot_Wp_Istg_Question::seed();
    }


    public static function drop(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'chatbot_wp_istg_questions';
        $sql = "DROP TABLE IF EXISTS $table_name;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
 * Prevents unnecessary re-creating index and repetitive altering table operations when using WordPress dbDelta function
 *
 * Usage Example:
 *
 * $table_name      = "ratings";
 *
 * $table_columns   = "id INT(6) UNSIGNED AUTO_INCREMENT,
 *                  rate tinyint(1) NOT NULL,
 *                  ticket_id bigint(20) NOT NULL,
 *                  response_id bigint(20) NOT NULL,
 *                  created_at TIMESTAMP";
 *
 * $table_keys      = "PRIMARY KEY (id),
 *                  KEY ratings_rate (rate),
 *                  UNIQUE KEY ratings_response_id (response_id)";
 *
 * create_table($table_name, $table_columns, $table_keys);
 *
 * Things that need to be considered when using dbDelta function :
 *
 * You must put each field on its own line in your SQL statement.
 * You must have two spaces between the words PRIMARY KEY and the definition of your primary key.
 * You must use the key word KEY rather than its synonym INDEX and you must include at least one KEY.
 * You must not use any apostrophes or backticks around field names.
 * Field types must be all lowercase.
 * SQL keywords, like CREATE TABLE and UPDATE, must be uppercase.
 * You must specify the length of all fields that accept a length parameter. int(11), for example.
 *
 * Further information can be found on here:
 *
 * http://codex.wordpress.org/Creating_Tables_with_Plugins
 *
 * @param $table_name
 * @param $table_columns
 * @param null $table_keys
 * @param null $charset_collate
 * @version 1.0.1
 * @author Ugur Mirza Zeyrek
 */
public static function create_table($table_name, $table_columns, $table_keys = null, $db_prefix = true, $charset_collate = null) {
    global $wpdb;

    if($charset_collate == null)
        $charset_collate = $wpdb->get_charset_collate();
    $table_name = ($db_prefix) ? $wpdb->prefix.$table_name : $table_name;
    $table_columns = strtolower($table_columns);

    if($table_keys)
        $table_keys =  ", $table_keys";

    $table_structure = "( $table_columns $table_keys )";

    $search_array = array();
    $replace_array = array();

    $search_array[] = "`";
    $replace_array[] = "";

    $table_structure = str_replace($search_array,$replace_array,$table_structure);

    $sql = "CREATE TABLE $table_name $table_structure $charset_collate;";

    // Rather than executing an SQL query directly, we'll use the dbDelta function in wp-admin/includes/upgrade.php (we'll have to load this file, as it is not loaded by default)
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

    // The dbDelta function examines the current table structure, compares it to the desired table structure, and either adds or modifies the table as necessary
    return dbDelta($sql);
}

    public static function seed(){
        $data = json_decode('[{"tema":"Instituto Superior Tecnológico Guayaquil\n    Ayuda\n    hola\n    buenas tardes\n    buenas noches\n    buenos días\n    Saludo Inicial\n    Información\n    Programas de estudio\n    Requisitos de ingreso","respuesta":"_SALUDO_, gracias por escribir al Instituto Superior Tecnológico Guayaquil. ¿Cómo podemos ayudarle?"},{"tema":"Problema\n    Caso anterior\n    Número de cédula\n    Ayuda\n    Consulta de Casos o Requerimiento Anterior\n    Revisión","respuesta":"_SALUDO_, indíquenos su número de cédula para revisar su caso."},{"tema":"Oferta académica\n    Carreras disponibles\n    Plan de estudios\n    Oferta de Carreras\n    Desarrollo de Software\n    Requisitos de inscripción","respuesta":"_SALUDO_ , para el periodo 2023-1, el Tecnológico Guayaquil oferto las siguientes carreras:\n• Desarrollo de Software (modalidad hibrida)\n• Diseño Gráfico (presencial)\n• Marketing (presencial)\nEn el siguiente enlace: https://istg.edu.ec/ opción oferta académica, podrá encontrar más información sobre nuestras carreras. Al finalizar obtienen su Título de Tecnólogo, considerado de Tercer Nivel.\nEl único requisito para ingresar a un Instituto de Educación Superior Pública como el Tecnológico Guayaquil, es realizar el proceso de acceso a la Educación Superior de Senescyt, es decir, cumplir con el registro nacional www.registrounicoedusup.gob.ec, inscribirse, rendir el examen de admisión, postular por un cupo, obtenerlo y aceptarlo."},{"tema":"Oferta académica\n    Carreras disponibles\n    Plan de estudios\n    Oferta de Carreras \n    Desarrollo de Software\n    Requisitos de inscripción","respuesta":"Agradecemos su interés por nuestra institución por lo que le solicitamos amablemente su nombre y correo electrónico para enviarle información adicional de las carreras y servicios que ofrecemos."},{"tema":"Postulación\n    Inscripción\n    Plazos\n    Proceso de admisión\n    Oferta de Carreras \n    Información actualizada","respuesta":"Muchas gracias, por este medio lo mantendremos informado sobre el proceso de acceso a la Educación Superior."},{"tema":"Postulación\n    Inscripción\n    Plazos\n    Proceso de admisión\n    Proceso de Admisión Cumplido el Registro\n    Información actualizada","respuesta":"_SALUDO_. Si usted completo el proceso de Registro Único de Senescyt y la inscripción este periodo 2023-1, debe estar atento a las redes sociales institucionales y esperar el 3er, paso de este proceso, test de conocimiento y aptitudes."},{"tema":"Registro en Senescyt\n    Proceso de admisión\n    Comunicación con Senescyt\n    Información\n    Dudas sobre el Proceso de Registro Nacional y Admisión de Senescyt\n    Preguntas","respuesta":"_SALUDO_, Si usted completo el proceso de Registro Único de Senescyt este periodo 2023-1, desde el 1 al 5 de febrero podrás inscribirte para participar en el proceso de admisión de los Institutos Tecnológicos con proceso asistido por parte de la Senescyt. Pronto se publicará más información con todos los pasos a seguir."},{"tema":"¿Retirarse de asignatura\n    Plazo\n    Proceso de retiro\n    Solicitud\n    Retiro Voluntario\n    Instrucciones","respuesta":"_SALUDO_, recuerde que este proceso lo realiza directamente Senecyt. Para más información puede comunicarse 08:00 a 16:30 en la plataforma https://siau.senescyt.gob.ec/"},{"tema":"Situación de fuerza mayor\n    Solicitud de retiro\n    Plazo\n    Procedimiento\n    Instrucciones","respuesta":"_SALUDO_, en el siguiente enlace podrá encontrar el manual de retiro voluntario: https://istg.edu.ec/descargas/"},{"tema":"Situación de fuerza mayor\n    Solicitud de retiro\n    Plazo\n    Procedimiento\n    Retiro Fuerza Mayor\n    Instrucciones","respuesta":"Se ha enviado a su correo institucional la solicitud de retiro por fuerza mayor"},{"tema":"Situación de fuerza mayor\n    Solicitud de retiro\n    Plazo\n    Procedimiento\n    \n    Instrucciones","respuesta":"El plazo de recepción de solicitudes de retiro voluntario y de fuerza mayor ya culmino para este periodo 2022-2."},{"tema":"Matriculación\n    Proceso de ingreso\n    Calendario\n    Retiro Fuera de Plazo Establecido\n    Canales oficiales\n    Información","respuesta":"Obtuviste un cupo y lo aceptaste.\n✨✨Bienvenido a la Comunidad ISTG✨✨\nNos llena de alegría que seas parte de esta gran familia.\nRecuerda:\n▶️ El proceso de matriculación estima empezar una vez culminen todos los periodos de postulación y aceptación de cupo realizado por Senescyt.\n▶️ No es necesario acercarte de manera presencial a ninguna de nuestras sedes.\n▶️ Mantente informado por los canales oficiales (página web - redes sociales), sobre el calendario y los procesos de ingreso. Pronto se publicará más información al respecto."},{"tema":"Retiro del Instituto\n    Proceso de postulación\n    Registro Nacional\n    Senescyt\n    Comunicación","respuesta":"_SALUDO_, hasta el periodo 2022-2 el proceso que debía realizar era el Retorno al Acceso a la Educación Superior de Senescyt, donde podía habilitar su cuenta o habilitación su nota para volver a realizar el proceso de postulación.  Actualmente debe realizar el Registro Nacional en la plataforma www.registrounicoedusup.gob.ec y luego seguir los pasos que se indicarán. Esto es obligatorio. \nRecuerde que este proceso lo realiza directamente Senecyt. Para más información puede comunicarse 08:00 a 16:30 en la plataforma https://siau.senescyt.gob.ec/"},{"tema":"Cuenta de usuario\n    Acceso a plataforma\n    Proveedor de credenciales\n    Correo recibido\n    Crendenciales\n    Carnet\n    Información de acceso","respuesta":"_SALUDO_, debe enviar un correo a comunicados@istg.edu.ec para que lo puedan asistir. Recuerde incluir sus datos (Cédula, nombre completo y carrera) y su consulta."},{"tema":"Clave olvidada\n    Soporte técnico\n    Correo de soporte\n    Sistema académico\n    Inconveniente","respuesta":"_SALUDO_, debe comunicarse al correo: soporte_correos@istg.edu.ec desde su correo personal para que lo puedan asistir. Recuerde incluir sus datos, carrera, correo institucional y breve descripción del inconveniente."},{"tema":"Costo de matrícula\n    Segunda carrera\n    Pago de asignaturas\n    Gratuidad\n    Costo por semestre","respuesta":"Si es su primer cupo aceptado en una IES pública la educación es gratuita, caso contrario deberá cancelar un valor por asignatura definido por Senescyt una vez al inicio de cada semestre."},{"tema":"Costo aproximado\n    Tarifas\n    Pago semestral\n    Valor a pagar\n    Tarifas de asignaturas","respuesta":"El valor aproximado es de $200 a $300 una vez al inicio de cada semestre. Una vez se habilite la plataforma SIAU podrá visualizar este valor."},{"tema":"Clave siga, correo, aula virtual, correo institucional, etc.","respuesta":"_SALUDO_, debe comunicarse al correo: soporte_siga@istg.edu.ec para que lo puedan asistir. Recuerde escribir su nombre completo, cédula, carrera y detalle de su inconveniente."},{"tema":"Acceso aula virtual\n    Configuración en celular\n    Problemas de acceso\n    Requisitos de sistema\n    Ayuda técnica","respuesta":"https://www.instagram.com/reel/Cljr2BsrGXY/?utm_source=ig_web_copy_link\n\n_SALUDO_, debe seguir los pasos indicados en el video, para más información debe comunicarse con el gestor de sistemas de su carrera para que lo puedan asistir. (Recuerde incluir sus datos, carrera, descripción del inconveniente y captura de pantalla)."},{"tema":"Configuración avanzada\n    Acceso seguro\n    Conexión privada\n    Acceso a plataforma\n    Instrucciones","respuesta":"_SALUDO_, debe dar clic en configuración avanzada y luego dar clic en acceder."},{"tema":"Instituto en Ambato\n    Institución en Ambato\n    Contactar ISTG Ambato\n    Información local\n    Distinción entre instituciones","respuesta":"_SALUDO_. Usted se está comunicando con el Instituto Superior Tecnológico Guayaquil de la ciudad de Guayaquil. Debe comunicarse directamente con ellos. Somos dos Instituciones completamente diferentes e independientes."},{"tema":"Manuales de procesos\n    Descarga de manuales\n    Documentación oficial\n    Guías de ayuda\n    Procedimientos detallados","respuesta":"_SALUDO_, en el siguiente enlace podrá encontrar el manual solicitado: https://istg.edu.ec/descargas/"},{"tema":"Homologación de asignaturas\n    Plazo vencido\n    Proceso fuera de tiempo\n    Solicitud de homologación\n    Requisitos de homologación","respuesta":"_SALUDO_, el plazo de recepción de solicitudes de homologación para el periodo 2022-2 ya culmino, debe esperar al próximo semestre y enviar la solicitud dentro del plazo establecido.\nEn el siguiente enlace podrá encontrar el manual de homologación: https://istg.edu.ec/descargas/ Sugerimos revisar que cumpla con todos los requisitos mencionados."},{"tema":"Homologación de asignaturas\n    Proceso dentro del tiempo\n    Solicitud de homologación\n    Requisitos de homologación","respuesta":"Los estudiantes que deseen solicitar la homologación interna (cambio de carrera), podrán realizar este trámite DESDE EL MARTES 26/04/2022 HASTA EL MIÉRCOLES 11/05/2022. Te dejamos el link para que puedas revisar el manual https://istg.edu.ec/descargas/"},{"tema":"Reingreso a institución\n    Plazo vencido\n    Proceso fuera de tiempo\n    Solicitud de reingreso\n    Requisitos de reingreso","respuesta":"_SALUDO_, el plazo de recepción de solicitudes de reingreso para el periodo 2022-2 ya culmino, debe esperar al próximo semestre y enviar la solicitud dentro del plazo establecido."},{"tema":"Clases de inglés\n    Consultas sobre inglés\n    Soporte para inglés\n    Información sobre cursos\n    Ayuda con idioma\n    ","respuesta":"_SALUDO_, debe comunicarse al correo ingles@istg.edu.ec para que la puedan asistir."},{"tema":"Inscripción en módulos de inglés\n    Formulario de inscripción\n    Certificado de matrícula\n    Inscripción extracurricular\n    Curso de inglés\n    Módulos de inglés","respuesta":"_SALUDO_, debe llenan el formulario publicado en redes sociales y suben el certificado de matrícula, que lo puedes descargar de la plataforma académica."},{"tema":"Notas académicas\n    Certificado de calificaciones\n    Historial académico\n    Solicitud de certificado\n    Obtener calificaciones","respuesta":"Para poder revisar tus notas y emitir un certificado debes ingresar al sistema académico con tu correo institucional, dar clic en calificaciones"},{"tema":"Módulos extracurriculares\n    Cursos de inglés\n    Nivel de ingreso\n    Información sobre módulos\n    Primer nivel de inglés","respuesta":"Los módulos extracurriculares de inglés solo se habilitarán para estudiantes de 2do. A 5to. Nivel. Debe estar atento a las redes sociales institucionales para más información."},{"tema":"Exámenes finales\n    Proceso de titulación\n    Obtención de título\n    Gestor de titulación\n    Preparación para exámenes","respuesta":"_SALUDO_, debe comunicarse con el gestor de titulación de su carrera para que la puedan asistir."},{"tema":"Problemas con invitaciones\n    Correo no recibido\n    Acceso a aulas virtuales\n    Estado de invitación\n    Ayuda con invitaciones","respuesta":"(Luego de solicitar la cédula y verificar si se encuentra matriculado)\n\n_SALUDO_, las invitaciones fueron enviadas a su correo institucional, envíenos captura de pantalla de su bandeja de entrada para verificar su estado."},{"tema":"EDUCACIÓN CONTINUA","respuesta":"_SALUDO_, en el siguiente enlace podrá revisar la información de los cursos disponibles: https://istg.edu.ec/cursos/ Para mayor asistencia debe comunicarse al correo: educacioncontinua@istg.edu.ec"},{"tema":"Horario de clases\n    Programación de asignaturas\n    Consulta de horarios\n    Calendario académico\n    Información de clases","respuesta":"_SALUDO_, Los puede encontrar en la página web https://istg.edu.ec/ opción estudiantes, horarios de clases."},{"tema":"Títulos de tercer nivel\n    Entrega de título\n    Comunicación con Senescyt\n    Obtención de título\n    Información sobre títulos","respuesta":"_SALUDO_, debe comunicarse al correo secretaria@istg.edu.ec para que lo puedan asistir."},{"tema":"Falta de respuesta\n    Comunicación no recibida\n    Asistencia con consultas\n    Soporte para becas\n    Estado de solicitud","respuesta":"_SALUDO_, puede volver a enviar el correo e incluir en el mismo correo a servicios@istg.edu.ec para darle seguimiento a su caso."},{"tema":"Falta de respuesta\n    Comunicación no recibida\n    Asistencia con consultas\n    Soporte para becas\n    ya me comunique con servicios\n    Estado de solicitud","respuesta":"_SALUDO_, debe comunicarse con bienestar_institucional@istg.edu.ec para que lo puedan asistir."},{"tema":"Comunicación con la rectora\n    Consultas directas\n    Autorización de Vanessa\n    Contactar a la rectora\n    Atención especial\n    ","respuesta":"_SALUDO_, de parte de la gestoría de comunicación nos indican que se puede comunicar directamente con la rectora al siguiente número para que la puedan asistir:  098 237 9151\nFavor no compartir el número."},{"tema":"Sala de atención\n    Consultas vía Zoom\n    Horario de atención\n    Reuniones virtuales\n    Enlace a sala de Zoom","respuesta":"Para más información puede conectarse a la sala de atención vía zoom, de lunes a viernes 16h00 - 17h00: https://cedia.zoom.us/j/88944560127"},{"tema":"\n    Prematrícula completada\n    Revisión de documentos\n    Gestor de matrícula\n    Confirmación de registro\n    aceptación de cupo\n    se acepto el cupo\n    segunda postulación\n    Contacto posterior\n    ","respuesta":"_SALUDO_, los estudiantes que aceptaron su cupo en la 2da. postulación de Senescyt se podrán pre- matricular en los próximos días (SIAU - SIGA), tan pronto los usuarios estén ingresados en ambas plataformas se comunicará a través de nuestras redes sociales institucionales para que proceda a prematricularse. Adjuntamos los manuales para que se vaya familiarizando con el proceso. (SIGA https://bit.ly/38izhvS) (SIAU https://bit.ly/3yIzOlF)"},{"tema":"\n    \n    Prematrícula completada\n    Revisión de documentos\n    Gestor de matrícula\n    Confirmación de registro\n    aceptación de cupo\n    se acepto el cupo\n    segunda postulación\n    Contacto posterior\n    ","respuesta":"Buenas noches, los estudiantes que aceptaron su cupo en la 3ra. postulación de Senescyt se podrán pre- matricular en los próximos días (SIAU - SIGA), tan pronto los usuarios estén ingresados en ambas plataformas se comunicará a través de nuestras redes sociales institucionales para que proceda a prematricularse. Adjuntamos los manuales para que se vaya familiarizando con el proceso.(SIGA https://bit.ly/38izhvS) (SIAU https://bit.ly/3yIzOlF)"},{"tema":"Matrícula completada, matricula lista, matricula finalizada","respuesta":"_SALUDO_, pronto un gestor de matrícula revisará su documentación y se pondrá en contacto con usted. Sugerimos estar atento a su correo institucional."},{"tema":"\n    Estado de prematrícula\nRevisión de documentación\nGestor de matrícula\nConsultas sobre registro\nInformación sobre prematrícula\n","respuesta":"Su gestor de matrícula es el docente________________, puede comunicarse al correo: _________@istg.edu.ec para que lo puedan asistir."},{"tema":"Cambios en documentos\n    Correcciones necesarias\n    Modificaciones de registro\n    Inconvenientes con sistema\n    Solicitudes de cambios","respuesta":"_SALUDO_, debe comunicarse al correo e indicarle al gestor de matrícula que le habilite para poder realizar las correcciones."},{"tema":"Uso de SIAU\n    Instructivo de uso\n    Agencias de pago\n    Contraseña olvidada\n    Soporte para SIAU","respuesta":"Te explicamos sobre el SIAU 🚨\n \nPuedes revisar el instructivo del uso y las agencias donde puedes realizar los pagos: https://bit.ly/3yIzOlF\n \n Si no recuerdas tu contraseña, puedes recuperarla desde el mismo aplicativo; sin embargo, para quienes no puedan, deben solicitar el reseteo de lunes a viernes hasta las 15h00, a través del link: https://bit.ly/3l6NIpt."},{"tema":"Número de comprobante\n    Proceso de matrícula\n    Eximir de pago\n    Certificado de no adeudar\n    Indicación en SIGA","respuesta":"Si mantiene la gratuidad y descargo el certificado de no adeudar, puede poner lo siguiente: NA."},{"tema":"Cancelar prematrícula\n    No continuar estudios\n    Anulación de registro\n    Perder cupo\n    Retiro voluntario","respuesta":"Los estudiantes pre-matriculados que no deseen continuar con sus estudios, no deben completar su proceso de matrícula e informar a su gestor de matrícula su decisión y posteriormente esa pre-matrícula será anulada. \n\nLos alumnos matriculados en primer nivel por primera vez que se retiren voluntariamente, perderán su cupo; no podrán matricularse posteriormente, sino que deberán volver a realizar el proceso de acceso a la Educación Superior con SENESCYT."},{"tema":"Asignatura reprobada\n    Proceso de matrícula\n    Certificado de no adeudar\n    Orden de pago\n    Matrícula con asignatura pendiente","respuesta":"_SALUDO_, si es la primera vez que reprueba estas asignaturas debe esperar el proceso de matriculación. una vez inicie este proceso realizará el proceso normalmente, con la diferencia que, en vez de descargar el certificado de no adeudar, el sistema le otorgará la orden de pago por la asignatura reprobada una vez se habilite la plataforma SIAU."},{"tema":"Documentos necesarios\n    Requisitos para matricularse\n    Registro de matrícula\n    Pasos de inscripción\n    Proceso de admisión","respuesta":"REQUISITOS DE MATRICULACIÓN 2-2022\n1. Carpeta COLGANTE color CELESTE. - 1 unidad\n2. Carpeta manila con vincha.\n3. Protector de hojas de plástico transparente. - 2 unidades\n4. HOJA DE DATOS DEL ESTUDIANTE – FIRMADO. (Sistema Académico)\n5. Copia de CÉDULA.\n6. Copia de CARNÉ DE DISCAPACIDAD. (Sólo para quienes aplique)\n7. Copia de CERTIFICADO DE VOTACIÓN. (11-abril-2021)\n8. Copia de TÍTULO DE BACHILLER .\n9. CERTIFICADO DE REGISTRO DE TÍTULO DE BACHILLER obtenido de la página del MINEDUC\n10. CERTIFICADO DE MATRÍCULA Ciclo 2-2022\n11. CERTIFICADO DE NO ADEUDAR U ORDEN DE PAGO CON COPIA DEL COMPROBANTE DE PAGO Ciclo 2-2022\nPuntos que considerar:\n1. El CERTIFICADO DE REGISTRO DE TÍTULO DE BACHILLER lo puede descargar en la siguiente página: http://servicios.educacion.gob.ec/titulacion25-web/faces/paginas/consulta-titulos-refrendados.xhtml}\n2. El CERTIFICADO DE NO ADEUDAR U ORDEN DE PAGO lo puede descargar en la página de la plataforma SIAU (Una vez inicie el proceso de matriculación): https://siau-online.senescyt.gob.ec/\n3. Todos los documentos como copias de cédula, certificado de votación, título de bachiller, certificado de registro de títulos - MINEDUC tienen que estar legibles. No se aceptarán fotos impresas de estos documentos, ilegibles o que contengan manchas y/o tachones.\n4. Se le informa que toda la documentación antes mencionada deberá ser entregada en físico una vez SEA PUBLICADA LAS FECHAS EN REDES SOCIALES."}]');
            
        foreach($data as $value){
            $a = new Chatbot_Wp_Istg_Question();
            $a->set_text($value->tema);
            $a->set_answers($value->respuesta);
            $a->save();
        }
    }


 }