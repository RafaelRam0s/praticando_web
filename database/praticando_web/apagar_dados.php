<?php 

    require_once(__DIR__ . '/../../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('configuracoes/seguranca_de_cabecalho.php'));

    echo('Começando preenchimento de dados...' . "\n");

    echo('=========================================' . "\n");
    echo('Usuario' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario.php'));
    $resposta = Usuario::apagar_dados();
    Usuario::resetar_auto_increment();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Usuario_status' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario_status.php'));
    $resposta = Usuario_status::apagar_dados();
    Usuario_status::resetar_auto_increment();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Token_de_cadastro' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/token_de_cadastro.php'));
    $resposta = Token_de_cadastro::apagar_dados();
    Token_de_cadastro::resetar_auto_increment();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Historico_de_email' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/historico_de_email.php'));
    $resposta = Historico_de_email::apagar_dados();
    Historico_de_email::resetar_auto_increment();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Token_de_cadastro_validacao' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/token_de_cadastro_validacao.php'));
    $resposta = Token_de_cadastro_validacao::apagar_dados();
    Token_de_cadastro_validacao::resetar_auto_increment();
    print_r($resposta);

    echo('Terminando preenchimento de dados...' . "\n");

?>