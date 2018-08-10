<?php


class Utilidades{
    public function validate_captcha( $response, $remoteip){
		$secret_capcha = '6Ldrb10UAAAAAI4kziuY_bkVvTeZlXRhsVi_EaIk';
 
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secret_capcha,
            'response' => $response,
            'remoteip' => $remoteip
        );
        $query = http_build_query($data ,'','&');

        $options = array(
            'http' => array (
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                    "Content-Length: ".strlen($query)."\r\n",
                'method' => 'POST',
                'content' => $query
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);
        
        return ($captcha_success->success);
    }
    

    public function crear_sesion($uid){
        $token = bin2hex(openssl_random_pseudo_bytes(64));

    }
}

?>