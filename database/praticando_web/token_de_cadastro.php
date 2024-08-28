<?php 

// ------------------------------------------------------------------------
// Tabela no banco de dados
// ------------------------------------------------------------------------
/* 
CREATE TABLE token_de_cadastro (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT UNSIGNED NOT NULL,
    valor VARCHAR(255) NOT NULL UNIQUE,
    data_de_criacao DATETIME NOT NULL,
    data_de_expiracao DATETIME,
    data_de_uso DATETIME,

    CONSTRAINT fk_token_de_cadastro_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);
*/
require_once(__DIR__ . '/../../configuracoes/rotas.php');


// ------------------------------------------------------------------------
// Criar 
// ------------------------------------------------------------------------
function tb_token_de_cadastro_criar(
    $id_usuario,
    $valor,
    $data_de_criacao,
    $data_de_expiracao,
    $data_de_uso
) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        
        $conexao_db->beginTransaction();

        $comando = $conexao_db->prepare(
            'INSERT INTO token_de_cadastro
            (
                id_usuario,
                valor,
                data_de_criacao,
                data_de_expiracao,
                data_de_uso
            ) VALUES (
                :id_usuario,
                :valor,
                :data_de_criacao,
                :data_de_expiracao,
                :data_de_uso
            );'
        );

        $comando->execute([
            ':id_usuario' => $id_usuario,
            ':valor' => $valor,
            ':data_de_criacao' => $data_de_criacao,
            ':data_de_expiracao' => $data_de_expiracao,
            ':data_de_uso' => $data_de_uso
        ]);

        $id_inserido = $conexao_db->lastInsertId();

        if($comando->rowCount() > 0){
            $conexao_db->commit();
        } else {
            $conexao_db->rollBack();
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro na criação do registro',
                'conteudo' => null
            ];
        }

    } catch (Exception $e) {
        $conexao_db->rollBack();
        error_log("\033[41m\033[97m" . $e . "\033[0m", 0);
        
        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados, erro ao criar registro',
            'conteudo' => null
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso! Registro criado.',
        'conteudo' => ['id' => $id_inserido]
    ];
}

// ------------------------------------------------------------------------
// Visualizar 
// ------------------------------------------------------------------------
function tb_token_de_cadastro_ver_todos() {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        // Selecionar a tabela
        $comando = $conexao_db->prepare(
            'SELECT 
            id,
            id_usuario,
            valor,
            data_de_criacao,
            data_de_expiracao,
            data_de_uso
            FROM token_de_cadastro;
            ORDER BY id ASC'
        );

        // Executar o comando
        $comando->execute();

        // Buscar os dados
        $dado_encontrado = $comando->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        // Não há uma transação para fazer rollBack, então podemos remover essa linha
        error_log("\033[41m\033[97m" . $e . "\033[0m", 0);

        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados; erro ao buscar registros',
            'conteudo' => null
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso!',
        'conteudo' => $dado_encontrado
    ];
}

function tb_token_de_cadastro_buscar_valor(string $valor) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();
    
    try {
        
        // Selecionar a tabela
        $comando = $conexao_db->prepare(
            'SELECT 
            id,
            id_usuario,
            valor,
            data_de_criacao,
            data_de_expiracao,
            data_de_uso
            FROM token_de_cadastro 
            WHERE valor = :valor
            ORDER BY id ASC
            LIMIT 1;'
        );

        $comando->execute([
            ':valor' => $valor
        ]);

        $dado_encontrado = $comando->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        
        $conexao_db->rollBack();
        
        error_log("\033[41m\033[97m" . $e . "\033[0m", 0);

        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados; erro ao buscar registro',
            'conteudo' => null
        ];
        
    }

    if (count($dado_encontrado) == 0)
    {
        return [
            'sucesso' => 204,
            'mensagem' => 'Operação efetuada com sucesso! Registro não encontrado',
            'conteudo' => null
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso!',
        'conteudo' => $dado_encontrado[0]
    ];
}

function tb_token_de_cadastro_qtd_registro() {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        // Preparar o comando SQL para contar o total de registros
        $comando = $conexao_db->prepare(
            'SELECT COUNT(*) AS qtd_registro FROM token_de_cadastro'
        );

        // Executar o comando
        $comando->execute();

        // Buscar o total de registros
        $resultado = $comando->fetch(PDO::FETCH_ASSOC);
        $qtd_registro = $resultado['qtd_registro'];
        
    } catch (Exception $e) {
        // Registrar o erro e retornar uma resposta apropriada
        error_log("\033[41m\033[97m" . $e->getMessage() . "\033[0m", 0);

        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados; erro ao contar registros',
            'conteudo' => 0
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso!',
        'conteudo' => $qtd_registro
    ];
}

function tb_token_de_cadastro_ver_paginado($pagina = 1, $registros_por_pagina = 10) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    // Calcular o OFFSET baseado na página atual e no número de registros por página
    $offset = ($pagina - 1) * $registros_por_pagina;

    try {
        // Preparar o comando SQL com LIMIT e OFFSET
        $comando = $conexao_db->prepare(
            'SELECT 
            id,
            id_usuario,
            valor,
            data_de_criacao,
            data_de_expiracao,
            data_de_uso
            FROM token_de_cadastro
            ORDER BY id ASC
            LIMIT :registros_por_pagina OFFSET :offset'
        );

        // Vincular os parâmetros
        $comando->bindParam(':registros_por_pagina', $registros_por_pagina, PDO::PARAM_INT);
        $comando->bindParam(':offset', $offset, PDO::PARAM_INT);

        // Executar o comando
        $comando->execute();

        // Buscar os dados
        $dado_encontrado = $comando->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        // Registrar o erro e retornar uma resposta apropriada
        error_log("\033[41m\033[97m" . $e->getMessage() . "\033[0m", 0);

        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados; erro ao buscar registros',
            'conteudo' => null
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso!',
        'conteudo' => $dado_encontrado
    ];
}

// ------------------------------------------------------------------------
// Atualizar 
// ------------------------------------------------------------------------
function tb_token_de_cadastro_atualizar(
    $id,
    $id_usuario,
    $valor,
    $data_de_criacao,
    $data_de_expiracao,
    $data_de_uso
) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $conexao_db->beginTransaction();

        // Prepare o comando de atualização
        $comando = $conexao_db->prepare(
            'UPDATE token_de_cadastro
            SET 
                id_usuario = :id_usuario,
                valor = :valor,
                data_de_criacao = :data_de_criacao,
                data_de_expiracao = :data_de_expiracao,
                data_de_uso = :data_de_uso
            WHERE id = :id;'
        );

        // Execute o comando com os parâmetros fornecidos
        $comando->execute([
            ':id' => $id,
            ':id_usuario' => $id_usuario,
            ':valor' => $valor,
            ':data_de_criacao' => $data_de_criacao,
            ':data_de_expiracao' => $data_de_expiracao,
            ':data_de_uso' => $data_de_uso
        ]);

        if($comando->rowCount() > 0) {
            $conexao_db->commit();
        } else {
            $conexao_db->rollBack();
            return [
                'sucesso' => 204,
                'mensagem' => 'Operação efetuada com sucesso! Nenhum registro encontrado para atualizar ou nenhum dado foi modificado',
                'conteudo' => null
            ];
        }

    } catch (Exception $e) {
        $conexao_db->rollBack();
        error_log("\033[41m\033[97m" . $e . "\033[0m", 0);
        
        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados, erro ao atualizar registro',
            'conteudo' => null
        ];
    }

    $comando->closeCursor();

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação bem sucedida, registro atualizado',
        'conteudo' => null
    ];
}

function tb_token_de_cadastro_atualizar_data_de_uso(
    $id,
    $data_de_uso
) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $conexao_db->beginTransaction();

        // Prepare o comando de atualização
        $comando = $conexao_db->prepare(
            'UPDATE token_de_cadastro
            SET
                data_de_uso = :data_de_uso
            WHERE id = :id;'
        );

        // Execute o comando com os parâmetros fornecidos
        $comando->execute([
            ':id' => $id,
            ':data_de_uso' => $data_de_uso
        ]);

        if($comando->rowCount() > 0) {
            $conexao_db->commit();
        } else {
            $conexao_db->rollBack();
            return [
                'sucesso' => 400,
                'mensagem' => 'Nenhum registro encontrado para atualizar ou nenhum dado foi modificado',
                'conteudo' => null
            ];
        }

    } catch (Exception $e) {
        $conexao_db->rollBack();
        error_log("\033[41m\033[97m" . $e . "\033[0m", 0);
        
        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados, erro ao atualizar registro',
            'conteudo' => null
        ];
    }

    $comando->closeCursor();

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso! Registro atualizado',
        'conteudo' => null
    ];
}

// ------------------------------------------------------------------------
// Apagar
// ------------------------------------------------------------------------
function tb_token_de_cadastro_excluir($id) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $conexao_db->beginTransaction();

        // Prepare o comando de exclusão
        $comando = $conexao_db->prepare(
            'DELETE FROM token_de_cadastro
            WHERE id = :id;'
        );

        // Execute o comando com o id fornecido
        $comando->execute([
            ':id' => $id
        ]);

        if($comando->rowCount() > 0) {
            $conexao_db->commit();
        } else {
            $conexao_db->rollBack();
            return [
                'sucesso' => 204,
                'mensagem' => 'Operação efetuada com sucesso! Nenhum registro encontrado para excluir',
                'conteudo' => null
            ];
        }

    } catch (Exception $e) {
        $conexao_db->rollBack();
        error_log("\033[41m\033[97m" . $e . "\033[0m", 0);
        
        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados, erro ao excluir registro',
            'conteudo' => null
        ];
    }

    $comando->closeCursor();

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso! Registro excluído',
        'conteudo' => null
    ];
}

// ------------------------------------------------------------------------
// Funcionalidades 
// ------------------------------------------------------------------------
function tb_token_de_cadastro_resetar_auto_increment() {
    // Conectar com o banco
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $comando = $conexao_db->prepare('ALTER TABLE token_de_cadastro AUTO_INCREMENT = 1;');
        $comando->execute();
    } catch (Exception $e)
    {
        error_log("\033[41m\033[97m" . $e . "\033[0m", 0);

        return [
            'sucesso' => 400,
            'mensagem' => 'Erro ao resetar o auto_increment',
            'conteudo' => null
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso! auto_increment resetado',
        'conteudo' => null
    ];
}

?>