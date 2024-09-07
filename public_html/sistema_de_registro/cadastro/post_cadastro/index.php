<?php

    require_once(__DIR__ . '/../../../../configuracoes/rotas.php');
    
    // Verifica se o request_method existe, pq vai que a pessoa esteja usando um console para acessar o site
    if (isset($_SERVER['REQUEST_METHOD']) == true) {
        // Verifica se o site recebeu uma solicitação via post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $variaveis_da_pagina = [
                'inputs' => [
                    'name_nome_completo' => null,
                    'name_dia_nascimento' => null,
                    'name_mes_nascimento' => null,
                    'name_ano_nascimento' => null,
                    'name_email' => null,
                    'name_confirmacao_de_email' => null,
                    'name_senha' => null,
                    'name_confirmacao_senha' => null,
                    'name_termos_de_uso' => null,
                    'name_politica_de_privacidade' => null
                ],

                'respostas' => [
                    'erro_de_formulario' => null,
                    'sucesso_de_formulario' => null,
                    'data_nascimento' => null
                ],
                
                'valores' => [
                    'value_name_nome_completo' => null,
                    'value_name_dia_nascimento' => null,
                    'value_name_mes_nascimento' => null,
                    'value_name_ano_nascimento' => null,
                    'value_name_email' => null,
                    'value_name_confirmacao_de_email' => null,
                    'checked_name_termos_de_uso' => null,
                    'checked_name_politica_de_privacidade' => null,
                ]
            ];

            $relacao_name_com_campo = [
                'name_nome_completo' => 'Nome Completo',
                'name_dia_nascimento' => 'Dia de Nascimento',
                'name_mes_nascimento' => 'Mês de Nascimento',
                'name_ano_nascimento' => 'Ano de Nascimento',
                'name_email' => 'E-mail',
                'name_confirmacao_de_email' => 'Confirmação de E-mail',
                'name_senha' => 'Senha',
                'name_confirmacao_senha' => 'Confirmação de Senha',
                'name_termos_de_uso' => 'Termos de uso',
                'name_politica_de_privacidade' => 'Política de privacidade'
            ];

            // Verifica se todos os campos foram passados através do método POST
                $chaves_do_vetor = array_keys($variaveis_da_pagina['inputs']);
                for ($contador = 0; $contador < count($chaves_do_vetor); $contador++) {
                    if (!isset($_POST[$chaves_do_vetor[$contador]]))
                    {
                        $variaveis_da_pagina['inputs'][$chaves_do_vetor[$contador]] = 'O campo "' . $relacao_name_com_campo[$chaves_do_vetor[$contador]] . '" não foi definido!';
                    }
                }

                retornar_pagina_com_avisos();
            //

            // Retornar o valor do campo para o usuário não ter que preencher tudo novamente
                $chaves_do_vetor = array_keys($variaveis_da_pagina['valores']);
                for ($contador = 0; ($contador < count($chaves_do_vetor)); $contador++)
                {
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
                
                if ( (strlen($_POST['name_nome_completo']) < 2) || (strlen($_POST['name_nome_completo']) > 255) ) {
                    $variaveis_da_pagina['inputs']['name_nome_completo'] = 'O campo "' . $relacao_name_com_campo['name_nome_completo'] . '" não possui a quantidade certa de caracteres';
                }
                if ( (strlen($_POST['name_dia_nascimento']) < 1) || (strlen($_POST['name_dia_nascimento']) > 2) ) {
                    $variaveis_da_pagina['inputs']['name_dia_nascimento'] = 'O campo "' . $relacao_name_com_campo['name_dia_nascimento'] . '" não possui a quantidade certa de caracteres';
                }
                if ( (strlen($_POST['name_mes_nascimento']) < 1) || (strlen($_POST['name_mes_nascimento']) > 2) ) {
                    $variaveis_da_pagina['inputs']['name_mes_nascimento'] = 'O campo "' . $relacao_name_com_campo['name_mes_nascimento'] . '" não possui a quantidade certa de caracteres';
                }
                if ( (strlen($_POST['name_ano_nascimento']) < 1) || (strlen($_POST['name_ano_nascimento']) > 4) ) {
                    $variaveis_da_pagina['inputs']['name_ano_nascimento'] = 'O campo "' . $relacao_name_com_campo['name_ano_nascimento'] . '" não possui a quantidade certa de caracteres';
                }
                if ( (strlen($_POST['name_email']) < 3) || (strlen($_POST['name_email']) > 255) ) {
                    $variaveis_da_pagina['inputs']['name_email'] = 'O campo "' . $relacao_name_com_campo['name_email'] . '" não possui a quantidade certa de caracteres';
                }
                if ( (strlen($_POST['name_confirmacao_de_email']) < 3) || (strlen($_POST['name_confirmacao_de_email']) > 255) ) {
                    $variaveis_da_pagina['inputs']['name_confirmacao_de_email'] = 'O campo "' . $relacao_name_com_campo['name_confirmacao_de_email'] . '" não possui a quantidade certa de caracteres';
                }
                if ( (strlen($_POST['name_senha']) < 8) || (strlen($_POST['name_senha']) > 255) ) {
                    $variaveis_da_pagina['inputs']['name_senha'] = 'O campo "' . $relacao_name_com_campo['name_senha'] . '" não possui a quantidade certa de caracteres';
                }
                if ( (strlen($_POST['name_confirmacao_senha']) < 8) || (strlen($_POST['name_confirmacao_senha']) > 255) ) {
                    $variaveis_da_pagina['inputs']['name_confirmacao_senha'] = 'O campo "' . $relacao_name_com_campo['name_confirmacao_senha'] . '" não possui a quantidade certa de caracteres';
                }
                retornar_pagina_com_avisos();
            //

            // Validação dos valores dos campos informados
                // Verificar data de nascimento
                    
                    // Verificar se os valores passados são apenas números
                    if (
                        preg_match("/^[0-9]+$/", $_POST['name_dia_nascimento']) == true
                        && preg_match("/^[0-9]+$/", $_POST['name_mes_nascimento']) == true
                        && preg_match("/^[0-9]+$/", $_POST['name_ano_nascimento']) == true
                    ) {
                        date_default_timezone_set('UTC');
                        $data_formatada = new DateTime();
                        $data_formatada->setDate(
                            year: $_POST['name_ano_nascimento'], 
                            month: $_POST['name_mes_nascimento'], 
                            day: $_POST['name_dia_nascimento']
                        );
                        $data_formatada->setTime(0,0,0);
                        
                        // Verificar se a data informada existe no calendário, por exemplo não existe o dia 30/02/2023, pois o mês daquele ano acabava no dia 28
                        if (
                            $data_formatada->format('Y') == $_POST['name_ano_nascimento']
                            && $data_formatada->format('m') == $_POST['name_mes_nascimento']
                            && $data_formatada->format('d') == $_POST['name_dia_nascimento']
                        ) {
                            // Verificar se a data informada é menor que o dia atual ou maior que 200 anos atrás
                           
                            date_default_timezone_set('UTC');
                            $data_atual = new DateTime();
                            if ( ($data_atual->format('Y/m/d') < $data_formatada->format('Y/m/d')) )
                            {
                                $variaveis_da_pagina['repostas']['data_nascimento'] = 'O campo "Data de Nascimento" possui uma data muito no futuro';
                            } elseif ( ($data_atual->sub(new DateInterval('P200Y'))->format('Y/m/d')) > $data_formatada->format('Y/m/d') )
                            {
                                $variaveis_da_pagina['repostas']['data_nascimento'] = 'O campo "Data de Nascimento" possui uma data muito no passado';
                            }

                        } else {
                            $variaveis_da_pagina['repostas']['data_nascimento'] = 'O campo "Data de Nascimento" possui uma data inválida';
                        }
                    } else {
                        $variaveis_da_pagina['repostas']['data_nascimento'] = 'O campo "Data de Nascimento" possui caracteres inválidos';
                    }
                //

                // Verificar e-mail e confirmação de e-mail
                    if (strrpos($_POST['name_email'], '@') === false) {
                        $variaveis_da_pagina['inputs']['name_email'] = 'Este e-mail não pode ser cadastrado';
                    }

                    if ($_POST['name_email'] != $_POST['name_confirmacao_de_email']) {
                        $variaveis_da_pagina['inputs']['name_confirmacao_email'] = 'O E-mail e a Confirmação de E-mail devem ser iguais';
                    }
                //

                // Verificar senha e a confimação de senha
                    if ( preg_match('/[a-z]/', $_POST['name_senha']) != 1 ) {
                        $variaveis_da_pagina['inputs']['name_senha'] = 'A senha deve conter ao menos 1 caracter minúsculo';
                    } else if ( preg_match('/[A-Z]/', $_POST['name_senha']) != 1 ) {
                        $variaveis_da_pagina['inputs']['name_senha'] = 'A senha deve conter ao menos 1 caracter maiúsculo';
                    } else if ( preg_match('/[0-9]/', $_POST['name_senha']) != 1 ) {
                        $variaveis_da_pagina['inputs']['name_senha'] = 'A senha deve conter ao menos um número';
                    } else if ( preg_match('/[\W|_]/', $_POST['name_senha']) != 1 ) {
                        $variaveis_da_pagina['inputs']['name_senha'] = 'A senha deve conter ao menos 1 caracter especial';
                    }

                    if ($_POST['name_senha'] != $_POST['name_confirmacao_senha'])
                    {
                        $variaveis_da_pagina['inputs']['name_confirmacao_senha'] = 'A senha e a Confirmação de senha devem ser iguais';
                    }
                //

                // Verificar se foi assinado os termos de uso e a política de privacidade
                    if ( (string)$_POST['name_termos_de_uso'] !== 'true') 
                    {
                        $variaveis_da_pagina['inputs']['name_termos_de_uso'] = 'É necessário assinalar o campo "Termos de Uso"!';
                    }

                    if ( (string)$_POST['name_politica_de_privacidade'] !== 'true') 
                    {
                        $variaveis_da_pagina['inputs']['name_politica_de_privacidade'] = 'É necessário assinalar o campo "Política de privacidade"!';
                    }
                //

                retornar_pagina_com_avisos();
            //

            // Ver se o usuário não possui cadastro
                require_once(Rotas::buscar_arquivo('secure/praticando_web/usuario.php'));

                $usuario = Secure_usuario::ler_registro_por_email($_POST['name_email']);
                
                if ($usuario['sucesso'] == 200) {

                    if (isset($usuario['conteudo'][0]) == true) {
                        $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'E-mail já registrado. Cadastro Indisponíel!';
                        retornar_pagina_com_avisos();
                    }

                    // Criar conta
                        $novo_usuario = Secure_usuario::criar_registro(
                            email: $_POST['name_email'],
                            senha: $_POST['name_senha'],
                            nome: $_POST['name_nome_completo'],
                            data_nascimento: (
                                (string) $_POST['name_ano_nascimento'] 
                                . '-' . $_POST['name_mes_nascimento']
                                . '-' . $_POST['name_dia_nascimento']
                            )
                        );
                        
                        if ($novo_usuario['sucesso'] != 200) {
                            $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                            retornar_pagina_com_avisos();
                        }
                    //
                    
                    // Gerar status pendente para o usuario
                        require_once(Rotas::buscar_arquivo('secure/praticando_web/usuario_status.php'));
                        $novo_status = Secure_usuario_status::criar_registro($novo_usuario['conteudo']['id'], 'Pendente', 'Cadastro Criado');

                        if ($novo_status['sucesso'] != 200) {
                            
                            Secure_usuario::apagar_registro($novo_usuario['conteudo']['id']);

                            $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                            retornar_pagina_com_avisos();
                        }
                    //

                    // Gerar um token de acesso
                        require_once(Rotas::buscar_arquivo('secure/praticando_web/token_de_cadastro.php'));
                        $token_de_cadastro = Secure_token_de_cadastro::gerar_token_alfa_numerico(255);
                        $novo_token = Secure_token_de_cadastro::criar_registro($novo_usuario['conteudo']['id'], $token_de_cadastro);

                        if ($novo_token['sucesso'] != 200) {
                            
                            Secure_usuario_status::apagar_registro($novo_status['conteudo']['id']);
                            Secure_usuario::apagar_registro($novo_usuario['conteudo']['id']);

                            $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                            retornar_pagina_com_avisos();
                        }
                    //

                    // Registrar envio de e-mail
                        require_once(Rotas::buscar_arquivo('secure/praticando_web/historico_de_email.php'));
                        $historico_de_email = Secure_historico_de_email::criar_registro($novo_usuario['conteudo']['id'], 'Confimação de Cadastro');
                        
                        if ($historico_de_email['sucesso'] != 200) {
                                    
                            Secure_token_de_cadastro::apagar_registro($novo_token['conteudo']['id']);
                            Secure_usuario_status::apagar_registro($novo_status['conteudo']['id']);
                            Secure_usuario::apagar_registro($novo_usuario['conteudo']['id']);

                            $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                            retornar_pagina_com_avisos();
                        }
                    //

                    // Enviar e-mail de confirmação de cadastro
                        require_once(Rotas::buscar_arquivo('email/confirmar_cadastro.php'));
                        $envio_do_email = email_confirmar_cadastro($_POST['name_email'], $token_de_cadastro);

                        if ($envio_do_email['sucesso'] != 200) {
                                
                            Secure_historico_de_email::apagar_registro($historico_de_email['conteudo']['id']);
                            Secure_token_de_cadastro::apagar_registro($novo_token['conteudo']['id']);
                            Secure_usuario_status::apagar_registro($novo_status['conteudo']['id']);
                            Secure_usuario::apagar_registro($novo_usuario['conteudo']['id']);

                            $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                            retornar_pagina_com_avisos();
                        }
                    //

                    // Se der certo, redirecione para a página de cadastro bem sucedido
                    header('Location: /sistema_de_registro/cadastro/confirmacao_cadastro');
                    die();
                } else {
                    $variaveis_da_pagina['respostas']['erro_de_formulario'] = 'Um erro interno ocorreu, tente novamente! ' . __LINE__;
                    retornar_pagina_com_avisos();
                }
            //
        }
    }




    function retornar_pagina_com_avisos() {
        
        global $variaveis_da_pagina;
        $possui_aviso = false;

        $chaves_do_vetor = array_keys($variaveis_da_pagina['inputs']);
        for ($contador = 0; ($contador < count($chaves_do_vetor)) && ($possui_aviso == false); $contador++)
        {
            if (isset($variaveis_da_pagina['inputs'][$chaves_do_vetor[$contador]]))
            {
                $possui_aviso = true;
            }
        }

        $chaves_do_vetor = array_keys($variaveis_da_pagina['respostas']);
        for ($contador = 0; ($contador < count($chaves_do_vetor)) && ($possui_aviso == false); $contador++)
        {
            if (isset($variaveis_da_pagina['respostas'][$chaves_do_vetor[$contador]]))
            {
                $possui_aviso = true;
            }
        }
        
        if ($possui_aviso == true) 
        {
            require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));
            
            $dados_do_cookie = serialize($variaveis_da_pagina);
            $dados_do_cookie = aesEncriptar($dados_do_cookie);
    
            setcookie(
                name: 'formulario_cadastro',
                value: $dados_do_cookie,
                expires_or_options: 0, // 0 siginifica que o cookie fica ativo enquanto o navegador estiver aberto // time() + 120 deixa aberto por 2 minutos
                path: '/sistema_de_registro/cadastro', // Define a partir de que caminho o cookie pode ser lido
                domain: '', // Se deixar vazio somente o host que criou pode acessa-lo
                secure: true,
                httponly: true // Garante que o cookie não é acessível por javascript
            );
    
            header('Location: /sistema_de_registro/cadastro');
            die();
        }
    }

    require_once(Rotas::buscar_arquivo('controller/main_controller.php'));
?>