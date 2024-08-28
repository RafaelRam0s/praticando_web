<?php 

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

?>