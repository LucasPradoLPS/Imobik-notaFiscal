{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate2.tpl"}
<form name="form_imvgeral" id="form_imvgeral" method="GET">
    {include file="imovelcorretorhead.tpl"}
    <div class="full-row pt-0 bg-light">
        <div class="container">
            <div class="row">
                {include file="imovelcorretordetails.tpl"}
            </div>
            <div class="row">
                <div class="col-xl-8 order-xl-1">
                    {include file="filtercorretor.tpl"}
                    {include file="imovelcorretorgrid.tpl"}
                </div>
                <div class="col-xl-4 order-xl-2">
                    {include file="imovelcorretorcontact.tpl"}
                    {include file="imovelrecent.tpl"}
                </div>
            </div>
        </div>
    </div>
</form>
{include file="footer.tpl"}
{include file="scripts.tpl"}
<script>
{if $TOTALIMVLOCACAO > 0 && $TOTALIMVVENDA == 0}
  jQuery("#property-type-alugar").click();
{elseif $TOTALIMVLOCACAO == 0 && $TOTALIMVVENDA > 0}
  jQuery("#property-type-comprar").click();
{/if}
js_RolaTela(".inner-page-banner");
</script>
