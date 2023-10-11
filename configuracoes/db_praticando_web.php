<?php

require_once(__DIR__ . '/configuracoes.php');

function db_central_gerar_conexao()
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
            require_once(__DIR__ . '/../public_html/assets/funcionalidades_php/header.php');
            header("Location: /404");
        }
        
    } catch (PDOException $pe) // Conexão com o banco falhou
    {
        error_log('Falha na coneão com o banco de dados: ' . $pe->getMessage(), 0);
        
        // Redireciona o usuário para o erro 404
        require_once(__DIR__ . '/../public_html/assets/funcionalidades_php/header.php');
        header("Location: /404");
    }

    // Retorna a conexão com o banco
    return $conexao_db;
}




