<?php 

function email_confirmar_cadastro(
    string $email,
    string $token_de_cadastro
) {

    try {
        // Obter o protocolo (http ou https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        // Obter o host (domínio ou IP)
        $host = $_SERVER['HTTP_HOST'];
        // Construir a URL completa
        $url = $protocol . '://' . $host . '/';
        
        $from = "Rancode";
        $to = $email;
        $subject = "Confirmar cadastro em Rancode";
        $message = '
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8" />
                <meta name="author" content="Rafael Ramos da Silva" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />

                <title>Confirmação de Cadastro</title>
            </head>
            <body style="margin: 0px; font-family: monospace; border: 1px solid #000000;">
            
                <div style="margin: 0px; font-family: monospace; border: 1px solid #000000;">
                    <div style="background-color: #0600a1;">
                        <div style="padding: 15px 10px 15px 10px; text-align: center;">
                            <a href="' . $url . '" style="font-size: 20px; color: #ffffff; font-weight: 800; border: 3px solid #ffffff; display: inline-block; padding: 1px; text-decoration: none;" target="_blank">
                                RanCode
                            </a>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <div style="background-color: #dedede; font-size: 1.2em; height: 100%; padding: 10px;">
                            <h2>Confirmação de cadastro</h2>

                            <p>Clique no botão abaixo para confirmar sua conta e poder utilizar nossos serviços.</p>

                            <div style="display: block; width: 100%;">
                                <a href="' . $url . '/sistema_de_registro/cadastro/confirmacao_cadastro?token=' . $token_de_cadastro . '" style="display: block; margin: auto; width: 300px; background-color: #160cfc; color: white; text-align: center; padding: 10px; box-sizing: border-box; border-radius: 10px; text-decoration: none;" target="_blank">Confirmar cadastro</a>
                            </div>
                            
                            <p><strong>Caso não tenha feito qualquer cadastro conosco, favor desconsiderar este e-mail.</strong></p>
                        </div>
                    </div>
                    <div style="background-color: #0600a1;">
                        <div style="padding: 15px 10px 15px 10px; text-align: center; color: #ffffff;">
                            &#169; RanCode
                        </div>
                    </div>
                </div>
            </body>
            </html>
        ';
        $cc = "";
        $bcc = "";

        $headers = "From: " . $from . "\r\n";
        $headers .= "Cc: " . $cc . "\r\n";
        $headers .= "Bcc: " . $bcc . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers, "-f " . $from)) {
            return [
                'sucesso' => 200,
                'mensagem' => 'Email enviado com sucesso',
                'conteudo' => null
            ];
        } else {
            error_log('Erro no envio do email', 0);
            return [
                'sucesso' => 204,
                'mensagem' => 'Erro no envio do email',
                'conteudo' => null
            ];
        }

    } catch (Exception $e) {
        error_log($e, 0);
        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no envio do email',
            'conteudo' => null
        ];
    }
}
?>