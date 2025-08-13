<div class="container content-space-1 {$HIDDENLANCAMENTO}">
  <div class="w-md-75 w-lg-50 text-center mx-md-auto">
    <h2>{$SECAO->sitesecaotitulo}</h2>
  </div>
</div>
<div class="container content-space-1 content-space-b-lg-3 {$HIDDENLANCAMENTO}">
  <div class="tab-content" id="houseHeroTabContent">
    <div class="tab-pane fade show active" id="forSale" role="tabpanel" aria-labelledby="forSale-tab">
      <div class="row gx-3">
      {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}
        <div class="col-sm-6 col-lg-4 mb-3">
          {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
          {$file_headers = get_headers($img_lancamento)}
          {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
            {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
          {else}
            {$img_destaque = $img_lancamento}
          {/if}
          {$nomeSeo = $LANCAMENTO->imoveltipo|cat:" "|cat:$LANCAMENTO->imoveldestino|cat:" "|cat:$LANCAMENTO->cidade|cat:" "|cat:$LANCAMENTO->bairro}
          <a class="card card-stretched-vertical card-transition shadow-none bg-img-center gradient-y-overlay-lg-dark" href="javascript:js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')" style="background-image: url({$img_destaque}); min-height: 15rem;">
            <div class="card-body">
              <div class="mb-1">
                {if $LANCAMENTO->etiquetanome|trim != ""}
                  <span class="badge bg-light {$ETIQUETAMODELOTEXT[$LANCAMENTO->etiquetamodelo]}">              
                    {$LANCAMENTO->etiquetanome}
                  </span>                
                {/if}      
              </div>
              <div class="card-footer">
                <h3 class="text-white mb-0">{$LANCAMENTO->imoveltipo}</h3>
                {if $LANCAMENTO->idimovelsituacao == "1"}
                  {$valorPrimario = $LANCAMENTO->aluguel+$LANCAMENTO->iptu+$LANCAMENTO->condominio+$LANCAMENTO->outrataxavalor}
                  {$valorPrimario = $valorPrimario|number_format:2:",":"."}
                  {$valorPrimario = "Locação R$ "|cat:$valorPrimario}
                {else}
                  {$valorPrimario = $LANCAMENTO->venda|number_format:2:",":"."}
                  {$valorPrimario = "Venda R$ "|cat:$valorPrimario}
                {/if}
                <span class="d-block text-white">{$valorPrimario}</span>
              </div>
            </div>
          </a>
        </div>
      {/foreach}
      </div>
    </div>
  </div>
</div>
