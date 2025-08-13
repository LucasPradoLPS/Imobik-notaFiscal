{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate1.tpl"}

{foreach from=$SITE_SECAO item="SECAO"}
    {$arquivo = $SECAO->filename|trim}
    {include file="$arquivo"}
{/foreach}

{include file="footer.tpl"}
{include file="scripts.tpl"}
<script>
{if $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
  jQuery("#property-type-alugar").click();
{elseif $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
  jQuery("#property-type-comprar").click();
{elseif $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA > 0}
  jQuery("#property-type-comprar").click();
{/if}
</script>