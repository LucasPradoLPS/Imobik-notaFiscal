<div class="full-row p-3 mb-0 bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="home/">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            {if $SITUACAOIMV == "1,5"}
                                Imóveis para Alugar
                            {elseif $SITUACAOIMV == "3,5"}
                                Imóveis para Comprar
                            {else}
                                Imóveis Gerais
                            {/if}
                        </li>
                    </ol>
                </nav>
                <h1 class="text-secondary">O que você procura?</h1>
                {if $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
                    <h3 class="text-secondary">Compre seu imóvel aqui</h3>
                {elseif $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
                    <h3 class="text-secondary">Alugue seu imóvel aqui</h3>
                {elseif $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
                    <h3 class="text-secondary">Alugue ou compre seu imóvel aqui</h3>
                {/if}
            </div>
        </div>
    </div>
</div>
<style>
.label-situacao {
    font-size:20px!important;
    width:130px;!important;
    height:45px;
    text-align: center;
}
@media (max-width: 767px) {
    .label-situacao {
        font-size:17px!important;
        width:105px;!important;
    }
}             
</style>
<!--============== Property Search Form Start ==============-->
<div class="full-row p-0 bg-light">
    <div class="container quick-search">
        <div class="row">
            <div class="col-lg-12">
                <div class="col">
                    <ul class="select-custom">
                        {if $HIDDENLOCACAO == ""}                        
                            <li>
                                <input type="radio" name="situacaoImv" id="property-type-alugar" value="1,5" hidden {$SITUACAOIMVCHECKED.rent}>
                                <label for="property-type-alugar" class="label-situacao">Alugar</label>
                            </li>
                        {/if}
                        {if $HIDDENVENDA == ""}
                            <li>
                                <input type="radio" name="situacaoImv" id="property-type-comprar" value="3,5" hidden {$SITUACAOIMVCHECKED.buy}>
                                <label for="property-type-comprar" class="label-situacao">Comprar</label>
                            </li>
                        {/if}
                        {if $HIDDENTEMPORADA == ""}
                            <li>
                                <input type="radio" name="imoveldestinoImv" id="property-type-imoveldestino" value="1" hidden {$IMOVELDESTINOIMVCHECKED}>
                                <label for="property-type-imoveldestino" class="label-situacao">Temporada</label>
                            </li>
                        {/if}
                    </ul>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="row row-cols-lg-6 row-cols-md-4 row-cols-1 g-3">
                    <div class="col">
                        Código do Imóvel:<br>
                        <input type="text" class="form-control" name="codigoImv" id="codigoImv" value="{$CODIGOIMV}">
                    </div>
                    <div class="col">
                        Tipos de Imóveis:<br>
                        <select class="form-control" id="imoveltipo" name="tipoImovel[]" multiple autocomplete="off">
                            {foreach from=$SELECTEDTIPO item="SELECTEDITEM2"}
                                {if $SELECTEDITEM2@value == 0}
                                <option value="0" selected>Todos</option>
                                {break}
                                {/if}
                            {/foreach}
                            {foreach from=$IMOVELTIPO item="TIPO"}
                                {$selected_item = ""}
                                {foreach from=$SELECTEDTIPO item="SELECTEDITEM2"}
                                {if $SELECTEDITEM2@value == $TIPO->idimoveltipo}
                                    {$selected_item = "selected"}
                                    {break}
                                {/if}
                                {/foreach}
                                <option value="{$TIPO->idimoveltipo}" {$selected_item}>{$TIPO->imoveltipo}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col">
                        Cidade:<br>
                        <div class="position-relative">
                            <select id="cidadeImv" name="cidadeImv" class="form-control" onChange="js_BuscaBairro(this.value)">
                                {if $CIDADEIMV == 0}
                                    {$selected = "selected"}
                                {else}
                                    {$selected = ""}
                                {/if}
                                {$cidadeSelect = ""}
                                <option value="0" {$selected}>Todas as cidades</option>
                                {foreach from=$IMOVELCIDADE item="ITEMCIDADE"}
                                    {if $CIDADEIMV == $ITEMCIDADE->idcidade}
                                        {$selected = "selected"}
                                        {$cidadeSelect = $ITEMCIDADE->cidade}
                                    {else}
                                        {$selected = ""}
                                    {/if}
                                    <option value="{$ITEMCIDADE->idcidade}" {$selected}>{$ITEMCIDADE->cidade}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        Bairro:<br>
                        <div class="position-relative" id="selectBairro">
                            <select id="bairroImv" name="bairroImv" class="form-control"'>
                                {if $BAIRROIMV == 0}
                                    {$selected = "selected"}
                                {else}
                                    {$selected = ""}
                                {/if}
                                {$bairroSelect = ""}
                                <option value="0" {$selected}>Todos os bairros</option>
                                {foreach from=$IMOVELBAIRRO item="ITEMBAIRRO"}
                                    {if $BAIRROIMV === $ITEMBAIRRO->bairro}
                                        {$selected = "selected"}
                                        {$bairroSelect = $ITEMBAIRRO->bairro}
                                    {else}
                                        {$selected = ""}
                                    {/if}
                                    <option value="{$ITEMBAIRRO->bairro}" {$selected}>{$ITEMBAIRRO->bairro}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        Valor Mínimo R$:<br>
                        <input type="text" class="form-control" name="valorMinimo" id="valorMinimo" value="{$MINVALOR}">
                    </div>
                    <div class="col">
                        Valor Máximo R$:<br>
                        <input type="text" class="form-control" name="valorMaximo" id="valorMaximo" value="{$MAXVALOR}">
                    </div>
                    <div class="col-lg-3">
                        Dormitórios:<br>
                        <ul class="select-custom">
                            <li>
                                <input type="radio" name="quartoImv" id="property-quarto-1" value="1" hidden {$QUARTOCHECKED.1}>
                                <label style="height:45px;" for="property-quarto-1" class="select-btn">&nbsp;1+</label>
                            </li>
                            <li>
                                <input type="radio" name="quartoImv" id="property-quarto-2" value="2" hidden {$QUARTOCHECKED.2}>
                                <label style="height:45px;" for="property-quarto-2" class="select-btn">2+</label>
                            </li>
                            <li>
                                <input type="radio" name="quartoImv" id="property-quarto-3" value="3" hidden {$QUARTOCHECKED.3}>
                                <label style="height:45px;" for="property-quarto-3" class="select-btn">3+</label>
                            </li>
                            <li>
                                <input type="radio" name="quartoImv" id="property-quarto-4" value="4" hidden {$QUARTOCHECKED.4}>
                                <label style="height:45px;" for="property-quarto-4" class="select-btn">4+</label>
                            </li>
                            <li>
                                <input type="radio" name="quartoImv" id="property-quarto-todos" value="" hidden {$QUARTOCHECKED.Todos}>
                                <label style="height:45px;" for="property-quarto-todos" class="select-btn">Todos</label>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        Vagas:<br>
                        <ul class="select-custom">
                            <li>
                                <input type="radio" name="garagemImv" id="property-garagem-1" value="1" hidden {$GARAGEMCHECKED.1}>
                                <label style="height:45px;" for="property-garagem-1" class="select-btn">&nbsp;1+</label>
                            </li>
                            <li>
                                <input type="radio" name="garagemImv" id="property-garagem-2" value="2" hidden {$GARAGEMCHECKED.2}>
                                <label style="height:45px;" for="property-garagem-2" class="select-btn">2+</label>
                            </li>
                            <li>
                                <input type="radio" name="garagemImv" id="property-garagem-3" value="3" hidden {$GARAGEMCHECKED.3}>
                                <label style="height:45px;" for="property-garagem-3" class="select-btn">3+</label>
                            </li>
                            <li>
                                <input type="radio" name="garagemImv" id="property-garagem-4" value="4" hidden {$GARAGEMCHECKED.4}>
                                <label style="height:45px;" for="property-garagem-4" class="select-btn">4+</label>
                            </li>
                            <li>
                                <input type="radio" name="garagemImv" id="property-garagem-todos" value="" hidden {$GARAGEMCHECKED.Todos}>
                                <label style="height:45px;" for="property-garagem-todos" class="select-btn">Todos</label>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <br>
                        <div class="position-relative">
                            <button class="w-100 form-control text-start toggle-btn" data-target="#aditional-check">Mais Filtros <i style="right:20px;position:absolute;top:50%"class="fas fa-ellipsis-v font-mini icon-font y-center text-dark"></i></button>
                        </div>
                    </div>
                    <div class="col">
                        <br>
                        {if $USEMAP == true}
                            <a id="encontrarImv" class="w-100 btn btn-primary btn-transition" onclick="js_BuscaMap();" target="_blank">Encontrar Imóveis</a>
                        {else}
                            <a id="encontrarImv" class="w-100 btn btn-primary btn-transition" onclick="js_BuscaGridLista('{$FILEATUAL}');" target="_blank">Encontrar Imóveis</a>
                        {/if}
                    </div>
                    <div class="col">
                        <br>
                        {if $USEMAP == true}
                            <button class="w-100 btn btn-white btn-transition form-control" onclick="js_MenuDirecionaMap('')">Limpar Filtros</button>
                        {else}
                            <button class="w-100 btn btn-white btn-transition form-control" onclick="js_MenuDireciona('')">Limpar Filtros</button>
                        {/if}
                    </div>
                </div>
                <div id="aditional-check" class="aditional-features p-5 container w-lg-50 w-sm-100" 
                     style="background-color:#f9f9f9;left:50%;transform: translate(-50%)">
                    <h5 class="mb-3">Mais Filtros</h5>
                    <div class="row row-cols-lg-2 row-cols-md-2 row-cols-1 g-3">
                        <div class="col">
                            <label for="detalheImv" class="form-label">Características</label>
                            <select id="detalheImv" name="detalheImv[]" class="form-control" multiple>
                                {foreach from=$SELECTEDDETALHE item="SELECTEDITEM"}
                                    {if $SELECTEDITEM@value == 0}
                                        <option value="0" selected>Sem Filtro</option>
                                        {break}
                                    {/if}
                                {/foreach}
                                {foreach from=$IMOVELDETALHE item="DETALHE"}
                                    {$selected_item = ""}
                                    {foreach from=$SELECTEDDETALHE item="SELECTEDITEM"}
                                        {if $SELECTEDITEM@value == $DETALHE->idimoveldetalhe}
                                        {$selected_item = "selected"}
                                        {break}
                                        {/if}
                                    {/foreach}
                                    <option value="{$DETALHE->idimoveldetalhe}" {$selected_item}>{$DETALHE->imoveldetalhe}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col">
                            <label for="banheiroImv" class="form-label">Banheiros</label>
                            <select class="form-control" name="banheiroImv" id="banheiroImv">
                                <option value="0" {$BANHEIROCHECKED.Todos}>Sem Filtro</option>
                                <option value="1" {$BANHEIROCHECKED.1}>1+</option>
                                <option value="2" {$BANHEIROCHECKED.2}>2+</option>
                                <option value="3" {$BANHEIROCHECKED.3}>3+</option>
                                <option value="4" {$BANHEIROCHECKED.4}>4+</option>
                                <option value="5" {$BANHEIROCHECKED.5}>5+</option>
                                <option value="6" {$BANHEIROCHECKED.6}>6+</option>
                                <option value="7" {$BANHEIROCHECKED.7}>7+</option>
                                <option value="8" {$BANHEIROCHECKED.8}>8+</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="suiteImv" class="form-label">Suítes</label>
                            <select id="suiteImv" name="suiteImv" class="form-control">
                                <option value="0" {$SUITECHECKED.0}>Sem Filtro</option>
                                <option value="1" {$SUITECHECKED.1}>+1</option>
                                <option value="2" {$SUITECHECKED.2}>+2</option>
                                <option value="3" {$SUITECHECKED.3}>+3</option>
                                <option value="4" {$SUITECHECKED.4}>+4</option>
                                <option value="5" {$SUITECHECKED.5}>+5</option>
                            </select>
                        </div>
                        <div class="col">        
                            <label for="areaImv" class="form-label">Área M²</label>
                            <div class="row gx-3">
                                <div class="col-6">
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="areaImvMin" name="areaImvMin" value="{$AREAIMVMIN}" placeholder="Mínimo">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="areaImvMax" name="areaImvMax" value="{$AREAIMVMAX}" placeholder="Máximo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="zonaImv" class="form-label">Zona</label>
                            <ul class="select-custom">
                                <li>
                                    <input type="radio" name="zonaImv" id="property-type-urbana" value="U" hidden {$ZONAIMVCHECKED.urbana}>
                                    <label style="height:45px;" for="property-type-urbana" class="select-btn">Urbana</label>
                                </li>
                                <li>
                                    <input type="radio" name="zonaImv" id="property-type-rural" value="R" hidden {$ZONAIMVCHECKED.rural}>
                                    <label style="height:45px;" for="property-type-rural" class="select-btn">Rural</label>
                                </li>
                            </ul>
                        </div>
                        <div class="col">
                            <label for="logradouroImv" class="form-label">Logradouro</label>
                            <input type="text" class="form-control" id="logradouroImv" name="logradouroImv" value="{$LOGRADOUROIMV}" placeholder="Nome da rua, avenida, praça, etc...">
                        </div>
                        <div class="col">
                            <label for="corretorImv" class="form-label">Corretor</label>
                            <select id="corretorImv" name="corretorImv[]" class="form-control" multiple>
                                {foreach from=$SELECTEDCORRETOR item="SELECTEDITEM3"}
                                    {if $SELECTEDITEM3@value == 0}
                                        <option value="0" selected>Todos os Corretores</option>
                                        {break}
                                    {/if}
                                {/foreach}
                                {foreach from=$IMOVELCORRETORES item="CORRETORES"}
                                    {$selected_item = ""}
                                    {foreach from=$SELECTEDCORRETOR item="SELECTEDITEM3"}
                                        {if $SELECTEDITEM3@value == $CORRETORES->idpessoa}
                                            {$selected_item = "selected"}
                                            {break}
                                        {/if}
                                    {/foreach}
                                    <option value="{$CORRETORES->idpessoa}" {$selected_item}>{$CORRETORES->pessoa|trim}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <hr>    
        <div class="row">
            <div class="col">
                {$tpButton = "btn-soft-primary"}
                {if $SITUACAOIMVCHECKED.rent=="checked" && $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
                    <button onclick="js_limpaFiltro(1,'situacaoImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Para Alugar&nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $SITUACAOIMVCHECKED.buy=="checked" && $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
                    <button onclick="js_limpaFiltro(1,'situacaoImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Para Comprar&nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $IMOVELDESTINOIMVCHECKED=="checked"}
                    <button onclick="js_limpaFiltro(7,'imoveldestinoImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Para Temporada &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $ZONAIMVCHECKED.urbana=="checked"}
                    <button onclick="js_limpaFiltro(1,'zonaImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Zona: <b>Urbana</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $ZONAIMVCHECKED.rural=="checked"}
                    <button onclick="js_limpaFiltro(1,'zonaImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Zona: <b>Rural</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $CIDADEIMV|trim !="0"}
                    <button onclick="js_limpaFiltro(5,'cidadeImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Cidade: <b>{$cidadeSelect}</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BAIRROIMV|trim !="0"}
                    <button onclick="js_limpaFiltro(5,'bairroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Bairro: <b>{$BAIRROIMV}</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $QUARTOCHECKED.1=="checked"}
                    <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:0px 10px;" title="Excluir Filtro" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>1+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $QUARTOCHECKED.2=="checked"}
                    <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>2+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $QUARTOCHECKED.3=="checked"}
                    <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>3+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $QUARTOCHECKED.4=="checked"}
                    <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>4+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $GARAGEMCHECKED.1=="checked"}
                    <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>1+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $GARAGEMCHECKED.2=="checked"}
                    <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>2+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $GARAGEMCHECKED.3=="checked"}
                    <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>3+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $GARAGEMCHECKED.4=="checked"}
                    <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>4+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $MINVALOR|trim !="" and $MAXVALOR|trim ==""}
                    <button onclick="js_limpaFiltro(6,'valorMinimo')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Valor mínimo: R$ <b>{$MINVALOR|number_format:2:",":"."}</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $MINVALOR|trim =="" and $MAXVALOR|trim !=""}
                    <button onclick="js_limpaFiltro(6,'valorMaximo')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Valor máximo: R$ <b>{$MAXVALOR|number_format:2:",":"."} </b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $MINVALOR|trim !="" and $MAXVALOR|trim !=""}
                    <button onclick="js_limpaFiltro(6,'valorMaximo')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Valor: R$ <b>{$MINVALOR|number_format:2:",":"."} até R$ {$MAXVALOR|number_format:2:",":"."} </b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.1=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>1+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.2=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>2+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.3=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>3+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.4=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>4+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.5=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>5+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.6=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>6+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.7=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>7+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $BANHEIROCHECKED.8=="selected"}
                    <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>8+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $SUITECHECKED.1=="selected"}
                    <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Suites: <b>1+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $SUITECHECKED.2=="selected"}
                    <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Suites: <b>2+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $SUITECHECKED.3=="selected"}
                    <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Suites: <b>3+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $SUITECHECKED.4=="selected"}
                    <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Suites: <b>4+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $SUITECHECKED.5=="selected"}
                    <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Suites: <b>5+</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $AREAIMVMIN !="" and $AREAIMVMAX ==""}
                    <button onclick="js_limpaFiltro(3,'areaImvMin')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Área Mínima: <b>{$AREAIMVMIN} m²</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $AREAIMVMIN !="" and $AREAIMVMAX !=""}
                    <button onclick="js_limpaFiltro(3,'areaImvMin')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Área: entre <b>{$AREAIMVMIN} m²</b> e <b>{$AREAIMVMAX} m²</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $AREAIMVMIN =="" and $AREAIMVMAX !=""}
                    <button onclick="js_limpaFiltro(3,'areaImvMin')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Área Máxima: <b>{$AREAIMVMAX} m²</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $CODIGOIMV !=""}
                    <button onclick="js_limpaFiltro(2,'codigoImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Cód. Imóvel: <b>{$CODIGOIMV}</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
                {if $LOGRADOUROIMV !=""}
                    <button onclick="js_limpaFiltro(2,'logradouroImv')" style="padding:0px 10px;" title="Excluir Filtro" type="button" class="btn {$tpButton} btn-sm">Logradouro: <b>{$LOGRADOUROIMV}</b> &nbsp;&nbsp;<i class="fa-solid fa-rectangle-xmark fa-2xl"></i></button>
                {/if}
            </div>
        </div>
        <br>
    </div>
</div>
<!--============== Property Search Form End ==============-->
<div class="row pt-0 bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="woo-filter-bar p-3 d-flex flex-wrap justify-content-between">
                    <div class="d-flex flex-wrap woocommerce-ordering">
                        {if $USEMAP == true}
                            <select name="orderBy" id="orderBy" onChange="js_BuscaMap()">
                        {else}
                            <select name="orderBy" id="orderBy" onChange="js_BuscaGridLista('{$FILEATUAL}')">
                        {/if}
                          <option value="1" {$SELECTEDORDERBY.1}>Mais Recentes</option>
                          <option value="2" {$SELECTEDORDERBY.2}>Maior Valor</option>
                          <option value="3" {$SELECTEDORDERBY.3}>Menor Valor</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <span class="woocommerce-ordering-pages me-4 font-fifteen">Foram encontrados {$NUMREGISTROS} registro(s)</span>
                        <span class="view-category">
                            {$gridatual = ""}
                            {$listatual = ""}
                            {if $FILEATUAL=="imovelgrid.php"}
                                {$gridatual = "current"}
                            {/if}
                            {if $FILEATUAL=="imovellist.php"}
                                {$listatual = "current"}
                            {/if}
                            <button id="botaoGrid" title="Grid" class="grid-view {$gridatual}" value="grid" name="display" type="submit"><i class="flaticon-grid-1 flat-mini"></i></button>
                            <button id="botaoLista" title="List" class="list-view {$listatual}" value="list" name="display" type="submit"><i class="flaticon-grid flat-mini"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                
<script>
var settings = {};
new TomSelect('#imoveltipo',settings);
new TomSelect('#corretorImv',settings);
new TomSelect('#detalheImv',settings);
</script>