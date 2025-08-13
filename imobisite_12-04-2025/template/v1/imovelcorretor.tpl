{include file="header.tpl"}
<main id="content" role="main">
  <form name="form_imvgeral" id="form_imvgeral" method="GET">
    {include file="imovelcorretorhead.tpl"}
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mb-9 mb-lg-0">
          {include file="filtercorretor.tpl"}
          {include file="imovelcorretorgrid.tpl"}
        </div>
        <div class="col-lg-4">
          {include file="imovelcorretorcontact.tpl"}
        </div>
        <!-- Sticky Block End Point -->
        <div id="stickyBlockEndPoint"></div>
        <hr class="my-6">
      </div>
    </div>
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
