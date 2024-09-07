<?php 

require_once(__DIR__ . '/../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario_status.php'));


class Secure_usuario_status {

    public static function criar_registro(
        int $id_usuario,
        string $status,
        ?string $observacao
    ) {

        // Resetar auto_increment
            $resetar_auto_increment = Usuario_status::resetar_auto_increment();
        
            if ($resetar_auto_increment['sucesso'] != 200) {
                return $resetar_auto_increment;
            }
        //

        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual_formatada = $data_atual->format('Y-m-d H:i:s');

        return Usuario_status::criar_registro($id_usuario, $status, $data_atual_formatada, $observacao);
    }

    public static function ler_registro_por_id_usuario(int $id_usuario) {
        return Usuario_status::ler_registro_por_id_usuario($id_usuario);
    }

    public static function apagar_registro(int $id) {
        return Usuario_status::apagar_registro($id);
    }
}

?>