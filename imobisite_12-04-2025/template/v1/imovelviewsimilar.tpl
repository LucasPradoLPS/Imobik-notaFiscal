<div class="container ">
  {if $IMOVELSIMILAR|count > 0}
    <div class="w-md-75 w-lg-50 mb-4">
      <h3><i class="bi bi-building text-secondary me-2"></i> Você também pode gostar desses:</h3>
    </div>
  {/if}
  <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3">
    {foreach from=$IMOVELSIMILAR item="GRIDIMOVELSHOW"}
      {include file="imovelcardgrid.tpl"}
    {/foreach}
  </div>
</div>
<input type="hidden" name="imvSelect" value="{$IMVSELECT}">
<input type="hidden" name="situacaoImv" value="">
<input type="hidden" name="cidadeImv" value="">
<input type="hidden" name="bairroImv" value="">
