<?php 
    require_once(__DIR__ . '/../../../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('controller/main_controller.php'));

    if (isset($_COOKIE['formulario_cadastro'])) {
        
        require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));

        $dados_do_cookie = unserialize(aesDesencriptar($_COOKIE['formulario_cadastro']));
        $dados_do_cookie = escaparDados($dados_do_cookie);

        function escaparDados($dados) {
            if (is_array($dados)) {
                foreach ($dados as &$valor) {
                    $valor = escaparDados($valor); // Chamada recursiva para arrays aninhados
                }
                unset($valor); // Importante: Desfaz a referência do último item
            } elseif (is_string($dados)) {
                // Aplica htmlspecialchars diretamente em strings
                if (isset($dados)) {
                    $dados = htmlspecialchars($dados, ENT_QUOTES, 'UTF-8');
                }
            }
            return $dados;
        }
    }
?>

<div>

    <!-- Validação de erros no formulário -->
    <?php  if(isset($dados_do_cookie)): ?>
        <p class="aviso_de_erro" style="padding: 10px;">
            <strong>Cadastro não realizado:</strong> <br/>
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

    <h2>Cadastro</h2>

    <p>Preencha o formulário para que participe do nosso sistema, caso já possua uma conta entre <a href="/sistema_de_registro/login">aqui</a></p>

    <div>
        <form id="form_cadastro" method="POST" action="/sistema_de_registro/cadastro/post_cadastro/index.php">
            
            <h3>Dados pessoais</h3>
            
            <div>
                <h4>
                    <label for="id_nome_completo">Nome completo:</label>
                </h4>
                <input type="text" id="id_nome_completo" name="name_nome_completo" minlength="2" maxlength="255" required="required" value="<?php if(isset($dados_do_cookie['valores']['value_name_nome_completo'])) {echo($dados_do_cookie['valores']['value_name_nome_completo']);}?>" />
            </div>
            <div>
                <h4>
                    <label for="id_dia_nascimento">Data de nascimento:</label>
                </h4>

                <label for="id_dia_nascimento">Dia:</label>
                <input type="text" id="id_dia_nascimento" name="name_dia_nascimento" placeholder="Dia" minlength="1" maxlength="2" required="required" value="<?php if(isset($dados_do_cookie['valores']['value_name_dia_nascimento'])) {echo($dados_do_cookie['valores']['value_name_dia_nascimento']);}?>">
                <label for="id_mes_nascimento">Mês:</label>
                <input type="text" id="id_mes_nascimento" name="name_mes_nascimento" placeholder="Mês" minlength="1" maxlength="2" required="required" value="<?php if(isset($dados_do_cookie['valores']['value_name_mes_nascimento'])) {echo($dados_do_cookie['valores']['value_name_mes_nascimento']);}?>">
                <label for="id_ano_nascimento">Ano:</label>
                <input type="text" id="id_ano_nascimento" name="name_ano_nascimento" placeholder="Ano" minlength="1" maxlength="4" required="required" value="<?php if(isset($dados_do_cookie['valores']['value_name_ano_nascimento'])) {echo($dados_do_cookie['valores']['value_name_ano_nascimento']);}?>">
            </div>
            
            <h3>Acesso</h3>
            
            <div>
                <h4>
                    <label for="id_email">E-mail:</label>
                </h4>
                <input type="email" id="id_email" name="name_email" minlength="3" maxlength="255" required="required" value="<?php if(isset($dados_do_cookie['valores']['value_name_email'])) {echo($dados_do_cookie['valores']['value_name_email']);}?>" />
            </div>
            
            <div>
                <h4>
                    <label for="id_confirmacao_de_email">Confirmação de E-mail:</label>
                </h4>
                <input type="email" id="id_confirmacao_de_email" name="name_confirmacao_de_email" minlength="3" maxlength="255" required="required" value="<?php if(isset($dados_do_cookie['valores']['value_name_confirmacao_de_email'])) {echo($dados_do_cookie['valores']['value_name_confirmacao_de_email']);}?>" />
            </div>

            <div>
                <h4>
                    <label for="id_senha">Senha:</label> 
                </h4>
                <input type="password" id="id_senha" name="name_senha" minlength="8" maxlength="255" required="required" />
                <!-- <div class="requisitos_de_senha">
                    <p>A senha deverá ter:</p>
                    <ul>
                        <li>Mínimo de 8 caracteres</li>
                        <li>Letra minúscula</li>
                        <li>Letra maiúscula</li>
                        <li>Número</li>
                        <li>Caracter especial</li>
                    </ul>
                </div> -->
            </div>
            
            <div>
                <h4>
                    <label for="id_confirmacao_senha">Confirmação de Senha:</label>
                </h4>
                <input type="password" id="id_confirmacao_senha" name="name_confirmacao_senha" minlength="8" maxlength="255" required="required" />
            </div>

            <div>
                <div>
                    <input type="checkbox" id="id_termos_de_uso" name="name_termos_de_uso" value="true" required="required" <?php if(isset($dados_do_cookie['valores']['checked_name_termos_de_uso'])) {echo('checked="checked"');}?>/>
                    <label for="id_termos_de_uso">Li e aceito os <a href="/termos_de_uso" target="_blank">Termos de uso</a></label>
                </div>
                
                <div>
                    <input type="checkbox" id="id_politica_de_privacidade" name="name_politica_de_privacidade" value="true" required="required" <?php if(isset($dados_do_cookie['valores']['checked_name_termos_de_uso'])) {echo('checked="checked"');}?> />
                    <label for="id_politica_de_privacidade">Li e aceito a <a href="/politica_de_privacidade" target="_blank">Política de privacidade</a></label>
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="subtmit">Cadastrar</button>
            </div>
        </form>
        
        <hr>
        
    </div>
</div>
