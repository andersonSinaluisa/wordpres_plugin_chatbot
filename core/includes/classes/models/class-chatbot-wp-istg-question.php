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
        $data = json_decode('[{"tema":"hola \n buenas tardes \n buenas noches \n buenos días \n buenos dias","respuesta":"Hola, gracias por escribir al Instituto Superior Tecnológico Guayaquil. ¿Cómo podemos ayudarle?"},{"tema":"Problema\n    Caso anterior\n    Número de cédula\n    Ayuda\n    Consulta de Casos o Requerimiento Anterior\n    Revisión","respuesta":"_SALUDO_, indíquenos su número de cédula para revisar su caso."},{"tema":"información","respuesta":"Bienvenid@, \n Para el periodo 2023-2, el Tecnológico Guayaquil oferto las siguientes carreras:  \n • Desarrollo de Software (modalidad híbrida)  \n • Diseño Gráfico (presencial) \n • Marketing digital (presencial)  \n En el siguiente enlace: https: //istg.edu.ec/ opción oferta académica, podrá encontrar más información sobre nuestras carreras. \n  Agradecemos su interés por nuestra institución por lo que le solicitamos amablemente  que llene este formulario para poderle enviar mayor información. \n"},{"tema":"proceso de admisión","respuesta":"Si completaste el Registro Único de Senescyt y su respectiva inscripción este periodo 2023-2, debes estar atento a las redes sociales institucionales donde indicaremos el 3er paso de este proceso, test de conocimiento y aptitudes."},{"tema":"registro en senescyt \n proceso de admisión \n comunicación con senescyt \n información","respuesta":"Agradecemos su interés por nuestra institución por lo que le solicitamos amablemente su nombre y correo electrónico para enviarle información adicional de las carreras y servicios que ofrecemos."},{"tema":"retiro voluntario","respuesta":"Para revisar el proceso ingresa en el siguiente enlace donde podrás encontrar el manual de retiro voluntario: https://istg.edu.ec/descargas/"},{"tema":"retiro fuerza mayor","respuesta":"Deberás enviar un correo a bienestar_institucional@istg.edu.ec con la solicitud de retiro por fuerza mayor el cual solo se puede receptar hasta el primer día de los exámenes de primer parcial , el formulario podrás encontrarlo en https://istg.edu.ec/descargas/"},{"tema":"retiro fuerza de plazo","respuesta":"El plazo de recepción de solicitudes de retiro voluntario y de fuerza mayor ya culminó para este periodo 2023-1."},{"tema":"¿QUÉ HACER SI ACEPTASTE TU CUPO?","respuesta":"Obtuviste un cupo y lo aceptaste. \n ✨✨Bienvenido a la Comunidad ISTG✨✨ \n Nos llena de alegría que seas parte de esta gran familia. \n Recuerda: \n ▶️ El proceso de matriculación estima empezar una vez culminen todos los periodos de postulación y aceptación de cupo realizado por Senescyt. ▶️ No es necesario acercarte de manera presencial a ninguna de nuestras sedes. \n ▶️ Mantente informado por los canales oficiales (página web - redes sociales), sobre el calendario y los procesos de ingreso. Pronto se publicará más información al respecto."},{"tema":"retiro fuerza de plazo","respuesta":"Buenas tardes, hasta el periodo 2023-1 el proceso que debía realizar era el Retorno al Acceso a la Educación Superior de Senescyt, donde podía habilitar su cuenta o habilitación su nota para volver a realizar el proceso de postulación.  \n Actualmente debe realizar el Registro Nacional en la plataforma www.registrounicoedusup.gob.ec y luego seguir los pasos que se indicarán. Esto es obligatorio.\n Recuerde que este proceso lo realiza directamente Senescyt. \n Para más información puede comunicarse 08:00 a 16:30 en la plataforma https://siau.senescyt.gob.ec/"},{"tema":"credenciales","respuesta":"El proceso de credenciales se maneja directamente con el proveedor, solicitar información al correo recibido por parte de ellos."},{"tema":"recuperación de clave problemas en el sistema académico","respuesta":"Buenas tardes, debe comunicarse al correo: soporte_correos@istg.edu.ec desde su correo personal registrado para que lo puedan asistir. \n Recuerde incluir sus datos, carrera, correo institucional y breve descripción del inconveniente."},{"tema":"valor a cancelar","respuesta":"Si es su primer cupo aceptado en una IES pública la educación es gratuita, caso contrario deberá cancelar un valor por asignatura definido por Senescyt una vez al inicio de cada semestre."},{"tema":"recuperación de clave del siga","respuesta":"Debes comunicarte al correo: soporte_siga@istg.edu.ec para que lo puedan asistir. Recuerde escribir su nombre completo, cédula, carrera y detalle de su inconveniente."},{"tema":"valor a cancelar","respuesta":"Si es su primer cupo aceptado en una IES pública la educación es gratuita, caso contrario deberá cancelar un valor por asignatura definido por Senescyt una vez al inicio de cada semestre."},{"tema":"recuperación de clave del siga","respuesta":"Debes comunicarte al correo: soporte_siga@istg.edu.ec para que lo puedan asistir. Recuerde escribir su nombre completo, cédula, carrera y detalle de su inconveniente."},{"tema":"puedo ingresar al aula virtual desde mi celular","respuesta":"Para poder configurar en tu celular la plataforma virtual sigue los pasos indicados en el reel adjunto https://www.instagram.com/reel/Cljr2BsrGXY/?utm_source=ig_web_copy_link ( Sí tienes problemas deberás enviar un correo al gestor de TIC por carrera ) incluye tus datos completos, carrera, cédula e indicar cual es el inconveniente"},{"tema":"conexión privada al ingresar al sistema académico","respuesta":"Buenas tardes. Usted se está comunicando con el Instituto Superior Tecnológico Guayaquil de la ciudad de Guayaquil. Debe comunicarse directamente con ellos. Somos dos Instituciones completamente diferentes e independientes."},{"tema":"ISTG AMBATO","respuesta":"Buenas tardes. Usted se está comunicando con el Instituto Superior Tecnológico Guayaquil de la ciudad de Guayaquil. Debe comunicarse directamente con ellos. Somos dos Instituciones completamente diferentes e independientes."},{"tema":"manuales","respuesta":"En el siguiente link podrás descargar los manuales de cada uno de los procesos vigentes para este periodo : https://istg.edu.ec/descargas/"},{"tema":"homologación","respuesta":"El plazo de recepción de solicitudes de homologación para el periodo 2023-1 ya culminó, debe esperar al próximo semestre y enviar la solicitud dentro del plazo establecido. En el siguiente enlace podrá encontrar el manual de homologación: https://istg.edu.ec/descargas/ Sugerimos revisar que cumpla con todos los requisitos mencionados."},{"tema":"reingreso","respuesta":"El plazo de recepción de solicitudes de reingreso para el periodo 2023-1 ya culminó, debe esperar al próximo semestre y enviar la solicitud dentro del plazo establecido."},{"tema":"dudas sobre inglés, preguntas sobre inglés","respuesta":"Debes comunicarte al correo ingles@istg.edu.ec para que la puedan asistir."},{"tema":"módulos de inglés \n inscripciones de ingles","respuesta":"Debes llenar el formulario publicado en redes sociales y subir el certificado de matrícula, que lo puedes descargar de la plataforma \"Académico\".Los módulos extracurriculares de inglés solo se habilitarán para estudiantes de 2do. A 5to. Nivel. Debe estar atento a las redes sociales institucionales para más información."},{"tema":"certificados de notas","respuesta":"Para poder revisar tus notas y emitir un certificado debes ingresar al sistema académico con tu correo institucional, dar clic en calificaciones"},{"tema":"examenes complexivos titulación","respuesta":"Debes comunicarte con el gestor de titulación de su carrera para que la puedan asistir. Se lo direcciona con el gestor respectivo DESO: esanchez@istg.edu.ec DISE: jcedillo@istg.edu.ecMKT: vcastro@istg.edu.ec"},{"tema":"no recibí invitación a las aulas virtuales","respuesta":"Las invitaciones son enviadas a los correos institucionales, envíenos captura de pantalla de su bandeja de entrada para verificar su estado."},{"tema":"horarios de clases","respuesta":"Buenas tardes, puede volver a enviar el correo e incluir en el mismo correo a comunicados@istg.edu.ec para darle seguimiento a su caso."},{"tema":"sigue sin recibir respuesta / becas","respuesta":"Para más información puede conectarse a la sala de atención vía zoom, de lunes a viernes 16h00 - 17h00: https://cedia.zoom.us/j/88944560127"},{"tema":"He completado mi prematricula","respuesta":"Buenas tardes, pronto un gestor de matrícula revisará su documentación y se pondrá en contacto con usted. Sugerimos estar atento a su correo institucional."},{"tema":"sistema siau","respuesta":"Te explicamos sobre el SIAU 🚨 \n Puedes revisar el instructivo del uso y las agencias donde puedes realizar los pagos: https://bit.ly/3yIzOlF \n Si no recuerdas tu contraseña, puedes recuperarla desde el mismo aplicativo; sin embargo, para quienes no puedan, deben solicitar el reseteo de lunes a viernes hasta las 15h00, a través del link: https://bit.ly/3l6NIpt."},{"tema":"retiro voluntario sin completar la prematrícula","respuesta":"Los estudiantes pre-matriculados que no deseen continuar con sus estudios, no deben completar su proceso de matrícula e informar a su gestor de matrícula su decisión y posteriormente esa pre-matrícula será anulada. Los alumnos matriculados en primer nivel por primera vez que se retiren voluntariamente, perderán su cupo; no podrán matricularse posteriormente, sino que deberán volver a realizar el proceso de acceso a la Educación Superior con SENESCYT."},{"tema":"REPROBÉ UNA ASIGNATURA PROCESO DE MATRICULACIÓN","respuesta":"Si es la primera vez que reprueba estas asignaturas debe esperar el proceso de matriculación. Una vez inicie este proceso realizará el proceso normalmente, con la diferencia que, en vez de descargar el certificado de no adeudar, el sistema le otorgará la orden de pago por la asignatura reprobada una vez se habilite la plataforma SIAU."},{"tema":"REQUISITOS DE MATRICULACIÓN","respuesta":"PENDIENTE SOLICITAR EN FECHAS DE MATRICULACIÓN."},{"tema":"Exámenes finales\n    Proceso de titulación\n    Obtención de título\n    Gestor de titulación\n    Preparación para exámenes","respuesta":"Buenas tardes, si realizaste el proceso del registro único y te inscribiste para los institutos públicos puedes inscribirte y/o tienes tu nota habilitada de la senescyt que no supere los cuatro períodos puedes inscribirte con nosotros."},{"tema":"REQUISITOS NIVELTEC 2023-1","respuesta":"(Luego de solicitar la cédula y verificar si se encuentra matriculado)\n\n_SALUDO_, las invitaciones fueron enviadas a su correo institucional, envíenos captura de pantalla de su bandeja de entrada para verificar su estado."}]');
            
        foreach($data as $value){
            $a = new Chatbot_Wp_Istg_Question();
            $a->set_text($value->tema);
            $a->set_answers($value->respuesta);
            $a->save();
        }
    }


 }