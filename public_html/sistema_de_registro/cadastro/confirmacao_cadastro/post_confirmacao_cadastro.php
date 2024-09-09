<?php

    require_once(__DIR__ . '/../../../../configuracoes/rotas.php');
    
    // Verifica se o request_method existe, pq vai que a pessoa esteja usando um console para acessar o site
    if (isset($_SERVER['REQUEST_METHOD']) == true) {
        // Verifica se o site recebeu uma solicitação via post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $variaveis_da_pagina = [
                'inputs' => [
                    'name_email' => null,
                    'name_token' => null
                ],

                'respostas' => [
                    'erro_de_formulario' => null,
                    'sucesso_de_formulario' => null,
                    'numero_tentativa' => null
                ],
                
                'valores' => [
                    'value_name_email' => null
                ]
            ];

            $relacao_name_com_campo = [
                'name_email' => 'E-mail',
                'name_token' => 'Token'
            ];

            // Verifica se todos os campos foram passados através do método POST
                $chaves_do_vetor = array_keys($variaveis_da_pagina['inputs']);
                for ($contador = 0; $contador < count($chaves_do_vetor); $contador++) {
                    if (!isset($_POST[$chaves_do_vetor[$contador]])) {
                        $variaveis_da_pagina['inputs'][$chaves_do_vetor[$contador]] = 'O campo "' . $relacao_name_com_campo[$chaves_do_vetor[$contador]] . '" não foi definido!';
                    }
                }

                retornar_pagina_com_avisos();
            //

            // Retornar o valor do campo para o usuário não ter que preencher tudo novamente
                $chaves_do_vetor = array_keys($variaveis_da_pagina['valores']);
                for ($contador = 0; ($contador < count($chaves_do_vetor)); $contador++) {
                    $variaveis_da_pagina['valores'][$chaves_do_vetor[$contador]] = 
                        $_POST[
                            substr(
                                $chaves_do_vetor[$contador], 
                                (strpos(
                                    $chaves_do_vetor[$contador], 
                                    '_'
                                ) + 1)
                            )
                        ];
                }
            //

            // Verifica os campos que ficaram vazios
                $chaves_do_vetor = array_keys($variaveis_da_pagina['inputs']);
                for ($contador = 0; $contador < count($chaves_do_vetor); $contador++) {
                    if (empty($_POST[$chaves_do_vetor[$contador]])) {
                        $variaveis_da_pagina['inputs'][$chaves_do_vetor[$contador]] = 'O campo "' . $relacao_name_com_campo[$chaves_do_vetor[$contador]] . '" está vazio!';

                    } elseif ($_POST[$chaves_do_vetor[$contador]] != trim($_POST[$chaves_do_vetor[$contador]])) {
                        $variaveis_da_pagina['inputs'][$chaves_do_vetor[$contador]] = 'O campo "' . $relacao_name_com_campo[$chaves_do_vetor[$contador]] . '" possui espaços em branco no inicio ou no final!';
                    }
                }

                retornar_pagina_com_avisos();
            //

            // Verifica se cada campo foi preenchido com a quantidade certa de caracteres
                require_once(Rotas::buscar_arquivo('secure/validacoes_de_cadastro.php'));
                
                if ( (strlen($_POST['name_email']) < 3) || (strlen($_POST['name_email']) > 255) ) {
                    $variaveis_da_pagina['inputs']['name_email'] = 'O campo "' . $relacao_name_com_campo['name_email'] . '" não possui a quantidade certa de caracteres';
                }
                retornar_pagina_com_avisos();
            //

            // Pegar ID do Token
                require_once(Rotas::buscar_arquivo('secure/praticando_web/token_de_cadastro.php'));
                $token_informado = Secure_token_de_cadastro::ler_registro_por_valor($_POST['name_token']);

                require_once(Rotas::buscar_arquivo('funcoes_php/comparar_estrutura_de_arrays.php'));
                $resposta_esperada = [
                    'sucesso' => null, 
                    'mensagem' => null,
                    'conteudo' => [[
                        'id' => null,
                        'id_usuario' => null,
                        'valor' => null,
                        'data_de_criacao' => null,
                        'data_de_expiracao' => null,
                        'data_de_uso' => null
                    ]]
                ];

                if (
                    estruturas_de_array_iguais($token_informado, $resposta_esperada) != true
                    || $token_informado['sucesso'] != 200
                ) {
                    $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                    retornar_pagina_com_avisos();
                }
            //
            // Ver quantas tentativas foram feitas
                require_once(Rotas::buscar_arquivo('secure/praticando_web/token_de_cadastro_validacao.php'));
                $numero_tentativa = Secure_token_de_cadastro_validacao::ler_qtd_registros_por_id_token_de_cadastro($token_informado['conteudo'][0]['id']);
                $resposta_esperada = [
                    'sucesso' => null, 
                    'mensagem' => null,
                    'conteudo' => [['qtd' => null]]
                ];

                if (
                    estruturas_de_array_iguais($numero_tentativa, $resposta_esperada) != true
                    || $numero_tentativa['sucesso'] != 200
                ) {
                    $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                    retornar_pagina_com_avisos();
                }
            //
            // Registrar tentativa de validacao
                $novo_registro_de_auditoria = Secure_token_de_cadastro_validacao::criar_registro($token_informado['conteudo'][0]['id'], json_encode($_SERVER), $_POST['name_token']);
                $resposta_esperada = [
                    'sucesso' => null, 
                    'mensagem' => null,
                    'conteudo' => ['id' => null]
                ];
                
                if (
                    estruturas_de_array_iguais($novo_registro_de_auditoria, $resposta_esperada) != true
                    || $novo_registro_de_auditoria['sucesso'] != 200
                ) {
                    $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                    retornar_pagina_com_avisos();
                }
            //
            // Verificar se e-mail está registrado no banco
                require_once(Rotas::buscar_arquivo('secure/praticando_web/usuario.php'));
                $usuario = Secure_usuario::ler_registro_por_email($_POST['name_email']);
                
                if (
                    $usuario['sucesso'] != 200
                    && $numero_tentativa['conteudo'][0]['qtd'] >= 5
                ) {
                    Secure_token_de_cadastro::atualizar_data_de_uso($token_informado['conteudo'][0]['valor']);
                    $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Quantidade de tentativas ultrapassadas!';
                    retornar_pagina_com_avisos();
                }

                if ($usuario['sucesso'] != 200) {
                    $variaveis_da_pagina['respostas']['numero_tentativa'] = 'Você possui mais ' . (5 - $numero_tentativa['conteudo'][0]['qtd']) . ' tentativas de validação.';
                    retornar_pagina_com_avisos();
                }
            //
            // Verificar se o token informado não possui relação com o email informado
                if (
                    $usuario['conteudo'][0]['id'] != $token_informado['conteudo'][0]['id_usuario']
                    && $numero_tentativa['conteudo'][0]['qtd'] >= 5
                ) {
                    Secure_token_de_cadastro::atualizar_data_de_uso($token_informado['conteudo'][0]['valor']);
                    $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Quantidade de tentativas ultrapassadas!';
                    retornar_pagina_com_avisos();
                }

                if ($usuario['conteudo'][0]['id'] != $token_informado['conteudo'][0]['id_usuario']) {
                    $variaveis_da_pagina['respostas']['numero_tentativa'] = 'Você possui mais ' . (5 - $numero_tentativa['conteudo'][0]['qtd']) . ' tentativas de validação.';
                    retornar_pagina_com_avisos();
                }
                
                // Gerar status autorizado
                    require_once(Rotas::buscar_arquivo('secure/praticando_web/usuario_status.php'));
                    $novo_status = Secure_usuario_status::criar_registro($token_informado['conteudo'][0]['id_usuario'], 'Autorizado', 'Token Validado');

                    if ($novo_status['sucesso'] != 200) {
                        $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                        retornar_pagina_com_avisos();
                    }
                //

                // Registrar uso do token
                    $atualizar_token = Secure_token_de_cadastro::atualizar_data_de_uso($token_informado['conteudo'][0]['valor']);
                    if ($atualizar_token['sucesso'] != 200) {
                        // Se status autorizado der erro revogue o status
                        Secure_usuario_status::apagar_registro($novo_status['conteudo'][0]['id']);
                        $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                        retornar_pagina_com_avisos();
                    }
                //

                header('Location: /sistema_de_registro/cadastro/confirmacao_cadastro/confirmado');
                die();
            //
        }
    }




    function retornar_pagina_com_avisos() {
        
        global $variaveis_da_pagina;
        $possui_aviso = false;

        $chaves_do_vetor = array_keys($variaveis_da_pagina['inputs']);
        for ($contador = 0; ($contador < count($chaves_do_vetor)) && ($possui_aviso == false); $contador++) {
            if (isset($variaveis_da_pagina['inputs'][$chaves_do_vetor[$contador]])) {
                $possui_aviso = true;
            }
        }

        $chaves_do_vetor = array_keys($variaveis_da_pagina['respostas']);
        for ($contador = 0; ($contador < count($chaves_do_vetor)) && ($possui_aviso == false); $contador++) {
            if (isset($variaveis_da_pagina['respostas'][$chaves_do_vetor[$contador]])) {
                $possui_aviso = true;
            }
        }
        
        if ($possui_aviso == true) {
            require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));
            
            $dados_do_cookie = serialize($variaveis_da_pagina);
            $dados_do_cookie = aesEncriptar($dados_do_cookie);
    
            setcookie(
                name: 'formulario_confirmacao_cadastro',
                value: $dados_do_cookie,
                expires_or_options: 0, // 0 siginifica que o cookie fica ativo enquanto o navegador estiver aberto // time() + 120 deixa aberto por 2 minutos
                path: '/sistema_de_registro/cadastro', // Define a partir de que caminho o cookie pode ser lido
                domain: '', // Se deixar vazio somente o host que criou pode acessa-lo
                secure: true,
                httponly: true // Garante que o cookie não é acessível por javascript
            );
    
            header('Location: /sistema_de_registro/cadastro/confirmacao_cadastro?token=' . $_POST['name_token']);
            die();
        }
    }

    header('Location: /error/404');
    die();
?>