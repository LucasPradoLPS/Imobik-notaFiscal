{if $TOTALLANCAMENTO > 0}
  <div class="position-relative" style="top:-30px">
    <div class="js-swiper-shop-classic-hero swiper bg-light">
      <div class="swiper-wrapper">
        {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}
          <div class="swiper-slide">
            <div class="container content-space-t-2 content-space-b-3">
              <div class="row align-items-lg-center">
                <div class="col-lg-5 order-lg-2 mb-7 mb-lg-0">
                  <div class="mb-6">
                    <h3 class="display-4 mb-2">{$LANCAMENTO->imoveltipo}</h3>
                    <h3 class="display-7 mb-4">{$LANCAMENTO->imovelsituacao|lower|ucwords} - {$LANCAMENTO->imoveldestino}</h3>
                    <p>{$LANCAMENTO->caracteristicas|substr:0:150}...</p>
                  </div>
                  {$nomeSeo = $LANCAMENTO->imoveltipo|cat:" "|cat:$LANCAMENTO->imoveldestino|cat:" "|cat:$LANCAMENTO->cidade|cat:" "|cat:$LANCAMENTO->bairro}
                  <div class="d-flex gap-2 justify-content-center">
                    <a class="btn btn-primary rounded-pill" href="javascript:js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')">Ver imóvel</a>
                  </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                  <div class="w-75 mx-auto">
                    {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
                    {$file_headers = get_headers($img_lancamento)}
                    {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                      {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                    {else}
                      {$img_destaque = $img_lancamento}
                    {/if}
                    <img class="img-fluid" src="{$img_destaque}" alt="Image Description">
                  </div>
                </div>
              </div>
            </div>
          </div>
        {/foreach}
      </div>
      <div class="js-swiper-shop-classic-hero-button-next swiper-button-next"></div>
      <div class="js-swiper-shop-classic-hero-button-prev swiper-button-prev"></div>
    </div>
    <div class="mb-3" style="display: table; margin: -80px auto;">
      <div class="js-swiper-shop-hero-thumbs swiper" style="max-width: 25rem; ">
        <div class="swiper-wrapper">
          {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}
            {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
            {$file_headers = get_headers($img_lancamento)}
            {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
              {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
            {else}
              {$img_destaque = $img_lancamento}
            {/if}
            <div class="swiper-slide">
              <a class="js-swiper-thumb-progress swiper-thumb-progress-avatar" href="javascript:;" tabindex="0">
                <img class="swiper-thumb-progress-avatar-img" src="{$img_destaque}" alt="Image Description">
              </a>
            </div>
          {/foreach}
        </div>
      </div>
    </div>
  </div>
{/if}
