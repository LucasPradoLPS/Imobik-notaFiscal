{include file="header.tpl"}
<main id="content" role="main">
  <form name="form_imvgeral" id="form_imvgeral" method="GET">
    {include file="imovelviewimg.tpl"}
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mb-9 mb-lg-0">
          {include file="imovelviewhead.tpl"}
          <div class="tab-content">
            {include file="imovelviewdetails.tpl"}
            {include file="imovelviewvideo.tpl"}
            {include file="imovelviewmap.tpl"}
          </div>
          {include file="imovelviewagent.tpl"}
        </div>
        <div class="col-lg-4">
          {include file="imovelviewcontact.tpl"}
        </div>
        <!-- Sticky Block End Point -->
        <div id="stickyBlockEndPoint"></div>
        <hr class="my-6">
      </div>
    </div>
    {include file="imovelviewsimilar.tpl"}
    {include file="imovelviewproposta.tpl"}
  </form>
</main>
{include file="footer.tpl"}
{include file="scripts.tpl"}
