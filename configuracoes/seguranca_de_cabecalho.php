<?php
    // Previnir roubo de cliques, resumindo; de colocarem o site em outros iframes, pq isso? Para evitar que peguem uma rota semelhante com a do site, por exemplo rancode.com.br e peguem o rencode.com.br e nisso façam um iframe do site e coloquem por cima do site um link malicioso que pode fazer download ou roubar dados
    header("Content-Security-Policy: frame-ancestors 'none'", false);
    header("X-Frame-Options: DENY");

    // Desativar o retorno de erros do php em produção
    // error_reporting(0);

?>