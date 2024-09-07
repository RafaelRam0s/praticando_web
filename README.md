# praticando_web
    Objetivo: Colocar em prática o desenvolvimento web

- Para rodar o código e ver o site funcionando:
    Execute com o php 8.2 a página public_html
        No caso o servidor "roda" a página public_html, então a rota default localhost/index.php tem que ser a partir da public_html
        
        Você pode dar um "cd" até a pasta public_html e depois executar com "php -S localhos:8080" depois vá no seu navegador e acesse "localhost:8080/" verifique se o php está nas suas variáveis de ambiente do computador

    Do php é necessário habilitar algumas extensões, entre elas: 
        * Configure o arquivo: "php82/php.ini"
        pdo_mysql
        openssl
        mbstring
        curl

    Necessário também ajustar as conexões com o seu banco de dados, crie um arquivo "configuracoes/configuracoes.php" com o modelo do arquivo "configuracoes/config.php"

- Se pegar este template:
    Definir sitemap.xml e robots.txt para ajudar na indexação das suas páginas pelo bots dos navegadores
    Definir palavras chaves e descrições de cada página na controller
    Minificar arquivos css e js
    Criar chaves de segurança no arquivo de config
    Verificar "Políticas de Privacidade", "Termos de uso" e "Licenças de código"
    Ajustar .htaccess se o servidor for Apache
    Garantir que está usando a versão 8.2 do php e garantir que ela continua segura

- Tarefas a fazer:
    Ajustar o css "layout_rancode.css"
    Ajustar o js "script.js"
    Adicionar camada de segurança para envios com token:
        Ao gerar um token e enviar um email para uma pessoa poder validar o cadastro ou trocar a senha valide se o token pode ser usado para confirmar a ação, caso possa, solicite o usuário confirmar o email para o qual o token foi enviado, se passar de 10 tentativas invalide o token e registre um acesso forçado, pegue ip da máquina e toda informação que for possível

- Antes de subir para a produção:
    Verificar os arquivos: 
        - config - mudar senhas
        - banco de dados - verificar conexoes
        - seguranca_de_cabecalho.php - desativar mensagens de erro na tela
        - .htaccess - verificar se funciona
