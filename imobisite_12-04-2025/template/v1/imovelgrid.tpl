{include file="header.tpl"}
<main id="content" role="main">
  <form name="form_imvgeral" id="form_imvgeral" method="GET">
    {include file="filtersearch.tpl"}
    {include file="imovelgridpag.tpl"}
  </form>
</main>
{include file="footer.tpl"}
{include file="scripts.tpl"}
<script>
{if $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
  jQuery("#statusBtnRadioRentMoreFilters").click();
{elseif $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
  jQuery("#statusBtnRadioBuyMoreFilters").click();
{/if}
js_RolaTela(".w-md-75");
</script>
