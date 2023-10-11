<?php

// ------------------------------------------------------------------------
// Redirecionamento de url por caminho de pastas
// ------------------------------------------------------------------------
function redirect_by_path($path)
{
    $redirect = substr(strtr(realpath($path), '\\', '/'), strlen($_SERVER['DOCUMENT_ROOT']));
    header("location: $redirect");
    die();
}
// Exemplo de uso: redirect_by_path(__DIR__ . '/../../404.php');
// O usuário é redirecionado para a outra url e essa url atual não consta no histórico de navegação





function tratarUrl(string $caminho_da_url) : string
{
    // Tratamento da url
    
    // Transformar em um vetor, separando onde tiver a presença da /
    $lista_de_rotas = explode('/', $caminho_da_url);
    $lista_de_rotas_limpa = [];

    for ($contador = 0; $contador < count($lista_de_rotas); $contador++)
    {
        if ($lista_de_rotas[$contador] != '')
        {
            $lista_de_rotas_limpa[] = $lista_de_rotas[$contador];
        }
    }

    // Limpar rota final, caso esteja com os símbolos ? ou #
    if($lista_de_rotas_limpa == null)
    {
        $lista_de_rotas_limpa[] = '';
    }

    if (str_contains($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '?') === true)
    {
        $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1] = mb_substr(
            $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], 
            0, 
            mb_strpos($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '?')
        );
    } 
    if (str_contains($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '#') === true)
    {
        $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1] = mb_substr(
            $lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], 
            0,
            mb_strpos($lista_de_rotas_limpa[count($lista_de_rotas_limpa) - 1], '#')
        );
    }

    return implode('/', $lista_de_rotas_limpa);
}


