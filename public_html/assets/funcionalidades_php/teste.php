<?php 
error_reporting(E_ALL); // Reporta todos os tipos de erros
ini_set('display_errors', 0); // Não exibe erros na tela
ini_set('log_errors', 1); // Habilita o log de erros
ini_set('error_log', __DIR__ . '/teste_avisos.txt'); // Define o arquivo de log


trigger_error("Este é um erro de teste.", E_USER_WARNING);


?>