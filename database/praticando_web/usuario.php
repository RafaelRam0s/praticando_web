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
    data_de_cadastro DATETIME NOT NULL
);
*/
require_once(__DIR__ . '/../../configuracoes/rotas.php');


// ------------------------------------------------------------------------
// Criar 
// ------------------------------------------------------------------------
function tb_usuario_criar(
    $email,
    $senha,
    $nome,
    $data_nascimento,
    $termos_de_uso_aceito,
    $politica_de_privacidade_aceito,
    $data_de_cadastro
) {
    convocar_rota('config/configuracoes');
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();
    

    try {
        
        $conexao_db->beginTransaction();

        $comando = $conexao_db->prepare(
            'INSERT INTO usuario
            (
                email,
                senha,
                nome,
                data_nascimento,
                termos_de_uso_aceito,
                politica_de_privacidade_aceito,
                data_de_cadastro
            ) VALUES (
                AES_ENCRYPT(:email, UNHEX(SHA2(:chave_criptografica, 512))),
                AES_ENCRYPT(:senha, UNHEX(SHA2(:chave_criptografica, 512))),
                :nome,
                :data_nascimento,
                :termos_de_uso_aceito,
                :politica_de_privacidade_aceito,
                :data_de_cadastro
            );'
        );

        $comando->execute([
            ':email' => $email,
            ':senha' => $senha,
            ':nome' => $nome,
            ':data_nascimento' => $data_nascimento,
            ':termos_de_uso_aceito' => $termos_de_uso_aceito,
            ':politica_de_privacidade_aceito' => $politica_de_privacidade_aceito,
            ':data_de_cadastro' => $data_de_cadastro,
            ':chave_criptografica' => AES_KEY_DB_PRATICANDO_WEB
        ]);

        $id_inserido = $conexao_db->lastInsertId();

        if($comando->rowCount() > 0){
            $conexao_db->commit();
        } else {
            $conexao_db->rollBack();
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro no banco de dados, falta de confirmação do banco, verificar criação do registro',
                'conteudo' => null
            ];
        }

    } catch (Exception $e) {
        $conexao_db->rollBack();
        error_log($e, 0);
        
        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados, erro ao criar registro',
            'conteudo' => null
        ];
    }

    $comando->closeCursor();

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso!',
        'conteudo' => ['id' => $id_inserido]
    ];
}

// ------------------------------------------------------------------------
// Visualizar 
// ------------------------------------------------------------------------
function tb_usuario_buscar_por_email(string $email)
{
    convocar_rota('config/configuracoes');
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();
    
    try {
        
        // Selecionar a tabela
        $comando = $conexao_db->prepare(
            'SELECT 
            id,
            AES_DECRYPT(email, UNHEX(SHA2(:chave_criptografica, 512))) email,
            AES_DECRYPT(senha, UNHEX(SHA2(:chave_criptografica, 512))) senha,
            nome,
            data_nascimento,
            termos_de_uso_aceito,
            politica_de_privacidade_aceito,
            data_de_cadastro
            FROM usuario 
            WHERE email = AES_ENCRYPT(:email, UNHEX(SHA2(:chave_criptografica, 512)))
            LIMIT 1'
        );

        $comando->execute([
            ':email' => $email,
            ':chave_criptografica' => AES_KEY_DB_PRATICANDO_WEB
        ]);

        $dado_encontrado = $comando->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        
        $conexao_db->rollBack();
        
        error_log($e, 0);

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
            'mensagem' => 'Registro não encontrado',
            'conteudo' => null
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso!',
        'conteudo' => $dado_encontrado
    ];
}

function tb_usuario_buscar_por_id(string $id)
{
    convocar_rota('config/configuracoes');
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();
    
    try {
        
        // Selecionar a tabela
        $comando = $conexao_db->prepare(
            'SELECT 
            id,
            AES_DECRYPT(email, UNHEX(SHA2(:chave_criptografica, 512))) email,
            AES_DECRYPT(senha, UNHEX(SHA2(:chave_criptografica, 512))) senha,
            nome,
            data_nascimento,
            termos_de_uso_aceito,
            politica_de_privacidade_aceito,
            data_de_cadastro
            FROM usuario 
            WHERE email = AES_ENCRYPT(:email, UNHEX(SHA2(:chave_criptografica, 512)))
            LIMIT 1'
        );

        $comando->bindValue(':email', (string) $id, );
        $comando->bindValue(':chave_criptografica', AES_KEY_DB_PRATICANDO_WEB);

        $comando->execute();

        $dado_encontrado = $comando->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        
        $conexao_db->rollBack();
        
        error_log($e, 0);

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
            'mensagem' => 'Registro não encontrado',
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
function tb_usuario_excluir($id) {
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $conexao_db->beginTransaction();

        // Prepare o comando de exclusão
        $comando = $conexao_db->prepare(
            'DELETE FROM usuario
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
function tb_usuario_resetar_auto_increment() {
    // Conectar com o banco
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {
        $comando = $conexao_db->prepare('ALTER TABLE usuario AUTO_INCREMENT = 1;');
        $comando->execute();
    } catch (Exception $e)
    {
        error_log($e, 0);

        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados, erro ao resetar o auto_increment' . $e,
            'conteudo' => null
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação efetuada com sucesso! Resetado o auto_increment!',
        'conteudo' => null
    ];
}

?>