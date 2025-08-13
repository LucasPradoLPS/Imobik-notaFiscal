<div class="container content-space-1">
  <div class="row gx-2">
    <div class="col-lg-2 col-sm-12 mb-5 mb-lg-3"></div>
    <div class="col-lg-8 col-sm-12 mb-5 mb-lg-3">
      <div class="row gx-2">
        <div class="col-lg-12 col-sm-12 mb-5 mb-lg-3">
          <div class="col-xg mb-lg-2 text-center">
            <label class="input-label"><h1>O que você procura?</h1></label> <br>
            <label class="input-label">
              {if $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
                <h3 class="text-secondary">Compre seu imóvel aqui</h3>
              {elseif $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
                <h3 class="text-secondary">Alugue seu imóvel aqui</h3>
              {elseif $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
                <h3 class="text-secondary">Alugue ou compre seu imóvel aqui</h3>
              {/if}
            </label>
            <br><br>
             <div class="btn-group btn-group-segment d-flex mb-4" role="group" aria-label="">
              <input type="radio" class="btn-check flex-fill {$HIDDENLOCACAO}" name="situacaoImv" value="1,5" id="statusBtnRadioRentMoreFilters" autocomplete="off" {$SITUACAOIMVCHECKED.rent}>
              <label class="btn btn-sm {$HIDDENLOCACAO}" for="statusBtnRadioRentMoreFilters">Alugar</label>
              <input type="radio" class="btn-check flex-fill {$HIDDENVENDA}" name="situacaoImv" value="3,5" id="statusBtnRadioBuyMoreFilters" autocomplete="off" {$SITUACAOIMVCHECKED.buy}>
              <label class="btn btn-sm {$HIDDENVENDA}" for="statusBtnRadioBuyMoreFilters">Comprar</label>
            </div>
          </div>
        </div>
      </div>
      <div class="row gx-2">
        <div class="col-lg-6 col-sm-12 mb-3">
          <select id="cidadeImv" name="cidadeImv" class="js-select form-select" onChange="js_BuscaBairro(this.value)" data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
            {if $CIDADEIMV == 0}
              {$selected = "selected"}
            {else}
              {$selected = ""}
            {/if}
            {$cidadeSelect = ""}
            <option value="0" {$selected}>Todas as Cidades</option>
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
        <div id="selectBairro" class="col-lg-6 col-sm-12 mb-3">
          <select id="bairroImv" name="bairroImv" class="js-select form-select" data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
            {if $BAIRROIMV == 0}
              {$selected = "selected"}
            {else}
              {$selected = ""}
            {/if}
            {$bairroSelect = ""}
            <option value="0" {$selected}>Todos os Bairros</option>
            {foreach from=$IMOVELBAIRRO item="ITEMBAIRRO"}
              {if $BAIRROIMV == $ITEMBAIRRO->bairro}
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
      <div class="row gx-2">
        <div class="col-lg-12 col-sm-12 mb-3">
          <div class="">
            <select id="imoveltipo" name="tipoImovel[]" class="js-select form-select" multiple data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
              {foreach from=$SELECTEDTIPO item="SELECTEDITEM2"}
                {if $SELECTEDITEM2@value == 0}
                  <option value="0" selected>Todos Tipos de Imóveis</option>
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
        </div>
      </div>
      <div class="row gx-2">
        <div class="col-lg-6 col-sm-12 mb-3 d-flex gx-2">
          <div class="dropdown w-100 p-1">
            <a class="w-100 btn btn-white btn-sm dropdown-toggle" href="#" id="carsFilterFormDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <span class="svg-icon svg-icon-xs svg-inline text-muted me-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 512"><path d="M176 256c44.11 0 80-35.89 80-80s-35.89-80-80-80-80 35.89-80 80 35.89 80 80 80zm352-128H304c-8.84 0-16 7.16-16 16v144H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v352c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16v-48h512v48c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V240c0-61.86-50.14-112-112-112z"/></svg>
              </span>
              &nbsp;Dormitórios
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-card" aria-labelledby="carsFilterFormDropdown" style="min-width: 25rem;">
              <div class="card card-sm">
                <div class="card-body">
                  <div class="btn-group btn-group-segment d-flex" role="group" aria-label="cars radio button group">
                    <input type="radio" class="btn-check flex-fill" name="quartoImv" value="1" id="carsBtnRadio1" autocomplete="off" {$QUARTOCHECKED.1}>
                    <label class="btn btn-sm" for="carsBtnRadio1">1+</label>
                    <input type="radio" class="btn-check flex-fill" name="quartoImv" value="2" id="carsBtnRadio2" autocomplete="off" {$QUARTOCHECKED.2}>
                    <label class="btn btn-sm" for="carsBtnRadio2">2+</label>
                    <input type="radio" class="btn-check flex-fill" name="quartoImv" value="3" id="carsBtnRadio3" autocomplete="off" {$QUARTOCHECKED.3}>
                    <label class="btn btn-sm" for="carsBtnRadio3">3+</label>
                    <input type="radio" class="btn-check flex-fill" name="quartoImv" value="4" id="carsBtnRadio4" autocomplete="off" {$QUARTOCHECKED.4}>
                    <label class="btn btn-sm" for="carsBtnRadio4">4+</label>
                    <input type="radio" class="btn-check flex-fill" name="quartoImv" value="" id="carsBtnRadio5" autocomplete="off" {$QUARTOCHECKED.Todos}>
                    <label class="btn btn-sm" for="carsBtnRadio5">Todos</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="dropdown w-100 p-1">
            <a class="w-100 btn btn-white btn-sm dropdown-toggle" href="#" id="bedsFilterFormDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <span class="svg-icon svg-icon-xs svg-inline text-muted me-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 28 28"><path d="M23.5 7c.276 0 .5.224.5.5v.511c0 .793-.926.989-1.616.989l-1.086-2h2.202zm-1.441 3.506c.639 1.186.946 2.252.946 3.666 0 1.37-.397 2.533-1.005 3.981v1.847c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1h-13v1c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1.847c-.608-1.448-1.005-2.611-1.005-3.981 0-1.414.307-2.48.946-3.666.829-1.537 1.851-3.453 2.93-5.252.828-1.382 1.262-1.707 2.278-1.889 1.532-.275 2.918-.365 4.851-.365s3.319.09 4.851.365c1.016.182 1.45.507 2.278 1.889 1.079 1.799 2.101 3.715 2.93 5.252zm-16.059 2.994c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm10 1c0-.276-.224-.5-.5-.5h-7c-.276 0-.5.224-.5.5s.224.5.5.5h7c.276 0 .5-.224.5-.5zm2.941-5.527s-.74-1.826-1.631-3.142c-.202-.298-.515-.502-.869-.566-1.511-.272-2.835-.359-4.441-.359s-2.93.087-4.441.359c-.354.063-.667.267-.869.566-.891 1.315-1.631 3.142-1.631 3.142 1.64.313 4.309.497 6.941.497s5.301-.184 6.941-.497zm2.059 4.527c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm-18.298-6.5h-2.202c-.276 0-.5.224-.5.5v.511c0 .793.926.989 1.616.989l1.086-2z"/></svg>
              </span>
              Vagas
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-card" aria-labelledby="bedsFilterFormDropdown" style="min-width: 25rem;">
              <div class="card card-sm">
                <div class="card-body">
                  <div class="btn-group btn-group-segment d-flex" role="group" aria-label="Beds radio button group">
                    <input type="radio" class="btn-check flex-fill" name="garagemImv" value="1" id="bedsBtnRadio1" autocomplete="off" {$GARAGEMCHECKED.1}>
                    <label class="btn btn-sm" for="bedsBtnRadio1">1+</label>
                    <input type="radio" class="btn-check flex-fill" name="garagemImv" value="2" id="bedsBtnRadio2" autocomplete="off" {$GARAGEMCHECKED.2}>
                    <label class="btn btn-sm" for="bedsBtnRadio2">2+</label>
                    <input type="radio" class="btn-check flex-fill" name="garagemImv" value="3" id="bedsBtnRadio3" autocomplete="off" {$GARAGEMCHECKED.3}>
                    <label class="btn btn-sm" for="bedsBtnRadio3">3+</label>
                    <input type="radio" class="btn-check flex-fill" name="garagemImv" value="4" id="bedsBtnRadio4" autocomplete="off" {$GARAGEMCHECKED.4}>
                    <label class="btn btn-sm" for="bedsBtnRadio4">4+</label>
                    <input type="radio" class="btn-check flex-fill" name="garagemImv" value="" id="bedsBtnRadio5" autocomplete="off" {$GARAGEMCHECKED.Todos}>
                    <label class="btn btn-sm" for="bedsBtnRadio5">Todos</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-sm-12 mb-3 d-flex">
          <input type="text" class="w-100 btn btn-white btn-sm js-input-mask form-control" id="codigoImv" name="codigoImv" value="{$CODIGOIMV}" placeholder="Código do Imóvel" data-hs-mask-options='{literal}{"mask": "000000000"}{/literal}'>
          <div class="dropdown w-100 p-1">
            <a class="w-100 btn btn-white btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#realEstateMoreFiltersModal">
              <i class="bi-sliders me-2"></i> Mais Filtros
            </a>
          </div>
        </div>
      </div>
      <div class="row mb-8">
        <div class="mb-lg-0 text-center">
          <a id="encontrarImv" class="btn btn-primary btn-transition" onclick="js_BuscaGridLista('{$FILEATUAL}');" target="_blank">Encontrar Imóveis</a>
          <a class="btn btn-white" role="button" onclick="js_MenuDireciona('');">Limpar Filtros</a>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-sm-12 mb-5 mb-lg-3"></div>
  </div>

  <div class="row">
    <div class="mb-lg-0">
      {$tpButton = "btn-soft-primary"}
      {if $SITUACAOIMVCHECKED.rent=="checked" && $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
        <button onclick="js_limpaFiltro(1,'situacaoImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Para Alugar&nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $SITUACAOIMVCHECKED.buy=="checked" && $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
        <button onclick="js_limpaFiltro(1,'situacaoImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Para Comprar&nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $ZONAIMVCHECKED.urbana=="checked"}
        <button onclick="js_limpaFiltro(1,'zonaImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Zona: <b>Urbana</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $ZONAIMVCHECKED.rural=="checked"}
        <button onclick="js_limpaFiltro(1,'zonaImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Zona: <b>Rural</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $CIDADEIMV|trim !="0"}
        <button onclick="js_limpaFiltro(5,'cidadeImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Cidade: <b>{$cidadeSelect}</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $BAIRROIMV|trim !="0"}
        <button onclick="js_limpaFiltro(5,'bairroImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Bairro: <b>{$BAIRROIMV}</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $QUARTOCHECKED.1=="checked"}
        <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>1+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $QUARTOCHECKED.2=="checked"}
        <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>2+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $QUARTOCHECKED.3=="checked"}
        <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>3+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $QUARTOCHECKED.4=="checked"}
        <button onclick="js_limpaFiltro(4,'quartoImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Dormitórios: <b>4+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $GARAGEMCHECKED.1=="checked"}
        <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>1+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $GARAGEMCHECKED.2=="checked"}
        <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>2+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $GARAGEMCHECKED.3=="checked"}
        <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>3+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $GARAGEMCHECKED.4=="checked"}
        <button onclick="js_limpaFiltro(4,'garagemImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Vagas: <b>4+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $MINVALOR|trim !="" and $MAXVALOR|trim ==""}
        <button onclick="js_limpaFiltro(6,'valorMinimo')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Valor mínimo: R$ <b>{$MINVALOR|number_format:2:",":"."}</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $MINVALOR|trim =="" and $MAXVALOR|trim !=""}
        <button onclick="js_limpaFiltro(6,'valorMaximo')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Valor máximo: R$ <b>{$MAXVALOR|number_format:2:",":"."} </b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $MINVALOR|trim !="" and $MAXVALOR|trim !=""}
        <button onclick="js_limpaFiltro(6,'valorMaximo')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Valor: R$ <b>{$MINVALOR|number_format:2:",":"."} até R$ {$MAXVALOR|number_format:2:",":"."} </b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $BANHEIROCHECKED.1=="selected"}
        <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>1+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $BANHEIROCHECKED.2=="selected"}
        <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>2+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $BANHEIROCHECKED.3=="selected"}
        <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>3+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $BANHEIROCHECKED.4=="selected"}
        <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>4+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $BANHEIROCHECKED.5=="selected"}
        <button onclick="js_limpaFiltro(5,'banheiroImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Banheiros: <b>5+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $SUITECHECKED.1=="selected"}
        <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Suites: <b>1+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $SUITECHECKED.2=="selected"}
        <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Suites: <b>2+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $SUITECHECKED.3=="selected"}
        <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Suites: <b>3+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $SUITECHECKED.4=="selected"}
        <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Suites: <b>4+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $SUITECHECKED.5=="selected"}
        <button onclick="js_limpaFiltro(5,'suiteImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Suites: <b>5+</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;"></i></button>
      {/if}
      {if $AREAIMVMIN !="" and $AREAIMVMAX ==""}
        <button onclick="js_limpaFiltro(3,'areaImvMin')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Área Mínima: <b>{$AREAIMVMIN} m²</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $AREAIMVMIN !="" and $AREAIMVMAX !=""}
        <button onclick="js_limpaFiltro(3,'areaImvMin')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Área: entre <b>{$AREAIMVMIN} m²</b> e <b>{$AREAIMVMAX} m²</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $AREAIMVMIN =="" and $AREAIMVMAX !=""}
        <button onclick="js_limpaFiltro(3,'areaImvMin')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Área Máxima: <b>{$AREAIMVMAX} m²</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $CODIGOIMV !=""}
        <button onclick="js_limpaFiltro(2,'codigoImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Cód. Imóvel: <b>{$CODIGOIMV}</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
      {if $LOGRADOUROIMV !=""}
        <button onclick="js_limpaFiltro(2,'logradouroImv')" style="padding:4px;cursor:auto" type="button" class="btn {$tpButton} btn-sm">Logradouro: <b>{$LOGRADOUROIMV}</b> &nbsp;&nbsp;<i class="bi-x-square" style="font-size:20px;cursor:pointer"></i></button>
      {/if}
    </div>
  </div>
</div>
<!-- ========== SECONDARY CONTENTS ========== -->
<div class="modal fade" id="realEstateMoreFiltersModal" tabindex="-1" aria-labelledby="realEstateMoreFiltersModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="realEstateMoreFiltersModalLabel">Mais Filtros</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-4">
          <label for="detalheImv" class="form-label">Características</label>
          <select id="detalheImv" name="detalheImv[]" class="js-select form-select" multiple data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
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
        <div class="row gx-3">
          <div class="col-6">
            <div class="mb-4">
              <label for="banheiroImv" class="form-label">Banheiros</label>
              <select id="banheiroImv" name="banheiroImv" class="js-select form-select" data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
                <option value="0" {$BANHEIROCHECKED.0}>Sem Filtro</option>
                <option value="1" {$BANHEIROCHECKED.1}>+1</option>
                <option value="2" {$BANHEIROCHECKED.2}>+2</option>
                <option value="3" {$BANHEIROCHECKED.3}>+3</option>
                <option value="4" {$BANHEIROCHECKED.4}>+4</option>
                <option value="5" {$BANHEIROCHECKED.5}>+5</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="mb-4">
              <label for="suiteImv" class="form-label">Suítes</label>
              <select id="suiteImv" name="suiteImv" class="js-select form-select" data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
                <option value="0" {$SUITECHECKED.0}>Sem Filtro</option>
                <option value="1" {$SUITECHECKED.1}>+1</option>
                <option value="2" {$SUITECHECKED.2}>+2</option>
                <option value="3" {$SUITECHECKED.3}>+3</option>
                <option value="4" {$SUITECHECKED.4}>+4</option>
                <option value="5" {$SUITECHECKED.5}>+5</option>
              </select>
            </div>
          </div>
        </div>
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
        <div class="mb-1">
          <div class="row gx-3">
            <div class="col-6">
              <label for="codigoImv" class="form-label">Valor</label>
              <div class="dropdown w-100 p-1">
                <a class="w-100 btn btn-white btn-sm dropdown-toggle" href="#" id="priceFilterFormDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                  R$ Valor
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-card" style="min-width: 21rem;">
                  <div class="card card-sm">
                    <div class="card-body">
                      <div class="row justify-content-center mt-5">
                        <div class="col">
                          <span class="d-block small mb-1">Valor Mínimo:</span>
                          <input type="text" name="valorMinimo" value="{$MINVALOR}" class="form-control form-control-sm" id="valorMinimo">
                        </div>
                        <div class="col">
                          <span class="d-block small mb-1">Valor Máximo:</span>
                          <input type="text" name="valorMaximo" value="{$MAXVALOR}" class="form-control form-control-sm" id="valorMaximo">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <label for="zonaImv" class="form-label">Zona</label>
              <div class="btn-group btn-group-segment d-flex mb-4" role="group" aria-label="">
                <input type="radio" class="btn-check flex-fill" name="zonaImv" value="U" id="statusBtnRadioRentMoreFilters2" autocomplete="off" {$ZONAIMVCHECKED.urbana}>
                <label class="btn btn-sm" for="statusBtnRadioRentMoreFilters2">Urbana</label>
                <input type="radio" class="btn-check flex-fill" name="zonaImv" value="R" id="statusBtnRadioBuyMoreFilters2" autocomplete="off" {$ZONAIMVCHECKED.rural}>
                <label class="btn btn-sm" for="statusBtnRadioBuyMoreFilters2">Rural</label>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-4">
          <div class="row gx-3">
            <div class="col-12">
              <label for="logradouroImv" class="form-label">Logradouro</label>
              <input type="text" class="form-control" id="logradouroImv" name="logradouroImv" value="{$LOGRADOUROIMV}" placeholder="Nome da rua, avenida, praça, etc...">
            </div>
          </div>
        </div>
        <div class="mb-4">
          <div class="row gx-3">
            <div class="col-12">
              <label for="corretorImv" class="form-label">Corretor</label>
              <select id="corretorImv" name="corretorImv[]" class="js-select form-select" multiple data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
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
        <div class="mb-4">
          <div class="row gx-3">
            <div class="col-12 text-center">
               <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ========== END SECONDARY CONTENTS ========== -->
