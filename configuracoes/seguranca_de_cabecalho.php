<?php

    require_once(__DIR__ . '/rotas.php');
    
    error_reporting(E_ALL); // Reporta todos os tipos de erros
    // @@@ Habilitar em produção a linha abaixo
    ini_set('display_errors', 0); // Não exibe erros na tela 
    ini_set('log_errors', 1); // Habilita o log de erros
    ini_set('error_log', Rotas::buscar_arquivo('historico_de_erros_php.txt')); // Define o arquivo de log
    
    // Previnir roubo de cliques, resumindo; de colocarem o site em outros iframes, pq isso? Para evitar que peguem uma rota semelhante com a do site, por exemplo rancode.com.br e peguem o rencode.com.br e nisso façam um iframe do site e coloquem por cima do site um link malicioso que pode fazer download ou roubar dados
    header("Content-Security-Policy: frame-ancestors 'none'", false);
    header("X-Frame-Options: DENY");
    
?>