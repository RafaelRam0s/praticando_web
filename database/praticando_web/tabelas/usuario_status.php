<?php 

// ------------------------------------------------------------------------
// Tabela no banco de dados
// ------------------------------------------------------------------------
/* 
CREATE TABLE usuario_status (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT UNSIGNED NOT NULL,
    status ENUM('Pendente', 'Autorizado', 'Inativado') NOT NULL,
    data_de_criacao DATETIME NOT NULL,
    observacao VARCHAR(255),

    CONSTRAINT fk_usuario_status_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);
*/
require_once(__DIR__ . '/../../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('configuracoes/db_conexoes.php'));

class Usuario_status {
    
    // ------------------------------------------------------------------------
    // Assegurar criação no banco de dados
    // ------------------------------------------------------------------------
    
    public static function gerar_tabela() {
        
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            
            $conexao_db->exec('CREATE TABLE IF NOT EXISTS usuario_status (
                id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                id_usuario INT UNSIGNED NOT NULL,
                status ENUM(\'Pendente\', \'Autorizado\', \'Inativado\') NOT NULL,
                data_de_criacao DATETIME NOT NULL,
                observacao VARCHAR(255),

                CONSTRAINT fk_usuario_status_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
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
        string $status,
        string $data_de_criacao,
        ?string $observacao
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Preparar uma transação
            $conexao_db->beginTransaction();

            // Efetuar comando com proteção contra SQL Injection
            $comando = $conexao_db->prepare('INSERT INTO usuario_status (
                id_usuario,
                status,
                data_de_criacao,
                observacao
            ) VALUES (
                :id_usuario,
                :status,
                :data_de_criacao,
                :observacao
            );');

            $comando->execute([
                ':id_usuario' => $id_usuario,
                ':status' => $status,
                ':data_de_criacao' => $data_de_criacao,
                ':observacao' => $observacao
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
            $comando = $conexao_db->prepare('SELECT * FROM usuario_status ORDER BY id ASC;');

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
    public static function ler_registro_por_id_usuario($id_usuario) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Selecionar a tabela
            $comando = $conexao_db->prepare('SELECT * FROM usuario_status WHERE id_usuario = :id_usuario ORDER BY id DESC LIMIT 1;');

            // Executar o comando
            $comando->execute([':id_usuario' => $id_usuario]);

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
            $comando = $conexao_db->prepare('SELECT COUNT(*) AS qtd_registros FROM usuario_status;');

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
                FROM usuario_status
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
        string $status,
        string $data_de_criacao,
        ?string $observacao,
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            $conexao_db->beginTransaction();

            // Prepare o comando de atualização
            $comando = $conexao_db->prepare('UPDATE usuario_status
                SET 
                    id_usuario = :id_usuario,
                    status = :status,
                    data_de_criacao = :data_de_criacao,
                    observacao = :observacao
            WHERE id = :id;');

            // Execute o comando com os parâmetros fornecidos
            $comando->execute([
                ':id' => $id,
                ':id_usuario' => $id_usuario,
                ':status' => $status,
                ':data_de_criacao' => $data_de_criacao,
                ':observacao' => $observacao
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
            $comando = $conexao_db->prepare('DELETE FROM usuario_status WHERE id = :id;');

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
            $comando = $conexao_db->prepare('DELETE FROM usuario_status;');

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

            $comando = $conexao_db->prepare('ALTER TABLE usuario_status AUTO_INCREMENT = 1;');
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
        $resposta = Usuario_status::ler_registros();

        if ($resposta['sucesso'] == 200) {
            if ($resposta['conteudo'] == []) {

                date_default_timezone_set('UTC');
                $data_atual = new DateTime();
                $data_atual = $data_atual->format('Y-m-d H:i:s');

                // Testar funções
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, null);
                Usuario_status::atualizar_registro('1', '1', 'Autorizado', $data_atual, null);
                Usuario_status::ler_qtd_registros();
                Usuario_status::ler_registros_paginando();
                Usuario_status::ler_registro_por_id_usuario('1');
                Usuario_status::apagar_registro('1');
                Usuario_status::resetar_auto_increment();

                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 1');
                Usuario_status::criar_registro('1', 'Autorizado', $data_atual, 'teste 2');
                Usuario_status::criar_registro('1', 'Inativado', $data_atual, 'teste 3');
                Usuario_status::criar_registro('1', 'Autorizado', $data_atual, 'teste 4');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 5');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 6');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 7');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 8');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 9');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 10');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 11');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 12');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 13');
                Usuario_status::criar_registro('1', 'Pendente', $data_atual, 'teste 14');
                Usuario_status::criar_registro('1', 'Autorizado', $data_atual, 'teste 15');

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