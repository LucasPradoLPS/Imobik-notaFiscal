<div class="tab-pane fade show active" id="propertyOverviewNavOne" role="tabpanel" aria-labelledby="propertyOverviewNavOne-tab">
  <div class="mb-4">
    <h4><i class="bi bi-clipboard-check text-secondary me-2"></i> Detalhes do Imóvel</h4>
  </div>
  <div class="row justify-content-md-between">
    <div class="col-md-6">
      <dl class="row">
        <dt class="col-5">Código:</dt>
        <dd class="col-7">{$IMOVELSHOW->idimovel}</dd>
        <dt class="col-5">Tipo:</dt>
        <dd class="col-7">{$IMOVELSHOW->imoveltipo}</dd>
        <dt class="col-5">Finalidade:</dt>
        <dd class="col-7">{$IMOVELSHOW->imoveldestino}</dd>
        {if $IMOVELSHOW->perimetro == "U"}
          {$perimetro = "Urbano"}
        {else}
          {$perimetro = "Rural"}
        {/if}
        <dt class="col-5 mb-3">Perímetro:</dt>
        <dd class="col-7 mb-3">{$perimetro}</dd>
      </dl>
    </div>
    <div class="col-md-6">
      <dl class="row">
        <dt class="col-5">Área:</dt>
        <dd class="col-7">{$IMOVELSHOW->area}
          {if $IMOVELSHOW->perimetro == "U"}
            m²
          {else}
            hectare(s)
          {/if}

        </dd>
        <dt class="col-5">Construção:</dt>
        <dd class="col-7">{$IMOVELSHOW->imovelmaterial}</dd>
        <dt class="col-5">Nº Reg. Imóveis:</dt>
        <dd class="col-7">&nbsp;{$IMOVELSHOW->imovelregistro}</dd>
        <dt class="col-5">Nº Matr. Pref:</dt>
        <dd class="col-7">&nbsp;{$IMOVELSHOW->prefeituramatricula}</dd>
      </dl>
    </div>
  </div>
  <div class="border-top py-4 mt-4"></div>
  <div class="mb-4">
    <h4><i class="bi bi-list-task text-secondary me-2"></i> Características</h4>
  </div>
  <div class="row justify-content-md-between mb-6">
    <div class="col-md-6">
      <dl class="row">
        {if $IMOVELSHOW->abrigo != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->abrigo+0}-fill me-1 text-muted"></i>Abrigo:</dt><dd class="col-4">{$IMOVELSHOW->abrigo+0}</dd>{/if}
        {if $IMOVELSHOW->aquecedor != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->aquecedor+0}-fill me-1 text-muted"></i>Aquecedor:</dt><dd class="col-4">{$IMOVELSHOW->aquecedor+0}</dd>{/if}
        {if $IMOVELSHOW->areaservico != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->areaservico+0}-fill me-1 text-muted"></i>Área de Serviço:</dt><dd class="col-4">{$IMOVELSHOW->areaservico+0}</dd>{/if}
        {if $IMOVELSHOW->banheiro != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->banheiro+0}-fill me-1 text-muted text-muted"></i>Banheiro:</dt><dd class="col-4">{$IMOVELSHOW->banheiro+0}</dd>{/if}
        {if $IMOVELSHOW->biblioteca != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->biblioteca+0}-fill me-1 text-muted"></i>Biblioteca:</dt><dd class="col-4">{$IMOVELSHOW->biblioteca+0}</dd>{/if}
        {if $IMOVELSHOW->churrasqueira != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->churrasqueira+0}-fill me-1 text-muted"></i>Churrasqueira:</dt><dd class="col-4">{$IMOVELSHOW->churrasqueira+0}</dd>{/if}
        {if $IMOVELSHOW->closet != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->closet+0}-fill me-1 text-muted"></i>Closet:</dt><dd class="col-4">{$IMOVELSHOW->closet+0}</dd>{/if}
        {if $IMOVELSHOW->condicionador != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->condicionador+0}-fill me-1 text-muted"></i>Condicionador de Ar:</dt><dd class="col-4">{$IMOVELSHOW->condicionador+0}</dd>{/if}
        {if $IMOVELSHOW->copa != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->copa+0}-fill me-1 text-muted"></i>Copa:</dt><dd class="col-4">{$IMOVELSHOW->copa+0}</dd>{/if}
        {if $IMOVELSHOW->cozinha != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->cozinha+0}-fill me-1 text-muted"></i>Cozinha:</dt><dd class="col-4">{$IMOVELSHOW->cozinha+0}</dd>{/if}
        {if $IMOVELSHOW->dependenciaemp != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->dependenciaemp+0}-fill me-1 text-muted"></i>Dep. Empregados:</dt><dd class="col-4">{$IMOVELSHOW->dependenciaemp+0}</dd>{/if}
        {if $IMOVELSHOW->despensa != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->despensa+0}-fill me-1 text-muted"></i>Despensa:</dt><dd class="col-4">{$IMOVELSHOW->despensa+0}</dd>{/if}
        {if $IMOVELSHOW->destaque != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->destaque+0}-fill me-1 text-muted"></i>Destaque:</dt><dd class="col-4">{$IMOVELSHOW->destaque+0}</dd>{/if}
        {if $IMOVELSHOW->dormitorio != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->dormitorio+0}-fill me-1 text-muted"></i>Dormitório:</dt><dd class="col-4">{$IMOVELSHOW->dormitorio+0}</dd>{/if}
        {if $IMOVELSHOW->escritorio != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->escritorio+0}-fill me-1 text-muted"></i>Escritório:</dt><dd class="col-4">{$IMOVELSHOW->escritorio+0}</dd>{/if}
        {if $IMOVELSHOW->homeoffice != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->homeoffice+0}-fill me-1 text-muted"></i>Home Office:</dt><dd class="col-4">{$IMOVELSHOW->homeoffice+0}</dd>{/if}
        {if $IMOVELSHOW->lareira != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->lareira+0}-fill me-1 text-muted"></i>Lareira:</dt><dd class="col-4">{$IMOVELSHOW->lareira+0}</dd>{/if}
        {if $IMOVELSHOW->lavabo != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->lavabo+0}-fill me-1 text-muted"></i>Lavabo:</dt><dd class="col-4">{$IMOVELSHOW->lavabo+0}</dd>{/if}
        {if $IMOVELSHOW->lavanderia != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->lavanderia+0}-fill me-1 text-muted"></i>Lavanderia:</dt><dd class="col-4">{$IMOVELSHOW->lavanderia+0}</dd>{/if}
        {if $IMOVELSHOW->living != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->living+0}-fill me-1 text-muted"></i>Living:</dt><dd class="col-4">{$IMOVELSHOW->living+0}</dd>{/if}
        {if $IMOVELSHOW->mesanino != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->mesanino+0}-fill me-1 text-muted"></i>Mesanino:</dt><dd class="col-4">{$IMOVELSHOW->mesanino+0}</dd>{/if}
        {if $IMOVELSHOW->outros != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->outros+0}-fill me-1 text-muted"></i>Outros:</dt><dd class="col-4">{$IMOVELSHOW->outros+0}</dd>{/if}
        {if $IMOVELSHOW->patio != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->patio+0}-fill me-1 text-muted"></i>Pátio:</dt><dd class="col-4">{$IMOVELSHOW->patio+0}</dd>{/if}
        {if $IMOVELSHOW->piscina != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->piscina+0}-fill me-1 text-muted"></i>Piscina:</dt><dd class="col-4">{$IMOVELSHOW->piscina+0}</dd>{/if}
        {if $IMOVELSHOW->quartocasal != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->quartocasal+0}-fill me-1 text-muted"></i>Quarto de Casal:</dt><dd class="col-4">{$IMOVELSHOW->quartocasal+0}</dd>{/if}
        {if $IMOVELSHOW->quartohospede != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->quartohospede+0}-fill me-1 text-muted"></i>Quarto de Hóspede:</dt><dd class="col-4">{$IMOVELSHOW->quartohospede+0}</dd>{/if}
        {if $IMOVELSHOW->quartosolteiro != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->quartosolteiro+0}-fill me-1 text-muted"></i>Quarto de Solteiro:</dt><dd class="col-4">{$IMOVELSHOW->quartosolteiro+0}</dd>{/if}
        {if $IMOVELSHOW->sacada != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->sacada+0}-fill me-1 text-muted"></i>Sacada:</dt><dd class="col-4">{$IMOVELSHOW->sacada+0}</dd>{/if}
        {if $IMOVELSHOW->salaestar != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->salaestar+0}-fill me-1 text-muted"></i>Sala de Estar:</dt><dd class="col-4">{$IMOVELSHOW->salaestar+0}</dd>{/if}
        {if $IMOVELSHOW->salajantar != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->salajantar+0}-fill me-1 text-muted"></i>Sala de Jantar:</dt><dd class="col-4">{$IMOVELSHOW->salajantar+0}</dd>{/if}
        {if $IMOVELSHOW->sala != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->sala+0}-fill me-1 text-muted"></i>Sala:</dt><dd class="col-4">{$IMOVELSHOW->sala+0}</dd>{/if}
        {if $IMOVELSHOW->salao != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->salao+0}-fill me-1 text-muted"></i>Salão:</dt><dd class="col-4">{$IMOVELSHOW->salao+0}</dd>{/if}
        {if $IMOVELSHOW->split != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->split+0}-fill me-1 text-muted"></i>Split:</dt><dd class="col-4">{$IMOVELSHOW->split+0}</dd>{/if}
        {if $IMOVELSHOW->suite != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->suite+0}-fill me-1 text-muted"></i>Suíte Office:</dt><dd class="col-4">{$IMOVELSHOW->suite+0}</dd>{/if}
        {if $IMOVELSHOW->terraco != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->terraco+0}-fill me-1 text-muted"></i>Terraço:</dt><dd class="col-4">{$IMOVELSHOW->terraco+0}</dd>{/if}
        {if $IMOVELSHOW->vagagaragem != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->vagagaragem+0}-fill me-1 text-muted"></i>Vaga de Garagem:</dt><dd class="col-4">{$IMOVELSHOW->vagagaragem+0}</dd>{/if}
        {if $IMOVELSHOW->varanda != ''}<dt class="col-8"><i class="bi-dice-{$IMOVELSHOW->varanda+0}-fill me-1 text-muted"></i>Varanda:</dt><dd class="col-4">{$IMOVELSHOW->varanda+0}</dd>{/if}
      </dl>
    </div>
  </div>
  {if $IMOVELSHOW->caracteristicas|trim != ""}
    <div class="mb-4">
      <h4><i class="bi bi-info-square text-secondary me-2"></i> Sobre o imóvel</h4>
    </div>
    <p>{$IMOVELSHOW->caracteristicas}</p>
  {/if}
</div>
