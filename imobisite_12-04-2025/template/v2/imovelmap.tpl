{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate3.tpl"}
  <form name="form_imvgeral" id="form_imvgeral" method="GET" class="position-relative">
    {include file="imovelmapcontent.tpl"}
  </form>
{include file="scripts.tpl"}
<script>
{if $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
  jQuery("#property-type-alugar").click();
{elseif $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
  jQuery("#property-type-comprar").click();
{/if}
//js_RolaTela(".woo-filter-bar");
</script>