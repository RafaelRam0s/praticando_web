<div>

    <?php 
        require_once(__DIR__ . '/../../../../configuracoes/rotas.php');
        
        if (isset($_GET['token'])) {
            $_GET['token'] = htmlspecialchars($_GET['token']);

            // Ver se o token existe
            convocar_rota('secure/praticando_web/token_de_cadastro');
            
            // Ver se expirou
            // Ver se não foi utilizado
            // Gerar status autorizado
            // Se status autorizado der erro limpe a data de uso do cookie
            
            
            $resposta = secure_token_de_cadastro_atualizar_data_de_uso($_GET['token']);
            
            if ($resposta['sucesso'] == 200) {
                // Autorizar o status
                convocar_rota('secure/praticando_web/usuario_status');
                $novo_status = secure_usuario_status_criar(, 'Autorizado', 'Validado por token');
                if ($novo_status['sucesso'] != 200) {
                    
                }
            }
        }
        
    ?>

    <?php if (!isset($_GET['token'])): ?>
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

    <?php if(isset($resposta)): ?>
        <?php if($resposta['sucesso'] == 200): ?>
            <div>
                <h2>Cadastro Confirmado</h2>

                <p>Email confirmado com sucesso, acesse a <a href="/sistema_de_cadastro/login">área de login</a> para utilizar nossos serviços</p>
            </div>
        <?php endif; ?>
        <?php if($resposta['sucesso'] != 200): ?>
            <div>
                <h2>Token inválido</h2>

                <p>Faça login na conta criada para que possamos te ajudar</p>

                <p><a href="/sistema_de_registro/login">Área de Login</a></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>