<?php 

    require_once(__DIR__ . '/../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('configuracoes/seguranca_de_cabecalho.php'));

    function carregar_pagina(string $url_da_pagina) {

        $rota_limpa = tratar_url($url_da_pagina);

        $layout_arquivo_conteudo = 'public_html/error/404/404.php';
        $layout_titulo = '404';
        $layout_descricao = 'Página não encontrada ou alguma funcionalidade não está disponível';
        $layout_palavras_chaves = 'erro';

        if ($rota_limpa == '' || $rota_limpa == 'home') {
            
            $layout_arquivo_conteudo = 'public_html/home/home.php';
            $layout_titulo = 'Meu perfil';
            $layout_descricao = 'Olá sou Rafael Ramos, um estudante adquirindo cada vez mais conhecimento nos diversos ramos da programação não se fixando apenas desenvolvimento web, mas tendo ela como principal foco.';
            $layout_palavras_chaves = 'html, css, javascript, php, programador, perfil, estudante';

        } elseif ($rota_limpa == 'politica_de_privacidade') {

            $layout_arquivo_conteudo = 'public_html/politica_de_privacidade/politica_de_privacidade.php';
            $layout_titulo = 'Política de privacidade';

        } elseif ($rota_limpa == 'termos_de_uso') {
            
            $layout_arquivo_conteudo = 'public_html/termos_de_uso/termos_de_uso.php';
            $layout_titulo = 'Termos de uso';

        } elseif ($rota_limpa == 'templates/template_html') {
            
            $layout_arquivo_conteudo = 'public_html/templates/template_html/template_html.php';
            $layout_titulo = 'Template html';

        } elseif ($rota_limpa == 'sistema_de_registro/cadastro') {
            
            require_once(Rotas::buscar_arquivo('public_html/sistema_de_registro/cadastro/header_cadastro.php'));
            
            $layout_arquivo_conteudo = 'public_html/sistema_de_registro/cadastro/cadastro.php';
            $layout_titulo = 'Cadastramento';

        } elseif ($rota_limpa == 'sistema_de_registro/cadastro/confirmacao_cadastro') {
            
            $layout_arquivo_conteudo = 'public_html/sistema_de_registro/cadastro/confirmacao_cadastro/confirmacao_cadastro.php';
            $layout_titulo = 'Confirme o Cadastro';

        } elseif ($rota_limpa == 'sistema_de_registro/login') {

            $layout_arquivo_conteudo = 'public_html/sistema_de_registro/login/login.php';
            $layout_titulo = 'Login';

        } elseif ($rota_limpa == 'error/404') {

            $layout_arquivo_conteudo = 'public_html/error/404/404.php';
            $layout_titulo = '404';
            $layout_descricao = 'Página não encontrada ou alguma funcionalidade não está disponível';
            $layout_palavras_chaves = 'erro';
            
        } else {

            require_once(Rotas::buscar_arquivo('controller/logado_controller.php'));

        }
        
        require_once(Rotas::buscar_arquivo('layout/layout_rancode.php'));
        die();
    }

    function tratar_url(string $caminho_da_url) : string {
        // Tratamento da url
        
        // Transformar em um vetor, separando onde tiver a presença da /
        $lista_de_rotas = explode('/', $caminho_da_url);
        $lista_de_rotas_limpa = [];

        for ($contador = 0; $contador < count($lista_de_rotas); $contador++) {
            if ($lista_de_rotas[$contador] != '') {
                $lista_de_rotas_limpa[] = $lista_de_rotas[$contador];
            }
        }

        // Limpar rota final, caso esteja com os símbolos ? ou #
        if($lista_de_rotas_limpa == null) {
            $lista_de_rotas_limpa[] = '';
        }

        if (str_contains($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '?') === true) {
            $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1] = mb_substr(
                $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], 
                0, 
                mb_strpos($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '?')
            );
        } 
        if (str_contains($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '#') === true) {
            $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1] = mb_substr(
                $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], 
                0,
                mb_strpos($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '#')
            );
        }

        return implode('/', $lista_de_rotas_limpa);
    }

    if (isset($_SERVER['REQUEST_URI'])) {
        carregar_pagina($_SERVER['REQUEST_URI']);
    } else {
        carregar_pagina('error/404');
    }

?>