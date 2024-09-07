<?php
    require_once(__DIR__ . '/../../../configuracoes/rotas.php');
    require_once(Rotas::buscar_arquivo('controller/main_controller.php'));
?>

<div>
    <h2>Conteúdo</h2>
    
    <section>
        <h3>Paleta de cores:</h3>

        <div>
            <div class="bloco_cor_a1"></div>
            <div class="bloco_cor_a2"></div>
            <div class="bloco_cor_a3"></div>
            <div class="bloco_cor_a4"></div>
            <div class="bloco_cor_a5"></div>
            <div class="bloco_cor_a6"></div>
            <div class="bloco_cor_a7"></div>
        </div>
    </section>

    <section>
        <h3>Tamanhos de texto:</h3>

        <div>
            <h1>Teste h1</h1>
            <h2>Teste h2</h2>
            <h3>Teste h3</h3>
            <h4>Teste h4</h4>
            <h5>Teste h5</h5>
            <h6>Teste h6</h6>
            <p>Teste p</p>
        </div>
    </section>
        
    <section>
        <h3>Exemplos com link:</h3>

        <div>
            <p> Link não visitado <span class="hyperlink_nao_visitado">Teste</span> </p>

            <p> Link já visitado <span class="hyperlink_visitado">Teste</span> </p>

            <p> Link pressionado <span href="#" class="hyperlink_pressionado">Teste</span> </p>

            <p> <a href="#">Link</a> </p>
        </div>
    </section>
        
    <section>
        <h3>Exemplos de lista:</h3>

        <div>

            <p>Lista ordenada:</p>

            <ol>
                <li>Primeiro item</li>
                <li>Segundo item</li>
            </ol>

            <p>Lista não-ordenada:</p>

            <ul>
                <li>Primeiro item</li>
                <li>Segundo item</li>
            </ul>

            <p>Lista de descrição:</p>

            <dl>
                <dt> Titulo do dado &lt;dt&gt; </dt>
                <dd> Descrição da tagname &lt;dt&gt; </dd>
                
                <dt> Titulo do dado &lt;dd&gt; </dt>
                <dd> Descrição da tagname &lt;dd&gt; </dd>
            </dl>

        </div>
    </section>
        
    <section>
        <h3>Tipos de marcações textuais:</h3>

        <div>

            <p>Texto <strong>Negrito</strong></p>

            <p>Texto <em>Enfatizado/Itálico</em></p>

            <p>Texto <mark>Marcado</mark></p>
            
            <p>Texto <small>Pequeno</small></p>

            <p>Texto <del>deletado</del> e <ins>inserido</ins></p>

            <p>Texto <sub>subscrito</sub> e <sup>sobrescrito</sup></p>

        </div>
    </section>

    <section>
        <h3>Tipos de mídias:</h3>

        <div>
            <p>Imagem:</p>

            <div>

                <figure class="conteiner_de_midia">
                    <picture>
                        <source media="(max-width: 600px)" srcset="/assets/imagens/logo/imagem_conceitual_paleta_de_cores_01_pq.png" width="300" height="300" />
                        <img src="/assets/imagens/logo/imagem_conceitual_paleta_de_cores_01.png" alt="Triangulos de diversos tamanhos e cores" width="810" height="603" />
                    </picture>
                    
                    <figcaption>Imagem com proporção original de 810x603px</figcaption>
                </figure>

            </div>
            
            <p>Áudio:</p>

            <div class="conteiner_de_midia">
                <audio controls="controls">
                    <source src="/assets/audios/musica_de_jogo.mp3" type="audio/mpeg">
                    <source src="/assets/audios/musica_de_jogo.ogg" type="audio/ogg">
                    Seu navegador não suporta os arquivos de áudio
                </audio>
            </div>

            <p>Vídeo:</p>

            <div class="conteiner_de_midia">
                <video controls="controls" width="320" height="176">
                    <source src="/assets/videos/mov_bbb.mp4" type="video/mp4">
                    <source src="/assets/videos/mov_bbb.ogv" type="video/ogg">
                    Seu navegador não suporta os arquivos de vídeo
                </video>
            </div>

            <p>Iframe:</p>
            
            <p>Descomentar o código que traz o Iframe [@@@ Problemas no console quando adicionado o iframe]</p>
        
            <!-- 
                <div class="conteiner_de_iframe_youtube">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/u9NE0jInb_c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>  
            -->
        

        </div>
    </section>

    <section>
        <h3>Referências textuais:</h3>

        <div>
            <p>- Endereços de contato:</p>
            
            <address>
                <a href="https://github.com/RafaelRam0s" target="_blank" rel="nofollow">
                    <i class="fa-brands fa-github"></i>
                    Github
                </a>
                <br />
                <a href="https://www.instagram.com/rafael6ramos/" target="_blank" rel="nofollow">
                    <i class="fa-brands fa-instagram"></i>
                    Instagram
                </a>
            </address>

            <p>- Texto para <abbr title="Abreviation">abbr</abbr></p>

            <blockquote cite="https://www.w3schools.com/tags/tag_blockquote.asp">
                Bloco de referencia textual Lorem, ipsum dolor sit amet consectetur adipisicing elit. Esse porro ratione enim molestiae cupiditate perferendis natus tempora deserunt alias doloremque assumenda modi reiciendis pariatur aut, commodi voluptatibus odit sapiente eligendi?
            </blockquote>

            <p>- Parágrafo com <q cite="https://www.w3schools.com/tags/tag_q.asp">referencia textual em linha</q></p>

            <p>- Parágrafo com citação à <cite>W3Schools</cite></p>

            <pre>
                - Texto pré formatado
            </pre>

            <p>- Parágrafo que marca um elemento como o elemento que será explicado durante o texto atual: <dfn>dfn</dfn>.</p>
            
            <p>- Parágrafo que informa um código: <code>&lt;code&gt;</code></p>
        </div>
    </section>
        
    <section>
        <h3>Tabelas:</h3>

        <div>
            
            <p>Tabela 1, com tópicos na horizontal:</p>

            <div class="container_de_tabela">
                <table>
                    <caption>Teste</caption>
                    <tr>
                        <th scope="col">teste 1</th>
                        <th scope="col">teste 2</th>
                    </tr>
                    <tr>
                        <td>Célula 1</td>
                        <td>Célula 2</td>
                    </tr>
                    <tr>
                        <td>Célula 3</td>
                        <td>Célula 4</td>
                    </tr>
                </table>
            </div>
            
            <p>Tabela 2, com tópicos na vertical:</p>

            <div class="container_de_tabela">
                <table>
                    <caption>Título de tabela</caption>
                    <tr>
                        <th scope="row">Tópico 1</th>
                        <td>Célula 1</td>
                        <td>Célula 2</td>
                        <td>Célula 3</td>
                        <td>Célula 4</td>
                    </tr>
                    <tr>
                        <th scope="row">Tópico 2</th>
                        <td>Célula 5</td>
                        <td>Célula 6</td>
                        <td>Célula 7</td>
                        <td>Célula 8</td>
                    </tr>
                    <tr>
                        <th scope="row">Tópico 3</th>
                        <td>Célula 9</td>
                        <td>Célula 10</td>
                        <td>Célula 11</td>
                        <td>Célula 12</td>
                    </tr>
                    <tr>
                        <th scope="row">Tópico 4</th>
                        <td>Célula 13</td>
                        <td>Célula 14</td>
                        <td>Célula 15</td>
                        <td>Célula 16</td>
                    </tr>
                </table>
            </div>

        </div>
    </section>

    <section>
        <h3>Formulários:</h3>

        <div>
            <h4>Botões</h4>

            <div>
                <button type="button" title="Botão de teste do tipo button">Tipo button</button>
                <button type="reset" title="Botão de teste do tipo reset">Tipo reset</button>
                <button type="submit" title="Botão de teste do tipo enviar">Tipo submit</button>
            </div>

            <h4>Input Text</h4>

            <div>
                <form action="#" method="GET" autocomplete="on">
                    <label for="id_nome">Nome:</label>
                    <input type="text" id="id_nome" name="name_nome" required="required" minlength="2" maxlength="255" placeholder="Digite um nome..." autocomplete="name" />
                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Input Password</h4>

            <div>
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_senha">Senha:</label>
                    <input type="password" id="id_senha" name="name_senha" />
                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Input Checkbox</h4>

            <div>
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_checkbox">Caixa de seleção</label>
                    <input type="checkbox" id="id_checkbox" name="name_checkbox" value="Marcado" />

                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Input Radio</h4>

            <div>
                
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_radio1">radio1</label>
                    <input type="radio" id="id_radio1" name="name_radio" value="radio1" checked="checked" />
                    <label for="id_radio2">radio2</label>
                    <input type="radio" id="id_radio2" name="name_radio" value="radio2" />

                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Input Color</h4>

            <div>
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_color">color</label>
                    <input type="color" id="id_color" name="name_color" value="#0099ff" />

                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Input Range</h4>

            <div>
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_range">range</label>
                    <input type="range" id="id_range" name="name_range" min="1" max="10" value="2" />

                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Input File</h4>
            
            <div>
                <form action="#" method="POST" autocomplete="off">
                    <label for="id_file">file</label>
                    <input type="file" id="id_file" name="name_file" />

                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Select, Option, Optgroup</h4>
            
            <div>
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_select">Aba de seleções</label>
                    <select id="id_select" name="name_select" required>
                        <option value="" disabled>Selecione uma opção</option>
                        <option value="select_option_0">0</option>
                        <optgroup label="optgroup1">
                            <option value="select_option_1">1</option>
                            <option value="select_option_2">2</option>
                            <option value="select_option_3">3</option>
                        </optgroup>
                        <optgroup label="optgroup2">
                            <option value="select_option_4">4</option>
                            <option value="select_option_5">5</option>
                            <option value="select_option_6">6</option>
                        </optgroup>
                        <option value="select_option_7">7</option>
                    </select>

                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Datalist</h4>

            <div>
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_datalist">datalist</label>
                    <input type="text" id="id_datalist" name="name_datalist" list="datalist_1" />

                    <datalist id="datalist_1">
                        <option value="datalist_option_1">datalist_option_1</option>
                        <option value="datalist_option_2">datalist_option_2</option>
                        <option value="datalist_option_3">datalist_option_3</option>
                    </datalist>
                    
                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Textarea</h4>
            
            <div>   
                <form action="#" method="GET" autocomplete="off">
                    <label for="id_textarea">textarea</label>
                    <textarea id="id_textarea" name="name_textarea" cols="30" rows="5"></textarea>
                    
                    <button type="submit" title="Enviar formulário">Enviar formulário</button>
                </form>
            </div>

            <h4>Output</h4>

            <div>
                <label for="output">Output:</label>
                <output id="id_output" name="name_output">Saída de dados</output>
            </div>

            <h4>Campo de Formulário</h4>

            <div>
                <form action="#" method="GET">
                    <fieldset>
                        <legend>[@@@ Campo de intputs à editar]</legend>

                        <div>
                            <label for="id_numero">Numérico</label>
                            <input type="number" id="id_numero" name="name_numero" min="0" max="10" step="0.01" />
                        </div>

                        <div>
                            <label for="id_month">month</label>
                            <input type="month" id="id_month" name="name_month" value="2020-07" />
                        </div>

                        <div>
                            <label for="id_date">date</label>
                            <input type="date" id="id_date" name="name_date" value="2002-07-13" />
                        </div>

                        <div>
                            <label for="id_time">time</label>
                            <input type="time" id="id_time" name="name_time" />
                        </div>

                        <div>
                            <label for="id_email">email</label>
                            <input type="email" id="id_email" name="name_email" />
                        </div>

                        <div>
                            <label for="id_tel">tel</label>
                            <input type="tel" id="id_tel" name="name_tel" pattern="^\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$" placeholder="(xx) xxxxx-xxxx" />
                        </div>

                        
                        <div>         
                            <label for="id_data">Data </label>
                            <input type="text" name="name_data" id="id_data" placeholder="dd/mm/aaaa" maxlength="10"  onblur="formatarData(this)" >
                        </div>



                    </fieldset>
                </form>
            </div>

        </div>
    </section>
        
</div>


<script>
    
    function mascaraData(elemento_input, evento)
    {
        // Salva a posição de cursor de texto
        let posicao_do_cursor = elemento_input.selectionStart;

        // Faz uma mascara de entrada somente com números
        let data = elemento_input.value.replace(/\D/g, '');
        
        if (data.length > 2 && data.length <= 4)
        {
            data = data.replace(/(\d{2})(\d)/, '$1/$2');
        } else if (data.length > 4)
        {
            data = data.replace(/(\d{2})(\d{2})(\d)/, '$1/$2/$3');
        }

        // Retorna o valor para a tela
        elemento_input.value = data;

        // Manter o cursor na posição em que o usuário está alterando, caso em algum momento ele tenha movido o cursor de texto para outra posição
        if (
            (evento.key === 'Backspace')
            || ((posicao_do_cursor + 1 != data.length))
        ) {   
            if (evento.key.indexOf(/[A-Z][a-z]/) != -1)
            {
                elemento_input.setSelectionRange(posicao_do_cursor - 1, posicao_do_cursor - 1);
            } else {
                elemento_input.setSelectionRange(posicao_do_cursor, posicao_do_cursor);
            }
        }
    }


    // ---------------------------------
    // Valida se a data está no calendário e se não estiver apaga tudo
    // ---------------------------------
    function formatarData(elemento_input)
    {
        let data = elemento_input.value.replace(/\D/g, '');

        let dia = parseInt(data.substr(0, 2), 10);
        let mes = parseInt(data.substr(2, 2), 10);
        let ano = parseInt(data.substr(4, 4), 10);

        if ( dataValida('' + ano + '-' + mes + '-' + dia) == false) {
            
            elemento_input.value = '';
        } else {
            
            data = '' 
                + ("00" + dia).slice(-2) + '/'
                + ("00" + mes).slice(-2) + '/'
                + ("0000" + ano).slice(-4);
        
            elemento_input.value = data;
        }
    }
    /* 
        <div>         
            <label for="id_data">Data </label>
            <input type="text" name="name_data" id="id_data" placeholder="dd/mm/aaaa" maxlength="10"  onblur="formatarData(this)" >
        </div>
    */
    

</script>
