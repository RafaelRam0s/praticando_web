<?php 

require_once(__DIR__ . '/../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/historico_de_email.php'));

class Secure_historico_de_email {

    public static function criar_registro(int $id_usuario, string $assunto) {

        // Resetar auto_increment
            $resetar_auto_increment = Historico_de_email::resetar_auto_increment();
    
            if ($resetar_auto_increment['sucesso'] != 200) {
                return $resetar_auto_increment;
            }
        //
    
        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual_formatada = $data_atual->format('Y-m-d H:i:s');
    
        return Historico_de_email::criar_registro(
            $id_usuario,
            $assunto,
            $data_atual_formatada
        );
    }

    public static function apagar_registro(int $id) {
        return Historico_de_email::apagar_registro($id);
    }

}

?>