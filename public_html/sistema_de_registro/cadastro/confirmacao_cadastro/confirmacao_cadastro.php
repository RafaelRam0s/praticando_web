<?php
    require_once(__DIR__ . '/../../../../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('controller/main_controller.php'));
?>

<div>

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
    <?php else: ?>

        <?php 
            $_GET['token'] = htmlspecialchars($_GET['token']);
            $token_valido = false;

            // Ver se o token existe
            require_once(Rotas::buscar_arquivo('secure/praticando_web/token_de_cadastro.php'));
            $token_informado = Secure_token_de_cadastro::ler_registro_por_valor($_GET['token']);

            $retorno_esperado = [
                'sucesso' => null,
                'mensagem' => null,
                'conteudo' => [
                    [
                        'id' => null,
                        'id_usuario' => null,
                        'valor' => null,
                        'data_de_criacao' => null,
                        'data_de_expiracao' => null,
                        'data_de_uso' => null
                    ]
                ]
            ];

            require_once(Rotas::buscar_arquivo('funcoes_php/comparar_estrutura_de_arrays.php'));
            
            if (estruturas_de_array_iguais($token_informado, $retorno_esperado) == true) {
                if ($token_informado['sucesso'] == 200) {
                    // Ver se não foi utilizado
                    if(empty($token_informado['conteudo'][0]['data_de_uso'])) {
                        // Ver se expirou
                        date_default_timezone_set('UTC');
                        $data_atual = new DateTime();
                        $data_de_expiracao = new DateTime($token_informado['conteudo'][0]['data_de_expiracao']);
    
                        if ($data_de_expiracao > $data_atual) {
                            $token_valido = true;
                        }
                    }
                }
            }
        ?>
        
        <?php if($token_valido == true): ?>
            <?php 
                if (isset($_COOKIE['formulario_confirmacao_cadastro'])) {
        
                    require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));
                    $dados_do_cookie = unserialize(aesDesencriptar($_COOKIE['formulario_confirmacao_cadastro']));
                    
                    require_once(Rotas::buscar_arquivo('funcoes_php/escarpar_dados.php'));
                    $dados_do_cookie = escarpar_dados($dados_do_cookie);
                }    
            ?>

            <!-- Validação de erros no formulário -->
            <?php  if(isset($dados_do_cookie)): ?>
                <p class="aviso_de_erro" style="padding: 10px;">
                    <strong>Validação não realizada:</strong> <br/>
                    <?php 
                        function coletarTextosNaoVazios($array) {
                            $resultados = [];
                            
                            foreach ($array as $item) {
                                if (is_array($item)) {
                                    // Chama a função recursivamente se o item for um array
                                    $resultados = array_merge($resultados, coletarTextosNaoVazios($item));
                                } elseif (!empty($item)) {
                                    // Adiciona o item ao resultado se não estiver vazio
                                    $resultados[] = $item;
                                }
                            }
                            
                            return $resultados;
                        }

                        $textos = array_merge(coletarTextosNaoVazios($dados_do_cookie['respostas']), coletarTextosNaoVazios($dados_do_cookie['inputs']));
                        
                        foreach ($textos as $texto) {
                            echo $texto . "<br/>";
                        }
                    ?>
                </p>
                
            <?php endif;?> 

            <h2>Confirme o seu email</h2>

            <p>Para a segurança da sua conta pedimos que confirme a qual email este token foi vinculado.</p>

            <form action="/sistema_de_registro/cadastro/confirmacao_cadastro/post_confirmacao_cadastro.php" method="POST">
                <label for="id_email">Seu E-mail:</label>
                <input type="hidden" id="id_token" name="name_token" value="<?php echo($_GET['token']); ?>" />
                <input type="email" id="id_email" name="name_email" minlength="3" maxlength="255" required="required" value="<?php if(isset($dados_do_cookie['valores']['value_name_email'])) {echo($dados_do_cookie['valores']['value_name_email']);}?>" />
                
                <button type="submit">Confirmar</button>
            </form>
        <?php elseif($token_valido == false): ?>
            <div>
                <h2>Token inválido</h2>

                <p>Faça login na conta criada para que possamos te ajudar</p>

                <p><a href="/sistema_de_registro/login">Área de Login</a></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
