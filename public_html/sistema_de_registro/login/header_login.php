<?php 
require_once(__DIR__ . '/../../../configuracoes/rotas.php');
convocar_rota('config/configuracoes');

$variaveis_da_pagina = 
[
    'inputs' => [
        'name_nome_completo' => 'null',
        'name_dia_nascimento' => null,
        'name_mes_nascimento' => null,
        'name_ano_nascimento' => null,
        'name_email' => null,
        'name_confirmacao_de_email' => null,
        'name_senha' => null,
        'name_confirmacao_senha' => null,
        'name_termos_de_uso' => null,
        'name_politica_de_privacidade' => null
    ],

    'respostas' => [
        'erro_de_formulario' => null,
        'sucesso_de_formulario' => null,
        'data_nascimento' => null
    ],
    
    'valores' => [
        'value_name_nome_completo' => null,
        'value_name_dia_nascimento' => null,
        'value_name_mes_nascimento' => null,
        'value_name_ano_nascimento' => null,
        'value_name_email' => null,
        'value_name_confirmacao_de_email' => null,
        'checked_name_termos_de_uso' => null,
        'checked_name_politica_de_privacidade' => null,
    ]
];
$dados_do_cookie = serialize($variaveis_da_pagina);
$dados_do_cookie = aesEncriptar($dados_do_cookie);

setcookie(
    name: 'formulario_cadastro',
    value: $dados_do_cookie,
    expires_or_options: 0, // 0 siginifica que o cookie fica ativo enquanto o navegador estiver aberto // time() + 120 deixa aberto por 2 minutos
    path: '/sistema_de_registro/cadastro', // Define a partir de que caminho o cookie pode ser lido
    domain: '', // Se deixar vazio somente o host que criou pode acessa-lo
    secure: true,
    httponly: true // Garante que o cookie não é acessível por javascript
);
?>