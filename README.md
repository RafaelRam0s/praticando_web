# praticando_web
    Objetivo: Colocar em prática o desenvolvimento web

- Para rodar o código e ver o site funcionando:
    Execute com o php 8.2 a página public_html
        No caso o servidor "roda" a página public_html, então a rota default localhost/index.php tem que ser a partir da public_html
    Do php é necessário habilitar algumas extensões, entre elas: 
        * Rota: "php82/php.ini"
        pdo_mysql
        openssl
        mbstring
        curl
    Necessário também ajustar as conexões com o seu banco de dados no arquivo de configuracoes/config.php

- Se pegar este template:
    Definir sitemap.xml e robots.txt para ajudar na indexação das suas páginas pelo bots dos navegadores
    Definir palavras chaves e descrições de cada página
    Minificar arquivos css e js
    Criar chaves de segurança no arquivo de config
    Verificar "Políticas de Privacidade", "Termos de uso" e "Licenças de código"
    Ajustar .htaccess se o servidor for Apache
    Garantir que está usando a versão 8.2 do php e garantir que ela continua segura

- Tarefas:
    Ajustar o css "layout_rancode.css"
    Ajustar o js "script.js"

- Antes de subir para a produção:
    Verificar os arquivos: 
        - seguranca_de_cabecalho.php - desativar mensagens de erro
        - banco de dados - verificar conexoes
        - config - mudar senhas



