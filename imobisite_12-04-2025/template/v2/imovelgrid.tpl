{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate2.tpl"}
  <form name="form_imvgeral" id="form_imvgeral" method="GET" class="position-relative">
    {include file="filtersearch.tpl"}
    {include file="imovelgridpag.tpl"}
  </form>
{include file="footer.tpl"}
{include file="scripts.tpl"}
<script>
{if $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
  jQuery("#property-type-alugar").click();
{elseif $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
  jQuery("#property-type-comprar").click();
{/if}
//js_RolaTela(".woo-filter-bar");
</script>
