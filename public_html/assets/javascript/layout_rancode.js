
// v 1.0.0

// ---------------------------------
// Função para ter um pré-carregamento da página, uma tela que prende o usuário até toda a página carregar
// ---------------------------------
(function configurarPaginaNoPreloader() {
    if (document.querySelectorAll('div#preloader')[0] != undefined){
        document.addEventListener(
            'load',
            function() {
                setTimeout(() => {
                    document.querySelectorAll('div#corpo')[0].style.display = 'block';
                    document.querySelectorAll('div#preloader')[0].style.opacity = 0;
                }, 500);
            },
            true
        );
    }
})();
/* 
<div id="preloader">
    <div>
        <i class="fa-solid fa-spinner animacao_rodando"></i>
        Carregando...
    </div>
</div> 
*/
/**/

// ---------------------------------
// Função para ter na barra de menu uma abertura de abas
// ---------------------------------
(function configurarMenuDeLinks() {
    for (
        let contador = 0; 
        document.querySelectorAll('#_menu_links ul li.aba_de_categorias')[contador] != undefined; 
        contador++
    ) {
        document.querySelectorAll('#_menu_links ul li.aba_de_categorias')[contador].addEventListener(
            'click',
            function () {
                if (this.querySelectorAll('ul')[0].style.display == 'none' || this.querySelectorAll('ul')[0].style.display == '') {
                    this.querySelectorAll('ul')[0].style.display = 'block';
                    setTimeout(() => {this.querySelectorAll('ul')[0].style.maxHeight = 'none';}, 50);
                } else {
                    this.querySelectorAll('ul')[0].style.maxHeight = '0vh';
                    setTimeout(() => {this.querySelectorAll('ul')[0].style.display = 'none';}, 50);
                }
            },
            true
        );
    }
})();
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
/*
    <div id="_abrir_menu_links" class="botao_menu">
        <button type="button" onclick="expandirMenu()" title="Abrir menu">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    <div id="_fechar_menu_links" class="botao_menu">
        <button type="button" onclick="recolherMenu()" title="Fechar menu">
            <i class="fa-solid fa-x"></i>
        </button>
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
            </ul>
        </div>
    </nav>
*/

// ---------------------------------
// Função para ter no topo da página uma diminuição suave quando a tela é escrolada para baixo
// ---------------------------------
(function configurarAnimacaoDoHeader() {
    window.addEventListener(
        'scroll',
        function() {
            if (window.scrollY >= 1) {
                document.querySelectorAll('header#cabecalho > #cabecalho_organizado')[0].style.padding = '1px 15px 1px 15px';
            } else if (window.scrollY < 1) {
                document.querySelectorAll('header#cabecalho > #cabecalho_organizado')[0].style.padding = '10px 15px 10px 15px';
            }
        },
        true
    );
})();

// ---------------------------------
// Função para redirecionar a página para o centro do conteudo pedido na url
// ---------------------------------
// Função para extrair o "id de redirecionamento" da URL
function pegarIdDeRedicionamentoDaURL() {
    /* 
        Exemplos de urls:
            http://localhost:8080/projetos/projeto_html - vai para ninguem
            http://localhost:8080/projetos/projeto_html#teste1 - vai para teste1
            http://localhost:8080/projetos/projeto_html#teste2?nome=teste - vai para teste2
            http://localhost:8080/projetos/projeto_html#teste2?nome=teste#teste3 - vai para teste2
            http://localhost:8080/projetos/projeto_html#teste4#teste2?nome=teste#teste3 - vai para teste2
    */

    let url = window.location.href;
    let redirecionamento = false;
    
    // Se tiver ? na url, corte a url antes do ?
    if ( url.indexOf('?') != -1 )
    {
        url = url.slice(0, url.indexOf('?'));
    }
    
    // Se tiver # na url, corte a url após o último #
    if ( url.lastIndexOf('#') != -1 )
    {
        redirecionamento = url.slice( url.lastIndexOf('#') + 1 );
    }

    return redirecionamento;
}
// Função para redirecionar o scroll para o elemento
function redirecionarCentroDaPaginaParaOId(id_do_elemento)
{
    if (id_do_elemento !== false)
    {
        if (document.querySelector('#' + id_do_elemento) != undefined) 
        {

            let elemento = document.querySelector('#' + id_do_elemento);
            let barra_superior = document.querySelector('#cabecalho');
            
            // Inicia a página no topo
            window.scrollTo({
                top: 0,
                behavior: "instant"
            });

            // Redireciona a página para a [posição do elemento - o tamanho da barra_superior]
            window.scrollTo({
                top: elemento.offsetTop - barra_superior.clientHeight,
                behavior: "smooth"
            });                
        }
    }
}

window.addEventListener(
    'load',
    function() {
        redirecionarCentroDaPaginaParaOId(pegarIdDeRedicionamentoDaURL());
    },
    true
);

window.addEventListener(
    'hashchange',
    function() {
        redirecionarCentroDaPaginaParaOId(pegarIdDeRedicionamentoDaURL());
    },
    true
);


// ---------------------------------
// Função para mascarar um input com cpf
// ---------------------------------
function mascaraCPF(elemento_input) {

    let cpf = elemento_input.value.replace(/\D/g, '');

    if (cpf.length > 3 && cpf.length <= 6) {
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    } else if (cpf.length > 6 && cpf.length <= 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d)/, '$1.$2.$3')
    } else if (cpf.length > 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d)/, '$1.$2.$3-$4');
    }

    elemento_input.value = cpf;
}
/*
    <div>
        <label for="id_cpf">CPF</label>
        <input type="text" id="id_cpf" name="name_cpf" autocomplete="off" maxlength="14" oninput="mascaraCPF(this)">
    </div>
*/
