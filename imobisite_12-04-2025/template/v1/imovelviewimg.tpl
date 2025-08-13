<div class="container content-space-t-1 pb-3">
  <div class="row align-items-lg-center">
    <div class="col-lg mb-2 mb-lg-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="javascript:js_Caminho('S','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->idimovelsituacao}')">{$IMOVELSHOW->imovelsituacao|lower|ucwords}</a></li>
          <li class="breadcrumb-item"><a href="javascript:js_Caminho('C','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->idcidade}')">{$IMOVELSHOW->cidade|lower|ucwords}</a></li>
          <!--<li class="breadcrumb-item"><a href="javascript:js_Caminho('B','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->bairro}')">{$IMOVELSHOW->bairro|lower|ucwords}</a></li>-->
          <li class="breadcrumb-item active">{$IMOVELSHOW->bairro|lower|ucwords}</li>
          <li class="breadcrumb-item active" aria-current="page">Cód. {$IMVZEROS}</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-auto d-flex">
      <!-- Dropdown -->
      <input type="hidden" id="url_copy" value="{$URLATUAL}">
      <div class="dropdown">
        <a class="link text-secondary" href="#" id="jobOverviewShareDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
          Compartilhar <i class="bi-share-fill small ms-1"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="jobOverviewShareDropdown">
          <a class="dropdown-item dz-dropzone" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=https://{$URLATUAL}%2F&amp;src=sdkpreparse')">
            <i class="bi-facebook dropdown-item-icon"></i> Facebook
          </a>
          <a class="dropdown-item dz-dropzone" onclick="window.open('https://api.whatsapp.com/send?text={$IMOVELSHOW->imoveltipo} {$IMOVELSHOW->imoveldestino|lower|ucwords} - {$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf}) https://{$URLATUAL}')">
            <i class="bi-whatsapp dropdown-item-icon"></i> Whatsapp
          </a>
          <a class="dropdown-item dz-dropzone" onclick="js_AbreTwitter()">
            <i class="bi-twitter dropdown-item-icon"></i> Twitter
          </a>
          <a class="dropdown-item dz-dropzone" id="buttonShare" role="button" aria-expanded="false">
            <i class="bi-back dropdown-item-icon"></i> Copiar URL
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container mb-5">
  <div class="rounded-2 overflow-hidden">
    <div class="row gx-2">
      <div class="col-md-8">
        <a class="card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$IMGDESTAQUE1}" style="background-image: url({$IMGDESTAQUE1}); min-height: 24.5rem;" data-fancybox="propertyOverviewGallery" data-caption="{$IMGLEGENDA1}">
          <div class="card-body">
            <div class="mb-1">
              {if $IMOVELSHOW->etiquetanome|trim != ""}
                <span class="badge text-white {$ETIQUETAMODELO[$IMOVELSHOW->etiquetamodelo]}">
                  {$IMOVELSHOW->etiquetanome}
                </span>                
              {/if}      
            </div>
          </div>
          <div class="position-absolute bottom-0 end-0 mb-3 me-3">
            <span class="d-md-none btn btn-sm btn-light">
              <i class="bi-arrows-fullscreen me-2"></i> Ver Imagens
            </span>
          </div>
          <img style="display:none" class="transation" src="{$IMGDESTAQUE1}" alt="{$IMGLEGENDA1}">
        </a>
      </div>
      <div class="col-md-4 d-none d-md-inline-block">
        <a class="card card-stretched-vertical card-transition shadow-none bg-img-center mb-2" href="{$IMGDESTAQUE2}" style="background-image: url({$IMGDESTAQUE2}); min-height: 12rem;" data-fancybox="propertyOverviewGallery" data-caption="{$IMGLEGENDA2}">
          <img style="display:none" class="transation" src="{$IMGDESTAQUE2}" alt="{$IMGLEGENDA3}">
        </a>
        <a class="card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$IMGDESTAQUE3}" style="background-image: url({$IMGDESTAQUE3}); min-height: 12rem;" data-fancybox="propertyOverviewGallery" data-caption="{$IMGLEGENDA3}">
          <div class="position-absolute bottom-0 end-0 mb-3 me-3">
            <span class="d-none d-md-inline-block btn btn-sm btn-light">
              <i class="bi-arrows-fullscreen me-2"></i> Ver Imagens
            </span>
          </div>
          <img style="display:none" class="transation" src="{$IMGDESTAQUE3}" alt="{$IMGLEGENDA3}">
        </a>
        {$XX = 0}
        {foreach from=$IMOVELIMAGEMEXPLODE item="IMAGEM_ITEM"}
          {if $XX>2}
            {$array_imagem = "#"|explode:$IMOVELIMAGEMEXPLODE[$XX]}          
            <a class="d-none" href="{$URLSYSTEM}{$array_imagem[0]}" data-fancybox="propertyOverviewGallery" data-caption="{$array_imagem[1]}">
              <img style="display:none" class="transation" src="{$URLSYSTEM}{$IMOVELIMAGEMEXPLODE[$XX]}" alt="{$array_imagem[1]}">
            </a>
          {/if}
          {$XX = $XX+1}
        {/foreach}
      </div>
    </div>
  </div>
</div>
<span id="liveToastBtn" class="d-none">Toast</span>
<div id="liveToast" class="position-fixed toast hide" role="alert" aria-live="assertive" aria-atomic="true" style="top: 20px; right: 20px; z-index: 1000;">
  <div class="toast-header">
    <div class="d-flex align-items-center flex-grow-1">
      <div class="flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 6v-6h-18v18h6v6h18v-18h-6zm-12 10h-4v-14h14v4h-10v10zm16 6h-14v-14h14v14z"/></svg>
      </div>
      <div class="flex-grow-1 ms-3">
        <h5 class="mb-0">URL copiada</h5>
        <small class="ms-auto">para área de transferência</small>
      </div>
      <div class="text-end">
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <div class="toast-body">
    Compartilhe este imóvel nas sua redes sociais.
  </div>
</div>
<script>
function js_AbreTwitter(){

  sText = encodeURI("{$IMOVELSHOW->imoveltipo} {$IMOVELSHOW->imoveldestino|lower|ucwords} - {$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf})");
  sUrl  = encodeURI("https://{$URLATUAL}");
  window.open("https://twitter.com/intent/tweet?url="+sUrl+"&text="+sText);

}
</script>
