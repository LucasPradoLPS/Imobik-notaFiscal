<style>
.label-situacao {
    width:80px;!important;
    text-align: center;
}
.select-custom li label{
    padding: 8px 12px;
}
</style>
<form class="bg-white rounded shadow-sm quick-search form-icon-right position-relative" name="form_imvgeral" id="form_imvgeral" method="GET">
    <div class="row row-cols-lg-6 row-cols-md-3 row-cols-1 g-3">
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
            </ul>
        </div>
        <div class="col">
            <div class="position-relative">
                <select id="cidadeImv" name="cidadeImv" class="form-control" onChange="js_BuscaBairro(this.value)">
                    <option value="0">Todas as cidades</option>
                    {foreach from=$IMOVELCIDADE item="ITEMCIDADE"}
                        <option value="{$ITEMCIDADE->idcidade}">{$ITEMCIDADE->cidade}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="col">
            <div class="position-relative" id="selectBairro">
                <select id="bairroImv" name="bairroImv" class="form-control"'>
                    <option value="0">Todos os bairros</option>
                </select>
            </div>
        </div>
        <div class="col">
            <input type="text" class="form-control" name="valorMaximo" id="valorMaximo" value="" placeholder="Valor máximo R$">                        
        </div>
        <div class="col">
            <div class="position-relative">
                <button class="form-control text-start toggle-btn" data-target="#aditional-check">Mais Filtros <i class="fas fa-ellipsis-v font-mini icon-font y-center text-dark"></i></button>
            </div>
        </div>
        <div class="col">
            {if $USEMAP == true}
                <button class="btn btn-primary w-100" onclick="js_BuscaGeralMap();">Encontrar Imóveis</button>
            {else}
                <button class="btn btn-primary w-100" onclick="js_BuscaGeral();">Encontrar Imóveis</button>
            {/if}
        </div>
        <!-- Advance Features -->
        <div id="aditional-check" class="aditional-features p-4" style="background-color:#f9f9f9;top:80%">
            <h5 class="mb-3">Mais filtros</h5>
            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-3">
                <div class="col">
                    <label for="codigoImv" class="form-label">Código</label>
                    <input type="text" class="form-control" id="codigoImv" name="codigoImv" value="" placeholder="Código do imóvel">
                </div>
                <div class="col">
                    <label for="quartoImv" class="form-label">Dormitórios:</label>
                    <ul class="select-custom">
                        <li>
                            <input type="radio" name="quartoImv" id="property-quarto-1" value="1" hidden>
                            <label for="property-quarto-1" class="select-btn">&nbsp;1+</label>
                        </li>
                        <li>
                            <input type="radio" name="quartoImv" id="property-quarto-2" value="2" hidden>
                            <label for="property-quarto-2" class="select-btn">2+</label>
                        </li>
                        <li>
                            <input type="radio" name="quartoImv" id="property-quarto-3" value="3" hidden>
                            <label for="property-quarto-3" class="select-btn">3+</label>
                        </li>
                        <li>
                            <input type="radio" name="quartoImv" id="property-quarto-4" value="4" hidden>
                            <label for="property-quarto-4" class="select-btn">4+</label>
                        </li>
                        <li>
                            <input type="radio" name="quartoImv" id="property-quarto-todos" value="" hidden checked>
                            <label for="property-quarto-todos" class="select-btn">Todos</label>
                        </li>
                    </ul>         
                </div>                   
                <div class="col">
                    <label for="garagemImv" class="form-label">Vagas:</label>
                    <ul class="select-custom">
                        <li>
                            <input type="radio" name="garagemImv" id="property-garagem-1" value="1" hidden>
                            <label style="height:45px;" for="property-garagem-1" class="select-btn">&nbsp;1+</label>
                        </li>
                        <li>
                            <input type="radio" name="garagemImv" id="property-garagem-2" value="2" hidden>
                            <label style="height:45px;" for="property-garagem-2" class="select-btn">2+</label>
                        </li>
                        <li>
                            <input type="radio" name="garagemImv" id="property-garagem-3" value="3" hidden>
                            <label style="height:45px;" for="property-garagem-3" class="select-btn">3+</label>
                        </li>
                        <li>
                            <input type="radio" name="garagemImv" id="property-garagem-4" value="4" hidden>
                            <label style="height:45px;" for="property-garagem-4" class="select-btn">4+</label>
                        </li>
                        <li>
                            <input type="radio" name="garagemImv" id="property-garagem-todos" value="" hidden checked>
                            <label style="height:45px;" for="property-garagem-todos" class="select-btn">Todos</label>
                        </li>
                    </ul>
                </div>                   
                <div class="col">
                    <label for="imoveltipo" class="form-label">Tipos de Imóveis:</label>
                    <select class="form-control" id="imoveltipo" name="tipoImovel[]" multiple autocomplete="off">
                        <option value="0" selected>Todos</option>
                        {foreach from=$IMOVELTIPO item="TIPO"}
                            <option value="{$TIPO->idimoveltipo}">{$TIPO->imoveltipo}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col">
                    <label for="detalheImv" class="form-label">Características</label>
                    <select id="detalheImv" name="detalheImv[]" class="form-control" multiple>
                        <option value="0" selected>Sem Filtro</option>
                        {foreach from=$IMOVELDETALHE item="DETALHE"}
                            <option value="{$DETALHE->idimoveldetalhe}">{$DETALHE->imoveldetalhe}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="col">
                    <label for="banheiroImv" class="form-label">Banheiros</label>
                    <select class="form-control" name="banheiroImv" id="banheiroImv">
                        <option value="0">Sem Filtro</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                        <option value="6">6+</option>
                        <option value="7">7+</option>
                        <option value="8">8+</option>
                    </select>
                </div>
                <div class="col">
                    <label for="suiteImv" class="form-label">Suítes</label>
                    <select id="suiteImv" name="suiteImv" class="form-control">
                        <option value="0">Sem Filtro</option>
                        <option value="1">+1</option>
                        <option value="2">+2</option>
                        <option value="3">+3</option>
                        <option value="4">+4</option>
                        <option value="5">+5</option>
                    </select>
                </div>
                <div class="col">        
                    <label for="areaImv" class="form-label">Área M²</label>
                    <div class="row gx-3">
                        <div class="col-6">
                            <div class="mb-4">
                                <input type="text" class="form-control" id="areaImvMin" name="areaImvMin" value="" placeholder="Mínimo">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-4">
                                <input type="text" class="form-control" id="areaImvMax" name="areaImvMax" value="" placeholder="Máximo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="zonaImv" class="form-label">Zona</label>
                    <ul class="select-custom">
                        <li>
                            <input type="radio" name="zonaImv" id="property-type-urbana" value="U" hidden>
                            <label style="height:45px;" for="property-type-urbana" class="select-btn">Urbana</label>
                        </li>
                        <li>
                            <input type="radio" name="zonaImv" id="property-type-rural" value="R" hidden>
                            <label style="height:45px;" for="property-type-rural" class="select-btn">Rural</label>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <label for="logradouroImv" class="form-label">Logradouro</label>
                    <input type="text" class="form-control" id="logradouroImv" name="logradouroImv" value="" placeholder="Nome da rua, avenida, praça, etc...">
                </div>
                <div class="col">
                    <label for="corretorImv" class="form-label">Corretor</label>
                    <select id="corretorImv" name="corretorImv[]" class="form-control" multiple>
                        <option value="0" selected>Todos os Corretores</option>
                        {foreach from=$IMOVELCORRETORES item="CORRETORES"}
                            <option value="{$CORRETORES->idpessoa}">{$CORRETORES->pessoa|trim}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
var settings = {};
new TomSelect('#imoveltipo',settings);
new TomSelect('#corretorImv',settings);
new TomSelect('#detalheImv',settings);
</script>