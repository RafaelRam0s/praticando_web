<?php 

// ------------------------------------------------------------------------
// Tabela no banco de dados
// ------------------------------------------------------------------------
/* 
CREATE TABLE usuario (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    email VARBINARY(1000) NOT NULL UNIQUE,
    senha VARBINARY(1000) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    termos_de_uso_aceito DATETIME NOT NULL,
    politica_de_privacidade_aceito DATETIME NOT NULL,
    data_de_criacao DATETIME NOT NULL
);
*/

require_once(__DIR__ . '/../../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('configuracoes/db_conexoes.php'));

class Usuario {
    
    // ------------------------------------------------------------------------
    // Assegurar criação no banco de dados
    // ------------------------------------------------------------------------
    
    public static function gerar_tabela() {
        
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            
            $conexao_db->exec('CREATE TABLE IF NOT EXISTS usuario (
                id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                email VARBINARY(1000) NOT NULL UNIQUE,
                senha VARBINARY(1000) NOT NULL,
                nome VARCHAR(255) NOT NULL,
                data_nascimento DATE NOT NULL,
                termos_de_uso_aceito DATETIME NOT NULL,
                politica_de_privacidade_aceito DATETIME NOT NULL,
                data_de_criacao DATETIME NOT NULL
            );');

        } catch (Exception $e) {
            trigger_error('Erro na criação de tabela: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na criação de tabela',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Tabela criada.',
            'conteudo' => null
        ];

    }

    // ------------------------------------------------------------------------
    // CREATE
    // ------------------------------------------------------------------------
    
    public static function criar_registro(
        string $email,
        string $senha,
        string $nome,
        string $data_nascimento,
        string $termos_de_uso_aceito,
        string $politica_de_privacidade_aceito,
        string $data_de_criacao
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Preparar uma transação
            $conexao_db->beginTransaction();

            // Efetuar comando com proteção contra SQL Injection
            $comando = $conexao_db->prepare('INSERT INTO usuario (
                email,
                senha,
                nome,
                data_nascimento,
                termos_de_uso_aceito,
                politica_de_privacidade_aceito,
                data_de_criacao
            ) VALUES (
                AES_ENCRYPT(:email, UNHEX(SHA2(:chave_criptografica, 512))),
                AES_ENCRYPT(:senha, UNHEX(SHA2(:chave_criptografica, 512))),
                :nome,
                :data_nascimento,
                :termos_de_uso_aceito,
                :politica_de_privacidade_aceito,
                :data_de_criacao
            );');

            require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));

            $comando->execute([
                ':email' => $email,
                ':senha' => $senha,
                ':nome' => $nome,
                ':data_nascimento' => $data_nascimento,
                ':termos_de_uso_aceito' => $termos_de_uso_aceito,
                ':politica_de_privacidade_aceito' => $politica_de_privacidade_aceito,
                ':data_de_criacao' => $data_de_criacao,
                ':chave_criptografica' => AES_KEY_DB_PRATICANDO_WEB
            ]);

            $id_do_registro = $conexao_db->lastInsertId();

            // Validar se o registro foi criado
            if($id_do_registro === false) {
                // Voltar alterações
                $conexao_db->rollBack();
                return [
                    'sucesso' => 404,
                    'mensagem' => 'Erro na criação do registro',
                    'conteudo' => null
                ];
            } else {
                // Salvar alterações
                $conexao_db->commit();
            }

        } catch (Exception $e) {
            $conexao_db->rollBack();
            
            trigger_error('Erro na criação do registro: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na criação do registro',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Dados registrados.',
            'conteudo' => ['id' => $id_do_registro]
        ];
    }

    // ------------------------------------------------------------------------
    // READ
    // ------------------------------------------------------------------------

    public static function ler_registros() {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Selecionar a tabela
            $comando = $conexao_db->prepare('SELECT * FROM usuario ORDER BY id ASC;');

            // Executar o comando
            $comando->execute();

            // Buscar os dados
            $dados_encontrados = $comando->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            trigger_error('Erro na leitura de registros: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na leitura de registros',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Dados lidos.',
            'conteudo' => $dados_encontrados
        ];
    }

    public static function ler_registro_por_email($email) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Selecionar a tabela
            $comando = $conexao_db->prepare('SELECT * FROM usuario ORDER BY id ASC;');

            $comando = $conexao_db->prepare('SELECT 
                id,
                AES_DECRYPT(email, UNHEX(SHA2(:chave_criptografica, 512))) email,
                AES_DECRYPT(senha, UNHEX(SHA2(:chave_criptografica, 512))) senha,
                nome,
                data_nascimento,
                termos_de_uso_aceito,
                politica_de_privacidade_aceito,
                data_de_criacao
                FROM usuario
                WHERE email = AES_ENCRYPT(:email, UNHEX(SHA2(:chave_criptografica, 512)))
            ORDER BY id DESC LIMIT 1;');

            require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));
    
            $comando->bindValue(':email', (string) $email, PDO::PARAM_STR);
            $comando->bindValue(':chave_criptografica', AES_KEY_DB_PRATICANDO_WEB, PDO::PARAM_STR);

            // Executar o comando
            $comando->execute();

            // Buscar os dados
            $dados_encontrados = $comando->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            trigger_error('Erro na leitura de registros: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na leitura de registros',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Dados lidos.',
            'conteudo' => $dados_encontrados
        ];
    }

    public static function ler_registro_por_id($id) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Selecionar a tabela
            $comando = $conexao_db->prepare('SELECT * FROM usuario ORDER BY id ASC;');

            $comando = $conexao_db->prepare('SELECT 
                id,
                AES_DECRYPT(email, UNHEX(SHA2(:chave_criptografica, 512))) email,
                AES_DECRYPT(senha, UNHEX(SHA2(:chave_criptografica, 512))) senha,
                nome,
                data_nascimento,
                termos_de_uso_aceito,
                politica_de_privacidade_aceito,
                data_de_criacao
                FROM usuario
                WHERE id = :id
            ORDER BY id DESC LIMIT 1;');

            require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));
    
            $comando->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $comando->bindValue(':chave_criptografica', AES_KEY_DB_PRATICANDO_WEB, PDO::PARAM_STR);

            // Executar o comando
            $comando->execute();

            // Buscar os dados
            $dados_encontrados = $comando->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            trigger_error('Erro na leitura de registros: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na leitura de registros',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Dados lidos.',
            'conteudo' => $dados_encontrados
        ];
    }


    public static function ler_qtd_registros() {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Preparar o comando SQL para contar o total de registros
            $comando = $conexao_db->prepare('SELECT COUNT(*) AS qtd_registros FROM usuario;');

            // Executar o comando
            $comando->execute();

            // Buscar o total de registros
            $resultado = $comando->fetch(PDO::FETCH_ASSOC);
            $qtd_registros = $resultado['qtd_registros'];
            
        } catch (Exception $e) {

            trigger_error('Erro na leitura de quantidade de registros: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na leitura de quantidade de registros',
                'conteudo' => 0
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Dados lidos.',
            'conteudo' => $qtd_registros
        ];
    }
    public static function ler_registros_paginando(int $pagina = 1, int $registros_por_pagina = 10) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        // Calcular o OFFSET baseado na página atual e no número de registros por página
        $offset = ($pagina - 1) * $registros_por_pagina;

        try {
            // Selecionar a tabela
            $comando = $conexao_db->prepare('SELECT *
                FROM usuario
                ORDER BY id ASC
            LIMIT :registros_por_pagina OFFSET :offset;');

            $comando->bindValue(':registros_por_pagina', (int)$registros_por_pagina, PDO::PARAM_INT);
            $comando->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

            // Executar o comando
            $comando->execute();
            
            // Buscar os dados
            $dados_encontrados = $comando->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            trigger_error('Erro na leitura de registros paginado: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na leitura de registros paginado',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Dados lidos.',
            'conteudo' => $dados_encontrados
        ];
    }
    
    // ------------------------------------------------------------------------
    // UPDATE
    // ------------------------------------------------------------------------
    
    public static function atualizar_registro(
        string $id,
        string $email,
        string $senha,
        string $nome,
        string $data_nascimento,
        string $termos_de_uso_aceito,
        string $politica_de_privacidade_aceito,
        string $data_de_criacao
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            $conexao_db->beginTransaction();

            // Prepare o comando de atualização
            $comando = $conexao_db->prepare('UPDATE usuario
                SET 
                    email = AES_ENCRYPT(:email, UNHEX(SHA2(:chave_criptografica, 512))),
                    senha = AES_ENCRYPT(:senha, UNHEX(SHA2(:chave_criptografica, 512))),
                    nome = :nome,
                    data_nascimento = :data_nascimento,
                    termos_de_uso_aceito = :termos_de_uso_aceito,
                    politica_de_privacidade_aceito = :politica_de_privacidade_aceito,
                    data_de_criacao = :data_de_criacao
            WHERE id = :id;');

            require_once(Rotas::buscar_arquivo('configuracoes/configuracoes.php'));

            // Execute o comando com os parâmetros fornecidos
            $comando->execute([
                ':id' => $id,
                ':email' => $email,
                ':senha' => $senha,
                ':nome' => $nome,
                ':data_nascimento' => $data_nascimento,
                ':termos_de_uso_aceito' => $termos_de_uso_aceito,
                ':politica_de_privacidade_aceito' => $politica_de_privacidade_aceito,
                ':data_de_criacao' => $data_de_criacao,
                ':chave_criptografica' => AES_KEY_DB_PRATICANDO_WEB
            ]);

            if($comando->rowCount() > 0) {
                $conexao_db->commit();
            } else {
                $conexao_db->rollBack();
                return [
                    'sucesso' => 204,
                    'mensagem' => 'Nenhum registro encontrado ou nenhum registro foi modificado',
                    'conteudo' => null
                ];
            }

        } catch (Exception $e) {
            $conexao_db->rollBack();
            trigger_error('Erro na atualização do registro: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na atualização do registro',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Registro atualizado.',
            'conteudo' => null
        ];
    }

    // ------------------------------------------------------------------------
    // DELETE
    // ------------------------------------------------------------------------

    public static function apagar_registro(string $id) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            $conexao_db->beginTransaction();

            // Prepare o comando de exclusão
            $comando = $conexao_db->prepare('DELETE FROM usuario WHERE id = :id;');

            // Execute o comando com o id fornecido
            $comando->execute([':id' => $id]);

            if($comando->rowCount() > 0) {
                $conexao_db->commit();
            } else {
                $conexao_db->rollBack();
                return [
                    'sucesso' => 204,
                    'mensagem' => 'Nenhum registro encontrado ou nenhum registro foi exluido',
                    'conteudo' => null
                ];
            }

        } catch (Exception $e) {
            $conexao_db->rollBack();
            trigger_error('Erro na exclusão de registro: ' . $e->getMessage(), E_USER_WARNING);
            
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na exclusão de registro',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Registro excluído.',
            'conteudo' => null
        ];
    }

    public static function apagar_dados() {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            $conexao_db->beginTransaction();

            // Prepare o comando de exclusão
            $comando = $conexao_db->prepare('DELETE FROM usuario;');

            // Execute o comando com o id fornecido
            $comando->execute();

            if($comando->rowCount() > 0) {
                $conexao_db->commit();
            } else {
                $conexao_db->rollBack();
                return [
                    'sucesso' => 204,
                    'mensagem' => 'Nenhum registro encontrado ou nenhum registro foi exluido',
                    'conteudo' => null
                ];
            }

        } catch (Exception $e) {
            $conexao_db->rollBack();
            trigger_error('Erro na exclusão de registros: ' . $e->getMessage(), E_USER_WARNING);
            
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na exclusão de registros',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Registros excluídos.',
            'conteudo' => null
        ];
    }

    // ------------------------------------------------------------------------
    // FUNCTIONS
    // ------------------------------------------------------------------------

    public static function resetar_auto_increment() {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {

            $comando = $conexao_db->prepare('ALTER TABLE usuario AUTO_INCREMENT = 1;');
            $comando->execute();

        } catch (Exception $e) {
            
            trigger_error('Erro ao resetar o auto_increment: ' . $e->getMessage(), E_USER_WARNING);

            return [
                'sucesso' => 400,
                'mensagem' => 'Erro ao resetar o auto_increment',
                'conteudo' => null
            ];
        }

        return [
            'sucesso' => 200,
            'mensagem' => 'Operação efetuada com sucesso! Auto_increment resetado.',
            'conteudo' => null
        ];
    }

    public static function gerar_dados() {
        $resposta = Usuario::ler_registros();

        if ($resposta['sucesso'] == 200) {
            if ($resposta['conteudo'] == []) {

                date_default_timezone_set('UTC');
                $data_atual = new DateTime();
                $somente_data = $data_atual->format('Y-m-d');
                $data_atual = $data_atual->format('Y-m-d H:i:s');

                // Testar funções
                Usuario::criar_registro('email 1', 'senha 1', 'nome 1', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::atualizar_registro('1', 'email 1', 'senha 1', 'nome 1', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::ler_qtd_registros();
                Usuario::ler_registros_paginando();
                Usuario::ler_registro_por_email('email 1');
                Usuario::ler_registro_por_id('1');
                Usuario::apagar_registro('1');
                Usuario::resetar_auto_increment();

                Usuario::criar_registro('email 1', 'senha 1', 'nome 1', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 2', 'senha 2', 'nome 2', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 3', 'senha 3', 'nome 3', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 4', 'senha 4', 'nome 4', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 5', 'senha 5', 'nome 5', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 6', 'senha 6', 'nome 6', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 7', 'senha 7', 'nome 7', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 8', 'senha 8', 'nome 8', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 9', 'senha 9', 'nome 9', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 10', 'senha 10', 'nome 10', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 11', 'senha 11', 'nome 11', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 12', 'senha 12', 'nome 12', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 13', 'senha 13', 'nome 13', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 14', 'senha 14', 'nome 14', $somente_data, $data_atual, $data_atual, $data_atual);
                Usuario::criar_registro('email 15', 'senha 15', 'nome 15', $somente_data, $data_atual, $data_atual, $data_atual);

                return [
                    'sucesso' => 200,
                    'mensagem' => 'Operação efetuada com sucesso! Dados gerados.',
                    'conteudo' => null
                ];

            } else {
                return [
                    'sucesso' => 204,
                    'mensagem' => 'Tabela já estava preenchida.',
                    'conteudo' => null
                ];
            }
        } else {
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na geração de dados.',
                'conteudo' => null
            ];
        }
    }
}

?>