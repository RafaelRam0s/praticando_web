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
require_once(__DIR__ . '/../../../configuracoes/rotas.php');


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

        if($comando->rowCount() > 0){
            $conexao_db->commit();
        } else {
            $conexao_db->rollBack();
            return [
                'sucesso' => 400,
                'mensagem' => 'Erro no banco de dados, falta de confirmação do banco, verificar criação do registro',
                'conteudo' => []
            ];
        }

    } catch (Exception $e) {
        $conexao_db->rollBack();
        error_log($e, 0);
        
        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados, erro ao criar registro',
            'conteudo' => []
        ];
    }

    $comando->closeCursor();

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação bem sucedida, registro criado',
        'conteudo' => []
    ];
}

// ------------------------------------------------------------------------
// Visualizar 
// ------------------------------------------------------------------------
function tb_usuario_buscar_registros($quantidade_de_registros, $pagina_de_busca)
{
    convocar_rota('config/configuracoes');
    convocar_rota('config/db_praticando_web');
    $conexao_db = db_praticando_web_gerar_conexao();

    try {

        // Calcular o offset com base na página e quantidade

        $comando = $conexao_db->prepare(
            'SELECT 
                id,
                AES_DECRYPT(email, UNHEX(SHA2(:chave_criptografica, 512))) as email,
                AES_DECRYPT(senha, UNHEX(SHA2(:chave_criptografica, 512))) as senha,
                nome,
                data_nascimento,
                termos_de_uso_aceito,
                politica_de_privacidade_aceito,
                data_de_cadastro
            FROM usuario
            ORDER BY id
            LIMIT :quantidade OFFSET :offset'
        );

        $comando->execute([
            ':quantidade' => (int) $quantidade_de_registros,
            ':offset' => (int) $pagina_de_busca,
            ':chave_criptografica' => AES_KEY_DB_PRATICANDO_WEB
        ]);

        $resultados = $comando->fetchAll(PDO::FETCH_ASSOC);

        return [
            'status' => 200,
            'mensagem' => 'Operação bem sucedida',
            'conteudo' => $resultados
        ];

    } catch (Exception $e) {
        error_log($e, 0);
        return [
            'status' => 400,
            'mensagem' => 'Erro no banco de dados; erro ao buscar registros',
            'conteudo' => []
        ];
    }
}

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
            WHERE email = AES_ENCRYPT(:email, UNHEX(SHA2(:chave_criptografica, 512)));
            LIMIT 1'
        );

        $comando->bindValue(':email', (string) $email, );
        $comando->bindValue(':chave_criptografica', AES_KEY_DB_PRATICANDO_WEB);

        $comando->execute();

        $dado_encontrado = $comando->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        
        $conexao_db->rollBack();
        
        error_log($e, 0);

        return [
            'sucesso' => 400,
            'mensagem' => 'Erro no banco de dados; erro ao buscar registro',
            'conteudo' => []
        ];
        
    }

    if (count($dado_encontrado) == 0)
    {
        return [
            'sucesso' => 204,
            'mensagem' => 'Registro não encontrado',
            'conteudo' => []
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => null,
        'conteudo' => [
            $dado_encontrado
        ]
    ];
}

// ------------------------------------------------------------------------
// Funcionalidades 
// ------------------------------------------------------------------------
function tb_usuario_resetar_auto_increment()
{
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
            'conteudo' => []
        ];
    }

    return [
        'sucesso' => 200,
        'mensagem' => 'Operação bem sucedida, resetado o auto_increment',
        'conteudo' => []
    ];
}

?>