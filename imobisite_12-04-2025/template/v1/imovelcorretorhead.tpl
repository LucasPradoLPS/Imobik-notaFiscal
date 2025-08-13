<div class="container content-space-t-1 pb-3">
  <div class="row align-items-lg-center">
    <div class="d-grid gap-5">
      <div class="">
        <div class="card-body">
          <div class="d-sm-flex">
            <div class="d-flex align-items-center align-items-sm-start">
              <div class="flex-shrink-0">
                {if isset($VIEWCORRETOR->selfie)}
                  {$filename = $URLSYSTEM|cat:$VIEWCORRETOR->selfie}
                {else}
                  {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
                {/if}
                {$file_headers = get_headers($filename)}
                {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                  <a class="avatar-circle card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$URLSYSTEM}{$FILENOIMAGE} target="_blank" style="background-image: url({$URLSYSTEM}{$FILENOIMAGE}); width:80px; min-height: 5rem;"></a>
                {else}
                  <a class="avatar-circle card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$filename}" target="_blank" style="background-image: url({$filename}); width:80px; min-height: 5rem;"></a>
                {/if}
              </div>
              <div class="d-sm-none flex-grow-1 ms-3">
                <h6 class="card-title">
                  <a class="text-dark">Corretor</a>
                  <img class="avatar avatar-xss ms-1" src="assets/v1/svg/illustrations/top-vendor.svg" alt="Review rating" data-toggle="tooltip" data-placement="top" title="Claimed profile">
                </h6>
              </div>
            </div>
            <div class="flex-grow-1 ms-sm-3">
              <div class="row">
                <div class="col col-md-8">
                  <h3 class="card-title">
                    <a class="text-dark">{$VIEWCORRETOR->pessoa|lower|ucwords}</a>
                  </h3>
                  <div class="d-none d-sm-inline-block">
                    <h6 class="card-title">
                      <a class="text-dark">Corretor</a>
                      <img class="avatar avatar-xss ms-1" src="assets/v1/svg/illustrations/top-vendor.svg" alt="Review rating" data-toggle="tooltip" data-placement="top" title="Claimed profile">
                    </h6>
                  </div>
                </div>
                <div class="col-auto order-md-3">
                  <div class="dropdown">
                    <a class="link text-secondary" href="#" id="jobOverviewShareDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                      <i class="bi-share-fill small ms-1" style="font-size:20px;"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="jobOverviewShareDropdown">
                      <a class="dropdown-item dz-dropzone" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={$URLSITE}{$URLSEO}%2F&amp;src=sdkpreparse')">
                        <i class="bi-facebook dropdown-item-icon"></i> Facebook
                      </a>
                      <a class="dropdown-item dz-dropzone" onclick="window.open('https://api.whatsapp.com/send?text={$VIEWCORRETOR->pessoa} {$URLSITE}{$URLSEO}')">
                        <i class="bi-whatsapp dropdown-item-icon"></i> Whatsapp
                      </a>
                      <a class="dropdown-item dz-dropzone" onClick="js_AbreTwitterCorretor()" role="button" aria-expanded="false">
                        <i class="bi-twitter dropdown-item-icon"></i> Twitter
                      </a>
                      <a class="dropdown-item dz-dropzone" onClick="js_ButtonShare()" role="button" aria-expanded="false">
                        <i class="bi-back dropdown-item-icon"></i> Copiar URL
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md mt-3 mt-md-0">
                  <span class="d-block small text-body mb-1">Fale Comigo</span>
                  {if $VIEWCORRETOR->fones|trim != ""}
                    <span class="badge bg-soft-info text-info me-2 dz-dropzone" onclick="location.href='tel:{$VIEWCORRETOR->fones}'">
                      <i class="bi-telephone-inbound-fill me-1"></i> {$VIEWCORRETOR->fones}
                    </span>
                  {/if}
                  {if $VIEWCORRETOR->celular|trim != ""}
                    <span class="badge bg-soft-info text-info me-2 dz-dropzone" onclick="location.href='https://api.whatsapp.com/send?phone=+55{$VIEWCORRETOR->celular}&text=Ol%C3%A1'">
                      <i class="bi-whatsapp me-1"></i> {$VIEWCORRETOR->celular}
                    </span>
                  {/if}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer pt-0">
          <ul class="list-inline list-separator small text-body">
            <li class="list-inline-item dz-dropzone" onclick="location.href='mailto:{$VIEWCORRETOR->email}'">
              <i class="bi-envelope-fill me-1"></i> {$VIEWCORRETOR->email}
            </li>
            <li class="list-inline-item">{$VIEWCORRETOR->cidade}</li>
            {if isset($VIEWCORRETOR->creci)}
              <li class="list-inline-item">
                CRECI: {$VIEWCORRETOR->creci}
              </li>
            {/if}
          </ul>
        </div>
      </div>
    </div>
  </div>
  <hr class="my-4">
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
function js_AbreTwitterCorretor(){

  sText = encodeURI("{$VIEWCORRETOR->pessoa} - {$CONFIG->nomefantasia}");
  sUrl  = encodeURI("{$URLSITE}{$URLSEO}");
  window.open("https://twitter.com/intent/tweet?url="+sUrl+"&text="+sText);

}

function js_ButtonShare(){

  copyToClipboard("{$URLSITE}{$URLSEO}");
  $("#liveToastBtn").click();

}

</script>
