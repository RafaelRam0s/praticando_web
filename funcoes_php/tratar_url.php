<?php 

function tratar_url(string $caminho_da_url) : string {
    // Tratamento da url
    
    // Transformar em um vetor, separando onde tiver a presença da /
    $lista_de_rotas = explode('/', $caminho_da_url);
    $lista_de_rotas_limpa = [];

    for ($contador = 0; $contador < count($lista_de_rotas); $contador++) {
        if ($lista_de_rotas[$contador] != '') {
            $lista_de_rotas_limpa[] = $lista_de_rotas[$contador];
        }
    }

    // Limpar rota final, caso esteja com os símbolos ? ou #
    if($lista_de_rotas_limpa == null) {
        $lista_de_rotas_limpa[] = '';
    }

    if (str_contains($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '?') === true) {
        $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1] = mb_substr(
            $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], 
            0, 
            mb_strpos($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '?')
        );
    } 
    if (str_contains($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '#') === true) {
        $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1] = mb_substr(
            $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], 
            0,
            mb_strpos($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '#')
        );
    }

    return implode('/', $lista_de_rotas_limpa);
}

?>