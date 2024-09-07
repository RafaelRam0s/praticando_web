<?php 

require_once(__DIR__ . '/../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('database/praticando_web/tabelas/usuario.php'));

class Secure_usuario {

    public static function criar_registro(
        string $email,
        string $senha,
        string $nome,
        string $data_nascimento
    ) {
        // Ver se os parametros estão certos
            if (
                Secure_usuario::validar_email($email)[0] == false
                || Secure_usuario::validar_senha($senha)[0] == false
                || Secure_usuario::validar_nome($nome)[0] == false
                || Secure_usuario::validar_data_de_nascimento($data_nascimento)[0] == false
            ) {
                return [
                    'sucesso' => 400,
                    'mensagem' => 'Invalido os valores passados no parâmetro da função',
                    'conteudo' => null
                ];
            }
        //
        // Resetar auto_increment
            $resetar_auto_increment = Usuario::resetar_auto_increment();
        
            if ($resetar_auto_increment['sucesso'] != 200) {
                return $resetar_auto_increment;
            }
        //

        date_default_timezone_set('UTC');
        $data_atual = new DateTime();
        $data_atual = $data_atual->format('Y-m-d H:i:s');

        return Usuario::criar_registro(
            $email, 
            password_hash($senha, PASSWORD_BCRYPT), 
            $nome, 
            $data_nascimento, 
            $data_atual, 
            $data_atual, 
            $data_atual
        );

        // password_verify($senha, $retorno_do_banco['conteudo'][0]['senha'])
    }

    public static function ler_registro_por_email(string $email) {
        // Ver se os parametros estão certos
            if (Secure_usuario::validar_email($email)[0] == false) {
                return [
                    'sucesso' => 400,
                    'mensagem' => 'Invalido os valores passados no parâmetro da função',
                    'conteudo' => null
                ];
            }
        //

        return Usuario::ler_registro_por_email($email);
    }

    public static function ler_registro_por_id(int $id) {
        return Usuario::ler_registro_por_id($id);
    }

    public static function apagar_registro(int $id) {
        return Usuario::apagar_registro($id);
    }

    // Validar nome
    protected static function validar_nome(string $nome) {    
        // Verificar se possui espaços em branco
        if (mb_strlen($nome) != mb_strlen(trim($nome)))
        {
            return [false, 'O nome possui espaços em branco'];
        }

        // Caracteres entre 2 e 255
        if (
            (strlen($nome) < 2) 
            || (strlen($nome) > 255)
        ) {
            return [false, 'O nome possui uma quantidade de caracteres inválida'];
        }

        return [true, 'Nome válido'];
    }

    // Validar data de nascimento, exemplo de recebimento 2014-12-28 yyyy-mm-dd
    protected static function validar_data_de_nascimento(string $data_nascimento) {

        // ver se o campo possui dois -
        $data_dividida = explode('-', $data_nascimento);
        if ( count($data_dividida) != 3)
        {
            return [false, 'Padrão de data inválido, utilize o seguinte padrão yyyy-mm-dd'];
        } 
        
        $ano = $data_dividida[0];
        $mes = $data_dividida[1];
        $dia = $data_dividida[2];

        // Verificar se os valores passados são apenas números
        if (
            preg_match("/^[0-9]+$/", $dia) == true
            && preg_match("/^[0-9]+$/", $mes) == true
            && preg_match("/^[0-9]+$/", $ano) == true
        ) {
            date_default_timezone_set('UTC');
            $data_formatada = new DateTime();
            $data_formatada->setDate(year: $ano, month: $mes, day: $dia);
            $data_formatada->setTime(hour: 0, minute: 0, second: 0);
            
            // Verificar se a data informada existe no calendário, por exemplo não existe o dia 30/02/2023, pois o mês daquele ano acabava no dia 28
            if (
                !($data_formatada->format('Y') == $ano
                && $data_formatada->format('m') == $mes
                && $data_formatada->format('d') == $dia)
            ) {
                return [false, 'A "Data de Nascimento" possui uma data inválida'];
            }
        } else {
            return [false, 'A "Data de Nascimento" possui caracteres inválidos'];
        }

        return [true, 'Data de nascimento válida'];
    }

    // Validar email
    protected static function validar_email(string $email) {

        // Verificar se possui espaços em branco
        if (mb_strlen($email) != mb_strlen(trim($email)))
        {
            return [false, 'O e-mail possui espaços em branco'];
        }

        // Caracteres entre 3 e 255
        if (
            (mb_strlen($email) < 3) 
            || (mb_strlen($email) > 255)
        ) {
            return [false, 'O e-mail possui uma quantidade de caracteres inválida'];
        }

        // Caracter @ não encontrado
        if (strpos($email, '@') == false) {
            return [false, 'O e-mail não possui @'];
        }

        return [true, 'E-mail válido'];
    }

    // Validar senha
    protected static function validar_senha(string $senha) {

        // Caracteres entre 8 e 255
        if (
            (strlen($senha) < 8) 
            || (strlen($senha) > 255)
        ) {
            return [false, 'A senha possui uma quantidade de caracteres inválida'];
        }
        
        // Possui ao menos 1 letra minúscula, 1 letra maiúscula, 1 número e 1 caracter especial
        if ( preg_match('/[a-z]/', $senha) != 1 ) {
            return [false, 'A senha deve conter ao menos 1 caracter minúsculo'];
        } else if ( preg_match('/[A-Z]/', $senha) != 1 ) {
            return [false, 'A senha deve conter ao menos 1 caracter maiúsculo'];
        } else if ( preg_match('/[0-9]/', $senha) != 1 ) {
            return [false, 'A senha deve conter ao menos um número'];
        } else if ( preg_match('/[\W|_]/', $senha) != 1 ) {
            return [false, 'A senha deve conter ao menos 1 caracter especial'];
        }

        return [true, 'Senha válida'];

    }
}


?>