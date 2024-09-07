<?php

/* 
Inserir no html:
<?php 
    require_once(__DIR__ . '/rotas.php');
    require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));
?>
<div>
    <div class="g-recaptcha" data-sitekey="<?php echo(GRECAPTCHA_PUBLIC_KEY); ?>"></div>
</div>
*/

class Validacao_de_captcha {
    
    public static function validar_recaptcha_v2(string $g_recaptcha_response) {
    
        // Verificar se foi definido o parametro
        if (!isset($g_recaptcha_response)) {
            trigger_error('Erro na chamada da função', E_USER_WARNING);
            return [
                'sucesso' => 404,
                'mensagem' => 'Falta de parâmetros na função'
            ];
        }
        
        // Verificar se está vazio
        if (empty($g_recaptcha_response)) {
            return [
                'sucesso' => 404,
                'mensagem' => 'Lembre-se de marcar o captcha!'
            ];
        }
    
        require_once(__DIR__ . '/rotas.php');
        require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));
    
        $secretKey = GRECAPTCHA_SECRET_KEY;
                
        try {
            // Conectar com a api do google
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                'secret' => $secretKey,
                'response' => $g_recaptcha_response
            )));
            
            // @@@ Descomente o bloco de comentário abaixo apenas na hora do teste, caso o servidor não tenha um SSL
                /* 
                if ( (isset($_SERVER['SERVER_NAME']) ? ($_SERVER['SERVER_NAME'] == 'localhost') : false) )
                {
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                }
                */
            // ---
            
            $response = curl_exec($ch);
            if ($response === false) {
                throw new Exception('Erro na execução post: ' . curl_error($ch), E_USER_WARNING);
            }
    
            curl_close ($ch);
    
            $responseKeys = json_decode($response, true);
    
            // Validando resposta do Google
            if (isset($responseKeys["success"])) {
                if ($responseKeys["success"] == true) {
                    return [
                        'sucesso' => 200,
                        'mensagem' => 'Captcha validado com sucesso!'
                    ];
                } 
                
                if (isset($responseKeys['error-codes'])) {
                    // Respostas possiveis de erro:
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
                    //

                    if ($responseKeys['error-codes'] != 'timeout-or-duplicate') {
                        trigger_error('Erro no captcha: ' . $responseKeys['error-codes'], E_USER_WARNING);
                    }
                    
                    return [
                        'sucesso' => 404,
                        'mensagem' => 'Erro no captcha, marque-o novamente!'
                    ];
                }
            }
    
        } catch (Exception $e) {
            trigger_error('Erro no Post para o google captcha: ' . $e, E_USER_WARNING);
            return [
                'sucesso' => 404,
                'mensagem' => 'Erro no captcha, contate o suporte!'
            ];
        }
    
        trigger_error('Erro no captcha: não foi possível obter a responseKeys corretamente', E_USER_WARNING);
        return [
            'sucesso' => 404,
            'mensagem' => 'Erro no captcha, contate o suporte!'
        ];
    
    }
    
}

?>