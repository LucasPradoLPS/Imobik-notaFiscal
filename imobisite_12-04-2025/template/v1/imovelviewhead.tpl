<div class="row justify-content-lg-between mb-3">
  <div class="col-12 col-sm-7 mb-5 mb-sm-0">
    <h1 class="h2 mb-0">{$IMOVELSHOW->imoveltipo}</h1>
    <span class="d-block text-dark">{$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf}) - {$IMOVELSHOW->imoveldestino|lower|ucwords}</span>
    {if $IMOVELSHOW->exibelogradouro == true}
      <span class="d-block text-dark mb-2">{$IMOVELSHOW->logradouro|lower|ucwords}&nbsp;&nbsp;&nbsp;{$IMOVELSHOW->complemento|lower|ucwords}</span>
    {/if}
    <ul class="list-inline list-separator text-body">
      {if $IMOVELSHOW->dormitorio+0 > 0}
        <li class="list-inline-item">
          <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 512"><path d="M176 256c44.11 0 80-35.89 80-80s-35.89-80-80-80-80 35.89-80 80 35.89 80 80 80zm352-128H304c-8.84 0-16 7.16-16 16v144H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v352c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16v-48h512v48c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V240c0-61.86-50.14-112-112-112z"/></svg>
          </span>
          {$IMOVELSHOW->dormitorio+0}
        </li>
      {/if}
      {if $IMOVELSHOW->banheiro+0 > 0}
        <li class="list-inline-item">
          <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512"><path d="M304,320a16,16,0,1,0,16,16A16,16,0,0,0,304,320Zm32-96a16,16,0,1,0,16,16A16,16,0,0,0,336,224Zm32,64a16,16,0,1,0-16-16A16,16,0,0,0,368,288Zm-32,32a16,16,0,1,0-16-16A16,16,0,0,0,336,320Zm-32-64a16,16,0,1,0,16,16A16,16,0,0,0,304,256Zm128-32a16,16,0,1,0-16-16A16,16,0,0,0,432,224Zm-48,16a16,16,0,1,0,16-16A16,16,0,0,0,384,240Zm-16-48a16,16,0,1,0,16,16A16,16,0,0,0,368,192Zm96,32a16,16,0,1,0,16,16A16,16,0,0,0,464,224Zm32-32a16,16,0,1,0,16,16A16,16,0,0,0,496,192Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,432,256Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,400,288Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,336,352Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,304,384Zm64-64a16,16,0,1,0,16,16A16,16,0,0,0,368,320Zm21.65-218.35-11.3-11.31a16,16,0,0,0-22.63,0L350.05,96A111.19,111.19,0,0,0,272,64c-19.24,0-37.08,5.3-52.9,13.85l-10-10A121.72,121.72,0,0,0,123.44,32C55.49,31.5,0,92.91,0,160.85V464a16,16,0,0,0,16,16H48a16,16,0,0,0,16-16V158.4c0-30.15,21-58.2,51-61.93a58.38,58.38,0,0,1,48.93,16.67l10,10C165.3,138.92,160,156.76,160,176a111.23,111.23,0,0,0,32,78.05l-5.66,5.67a16,16,0,0,0,0,22.62l11.3,11.31a16,16,0,0,0,22.63,0L389.65,124.28A16,16,0,0,0,389.65,101.65Z"/></svg>
          </span>
          {$IMOVELSHOW->banheiro+0}
        </li>
      {/if}
      {if $IMOVELSHOW->vagagaragem+0 > 0}
        <li class="list-inline-item">
          <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 28 28"><path d="M23.5 7c.276 0 .5.224.5.5v.511c0 .793-.926.989-1.616.989l-1.086-2h2.202zm-1.441 3.506c.639 1.186.946 2.252.946 3.666 0 1.37-.397 2.533-1.005 3.981v1.847c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1h-13v1c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1.847c-.608-1.448-1.005-2.611-1.005-3.981 0-1.414.307-2.48.946-3.666.829-1.537 1.851-3.453 2.93-5.252.828-1.382 1.262-1.707 2.278-1.889 1.532-.275 2.918-.365 4.851-.365s3.319.09 4.851.365c1.016.182 1.45.507 2.278 1.889 1.079 1.799 2.101 3.715 2.93 5.252zm-16.059 2.994c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm10 1c0-.276-.224-.5-.5-.5h-7c-.276 0-.5.224-.5.5s.224.5.5.5h7c.276 0 .5-.224.5-.5zm2.941-5.527s-.74-1.826-1.631-3.142c-.202-.298-.515-.502-.869-.566-1.511-.272-2.835-.359-4.441-.359s-2.93.087-4.441.359c-.354.063-.667.267-.869.566-.891 1.315-1.631 3.142-1.631 3.142 1.64.313 4.309.497 6.941.497s5.301-.184 6.941-.497zm2.059 4.527c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm-18.298-6.5h-2.202c-.276 0-.5.224-.5.5v.511c0 .793.926.989 1.616.989l1.086-2z"/></svg>
          </span>
          {$IMOVELSHOW->vagagaragem+0}
        </li>
      {/if}
      {if $IMOVELSHOW->area+0 > 0}
        <li class="list-inline-item">
          <i class="bi-rulers text-muted me-1"></i>  {$IMOVELSHOW->area+0}
          {if $IMOVELSHOW->perimetro == "U"}
            m²
          {else}
            hectare(s)
          {/if}
        </li>
      {/if}
    </ul>
  </div>
  <div class="col-sm-5 column-divider-sm">
    <div class="pl-md-4 text-end">
      {$cifrao = "R$ "}
      {$isVenda = "Venda "}
      {$isLocacao = "Locação "}
      {$isBorda = ""}
      {$exibeValorPrimario = ""}
      {$exibeValorSecundario = ""}
      {if $IMOVELSHOW->idimovelsituacao == "1"}
        {$valorPrimario = $IMOVELSHOW->aluguel+$IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}
        {if $valorPrimario != $IMOVELSHOW->aluguel}
          {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
          {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
          {$valorPrimario2 = "Locação "|cat:$cifrao|cat:$IMOVELSHOW->aluguel}
        {else}
          {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
          {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
          {$valorPrimario2 = "&nbsp;"}              
        {/if}  
        {$valorSecundario = ""}
        {$exibeValorSecundario = "d-none"}
        {if $IMOVELSHOW->exibealuguel == false }
          {$exibeValorPrimario = "d-none"}
        {/if}
        {$valorPrincipalTitulo = "Locação"}
        {if $valorPrimario == 0}
          {$valorPrimario = 0.01}
        {/if}  
        {$barra1 = $IMOVELSHOW->aluguel/$valorPrimario*100}
        {$barra2 = $IMOVELSHOW->iptu/$valorPrimario*100}
        {$barra3 = $IMOVELSHOW->condominio/$valorPrimario*100}
        {$barra4 = $IMOVELSHOW->outrataxavalor/$valorPrimario*100}
      {elseif $IMOVELSHOW->idimovelsituacao == "3"}
        {$valorPrimario = $IMOVELSHOW->venda+$IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}
        {if $valorPrimario != $IMOVELSHOW->venda}          
          {$valorPrimario2 = $IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}
          {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}  
          {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}              
        {else}  
          {$valorPrimario2 = "&nbsp;"}              
        {/if}  
        {$valorPrimario1 = $IMOVELSHOW->venda|number_format:2:",":"."}
        {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
        {$valorSecundario = ""}
        {$exibeValorSecundario = "d-none"}
        {if $IMOVELSHOW->exibevalorvenda == false }
          {$exibeValorPrimario = "d-none"}
        {/if}
        {$valorPrincipalTitulo = "Venda"}
        {if $valorPrimario == 0}
          {$valorPrimario = 0.01}
        {/if}  
        {$barra1 = $IMOVELSHOW->venda/$valorPrimario*100}
        {$barra2 = $IMOVELSHOW->iptu/$valorPrimario*100}
        {$barra3 = $IMOVELSHOW->condominio/$valorPrimario*100}
        {$barra4 = $IMOVELSHOW->outrataxavalor/$valorPrimario*100}          
      {elseif $IMOVELSHOW->idimovelsituacao == "5"}
        {$valorPrimario = $IMOVELSHOW->aluguel+$IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}            
        {if $valorPrimario != $IMOVELSHOW->aluguel}            
          {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
          {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
          {$valorPrimario2 = "Locação "|cat:$cifrao|cat:$IMOVELSHOW->aluguel}
        {else}  
          {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
          {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
          {$valorPrimario2 = "&nbsp;"}              
        {/if}  
        {$valorSecundario = $IMOVELSHOW->venda|number_format:2:",":"."}
        {$valorSecundario = $isVenda|cat:$cifrao|cat:$valorSecundario}
        {$valorPrincipalTitulo = "Locação"}

        {if $IMOVELSHOW->exibealuguel == false }
          {$exibeValorPrimario = "d-none"}
        {/if}
        {if $IMOVELSHOW->exibevalorvenda == false }
          {$exibeValorSecundario = "d-none"}
        {/if}

        {if $valorPrimario == 0}
          {$valorPrimario = 0.01}
        {/if}  
        {$barra1 = $IMOVELSHOW->aluguel/$valorPrimario*100}
        {$barra2 = $IMOVELSHOW->iptu/$valorPrimario*100}
        {$barra3 = $IMOVELSHOW->condominio/$valorPrimario*100}
        {$barra4 = $IMOVELSHOW->outrataxavalor/$valorPrimario*100}          
      {/if}
      {if $valorPrimario == 0.01}
          {$valorPrimario1 = $IMOVELSHOW->labelnovalvalues}
          {if $valorPrimario1|trim == ""}
              {$valorPrimario1 = "A Consultar"}
          {/if}
          {$valorSecundario = ""}
          {$exibeValorSecundario = "d-none"}
      {/if}
      <span class="d-block text-dark {$exibeValorPrimario}">
        {$valorPrimario2}
      </span>
      <h2 class="mb-0 text-primary {$exibeValorPrimario}">{$valorPrimario1}</h2>
      <span class="d-block text-muted {$exibeValorSecundario}">
        {$valorSecundario}
      </span>
    </div>
  </div>
</div>
<div class="row justify-content-lg-between mb-7">
  <div class="col-12 mb-5 mb-sm-0">
    <div class="progress mb-3 {$exibeValorPrimario}">
      <div class="progress-bar bg-primary" role="progressbar" style="width: {$barra1}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
      <div class="progress-bar bg-success" role="progressbar" style="width: {$barra2}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
      <div class="progress-bar bg-info" role="progressbar" style="width: {$barra3}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
      {if $IMOVELSHOW->outrataxa|trim != ""}
        <div class="progress-bar bg-warning" role="progressbar" style="width: {$barra4}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
      {/if}
    </div>
    <ul class="list-unstyled list-py-1 mb-0">
      <li class="d-flex align-items-center">
        <i class="bi-circle-fill text-primary me-2"></i>
        <span class="text-dark fw-semi-bold">{$valorPrincipalTitulo}</span>
        <div class="ms-auto">
          <span class="{$exibeValorPrimario}">
            {if $IMOVELSHOW->idimovelsituacao == "1" || $IMOVELSHOW->idimovelsituacao == "5"}
              R$ {$IMOVELSHOW->aluguel|number_format:2:",":"."}
            {else}
              R$ {$IMOVELSHOW->venda|number_format:2:",":"."}
            {/if}
          </span>
        </div>
      </li>
      <li class="d-flex align-items-center">
        <i class="bi-circle-fill text-success me-2"></i>
        <span class="text-dark fw-semi-bold">IPTU</span>
        <div class="ms-auto">
          <span class="{$exibeValorPrimario}">R$ {$IMOVELSHOW->iptu|number_format:2:",":"."}</span>
        </div>
      </li>
      <li class="d-flex align-items-center">
        <i class="bi-circle-fill text-info me-2"></i>
        <span class="text-dark fw-semi-bold">Condomínio</span>
        <div class="ms-auto">
          <span class="{$exibeValorPrimario}">R$ {$IMOVELSHOW->condominio|number_format:2:",":"."}</span>
        </div>
      </li>
      {if $IMOVELSHOW->outrataxa|trim != ""}
      <li class="d-flex align-items-center">
        <i class="bi-circle-fill text-warning me-2"></i>
        <span class="text-dark fw-semi-bold">{$IMOVELSHOW->outrataxa}</span>
        <div class="ms-auto">
          <span class="{$exibeValorPrimario}">R$ {$IMOVELSHOW->outrataxavalor|number_format:2:",":"."}</span>
        </div>
      </li>
      {/if}
      {if $IMOVELSHOW->idimovelsituacao != "3"}
        <hr class="my-2">
        <li class="d-flex align-items-center">
          <i class="bi-circle-fill text-secondary me-2"></i>
          <span class="text-dark fw-semi-bold">Total</span>
          <div class="ms-auto">
            <span class="{$exibeValorPrimario}">{$valorPrimario1}</span>
          </div>
        </li>
      {/if}
    </ul>
  </div>
</div>
{if $IMOVELSHOW->proposta == true}
  <div class="d-grid mb-5">
    <a id="abrePropostaMobile" class="d-lg-none btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#propostaModal">Fazer Proposta</a>
  </div>
{/if}
<div class="js-nav-scroller hs-nav-scroller-horizontal">
  <span class="hs-nav-scroller-arrow-prev" style="display: none;">
    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
      <i class="bi-chevron-left"></i>
    </a>
  </span>
  <span class="hs-nav-scroller-arrow-next" style="display: none;">
    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
      <i class="bi-chevron-right"></i>
    </a>
  </span>
  <ul class="nav nav-segment nav-fill mb-7" id="propertyOverviewNavTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" href="#propertyOverviewNavOne" id="propertyOverviewNavOne-tab" data-bs-toggle="tab" data-bs-target="#propertyOverviewNavOne" role="tab" aria-controls="propertyOverviewNavOne" aria-selected="true" style="min-width: 7rem;"><i class="bi-archive-fill text-muted me-3"></i>Detalhes</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" href="#propertyOverviewNavTwo" id="propertyOverviewNavTwo-tab" data-bs-toggle="tab" data-bs-target="#propertyOverviewNavTwo" role="tab" aria-controls="propertyOverviewNavTwo" aria-selected="false" style="min-width: 7rem;"><i class="bi-play-circle-fill text-muted me-3"></i>Vídeo</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" href="#propertyOverviewNavThree" id="propertyOverviewNavThree-tab" data-bs-toggle="tab" data-bs-target="#propertyOverviewNavThree" role="tab" aria-controls="propertyOverviewNavThree" aria-selected="false" style="min-width: 7rem;"><i class="bi-geo-alt-fill text-muted me-3"></i>Mapa</a>
    </li>
  </ul>
</div>
