<?php 

require_once(__DIR__ . '/../../configuracoes/rotas.php');

// ------------------------------------------------------------------------
// Criar 
// ------------------------------------------------------------------------
function secure_usuario_status_criar(
    int $id_usuario,
    string $status,
    ?string $observacao
) {

    convocar_rota('db/praticando_web/usuario_status');

    // Resetar auto_increment
        $resetar_auto_increment = tb_usuario_status_resetar_auto_increment();

        if ($resetar_auto_increment['sucesso'] != 200) {
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro ao resetar o auto_increment',
                'conteudo' => null
            ];
        }
    //

    // Salvar no banco de dados
        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual = $data_atual->format('Y-m-d H:i:s');

        $retorno_do_banco = tb_usuario_status_criar(
            id_usuario: $id_usuario,
            status: $status,
            observacao: $observacao,
            data_de_cadastro: $data_atual
        );
    // 

    return $retorno_do_banco;
}

// ------------------------------------------------------------------------
// Visualizar 
// ------------------------------------------------------------------------
function secure_usuario_status_situacao($id_usuario) {

    convocar_rota('db/praticando_web/usuario_status');

    return tb_usuario_status_buscar_id_usuario($id_usuario);
}

// ------------------------------------------------------------------------
// Apagar
// ------------------------------------------------------------------------
function secure_usuario_status_excluir($id_usuario_status) {
    
    convocar_rota('db/praticando_web/usuario_status');

    return tb_usuario_status_excluir($id_usuario_status);
}

?>