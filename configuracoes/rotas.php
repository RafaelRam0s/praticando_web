<?php 

function convocar_rota(string $rota)
{

    $lista_de_rotas = [
        'config/configuracoes' => '/configuracoes/configuracoes.php',
        'config/db_praticando_web' => '/configuracoes/db_praticando_web.php',
        'config/seguranca_de_cabecalho' => '/configuracoes/seguranca_de_cabecalho.php',
        'config/validacao_de_captcha' => '/configuracoes/validacao_de_captcha.php',
        
        'db/praticando_web/usuario' => '/database/praticando_web/usuario.php',
        'db/praticando_web/usuario_status' => '/database/praticando_web/usuario_status.php',
        'db/praticando_web/token_de_cadastro' => '/database/praticando_web/token_de_cadastro.php',
        'db/praticando_web/historico_de_email' => '/database/praticando_web/historico_de_email.php',
        
        'erro/404' => '/public_html/404/index.php',

        'secure/validacoes_de_cadastro' => '/secure/validacoes_de_cadastro.php',
        'secure/praticando_web/usuario' => '/secure/praticando_web/usuario.php',
        'secure/praticando_web/usuario_status' => '/secure/praticando_web/usuario_status.php',
        'secure/praticando_web/token_de_cadastro' => '/secure/praticando_web/token_de_cadastro.php',
        'secure/praticando_web/historico_de_email' => '/secure/praticando_web/historico_de_email.php',
        

        'email/confirmar_cadastro' => '/email/confirmar_cadastro.php',
    
        'controllers/controller' => '/public_html/controllers/controller.php',
        'layouts/layout_principal' => '/public_html/layouts/layout_rancode.php',
    
        'site/funcionalidades_php/header' => '/public_html/assets/funcionalidades_php/header.php',
        'site/404' => '/public_html/404/404.php',
        'site/home' => '/public_html/home/home.php',
        'site/termos_de_uso' => '/public_html/termos_de_uso/termos_de_uso.php',
        'site/politica_de_privacidade' => '/public_html/politica_de_privacidade/politica_de_privacidade.php',
        'site/templates/template_html' => '/public_html/templates/template_html/template_html.php',
        
        'site/sistema_de_registro/cadastro/header_cadastro' => '/public_html/sistema_de_registro/cadastro/header_cadastro.php',
        'site/sistema_de_registro/cadastro' => '/public_html/sistema_de_registro/cadastro/cadastro.php',
        'site/sistema_de_registro/cadastro/confirmacao_cadastro' => '/public_html/sistema_de_registro/cadastro/confirmacao_cadastro/confirmacao_cadastro.php',
        'site/sistema_de_registro/login/header_login' => '/public_html/sistema_de_registro/login/header_login.php',
        'site/sistema_de_registro/login' => '/public_html/sistema_de_registro/login/login.php'

    ];

    if (!isset($lista_de_rotas[$rota]))
    {
        error_log('Erro com a rota solicitada', 0);
        echo('Erro com a rota solicitada');
        die();
    }

    require_once(__DIR__ . '/../' . $lista_de_rotas[$rota]);
}

?>