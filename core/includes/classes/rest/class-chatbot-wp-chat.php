<?php

class Chatbot_Wp_Chat {

    public function __construct() {
        add_action('rest_api_init', array($this, 'registrar_endpoints'));
        add_action('wp_ajax_chat_ajax',  [$this,'chat_response']);
        add_action('wp_ajax_nopriv_chat_ajax', [$this,'chat_response']); // Para usuarios no autenticados

    }

 
   

    public function chat_response() {
        // Lógica del método API

        //obtener el valor text del body
        $text =   $_POST['text'];

        $data = Chatbot_Wp_Istg_Question::get_all();
        $options =[];
        foreach ($data as $value) {
            if(str_contains($value->text,$text) || 
                str_contains($value->text, strtolower($text)) ||
                str_contains($value->text, strtoupper($text)) ||
                str_contains($value->text, ucfirst($text)) ||
                str_contains($value->text, ucwords($text)) ||
                str_contains($value->text, mb_strtoupper($text)) ||
                str_contains($value->text, mb_strtolower($text)) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_TITLE, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_UPPER, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_LOWER, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_TITLE_SIMPLE, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_UPPER_SIMPLE, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_LOWER_SIMPLE, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_TITLE, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_UPPER, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_LOWER, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_TITLE_SIMPLE, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_UPPER_SIMPLE, "UTF-8")) ||
                str_contains($value->text, mb_convert_case($text, MB_CASE_LOWER_SIMPLE, "UTF-8")) ){
                
                
                $options[] = $value;
            }
        }
        error_log('RESPUESTA'. $text);
        error_log(json_encode($options));


        

        $data = array('answers' => $options);
        return wp_send_json($data);
    }
}

