<?php
require_once(__DIR__ . '/../../configuracoes/seguranca_de_cabecalho.php');
require_once(__DIR__ . '/../assets/funcionalidades_php/header.php');


function carregarArquivo(string $caminho_da_url)
{
    $rota_limpa = tratarUrl($caminho_da_url);

    $layout_descricao = '@@@';
    $layout_palavras_chaves = '@@@';
    $layout_titulo = '404';
    $layout_arquivo_conteudo = __DIR__ . '/../404/404.php';
    
    if (
        $rota_limpa == ''
        || $rota_limpa == 'home'
    ) {

        $layout_descricao = 'Olá sou Rafael Ramos, um estudante adquirindo cada vez mais conhecimento nos diversos ramos da programação não se fixando apenas desenvolvimento web, mas tendo ela como principal foco.';
        $layout_palavras_chaves = 'html, css, javascript, php, programador, perfil, estudante';
        $layout_titulo = 'Meu perfil';
        $layout_arquivo_conteudo = __DIR__ . '/../home/home.php';

    } elseif ($rota_limpa == 'politica_de_privacidade') {

        $layout_titulo = 'Política de privacidade';
        $layout_arquivo_conteudo = __DIR__ . '/../politica_de_privacidade/politica_de_privacidade.php';

    } elseif ($rota_limpa == 'termos_de_uso') {

        $layout_titulo = 'Termos de uso';
        $layout_arquivo_conteudo = __DIR__ . '/../termos_de_uso/termos_de_uso.php';

    } elseif ($rota_limpa == 'templates/template_html') {

        $layout_titulo = 'Template HTML';
        $layout_arquivo_conteudo = __DIR__ . '/../templates/template_html/template_html.php';


    } elseif ($rota_limpa == '404') {

        $layout_titulo = '404';
        $layout_arquivo_conteudo = __DIR__ . '/../404/404.php';

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
    carregarArquivo(404);
}

?>