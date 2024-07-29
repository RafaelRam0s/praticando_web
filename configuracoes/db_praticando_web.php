<?php

require_once(__DIR__ . '/rotas.php');
convocar_rota('config/configuracoes');

function db_praticando_web_gerar_conexao()
{
    // Tentar conexão com o banco
    try 
    {

        // Conectando com o banco
        $conexao_db = new PDO (
            'mysql:host=' . DB_CENTRAL['host'] 
            . ';dbname=' . DB_CENTRAL['dbname'] 
            . ';charset=' . DB_CENTRAL['charset'],
            DB_CENTRAL['username'],
            DB_CENTRAL['password'], 
            array(
                PDO::ATTR_TIMEOUT => 4, // tempo máximo de espera para conectar com o banco, em segundos
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );
        
        if(!$conexao_db)
        {
            error_log('Falha na coneão com o banco de dados', 0);
            // Redireciona o usuário para o erro 404
            convocar_rota('erro/404');
        }
        
    } catch (PDOException $pe) // Conexão com o banco falhou
    {
        error_log('Falha na conexão com o banco de dados: ' . $pe->getMessage(), 0);
        
        // Redireciona o usuário para o erro 404
        convocar_rota('erro/404');
    }

    // Retorna a conexão com o banco
    return $conexao_db;
}




