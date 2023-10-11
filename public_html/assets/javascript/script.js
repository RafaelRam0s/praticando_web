

/* 
    @@@ Fazer classes máscaras de input e delimitações de valores aceitos:
        Numérico, aceitando; 0123456789.,/
        Data, (dd/mm/aaaa), aceitando; 0123456789
        Horário, (--:--), aceitando; 0123456789
        Telefone ((+xx) xx xxxxx-xxxx), aceitando; 0123456789+ //Brasil, ver outros paises e internacional regex
        E-mail (texto@texto)
*/



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



// ---------------------------------
// Função para ter na barra de menu uma abertura de abas
// ---------------------------------
(function configurarMenuDeLinks() {
                
    for(
        let contador = 0; 
        document.querySelectorAll('#_menu_links ul li.aba_de_categorias')[contador] != undefined; 
        contador++
    ) 
    {
        document.querySelectorAll('#_menu_links ul li.aba_de_categorias')[contador].addEventListener(
            'click',
            function () {
                if (this.querySelectorAll('ul')[0].style.display == 'none' || this.querySelectorAll('ul')[0].style.display == '')
                {
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



// ---------------------------------
// Função para ter no topo da página uma diminuição suave quando a tela é escrolada para baixo
// ---------------------------------
(function configurarAnimacaoDoHeader() {
    window.addEventListener(
        'scroll',
        function() {
            if (window.scrollY >= 1)
            {
                document.querySelectorAll('header#cabecalho > #cabecalho_principal')[0].style.padding = '1px 15px 1px 15px';
            } else if (window.scrollY < 1) {
                document.querySelectorAll('header#cabecalho > #cabecalho_principal')[0].style.padding = '10px 15px 10px 15px';
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

    if (cpf.length > 3 && cpf.length <= 6) 
    {
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    } else if (cpf.length > 6 && cpf.length <= 9) 
    {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d)/, '$1.$2.$3')
    } else if (cpf.length > 9) 
    {
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



// ---------------------------------
// @@@ Função para mascarar um input com data
// ---------------------------------
// function mascaraData(elemento_input)
// {
//     // Só permite número e recorta a entrada caso tenha sido digitado algo diferente de um número
//     let data = elemento_input.value.replace(/\D/g, '');

//     if (data.length > 2 && data.length <= 4)
//     {
//         data = data.replace(/(\d{2})(\d)/, '$1/$2');
//     } else if (data.length > 4)
//     {
//         data = data.replace(/(\d{2})(\d{2})(\d)/, '$1/$2/$3');
//     }

//     elemento_input.value = data;
// }
/* 
    <div>
        <label for="id_data">data</label>
        <input type="text" id="id_data" name="name_data" autocomplete="off" maxlength="10" oninput="mascaraData(this)">
    </div>
*/



// ---------------------------------
// Função para validar data
// ---------------------------------
function dataValida(data_ano_mes_dia)
{
    // Exemplo aceito de parametro: data_ano_mes_dia = 2023-07-24

    let data_dividida = data_ano_mes_dia.split('-');

    if (data_dividida.length == 3)
    {
        let dia = data_dividida[2];
        let mes = data_dividida[1];
        let ano = data_dividida[0];

        if (mes >= 1 && mes <= 12)
        {
            let dia_final = 31;
            
            // Se mês par
            if (mes % 2 == 0)
            {
                dia_final = 29;
                
                // Se for fevereiro
                if (mes == 2)
                {
                    // Se for ano bissexto
                    if (ano % 4 == 0)
                    {
                        dia_final = 30;
                    }
                }
            }

            if (dia >= 1 && dia <= dia_final)
            {
                if (ano >= 1)
                {
                    return true;
                }
            }
        }
    }

    return false;
}



