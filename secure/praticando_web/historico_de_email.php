<?php 

require_once(__DIR__ . '/../../configuracoes/rotas.php');

// ------------------------------------------------------------------------
// Criar 
// ------------------------------------------------------------------------
function secure_historico_de_email_criar($id_usuario, $assunto) {

    convocar_rota('db/praticando_web/historico_de_email');

    // Resetar auto_increment
        $resetar_auto_increment = tb_historico_de_email_resetar_auto_increment();

        if ($resetar_auto_increment['sucesso'] != 200) {
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro ao resetar o auto_increment',
                'conteudo' => null
            ];
        }
    //

    date_default_timezone_set('UTC');
    $data_atual = new DateTime();
    $data_atual_formatada = $data_atual->format('Y-m-d H:i:s');

    return tb_historico_de_email_criar(
        $id_usuario,
        $assunto,
        $data_atual_formatada
    );
    
}

// ------------------------------------------------------------------------
// Visualizar 
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// Apagar
// ------------------------------------------------------------------------
function secure_historico_de_email_excluir($id) {

    convocar_rota('db/praticando_web/historico_de_email');

    return tb_historico_de_email_excluir($id);
}

// ------------------------------------------------------------------------
// Funcionalidades 
// ------------------------------------------------------------------------

?>