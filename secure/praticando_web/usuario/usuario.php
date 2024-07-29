<?php 

require_once(__DIR__ . '/../../../configuracoes/rotas.php');

// ------------------------------------------------------------------------
// Criar 
// ------------------------------------------------------------------------
function secure_usuario_registrar(
    string $email,
    string $senha,
    string $nome,
    string $data_nascimento
) {

    convocar_rota('secure/validacoes_de_cadastro');
    // Ver se os parametros estão certos
        if (
            validar_email($email)[0] == false
            || validar_senha($senha)[0] == false
            || validar_nome($nome)[0] == false
            || validar_data_de_nascimento($data_nascimento)[0] == false
        ) {

            error_log('....................... Testando a criacao de usuario .....................', 0);
            error_log((validar_data_de_nascimento($data_nascimento)[1]), 0);
            return [
                'sucesso' => 400,
                'mensagem' => 'Invalido os valores passados no parâmetro da função',
                'conteudo' => []
            ];
        }
    //

    convocar_rota('db/praticando_web/usuario');
    // Resetar auto_increment da tabela usuario
    
        $resetar_auto_increment = tb_usuario_resetar_auto_increment();

        if ($resetar_auto_increment['sucesso'] != 200)
        {
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro ao resetar o auto_increment',
                'conteudo' => []
            ];
        }
        
    //

    // Salvar no banco de dados
        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual = $data_atual->format('Y-m-d H:i:s');

        $retorno_do_banco = tb_usuario_criar(
            email: $email,
            senha: password_hash($senha, PASSWORD_BCRYPT),
            nome: $nome,
            data_nascimento: $data_nascimento,
            termos_de_uso_aceito: $data_atual,
            politica_de_privacidade_aceito: $data_atual,
            data_de_cadastro: $data_atual
        );
    // 

    return $retorno_do_banco;

}

// ------------------------------------------------------------------------
// Visualizar 
// ------------------------------------------------------------------------
function secure_usuario_ver(string $email)
{
    // Ver se os parametros estão certos
        convocar_rota('secure/validacoes_de_cadastro');
        if (validar_email($email)[0] == false) 
        {
            return [
                'sucesso' => 400,
                'mensagem' => 'Invalido os valores passados no parâmetro da função',
                'conteudo' => []
            ];
        }   
    //

    // Pegar do banco de dados
        convocar_rota('db/praticando_web/usuario');
        $retorno_do_banco = tb_usuario_buscar_por_email(email: $email);
    //
    return $retorno_do_banco;
}

?>