<?php
require_once(__DIR__ . '/../../configuracoes/rotas.php');
convocar_rota('config/seguranca_de_cabecalho');
convocar_rota('site/funcionalidades_php/header');

function carregarArquivo(string $caminho_da_url)
{
    $rota_limpa = tratarUrl($caminho_da_url);

    $layout_descricao = '@@@';
    $layout_palavras_chaves = '@@@';
    $layout_titulo = '404';
    $layout_arquivo_conteudo = 'site/404';
    
    if (
        $rota_limpa == ''
        || $rota_limpa == 'home'
    ) {

        $layout_descricao = 'Olá sou Rafael Ramos, um estudante adquirindo cada vez mais conhecimento nos diversos ramos da programação não se fixando apenas desenvolvimento web, mas tendo ela como principal foco.';
        $layout_palavras_chaves = 'html, css, javascript, php, programador, perfil, estudante';
        $layout_titulo = 'Meu perfil';
        $layout_arquivo_conteudo = 'site/home';

    } elseif ($rota_limpa == 'politica_de_privacidade') {

        $layout_titulo = 'Política de privacidade';
        $layout_arquivo_conteudo = 'site/politica_de_privacidade';

    } elseif ($rota_limpa == 'termos_de_uso') {

        $layout_titulo = 'Termos de uso';
        $layout_arquivo_conteudo = 'site/termos_de_uso';

    } elseif ($rota_limpa == 'templates/template_html') {

        $layout_titulo = 'Template HTML';
        $layout_arquivo_conteudo = 'site/templates/template_html';


    } elseif ($rota_limpa == 'sistema_de_registro/cadastro') {

        convocar_rota('site/sistema_de_registro/cadastro/header_cadastro');

        $layout_titulo = 'Cadastramento';
        $layout_arquivo_conteudo = 'site/sistema_de_registro/cadastro';

    } elseif ($rota_limpa == 'sistema_de_registro/cadastro/confirmacao_cadastro') {

        $layout_titulo = 'Confirme o Cadastro';
        $layout_arquivo_conteudo = 'site/sistema_de_registro/cadastro/confirmacao_cadastro';

    } elseif ($rota_limpa == 'sistema_de_registro/login') {

        $layout_titulo = 'Login';
        $layout_arquivo_conteudo = 'site/sistema_de_registro/login';


    } elseif ($rota_limpa == '404') {

        $layout_titulo = '404';
        $layout_arquivo_conteudo = 'site/404';

    } else {
        
        // Verifique se a rota está em algum dos outros arquivos controllers
        // require_once(__DIR__ . '/controller_acesso_usuario.php');
        // require_once(__DIR__ . '/controller_acesso_administrativo.php');

    }

    require_once(__DIR__ . '/../layouts/layout_rancode.php');
    die();
}

if ( isset($_SERVER['REQUEST_URI']) )
{
    carregarArquivo( $_SERVER['REQUEST_URI'] );
} else {
    carregarArquivo('404');
}

?>