<?php
require_once(__DIR__ . '/configuracoes.php');

function validar_recaptcha_v2($g_recaptcha_response) 
{
    if (isset($g_recaptcha_response))
    {
        if (!empty($g_recaptcha_response))
        {
            $captcha = $g_recaptcha_response;
            $secretKey = GRECAPTCHA_SECRET_KEY;
            
            try{
                /* Versão por via POST */
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
                    array(
                        'secret' => $secretKey,
                        'response' => $captcha
                    )
                ));
                
                // @@@ Descomente o bloco de comentário abaixo apenas na hora do teste
                    /* 
                    if ( (isset($_SERVER['SERVER_NAME']) ? ($_SERVER['SERVER_NAME'] == 'localhost') : false) )
                    {
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    }
                    if (! $response = curl_exec($ch) )
                    {
                        trigger_error(curl_error($ch));
                    }
                    */
                // ---

                curl_close ($ch);

                /* Versão por via GET 
                $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $captcha);
                */
            } catch (Exception $e)
            {
                error_log($e, 0);
                return [false, 'Erro no captcha, contate a equipe técnica!'];
            }
            
            // Verificar requisição
            if (isset($response))
            {
                $responseKeys = json_decode($response, true);
            } else {
                return [false, 'Erro no captcha!'];
            }
            
            // Validando resposta da Google
            if (isset($responseKeys["success"])) {
                if ($responseKeys["success"] == true)
                {
                    return [true, 'Captcha validado com sucesso!'];
                } else {
                    if ( isset($responseKeys['error-codes']) )
                    {
                        // Fazer um sistema de alerta, não para o usuário e sim para os desenvolvedores, controlado baseado em cada resposta do captcha a seguir listados:
                        
                            // missing-input-secret - The secret parameter is missing.
                            // segredo de entrada ausente - O parâmetro secreto está ausente.

                            // invalid-input-secret - The secret parameter is invalid or malformed.
                            // inválido-input-secret - O parâmetro secreto é inválido ou malformado.
                            
                            // missing-input-response - The response parameter is missing.
                            // falta-input-resposta - O parâmetro de resposta está ausente.
                            
                            // invalid-input-response - The response parameter is invalid or malformed.
                            // resposta de entrada inválida - O parâmetro de resposta é inválido ou malformado.
                            
                            // bad-request	The request is invalid or malformed.
                            // pedido ruim - A solicitação é inválida ou malformada.
                            
                            // timeout-or-duplicate	The response is no longer valid: either is too old or has been used previously.
                            // tempo limite ou duplicado - A resposta não é mais válida: é muito antiga ou foi usada anteriormente.

                        // print_r($responseKeys['error-codes']);
                        error_log('Erro no captcha: ' . $responseKeys['error-codes'], 0);
                    }

                    return [false, 'Erro no captcha, marque-o novamente!'];
                }
            } else {
                error_log('Erro no captcha: não foi possível obter a responseKeys', 0);
                return [false, 'Erro no captcha, contate o suporte!'];
            }

        } else {
            return [false, 'Lembre-se de marcar o captcha!'];
        }

    } else {
        return [false, 'Lembre-se de marcar o captcha!'];
    }
}
?>