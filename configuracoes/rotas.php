<?php 

class Rotas {

    public static function buscar_arquivo(string $rota_do_arquivo) {

        $rota_do_arquivo = htmlspecialchars($rota_do_arquivo);

        $rota_absoluta = __DIR__ . '/../' . $rota_do_arquivo;

        return $rota_absoluta;
    }

}

Rotas::buscar_arquivo('configuracoes/seguranca_de_cabecalho.php');

?>