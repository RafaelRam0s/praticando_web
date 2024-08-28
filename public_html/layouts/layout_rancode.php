<?php
    require_once(__DIR__ . '/../../configuracoes/rotas.php');
    convocar_rota('config/seguranca_de_cabecalho');

    if (!(
        isset($layout_descricao)
        && isset($layout_palavras_chaves)
        && isset($layout_titulo)
        && isset($layout_arquivo_conteudo)
    ))
    {
        echo('Erro ao carregar o layout!');
        die();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Rafael Ramos da Silva" />
    <meta name="description" content="<?php echo($layout_descricao); ?>" />
    <meta name="keywords" content="<?php echo($layout_palavras_chaves); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="license" href="/LICENSE" />
    <link rel="icon" href="/assets/imagens/icones/icone_logo_r_16px.ico" type="image/x-icon" />
    
    <link rel="stylesheet" href="/assets/css/style.css" media="all" />
    <link rel="stylesheet" href="/assets/css/layout_rancode.css" media="all" />
    
    <title><?php echo($layout_titulo); ?></title>

    <link rel="stylesheet" href="/assets/frameworks/fontawesome-free-6.2.1-web/css/all.min.css" />
    <!--
        Font Awesome linkado externamente: 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css"> 
    -->

</head>
<body>

    <!--     
        Tela de pré-carregamento
        <div id="preloader">
            <div>
                <i class="fa-solid fa-spinner animacao_rodando"></i>
                Carregando...
            </div>
        </div> 
    -->
    <div id="pre_cabecalho"></div>
    <div id="corpo">
        <header id="cabecalho">
            <div id="cabecalho_principal">

                <div>
                    <a href="/">
                        <div class="logo_em_css">
                            RanCode
                        </div>
                    </a>
                </div>

                <div class="display_none display_block_600px">
                    <span class="mensagem_menu">Hello World!</span>
                </div>

                <div id="_abrir_menu_links">
                    <button type="button" onclick="expandirMenu()" title="Abrir menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
                <div id="_fechar_menu_links">
                    <button type="button" onclick="recolherMenu()" title="Fechar menu">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div> 

            </div>

            <nav id="_menu_links">
                <div>
                    <ul>
                        <li>
                            <a href="/">Menu principal</a>
                        </li>
                        <li class="aba_de_categorias">
                            <span>Templates</span>
                            <ul>
                                <li>
                                    <a href="/templates/template_html">HTML</a>
                                </li>
                            </ul>
                        </li>
                        <li class="aba_de_categorias">
                            <span>Sistema de registros</span>
                            <ul>
                                <li>
                                    <a href="/sistema_de_registro/cadastro">Cadastro</a>
                                </li>
                                <li>
                                    <a href="/sistema_de_registro/cadastro/confirmacao_cadastro">Validação de Cadastro</a>
                                </li>
                                <li>
                                    <a href="/sistema_de_registro/login">Login</a>
                                </li>
                                <li>
                                    <a href="/sistema_de_registro/esqueci_a_senha">Esqueci a senhha</a>
                                </li>
                                <li>
                                    <a href="/sistema_de_registro/esqueci_a_senha/alterar_senha">Alterar senha</a>
                                </li>
                                <li>
                                    <a href="/sistema_de_registro/area_logado">Área para logados</a>
                                </li>
                            </ul>
                        </li>
                        <!--
                            <li class="aba_de_categorias">
                                <span>Aba de categorias 1</span>
                                <ul>
                                    <li>
                                        <a href="#">Site 3</a>
                                    </li>
                                    <li>
                                        <a href="#">Site 4</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Site 5</a>
                            </li> 
                        -->
                    </ul>
                </div>
            </nav>
        </header>
        
        <main>
            <?php convocar_rota($layout_arquivo_conteudo); ?>
        </main>
        
        <hr />

        <footer id="rodape">
            <div>
                <div id="area_informacoes" class="flex-direction_column_600px">
                    <div class="width_100p_600px">
                        <a href="/">
                            <div class="logo_em_css">
                                RanCode
                            </div>
                        </a>
                        <p><q>De grão em grão a galinha enche o papo</q></p>
                        <p><a href="/politica_de_privacidade" target="_self">Política de privacidade</a></p>
                        <p><a href="/termos_de_uso" target="_self">Termos de uso</a></p>
                    </div>
                    <div class="width_100p_600px">
                        <address>
                            <p>Criado por: Rafael Ramos da Silva</p>
                            <p>
                                <i class="fa-brands fa-github"></i> 
                                Github: <a href="https://github.com/RafaelRam0s" target="_blank" rel="nofollow">RafaelRam0s</a>
                            </p>
                            <p>
                                <i class="fa-brands fa-instagram"></i>
                                Instragram: <a href="https://www.instagram.com/rafael6ramos/" target="_blank" rel="nofollow">rafael6ramos</a>
                            </p>
                            <p>
                                <i class="fa-brands fa-linkedin-in"></i>
                                Linkedin: <a href="https://www.linkedin.com/in/rafael-ramos-3a330019b/" target="_blank" rel="nofollow">Rafael Ramos</a>
                            </p>
                            <p>
                                <i class="fa-solid fa-envelope"></i>
                                E-mail: <a href="mailto:rafael6ramos@gmail.com" target="_blank" rel="nofollow">rafael6ramos@gmail.com</a>
                            </p>
                            <p>
                                <i class="fas fa-mobile-alt"></i>
                                Celular de contato: <a href="tel:+5511950503563">+55 (11) 9-5050-3563</a>
                            </p>
                        </address>
                    </div>
                </div>
                
                <div id="area_copyright">
                    <hr />
                    
                    <p>&#169; <?php echo( (new DateTime('now', new DateTimeZone('America/Sao_Paulo')))->format('Y') ); ?> RanCode</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="/assets/javascript/script.js"></script>
    <script>
        function expandirMenu() {
            document.getElementById('_menu_links').style.display = 'block';
            setTimeout(() => {document.getElementById('_menu_links').style.maxHeight = '40vh';}, 100);

            document.getElementById('_abrir_menu_links').style.display = 'none';
            document.getElementById('_fechar_menu_links').style.display = 'block';
        };

        function recolherMenu() {
            document.getElementById('_menu_links').style.maxHeight = '0vh';
            setTimeout(() => {document.getElementById('_menu_links').style.display = 'none';}, 100);

            document.getElementById('_abrir_menu_links').style.display = 'block';
            document.getElementById('_fechar_menu_links').style.display = 'none';
        };
    </script>
</body>
</html>