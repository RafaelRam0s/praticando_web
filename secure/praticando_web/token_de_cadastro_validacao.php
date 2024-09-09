<?php

require_once(__DIR__ . '/../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/token_de_cadastro_validacao.php'));

class Secure_token_de_cadastro_validacao {
    
    public static function criar_registro(int $id_token_de_cadastro, string $dados_de_auditoria, string $valor_tentado) {
        
        // Resetar auto_increment
            $resetar_auto_increment = Token_de_cadastro_validacao::resetar_auto_increment();
        
            if ($resetar_auto_increment['sucesso'] != 200) {
                return $resetar_auto_increment;
            }
        //

        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual_formatada = $data_atual->format('Y-m-d H:i:s');

        return Token_de_cadastro_validacao::criar_registro($id_token_de_cadastro, $dados_de_auditoria, $valor_tentado, $data_atual_formatada);
    }

    public static function ler_qtd_registros_por_id_token_de_cadastro(int $id_token_de_cadastro) {
        return Token_de_cadastro_validacao::ler_qtd_registros_por_id_token_de_cadastro($id_token_de_cadastro);
    }
}

?>