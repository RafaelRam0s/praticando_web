<?php 

    require_once(__DIR__ . '/../../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('configuracoes/seguranca_de_cabecalho.php'));

    echo('Começando criação de tabelas...' . "\n");

    echo('=========================================' . "\n");
    echo('Usuario' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario.php'));
    $resposta = Usuario::gerar_tabela();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Usuario_status' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario_status.php'));
    $resposta = Usuario_status::gerar_tabela();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Token_de_cadastro' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/token_de_cadastro.php'));
    $resposta = Token_de_cadastro::gerar_tabela();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Historico_de_email' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/historico_de_email.php'));
    $resposta = Historico_de_email::gerar_tabela();
    print_r($resposta);

    echo('Finalizado criação de tabelas...' . "\n");


?>