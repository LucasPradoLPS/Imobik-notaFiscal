{include file="header.tpl"}
<main id="content" role="main">
  <form name="form_imvgeral" id="form_imvgeral" method="GET">
    {include file="$HEADERTEMPLATE/headertemplate.tpl"}
    {include file="filterhome.tpl"}
    {foreach from=$SITE_SECAO item="SECAO"}
      {$arquivo = $SECAO->filename|trim}
      {include file="$arquivo"}
    {/foreach}
  </form>
</main>
{include file="footer.tpl"}
{include file="scripts.tpl"}
<script>
{if $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
  jQuery("#statusBtnRadioRentMoreFilters").click();
{elseif $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
  jQuery("#statusBtnRadioBuyMoreFilters").click();
{elseif $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
  jQuery("#statusBtnRadioRentMoreFilters").click();
{/if}
</script>
