<?php

require_once(__DIR__ . '/../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/token_de_cadastro.php'));

class Secure_token_de_cadastro {
    
    public static function criar_registro(int $id_usuario, string $valor) {
        
        // Resetar auto_increment
            $resetar_auto_increment = Token_de_cadastro::resetar_auto_increment();
        
            if ($resetar_auto_increment['sucesso'] != 200) {
                return $resetar_auto_increment;
            }
        //

        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual_formatada = $data_atual->format('Y-m-d H:i:s');

        $data_de_limite = clone $data_atual;
        $data_de_limite->modify('+8 hours');
        $data_de_limite_formatada = $data_de_limite->format('Y-m-d H:i:s');

        return Token_de_cadastro::criar_registro($id_usuario, $valor, $data_atual_formatada, $data_de_limite_formatada, null);
    }

    public static function ler_registro_por_valor(string $valor) {
        return Token_de_cadastro::ler_registro_por_valor($valor);
    }

    public static function atualizar_data_de_uso(string $valor) {

        $token = Token_de_cadastro::ler_registro_por_valor($valor);
        
        if ($token['sucesso'] != 200) {
            return $token;
        }

        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual = $data_atual->format('Y-m-d H:i:s');

        return Token_de_cadastro::atualizar_registro(
            $token['conteudo'][0]['id'],
            $token['conteudo'][0]['id_usuario'],
            $token['conteudo'][0]['valor'],
            $token['conteudo'][0]['data_de_criacao'],
            $token['conteudo'][0]['data_de_expiracao'],
            $data_atual
        );
    }

    public static function apagar_registro(int $id) {
        return Token_de_cadastro::apagar_registro($id);
    }

    public static function gerar_token_alfa_numerico($comprimento = 255) : string {
        // Definir os caracteres permitidos
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
        // Inicializar o token
        $token = '';

        // Construir o token aleatório
        for ($i = 0; $i < $comprimento; $i++) {
            // Selecionar um caractere aleatório do conjunto
            $token .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }

        return $token;
    }

}

?>