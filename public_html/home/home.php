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
    <h2 style="text-align: center; font-weight: 400;">Rafael Ramos da Silva</h2>
    <h1 style="text-align: center; text-decoration: underline;">Desenvolvedor e Programador de Softwares</h1>

    <section>
        <h3 style="text-align: center;">Meu Perfil:</h3>

        <div>

            <div class="img_perfil">
                <img src="./assets/imagens/rafael_ramos_18.webp" alt="Foto do Rafael Ramos" width="960" height="960" />

                <div>
                    <h4>Linguagens e Tecnologias estudadas:</h4>

                    <ul class="lista_de_sistemas">
                        <li><i class="fa-brands fa-html5"></i> HTML5</li>
                        <li><i class="fa-brands fa-css3-alt"></i> CSS3</li>
                        <li><i class="fa-brands fa-js"></i> Javascript</li>
                        <li><i class="fa-brands fa-php"></i> PHP</li>
                        <li><i class="fa-solid fa-database"></i> MySQL</li>
                        <li><i class="fa-brands fa-github"></i> Github</li>
                        <li><i class="fa-brands fa-java"></i> Java</li>
                        <li><i class="fa-brands fa-python"></i> Python</li>
                        <li><i class="fa-brands fa-node"></i> NodeJS</li>
                        <li>C</li>
                        <li>C#</li>
                        <li>Asp.Net MVC</li>
                        <li>Arduino</li>
                        <li>Mips-32</li>
                    </ul>
                </div>
            </div>
            
            <div>
                <div>
                    <h4>O que faço atualmente:</h4>

                    <p>Estudo no Paraná na UTFPR campus Ponta Grossa em Análise e Desenvolvimento de Sistemas e busco poder contribuir no meio empresarial colocando meus conhecimentos e habilidades em prática, não só como desenvolvedor de softwares, mas também em funções que desempenham hablidades parecidas como analista de dados, gerencia e muitas outras.</p>
                </div>

                <div>
                    <h4>Experiência profissional:</h4>

                    <p>Atuei 2 anos como Desenvolvedor FullStack, realizando o design do site, sua implementação com o padrão MVC, otimização do site para rankeamento, conexões com APIs externas e internas utilizando o JSON, desenvolvimento de Banco de dados com o MySQL, atendimento ao cliente para soluções rápidas seja e-mail, telefone ou whatsapp, tester da aplicação, analista de dados, segurança de dados com criptografia, formulação de formulários, validações de login e manutenção diária.</p>
                </div>

                <div>
                    <h5>Idiomas:</h5> 
                    <span>Português fluente</span>
                    <br>
                    <span>Inglês técnico</span>
                </div>
                
                <div>
                    <h5 style="display: inline-block;">Nascimento:</h5> 
                    <span>13/07/2002</span>
                </div>

                <div>
                    <h5 style="display: inline-block;">Pretensão salarial:</h5> 
                    <span>A partir de R$ 2.000,00. Negociável de acordo com a função e benefícios</span>
                </div>

                <div>
                    <h4>Outros pontos sobre mim:</h4>
                    
                    <p>Sou um profissional com bom trabalho de equipe e comunicação, me destaco principalmente pela organização tanto de ideias quanto de projetos, possuo capacidade de resolver problemas de forma criativa e analítica, também me adapto bem ao ambiente conforme a necessidade e estou constantemente buscando aprender e melhorar minhas habilidades na área da tecnologia.</p>
                </div>

            </div>
            
        </div>
        
    </section>
</div>