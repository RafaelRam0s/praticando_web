<?php 

    require_once(__DIR__ . '/../../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('configuracoes/seguranca_de_cabecalho.php'));

    require_once(Rotas::buscar_arquivo('database/praticando_web/gerar_tabelas.php'));
    require_once(Rotas::buscar_arquivo('database/praticando_web/gerar_dados.php'));

    echo('Começando apresentação de dados...' . "\n");

    echo('=========================================' . "\n");
    echo('Usuario' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario.php'));
    $resposta = Usuario::ler_registros();
    // O print_r abaixo foi comentado pq o console da um bip quando o executa, possivelmente por ter caracteres indefinidos para ele ao ler o varbinary '  AV��&quot;-!s��ʤ= ' por exemplo
    // print_r($resposta);
    

    echo('=========================================' . "\n");
    echo('Usuario_status' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario_status.php'));
    $resposta = Usuario_status::ler_registros();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Token_de_cadastro' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/token_de_cadastro.php'));
    $resposta = Token_de_cadastro::ler_registros();
    print_r($resposta);

    echo('=========================================' . "\n");
    echo('Historico_de_email' . "\n");
    echo('=========================================' . "\n");
    require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/historico_de_email.php'));
    $resposta = Historico_de_email::ler_registros();
    print_r($resposta);

    echo('Terminando apresentação de dados...' . "\n");

?>