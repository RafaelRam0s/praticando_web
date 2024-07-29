<?php 
    /* 
        Captar o cookie de quando o usuário envia o formulário, mas possue erro no preenchimento 
        @@@ Testar php, javascript e sql injection feitos no cookie
    */
    
    if (isset($_COOKIE['formulario_cadastro']))
    {
        require_once(__DIR__ . '/../../../configuracoes/rotas.php');
        convocar_rota('config/configuracoes');
        $dados_do_cookie = unserialize(aesDesencriptar($_COOKIE['formulario_cadastro']));
    }

?>

<div>
    <h2>Cadastro</h2>

    <p>Preencha o formulário para que participe do nosso sistema, caso já possua uma conta entre <a href="/sistema_de_registro/login">aqui</a></p>
    
    <!-- Validação de erros no formulário -->
        <?php 
            if(isset($dados_do_cookie)):
        ?>
            <p>Erro no formulário:</p>
            <pre>
                <?php 
                    print_r($dados_do_cookie);
                ?>
            </pre>
        <?php endif;?> 
    

    <div>
        <form id="form_cadastro" method="POST" action="./cadastro/post_cadastro/index.php">
            
            <h3>Dados pessoais</h3>
            
            <div>
                <h4>
                    <label for="id_nome_completo">Nome completo:</label>
                </h4>
                <input type="text" id="id_nome_completo" name="name_nome_completo" minlength="2" maxlength="255" required="required" />
            </div>
            <div>
                <h4>
                    <label for="id_dia_nascimento">Data de nascimento:</label>
                </h4>

                <input type="text" id="id_dia_nascimento" name="name_dia_nascimento" placeholder="Dia" minlength="1" maxlength="2" required="required">
                <input type="text" id="id_mes_nascimento" name="name_mes_nascimento" placeholder="Mês" minlength="1" maxlength="2" required="required">
                <input type="text" id="id_ano_nascimento" name="name_ano_nascimento" placeholder="Ano" minlength="1" maxlength="4" required="required">
            </div>
            
            <h3>Acesso</h3>
            
            <div>
                <h4>
                    <label for="id_email">E-mail:</label>
                </h4>
                <input type="email" id="id_email" name="name_email" minlength="3" maxlength="255" required="required" />
            </div>
            
            <div>
                <h4>
                    <label for="id_confirmacao_de_email">Confirmação de E-mail:</label>
                </h4>
                <input type="email" id="id_confirmacao_de_email" name="name_confirmacao_de_email" minlength="3" maxlength="255" required="required" />
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
                    <input type="checkbox" id="id_termos_de_uso" name="name_termos_de_uso" value="true" required="required">
                    <label for="id_termos_de_uso">Li e aceito os <a href="/termos_de_uso" target="_blank">Termos de uso</a></label>
                </div>
                
                <div>
                    <input type="checkbox" id="id_politica_de_privacidade" name="name_politica_de_privacidade" value="true" required="required">
                    <label for="id_politica_de_privacidade">Li e aceito a <a href="/politica_de_privacidade" target="_blank">Política de privacidade</a></label>
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="subtmit">Enviar</button>
                <button type="reset">Limpar formulário</button>
            </div>
        </form>
        
        <hr>
        
        <button type="button" onclick="preenchimento_rapido_de_formulario()">Preencher automaticamente o formulário</button>
    </div>
</div>

<script>
    
    function preenchimento_rapido_de_formulario() {
        document.getElementById('id_nome_completo').value = 'Rafael Ramos';
        document.getElementById('id_email').value = 'rafael6otaku@gmail.com';
        document.getElementById('id_confirmacao_de_email').value = 'rafael6otaku@gmail.com';
        document.getElementById('id_dia_nascimento').value = '13';
        document.getElementById('id_mes_nascimento').value = '07';
        document.getElementById('id_ano_nascimento').value = '2002';
        document.getElementById('id_senha').value = 'Teste123!';
        document.getElementById('id_confirmacao_senha').value = 'Teste123!';
        document.getElementById('id_termos_de_uso').setAttribute('checked', 'checked');
        document.getElementById('id_politica_de_privacidade').setAttribute('checked', 'checked');
    }
    
</script>

