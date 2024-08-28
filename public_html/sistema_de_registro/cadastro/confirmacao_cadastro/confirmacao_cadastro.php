<div>

    <?php 
        require_once(__DIR__ . '/../../../../configuracoes/rotas.php');
        
        if (isset($_GET['token'])) {
            $_GET['token'] = htmlspecialchars($_GET['token']);
            $token_valido = false;

            // Ver se o token existe
            convocar_rota('secure/praticando_web/token_de_cadastro');
            $token_informado = secure_token_de_cadastro_buscar_valor($_GET['token']);

            if ($token_informado['sucesso'] == 200) {
                // Ver se não foi utilizado
                if(empty($token_informado['conteudo']['data_de_uso'])) {
                    // Ver se expirou
                    date_default_timezone_set('UTC');
                    $data_atual = new DateTime();
                    $data_de_expiracao = new DateTime($token_informado['conteudo']['data_de_expiracao']);
        
                    if ($data_de_expiracao > $data_atual) {
                        // Gerar status autorizado
                        convocar_rota('secure/praticando_web/usuario_status');
                        $novo_status = secure_usuario_status_criar($token_informado['conteudo']['id_usuario'], 'Autorizado', 'Token Validado');

                        if ($novo_status['sucesso'] == 200) {
                            // Registrar uso do token
                            $atualizar_token = secure_token_de_cadastro_atualizar_data_de_uso($token_informado['conteudo']['id']);

                            if ($atualizar_token['sucesso'] == 200) {
                                $token_valido = true;
                            } else {
                                // Se status autorizado der erro revogue o status
                                secure_usuario_status_excluir($novo_status['conteudo']['id']);
                                $token_valido = 'erro';
                            }

                        } else {
                            $token_valido = 'erro';
                        }
                    }
                }
            }
        }
    ?>

    <?php if (!isset($token_valido)): ?>
        <div>
            <h2>Estamos quase lá!</h2>

            <p>Enviamos uma mensagem para o seu e-mail, por favor confirme através dele o seu login para que possamos continuar!</p>

            <p>
                Caso não tenha recebido, certifique-se das seguintes dicas;
                <ul>
                    <li>Veja se a caixa de mensagens está atualizada</li>
                    <li>Verifique se o email não caiu em Spam</li>
                    <li>Garanta que nossos emails não estão sendo enviados para a Lixeira</li>
                </ul>    
            </p>
            
            <p>Se mesmo verificando o seu e-mail a mensagem ainda não foi enviada, faça login na conta criada para que possamos te ajudar</p>

            <p><a href="/sistema_de_registro/login">Área de Login</a></p>
        </div>
    <?php endif; ?>

    <?php if(isset($token_valido)): ?>
        <?php if($token_valido == true): ?>
            <div>
                <h2>Cadastro Confirmado</h2>

                <p>Email confirmado com sucesso, acesse a <a href="/sistema_de_registro/login">área de login</a> para utilizar nossos serviços</p>
            </div>
        <?php endif; ?>
        <?php if($token_valido == false): ?>
            <div>
                <h2>Token inválido</h2>

                <p>Faça login na conta criada para que possamos te ajudar</p>

                <p><a href="/sistema_de_registro/login">Área de Login</a></p>
            </div>
        <?php endif; ?>
        <?php if($token_valido === 'erro'): ?>
            <p class="aviso_de_erro">Um erro inesperado ocorreu com o seu token</p>
        <?php endif; ?>
    <?php endif; ?>

</div>