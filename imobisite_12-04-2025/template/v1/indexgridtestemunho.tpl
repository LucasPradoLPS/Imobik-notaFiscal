<div class="container content-space-1 {$HIDDENTESTEMUNHO}">
  <div class="w-md-75 w-lg-50 text-center mx-md-auto">
    <h2>{$SECAO->sitesecaotitulo}</h2>
  </div>
</div>
<div class="container content-space-1 {$HIDDENTESTEMUNHO}">
  <div class="row">
    {foreach from=$SITE_TESTEMUNHO item="TESTEMUNHO"}
      <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex gap-1 mb-2">
              <img src="assets/v1/svg/illustrations/star.svg" alt="Review rating" width="16">
              <img src="assets/v1/svg/illustrations/star.svg" alt="Review rating" width="16">
              <img src="assets/v1/svg/illustrations/star.svg" alt="Review rating" width="16">
              <img src="assets/v1/svg/illustrations/star.svg" alt="Review rating" width="16">
              <img src="assets/v1/svg/illustrations/star.svg" alt="Review rating" width="16">
            </div>
            <div class="mb-auto">
              <p class="card-text">{substr($TESTEMUNHO->depoimento, 0, 200)}</p>
            </div>
          </div>
          <div class="card-footer pt-0">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <img class="avatar avatar-circle" src="{$URLSYSTEM|cat:$TESTEMUNHO->filename}" alt="Image Description">
              </div>
              <div class="flex-grow-1 ms-3">
                <h5 class="card-title mb-0">{$TESTEMUNHO->nome}</h5>
                <p class="card-text small">{$TESTEMUNHO->cargo}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    {/foreach}
  </div>
</div>
