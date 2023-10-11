<style>
    .img_perfil {
        width: 300px;
        display: block;
        float: left;
        padding: 10px;
        margin-right: 30px;
        box-shadow: 0px 0px 4px black;
    }
    
    .img_perfil img {
        width: 250px;
        height: 250px;
        border-radius: 100%;
        display: block;
        margin: auto;
    }

    .lista_de_sistemas {
        padding: 0px;
    }
    .lista_de_sistemas li {
        background-color: var(--cor_a1);
        display: inline-block;
        color: var(--cor_z2);
        padding: 2px 5px 2px 5px;
        border-radius: 10px;
        margin-bottom: 5px;
        cursor: pointer;
    }
    .lista_de_sistemas li:hover {
        color: var(--cor_a1);
        background-color: var(--cor_z2);
        box-sizing: border-box;
        border: 1px solid black;
    }
    
    .observacao_de_agradecimento {
        font-size: 12px;
        font-weight: 800;
        text-align: center;
    }

    .icone_arduino {
        position: relative;
    }
    .icone_arduino .icone_arduino_sinais {
        position: absolute;
        left: 7px;
        top: 9px;
        width: 50px;
        zoom: 0.39;
    }
    .icone_arduino .fa-infinity {
        zoom: 1.2;
    }
    .icone_arduino .icone_arduino_sinais .fa-minus, .icone_arduino .icone_arduino_sinais .fa-plus {
        margin-right: 7px;
    }
    @media all and (max-width: 600px) {
        .img_perfil {
            width: auto;
            margin: auto;
        }
    }
</style>

<div>
    <h2 style="text-align: center;">O que é este site?</h2>

    <p style="text-align: center;">Este site que estou elaborando tem como obejtivo ser meu portfólio e a entrada de pequenos projetos que me chamarem atenção.</p>

    <section>
        <h3 style="text-align: center;">Meu Perfil:</h3>

        <div>

            <div class="img_perfil">
                <img src="/assets/imagens/rafael_ramos_18.webp" alt="Foto do Rafael Ramos" width="960" height="960" />

                <div>
                    <h4>Linguagens e Tecnologias estudadas:</h4>

                    <ul class="lista_de_sistemas">
                        <a style="color: unset;" href="/templates/template_html"><li><i class="fa-brands fa-html5"></i> HTML5</li></a>
                        <li><i class="fa-brands fa-css3-alt"></i> CSS3</li>
                        <li><i class="fa-brands fa-js"></i> Javascript</li>
                        <li><i class="fa-brands fa-php"></i> PHP</li>
                        <li><i class="fa-solid fa-database"></i> MySQL</li>
                        <li><i class="fa-brands fa-github"></i> Github</li>
                    </ul>
                </div>
            </div>
            
            <div>
                <p>Sou Rafael Ramos da Silva, um estudante adquirindo cada vez mais conhecimento nos diversos ramos da programação não se fixando apenas em desenvolvimento web, mas tendo ela como principal foco. Enquanto estou fazendo este site estou colocando tudo que sei em prática desenvolvendo de forma autonoma e autodidata.</p>

                <h4>Experiências profissionais:</h4>

                <p>• 2 anos em uma startup como estagiário.</p>

                <p>A empresa tinha como objetivo criar conexão entre profissionais da área de saúde mental e pacientes durante o tempo de pandemia da Covid-19. Lá aprendi a utilizar o Github para versionamento de códigos em equipes, conceitos de indexação de páginas nos algorítimos de pesquisas como o Google, prática com front-end, back-end, APIs e bancos de dados, sistemas de criptografia, login, chats, video-chamadas e pagamentos. Além de utilizar ferramentas de gerenciamento de metas com o Trello e utilização de e-mail corporativo para responder os usuários.</p>

                <h4>O que faço atualmente:</h4>

                <p>Estou estudando na UTFPR, campus Ponta Grossa, o curso de Bacharelado em Ciências da Computação, conhecendo cada vez mais as diversas oportunidades que o mundo da tecnologia tem a oferecer, disposto a engressar no mercado de trabalho e procurando formas de aprimorar e aplicar meus conhecimentos.</p>

                <p class="observacao_de_agradecimento">*Deixo aqui meus agradecimentos finais à minha família e amigos que me deram apoio, me ajudaram a estruturar este site e me ensinam cada dia mais.</p>

                <p><a href="Curriculo - Rafael Ramos_v3.pdf" download="curriculo_rafael_ramos.pdf">Baixe o meu curriculo completo</a></p>
            </div>
            
        </div>
        
    </section>
</div>