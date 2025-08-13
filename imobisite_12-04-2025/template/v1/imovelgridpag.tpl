<div class="container">
  <div class="mb-5">
    <div class="row align-items-center">
      <div class="col-sm mb-3 mb-sm-0">
        <span class="d-block"><h4 class="text-secondary">Foram encontrados {$NUMREGISTROS} registro(s)</h4></span>
      </div>
      {if $NUMREGISTROS > 0}
      <div class="col-sm-auto">
        <i id="botaoLista" class="bi bi-list-task" style="font-size:30px;color:black;cursor:pointer;"></i>
      </div>
      <div class="col-sm-auto">
        <select class="form-select form-select-sm" name="orderBy" id="orderBy" onChange="js_BuscaGridLista('{$FILEATUAL}')">
          <option value="1" {$SELECTEDORDERBY.1}>Mais Recentes</option>
          <option value="2" {$SELECTEDORDERBY.2}>Maior Valor</option>
          <option value="3" {$SELECTEDORDERBY.3}>Menor Valor</option>
        </select>
      </div>
      {/if}
    </div>
  </div>
  <div class="w-md-75 w-lg-50"></div>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 mb-5">
    {foreach from=$IMOVELGRID item="GRIDIMOVELSHOW"}
      {include file="imovelcardgrid.tpl"}
    {/foreach}
  </div>
  {if $NUMREGISTROS == 0}
    <div class="container content-space-b-2">
      <div class="text-center bg-img-start py-6" style="background: url(assets/v1/svg/components/shape-6.svg) center no-repeat;">
        <div class="mb-5">
          <h2>Ops...não achamos nada por aqui.</h2>
          <p>Redefina os filtros utilizados para encontrar o que você precisa.</p>
        </div>
      </div>
    </div>
  {/if}
  {if $NUMREGISTROS > 0}
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item {$PAGINATIONDISABLED.prev}">
          <a class="page-link" aria-label="Primeiro" onclick="js_Pagination(0)">
            <span aria-hidden="true">
              <i class="bi-chevron-double-left"></i>
            </span>
          </a>
        </li>
        <li class="page-item {$PAGINATIONDISABLED.prev}">
          <a class="page-link" aria-label="Anterior" onclick="js_Pagination({$PAGINATIONID-1})">
            <span aria-hidden="true">
              <i class="bi-chevron-left"></i>
            </span>
          </a>
        </li>
        <li class="page-item active"><a class="page-link">{$PAGINATIONID+1}</a></li>
        <li class="page-item {$PAGINATIONDISABLED.next}">
          <a class="page-link" aria-label="Próximo" onclick="js_Pagination({$PAGINATIONID+1})">
            <span aria-hidden="true">
              <i class="bi-chevron-right"></i>
            </span>
          </a>
        </li>
        <li class="page-item {$PAGINATIONDISABLED.next}">
          <a class="page-link" aria-label="Último" onclick="js_Pagination({$MAXPAGINATION})">
            <span aria-hidden="true">
              <i class="bi-chevron-double-right"></i>
            </span>
          </a>
        </li>
      </ul>
    </nav>
  {/if}
</div>
<input type="hidden" name="paginationId" id="paginationId" value="{$PAGINATIONID}">
<input type="hidden" name="imvSelect" value="">
