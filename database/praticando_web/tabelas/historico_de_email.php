<?php 

// ------------------------------------------------------------------------
// Tabela no banco de dados
// ------------------------------------------------------------------------
/* 
CREATE TABLE historico_de_email (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT UNSIGNED NOT NULL,
    assunto VARCHAR(255) NOT NULL,
    data_de_criacao DATETIME NOT NULL,
    
    CONSTRAINT fk_historico_de_email_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);
*/

require_once(__DIR__ . '/../../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('configuracoes/db_conexoes.php'));

class Historico_de_email {
    
    // ------------------------------------------------------------------------
    // Assegurar criação no banco de dados
    // ------------------------------------------------------------------------
    
    public static function gerar_tabela() {
        
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            
            $conexao_db->exec('CREATE TABLE IF NOT EXISTS historico_de_email (
                id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                id_usuario INT UNSIGNED NOT NULL,
                assunto VARCHAR(255) NOT NULL,
                data_de_criacao DATETIME NOT NULL,
                
                CONSTRAINT fk_historico_de_email_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
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
        string $id_usuario,
        string $assunto,
        string $data_de_criacao
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Preparar uma transação
            $conexao_db->beginTransaction();

            // Efetuar comando com proteção contra SQL Injection
            $comando = $conexao_db->prepare('INSERT INTO historico_de_email (
                id_usuario,
                assunto,
                data_de_criacao
            ) VALUES (
                :id_usuario,
                :assunto,
                :data_de_criacao
            );');

            $comando->execute([
                ':id_usuario' => $id_usuario,
                ':assunto' => $assunto,
                ':data_de_criacao' => $data_de_criacao
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
            $comando = $conexao_db->prepare('SELECT * FROM historico_de_email ORDER BY id ASC;');

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
            $comando = $conexao_db->prepare('SELECT COUNT(*) AS qtd_registros FROM historico_de_email;');

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
                FROM historico_de_email
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
        string $id_usuario,
        string $assunto,
        string $data_de_criacao
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            $conexao_db->beginTransaction();

            // Prepare o comando de atualização
            $comando = $conexao_db->prepare('UPDATE historico_de_email
                SET 
                    id_usuario = :id_usuario,
                    assunto = :assunto,
                    data_de_criacao = :data_de_criacao
            WHERE id = :id;');

            // Execute o comando com os parâmetros fornecidos
            $comando->execute([
                ':id' => $id,
                ':id_usuario' => $id_usuario,
                ':assunto' => $assunto,
                ':data_de_criacao' => $data_de_criacao
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
            $comando = $conexao_db->prepare('DELETE FROM historico_de_email WHERE id = :id;');

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
            $comando = $conexao_db->prepare('DELETE FROM historico_de_email;');

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

            $comando = $conexao_db->prepare('ALTER TABLE historico_de_email AUTO_INCREMENT = 1;');
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
        $resposta = Historico_de_email::ler_registros();

        if ($resposta['sucesso'] == 200) {
            if ($resposta['conteudo'] == []) {

                date_default_timezone_set('UTC');
                $data_atual = new DateTime();
                $data_atual = $data_atual->format('Y-m-d H:i:s');
                
                // Testar funções
                Historico_de_email::criar_registro('1', 'Teste 1', $data_atual);
                Historico_de_email::atualizar_registro('1', '1', 'testado 1', $data_atual);
                Historico_de_email::ler_qtd_registros();
                Historico_de_email::ler_registros_paginando();
                Historico_de_email::apagar_registro('1');
                Historico_de_email::resetar_auto_increment();

                Historico_de_email::criar_registro('1', 'teste 1', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 2', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 3', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 4', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 5', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 6', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 7', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 8', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 9', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 10', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 11', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 12', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 13', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 14', $data_atual);
                Historico_de_email::criar_registro('1', 'teste 15', $data_atual);

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