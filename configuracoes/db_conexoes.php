<?php

class Db_conexoes {

    public static function gerar_conexao(string $nome_banco) {
        
        if ($nome_banco == 'praticando_web_mysql') {
            require_once(__DIR__ . '/rotas.php');
            require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));

            try  {
                // Conectar com o banco
                $conexao_db = new PDO (
                    'mysql:host=' . DB_PRATICANDO_WEB['host'] 
                    . ';dbname=' . DB_PRATICANDO_WEB['dbname'] 
                    . ';charset=' . DB_PRATICANDO_WEB['charset'],
                    DB_PRATICANDO_WEB['username'],
                    DB_PRATICANDO_WEB['password'], 
                    array(
                        PDO::ATTR_TIMEOUT => 4, // tempo máximo de espera para conectar com o banco, em segundos
                        PDO::ATTR_PERSISTENT => true,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    )
                );
                
                if(!$conexao_db) {
                    // Registrar erro
                    trigger_error('Falha na coneão com o banco de dados', E_USER_WARNING);
                    
                    // Redireciona o usuário para página erro 404
                    header('Location: /error/404');
                    die();
                }
                
            } catch (Exception $e) {
                // Registrar erro
                trigger_error('Falha na conexão com o banco de dados: ' . $e, E_USER_WARNING);
                
                // Redireciona o usuário para página erro 404
                header('Location: /error/404');
                die();
            }

            // Retorna a conexão com o banco
            return $conexao_db;
        }

        trigger_error('Nome de banco inválido', E_USER_WARNING);
        header('Location: /error/404');
        die();
    }

}




