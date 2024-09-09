<?php 

// Permitir os dados recebidos serem colocados em tela para o usuário sem exetuar código php ou html
function escarpar_dados($dados) {
    if (is_array($dados)) {
        foreach ($dados as &$valor) {
            $valor = escarpar_dados($valor); // Chamada recursiva para arrays aninhados
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

?>