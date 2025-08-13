{if $IMOVELCORRETOR|count > 0}
  <hr class="my-6">
  <div class="mb-4">
    {if $IMOVELCORRETOR|count > 1}
      <h4>Corretores</h4>
    {else}
      <h4>Corretor</h4>
    {/if}
  </div>
  <div class="row">
    {foreach from=$IMOVELCORRETOR item="CORRETOR"}
      <div class="col-sm-6 col-md-6 mb-4 mb-sm-0">
        <div class="d-flex mb-4">
          <div class="flex-shrink-0">
            {if isset($CORRETOR->selfie)}
              {$filename = $URLSYSTEM|cat:$CORRETOR->selfie}
            {else}
              {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
            {/if}
            {$file_headers = get_headers($filename)}
            {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
              <a class="avatar-circle card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$URLSYSTEM}{$FILENOIMAGE}" target="_blank" style="background-image: url({$URLSYSTEM}{$FILENOIMAGE}); width:80px; min-height: 5rem;"></a>
            {else}
              <a class="avatar-circle card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$filename}" target="_blank" style="background-image: url({$filename}); width:80px; min-height: 5rem;"></a>
            {/if}
          </div>
          <div class="flex-grow-1 ms-3">
            <h4 class="mb-1">
              <a class="text-dark dz-dropzone" onclick="js_CorretorView({$CORRETOR->idpessoa},'{$CORRETOR->pessoa}')">{$CORRETOR->pessoa|lower|ucwords}</a>
            </h4>
            {if $CORRETOR->fones|trim != ""}
              <span class="d-block small mb-1">
                <a class="btn-ghost-secondary dz-dropzone" onclick="location.href='tel:{$CORRETOR->fones}'">
                  <i class="bi-telephone-inbound-fill me-1"></i> {$CORRETOR->fones}
                </a>
              </span>
            {/if}
            {if $CORRETOR->celular|trim != ""}
              <span class="d-block small mb-1">
                <a class="btn-ghost-secondary dz-dropzone" onclick="location.href='https://api.whatsapp.com/send?phone=+55{$CORRETOR->celular}&text=Olá, quero mais informações sobre o imóvel código {$IMOVELSHOW->idimovel}'" target="_blank">
                  <i class="bi-whatsapp me-1"></i> {$CORRETOR->celular}
                </a>
              </span>
            {/if}
            {if $CORRETOR->email|trim != ""}
              <span class="d-block small mb-1">
                <a class="btn-ghost-secondary dz-dropzone" onclick="location.href='mailto:{$CORRETOR->email}'">
                  <i class="bi-envelope-fill me-1"></i> {$CORRETOR->email}
                </a>
              </span>
            {/if}
            {if isset($CORRETOR->creci)}
              <span class="d-block small mb-1">
                <a class="btn-ghost-secondary dz-dropzone" >
                  <i class="bi-archive-fill me-1"></i> CRECI: {$CORRETOR->creci}
                </a>
              </span>
            {/if}
            <a class="link" href="javascript:js_CorretorView({$CORRETOR->idpessoa},'{$CORRETOR->pessoa}')">Imóveis deste corretor</a>
          </div>
        </div>
      </div>
    {/foreach}
  </div>
{/if}
