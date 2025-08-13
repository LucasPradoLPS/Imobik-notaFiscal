<div class="container content-space-1 {$HIDDENRURAL}">
  <div class="w-md-75 w-lg-50 text-center mx-md-auto">
    <h2>{$SECAO->sitesecaotitulo}</h2>
  </div>
</div>
<div class="container content-space-1 content-space-b-lg-3 {$HIDDENRURAL}">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 mb-5">
    {foreach from=$IMOVEL_RURAL item="GRIDIMOVELSHOW"}
      {include file="imovelcardgrid.tpl"}
    {/foreach}
  </div>
  <div class="text-center">
    <a class="btn btn-outline-primary zi-999" onclick="js_MenuDirecionaFooter('','R');">Buscar mais imóveis rurais <i class="bi-chevron-right small ms-1"></i></a>
  </div>
</div>
<input type="hidden" name="imvSelect" value="">
