<?php




// ------------------------------------------------------------------------
// Código para se conectar com o banco
// ------------------------------------------------------------------------
define('DB_CENTRAL', [
    'host' => '', 
    'dbname' => '',
    'charset' => 'UTF8',
    'username' => '', 
    'password' => ''
]);



// ------------------------------------------------------------------------
// Chaves de criptografia para o PHP
// ------------------------------------------------------------------------
define('AES_KEY', ''); // Chave com 32 caracteres
define('AES_IV', ''); // Chave com 16 caracteres


function aesEncriptar($valor) : string
{
    return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV));
}
function aesDesencriptar($valor) : string|false
{
    // Verifica se o valor de entrada é compatível com o hex2bin
    try {
        $entrada = @hex2bin($valor);
        
        if(false === $entrada) {
          throw new Exception("Invalid hexedecimal value.");
        }
    } catch(Exception $e) {
        return false;
    }

    // Descriptografa o valor
    $descriptografia = openssl_decrypt(hex2bin($valor), 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV);
    
    if($descriptografia === false)
    {
        return false;        
    } else {
        return $descriptografia;
    }
}




// ------------------------------------------------------------------------
// Chaves de criptografia para o MySQL
// ------------------------------------------------------------------------
define('AES_KEY_DB_PRATICANDO_WEB', ''); // 24 Caracteres



// ------------------------------------------------------------------------
// Chaves de acesso para o ReCaptcha
// ------------------------------------------------------------------------
define('GRECAPTCHA_SECRET_KEY', ''); // Gerado pelo Google
define('GRECAPTCHA_PUBLIC_KEY', ''); // Gerado pelo Google




