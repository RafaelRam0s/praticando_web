<?php 
    require_once(__DIR__ . '/../../../../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('controller/main_controller.php'));
    
    if (isset($_COOKIE['formulario_confirmacao_cadastro'])) {
        setcookie(
            name: 'formulario_confirmacao_cadastro',
            value: '',
            expires_or_options: -1, // 0 siginifica que o cookie fica ativo enquanto o navegador estiver aberto // time() + 120 deixa aberto por 2 minutos
            path: '/sistema_de_registro/cadastro', // Define a partir de que caminho o cookie pode ser lido
            domain: '', // Se deixar vazio somente o host que criou pode acessa-lo
            secure: true,
            httponly: true // Garante que o cookie não é acessível por javascript
        );
    }
    
?>