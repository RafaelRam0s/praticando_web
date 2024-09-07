<?php 

    require_once(__DIR__ . '/../configuracoes/rotas.php');

    if (isset($rota_limpa)) {
        
        // Verificar url
        $lista_de_rotas_validas = [
            'sistema_de_registro/logado'
        ];

        if (in_array($rota_limpa, $lista_de_rotas_validas)) {

            // Verificar session de login

            // Se inválido
                // Mandar aviso através de cookie que não pode acessar sem login
                // Redirecionar para a página de login

            if ($rota_limpa == 'sistema_de_registro/logado') {
                // Montar layout
            }
            
        }

    }
?>