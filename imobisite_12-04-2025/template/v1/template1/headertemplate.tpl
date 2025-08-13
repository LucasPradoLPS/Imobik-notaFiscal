<div class="position-relative overflow-hidden content-space-t-md-1">
  <div class="container">
    <div class="position-relative content-space-t-2 content-space-t-md-0 content-space-t-lg-3 content-space-b-2 content-space-b-md-3 content-space-b-xl-5">
      <div class="row position-relative zi-2 mt-md-n5">
        <div class="col-md-8 mb-7 mb-md-0">
          <div class="w-md-75 mb-7">
            <h1 class="display-8">
              {if isset($SITETEXT["v1-t01-header-1"])}
                {$SITETEXT["v1-t01-header-1"]}
              {else}
                TXT v1-t01-header-1<br>
              {/if}
              {if isset($SITETEXT["v1-t01-header-2"])}
                {$header2 = $SITETEXT["v1-t01-header-2"]} 
              {else}
                {$header2 = "TXT v1-t01-header-2<br>"}
              {/if}
              {if isset($SITETEXT["v1-t01-header-3"])}
                {$header3 = $SITETEXT["v1-t01-header-3"]} 
              {else}
                {$header3 = "TXT v1-t01-header-3<br>"}
                
              {/if}

              <span class="text-primary text-highlight-warning">
                <span class="js-typedjs"
                      data-hs-typed-options='{
                        "strings": ["{$header2}", "{$header3}"],
                        "typeSpeed": 90,
                        "loop": true,
                        "backSpeed": 30,
                        "backDelay": 2500
                      }'></span>
              </span>
            </h1>
          </div>
          <div class="input-card">
            <div class="input-card-form">
              <label for="buscaHero" class="form-label visually-hidden">Buscar locais</label>
              <div class="input-group input-group-merge">
                <span class="input-group-prepend input-group-text">
                  <i class="bi-search"></i>
                </span>
                <input type="text" class="form-control form-control-lg" id="buscaHero" name="buscaHero" placeholder="Faça sua pesquisa" aria-label="Faça sua pesquisa">
              </div>
            </div>
            <button type="button" class="btn btn-primary btn-lg" onclick="js_Search(document.form_imvgeral.buscaHero.value)">Buscar</button>
          </div>
          <p class="form-text small">Busque por cidade, bairro, logradouro,<br>tipo de imóvel e muito mais...</p>
        </div>
      </div>
      <div class="col-md-6 position-md-absolute top-0 end-0">
        {if isset($SITESLIDE['v1-t01-header-1-900x900'])}
          <img class="img-fluid" src="{$URLSYSTEM}{$SITESLIDE['v1-t01-header-1-900x900']}" alt="Image Description">
        {else}
          IMG v1-t01-header-1-900x900<br>
        {/if}
        <div class="position-absolute bottom-0 end-0 zi-n1 mb-n10 me-n7" style="width: 12rem;">
          <img class="img-fluid" src="assets/v1/svg/components/dots-lg.svg" alt="Image Description">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-10 position-absolute top-0 start-0 zi-n1 gradient-y-three-sm-primary h-100" style="background-size: calc(1000px + (100vw - 1000px) / 2);"></div>
</div>
