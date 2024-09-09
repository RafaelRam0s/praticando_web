<?php 
// ------------------------------------------------------------------------
// Tabela no banco de dados
// ------------------------------------------------------------------------
/* 
CREATE TABLE IF NOT EXISTS token_de_cadastro_validacao (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_token_de_cadastro INT UNSIGNED NOT NULL,
    dados_de_auditoria TEXT NOT NULL,
    valor_tentado VARCHAR(255),
    data_de_criacao DATETIME NOT NULL,

    CONSTRAINT fk_token_de_cadastro_validacao_token_de_cadastro FOREIGN KEY (id_token_de_cadastro) REFERENCES token_de_cadastro(id) ON DELETE CASCADE
);
*/
require_once(__DIR__ . '/../../../configuracoes/rotas.php');
require_once(Rotas::buscar_arquivo('configuracoes/db_conexoes.php'));

class Token_de_cadastro_validacao {
    
    // ------------------------------------------------------------------------
    // Assegurar criação no banco de dados
    // ------------------------------------------------------------------------
    
    public static function gerar_tabela() {
        
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            
            $conexao_db->exec('CREATE TABLE IF NOT EXISTS token_de_cadastro_validacao (
                id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                id_token_de_cadastro INT UNSIGNED NOT NULL,
                dados_de_auditoria TEXT NOT NULL,
                valor_tentado VARCHAR(255),
                data_de_criacao DATETIME NOT NULL,

                CONSTRAINT fk_token_de_cadastro_validacao_token_de_cadastro FOREIGN KEY (id_token_de_cadastro) REFERENCES token_de_cadastro(id) ON DELETE CASCADE
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
        string $id_token_de_cadastro,
        string $dados_de_auditoria,
        string $valor_tentado,
        string $data_de_criacao
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Preparar uma transação
            $conexao_db->beginTransaction();

            // Efetuar comando com proteção contra SQL Injection
            $comando = $conexao_db->prepare('INSERT INTO token_de_cadastro_validacao (
                id_token_de_cadastro,
                dados_de_auditoria,
                valor_tentado,
                data_de_criacao
            ) VALUES (
                :id_token_de_cadastro,
                :dados_de_auditoria,
                :valor_tentado,
                :data_de_criacao
            );');

            $comando->execute([
                ':id_token_de_cadastro' => $id_token_de_cadastro,
                ':dados_de_auditoria' => $dados_de_auditoria,
                ':valor_tentado' => $valor_tentado,
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
            $comando = $conexao_db->prepare('SELECT * FROM token_de_cadastro_validacao ORDER BY id ASC;');

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
            $comando = $conexao_db->prepare('SELECT COUNT(*) AS qtd_registros FROM token_de_cadastro_validacao;');

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
                FROM token_de_cadastro_validacao
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
    
    public static function ler_qtd_registros_por_id_token_de_cadastro(string $id_token_de_cadastro) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            // Selecionar a tabela
            $comando = $conexao_db->prepare('SELECT COUNT(*) AS qtd FROM token_de_cadastro_validacao WHERE id_token_de_cadastro = :id_token_de_cadastro;');

            $comando->bindValue(':id_token_de_cadastro', (int)$id_token_de_cadastro, PDO::PARAM_INT);

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

    // ------------------------------------------------------------------------
    // UPDATE
    // ------------------------------------------------------------------------
    
    public static function atualizar_registro(
        string $id,
        string $id_token_de_cadastro,
        string $dados_de_auditoria,
        string $valor_tentado,
        string $data_de_criacao
    ) {
        // Criar conexão com o banco
        $conexao_db = Db_conexoes::gerar_conexao('praticando_web_mysql');

        try {
            $conexao_db->beginTransaction();

            // Prepare o comando de atualização
            $comando = $conexao_db->prepare('UPDATE token_de_cadastro_validacao
                SET 
                    id_token_de_cadastro = :id_token_de_cadastro,
                    dados_de_auditoria = :dados_de_auditoria,
                    valor_tentado = :valor_tentado,
                    data_de_criacao = :data_de_criacao
            WHERE id = :id;');

            // Execute o comando com os parâmetros fornecidos
            $comando->execute([
                ':id' => $id,
                ':id_token_de_cadastro' => $id_token_de_cadastro,
                ':dados_de_auditoria' => $dados_de_auditoria,
                ':valor_tentado' => $valor_tentado,
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
            $comando = $conexao_db->prepare('DELETE FROM token_de_cadastro_validacao WHERE id = :id;');

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
            $comando = $conexao_db->prepare('DELETE FROM token_de_cadastro_validacao;');

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

            $comando = $conexao_db->prepare('ALTER TABLE token_de_cadastro_validacao AUTO_INCREMENT = 1;');
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
        $resposta = Token_de_cadastro_validacao::ler_registros();

        if ($resposta['sucesso'] == 200) {
            if ($resposta['conteudo'] == []) {

                date_default_timezone_set('UTC');
                $data_atual = new DateTime();
                $data_atual = $data_atual->format('Y-m-d H:i:s');

                // Testar funções
                Token_de_cadastro_validacao::criar_registro('1', 'teste 1', '1', $data_atual);
                Token_de_cadastro_validacao::atualizar_registro('1', '1', 'testado 1', '1', $data_atual);
                Token_de_cadastro_validacao::ler_qtd_registros();
                Token_de_cadastro_validacao::ler_registros_paginando();
                Token_de_cadastro_validacao::ler_qtd_registros_por_id_token_de_cadastro('1');
                Token_de_cadastro_validacao::apagar_registro('1');
                Token_de_cadastro_validacao::resetar_auto_increment();

                Token_de_cadastro_validacao::criar_registro('1', 'teste 1', '1', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 2', '2', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 3', '3', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 4', '4', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 5', '5', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 6', '6', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 7', '7', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 8', '8', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 9', '9', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 10', '10', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 11', '11', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 12', '12', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 13', '13', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', 'teste 14', '14', $data_atual);
                Token_de_cadastro_validacao::criar_registro('1', json_encode($_SERVER), 'email_qualquer@teste.com', $data_atual);

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