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
require_once(__DIR__ . '/../../configuracoes/rotas.php');


// ------------------------------------------------------------------------
// Criar 
// ------------------------------------------------------------------------
function tb_historico_de_email_criar(
    $id_usuario,
    $assunto,
    $data_de_criacao
) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        
        $conexao_db->beginTransaction();

        $comando = $conexao_db->prepare(
            'INSERT INTO historico_de_email
            (
                id_usuario,
                assunto,
                data_de_criacao
            ) VALUES (
                :id_usuario,
                :assunto,
                :data_de_criacao
            );'
        );

        $comando->execute([
            ':id_usuario' => $id_usuario,
            ':assunto' => $assunto,
            ':data_de_criacao' => $data_de_criacao
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
function tb_historico_de_email_ver_todos() {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        // Selecionar a tabela
        $comando = $conexao_db->prepare(
            'SELECT 
            id,
            id_usuario,
            assunto,
            data_de_criacao
            FROM historico_de_email;
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

// ------------------------------------------------------------------------
// Atualizar 
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// Apagar
// ------------------------------------------------------------------------
function tb_historico_de_email_excluir($id) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $conexao_db->beginTransaction();

        // Prepare o comando de exclusão
        $comando = $conexao_db->prepare(
            'DELETE FROM historico_de_email
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
function tb_historico_de_email_resetar_auto_increment() {
    // Conectar com o banco
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $comando = $conexao_db->prepare('ALTER TABLE historico_de_email AUTO_INCREMENT = 1;');
        $comando->execute();
    } catch (Exception $e) {
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