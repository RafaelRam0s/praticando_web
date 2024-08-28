<?php 

require_once(__DIR__ . '/../../configuracoes/rotas.php');

// ------------------------------------------------------------------------
// Criar 
// ------------------------------------------------------------------------
function secure_token_de_cadastro_criar($id_usuario, $valor) {

    convocar_rota('db/praticando_web/token_de_cadastro');

    // @@@ Fazer comentarios abaixo
    // Ver se o usuario existe
    // Ver se o valor do token é valido

    // Resetar auto_increment
        $resetar_auto_increment = tb_token_de_cadastro_resetar_auto_increment();

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
    
    $data_de_limite = clone $data_atual;
    $data_de_limite->modify('+8 hours');
    $data_de_limite_formatada = $data_de_limite->format('Y-m-d H:i:s');

    return tb_token_de_cadastro_criar(
        $id_usuario,
        $valor,
        $data_atual_formatada,
        $data_de_limite_formatada,
        null
    );
    
}

// ------------------------------------------------------------------------
// Visualizar 
// ------------------------------------------------------------------------
function secure_token_de_cadastro_buscar_valor($valor) {
    
    convocar_rota('db/praticando_web/token_de_cadastro');

    return  tb_token_de_cadastro_buscar_valor($valor);

}

// ------------------------------------------------------------------------
// Atualizar 
// ------------------------------------------------------------------------
function secure_token_de_cadastro_atualizar_data_de_uso($id) {

    date_default_timezone_set('UTC');
    $data_atual = new DateTime();
    
    return tb_token_de_cadastro_atualizar_data_de_uso($id, $data_atual->format('Y-m-d H:i:s'));
}

// ------------------------------------------------------------------------
// Apagar
// ------------------------------------------------------------------------
function secure_token_de_cadastro_excluir($id) {

    convocar_rota('db/praticando_web/token_de_cadastro');

    return tb_token_de_cadastro_excluir($id);
}

// ------------------------------------------------------------------------
// Funcionalidades 
// ------------------------------------------------------------------------
function gerarTokenAlfanumerico($comprimento = 255) {
    // Definir os caracteres permitidos
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    // Inicializar o token
    $token = '';

    // Garantir que o comprimento não exceda o tamanho máximo permitido
    $comprimento = min($comprimento, 255);

    // Construir o token aleatório
    for ($i = 0; $i < $comprimento; $i++) {
        // Selecionar um caractere aleatório do conjunto
        $token .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }

    return $token;
}

?>