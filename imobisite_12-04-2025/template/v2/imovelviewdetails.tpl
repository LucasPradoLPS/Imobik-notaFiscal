<div class="property-overview border rounded bg-white p-30 mb-30">
    <div class="row row-cols-1">
        <div class="col">
            <h5 class="mb-3 down-line">Detalhes do Imóvel</h5>
            <ul class="list-three-fold-width">
                <li><span class="font-500">Código:</span> {$IMOVELSHOW->idimovel}</li>
                <li><span class="font-500">Tipo:</span> {$IMOVELSHOW->imoveltipo}</li>
                <li><span class="font-500">Finalidade:</span> {$IMOVELSHOW->imoveldestino}</li>
                {if $IMOVELSHOW->perimetro == "U"}
                    {$perimetro = "Urbano"}
                {else}
                    {$perimetro = "Rural"}
                {/if}
                <li><span class="font-500">Perímetro:</span> {$perimetro}</li>
                <li><span class="font-500">Área:</span> 
                    {$IMOVELSHOW->area}
                    {if $IMOVELSHOW->perimetro == "U"}
                        m²
                    {else}
                        hectare(s)
                    {/if}
                </li>
                <li><span class="font-500">Construção:</span> {$IMOVELSHOW->imovelmaterial}</li>
                <li><span class="font-500">Nº Reg. Imóveis:</span> {$IMOVELSHOW->imovelregistro}</li>
                <li><span class="font-500">Nº Matr. Pref:</span> {$IMOVELSHOW->prefeituramatricula}</li>
            </ul>
        </div>
    </div>
</div>
<div class="property-overview border rounded bg-white p-30 mb-30">
    <div class="row row-cols-1">
        <div class="col">
            <h5 class="mb-3 down-line">Características</h5>
            <ul class="list-three-fold-width list-style-tick">

                {if $IMOVELSHOW->abrigo != ''} <li>Abrigo(s): <strong>{$IMOVELSHOW->abrigo+0}</strong></li> {/if}
                {if $IMOVELSHOW->aquecedor != ''} <li>Aquecedor(es): <strong>{$IMOVELSHOW->aquecedor+0}</strong></li> {/if}
                {if $IMOVELSHOW->areaservico != ''} <li>Área(s) de Serviço: <strong>{$IMOVELSHOW->areaservico+0}</strong></li> {/if}
                {if $IMOVELSHOW->banheiro != ''} <li>Banheiro(s): <strong>{$IMOVELSHOW->banheiro+0}</strong></li> {/if}
                {if $IMOVELSHOW->biblioteca != ''} <li>Biblioteca(s): <strong>{$IMOVELSHOW->biblioteca+0}</strong></li> {/if}
                {if $IMOVELSHOW->churrasqueira != ''} <li>Churrasqueira(s): <strong>{$IMOVELSHOW->churrasqueira+0}</strong></li> {/if}
                {if $IMOVELSHOW->closet != ''} <li>Closet(s): <strong>{$IMOVELSHOW->closet+0}</strong></li> {/if}
                {if $IMOVELSHOW->condicionador != ''} <li>Condicionador(es) de Ar(s): <strong>{$IMOVELSHOW->condicionador+0}</strong></li> {/if}
                {if $IMOVELSHOW->copa != ''} <li>Copa(s): <strong>{$IMOVELSHOW->copa+0}</strong></li> {/if}
                {if $IMOVELSHOW->cozinha != ''} <li>Cozinha(s): <strong>{$IMOVELSHOW->cozinha+0}</strong></li> {/if}
                {if $IMOVELSHOW->despensa != ''} <li>Despensa(s): <strong>{$IMOVELSHOW->despensa+0}</strong></li> {/if}
                {if $IMOVELSHOW->destaque != ''} <li>Destaque(s): <strong>{$IMOVELSHOW->destaque+0}</strong></li> {/if}
                {if $IMOVELSHOW->dependenciaemp != ''} <li>Dorm(s) de Empregada: <strong>{$IMOVELSHOW->dependenciaemp+0}</strong></li> {/if}
                {if $IMOVELSHOW->dormitorio != ''} <li>Dormitório(s): <strong>{$IMOVELSHOW->dormitorio+0}</strong></li> {/if}
                {if $IMOVELSHOW->escritorio != ''} <li>Escritório(s): <strong>{$IMOVELSHOW->escritorio+0}</strong></li> {/if}
                {if $IMOVELSHOW->homeoffice != ''} <li>Home Office(s): <strong>{$IMOVELSHOW->homeoffice+0}</strong></li> {/if}
                {if $IMOVELSHOW->lareira != ''} <li>Lareira(s): <strong>{$IMOVELSHOW->lareira+0}</strong></li> {/if}
                {if $IMOVELSHOW->lavabo != ''} <li>Lavabo(s): <strong>{$IMOVELSHOW->lavabo+0}</strong></li> {/if}
                {if $IMOVELSHOW->lavanderia != ''} <li>Lavanderia(s): <strong>{$IMOVELSHOW->lavanderia+0}</strong></li> {/if}
                {if $IMOVELSHOW->living != ''} <li>Living(s): <strong>{$IMOVELSHOW->living+0}</strong></li> {/if}
                {if $IMOVELSHOW->mesanino != ''} <li>Mesanino(s): <strong>{$IMOVELSHOW->mesanino+0}</strong></li> {/if}
                {if $IMOVELSHOW->outros != ''} <li>Outros(s): <strong>{$IMOVELSHOW->outros+0}</strong></li> {/if}
                {if $IMOVELSHOW->patio != ''} <li>Pátio(s): <strong>{$IMOVELSHOW->patio+0}</strong></li> {/if}
                {if $IMOVELSHOW->piscina != ''} <li>Piscina(s): <strong>{$IMOVELSHOW->piscina+0}</strong></li> {/if}
                {if $IMOVELSHOW->quartocasal != ''} <li>Quarto(s) de Casal: <strong>{$IMOVELSHOW->quartocasal+0}</strong></li> {/if}
                {if $IMOVELSHOW->quartohospede != ''} <li>Quarto(s) de Hóspede: <strong>{$IMOVELSHOW->quartohospede+0}</strong></li> {/if}
                {if $IMOVELSHOW->quartosolteiro != ''} <li>Quarto(s) de Solteiro: <strong>{$IMOVELSHOW->quartosolteiro+0}</strong></li> {/if}
                {if $IMOVELSHOW->sacada != ''} <li>Sacada(s): <strong>{$IMOVELSHOW->sacada+0}</strong></li> {/if}
                {if $IMOVELSHOW->salaestar != ''} <li>Sala(s) de Estar: <strong>{$IMOVELSHOW->salaestar+0}</strong></li> {/if}
                {if $IMOVELSHOW->salajantar != ''} <li>Sala(s) de Jantar: <strong>{$IMOVELSHOW->salajantar+0}</strong></li> {/if}
                {if $IMOVELSHOW->sala != ''} <li>Sala(s): <strong>{$IMOVELSHOW->sala+0}</strong></li> {/if}
                {if $IMOVELSHOW->salao != ''} <li>Salão(ões): <strong>{$IMOVELSHOW->salao+0}</strong></li> {/if}
                {if $IMOVELSHOW->split != ''} <li>Split(s): <strong>{$IMOVELSHOW->split+0}</strong></li> {/if}
                {if $IMOVELSHOW->suite != ''} <li>Suíte(s): <strong>{$IMOVELSHOW->suite+0}</strong></li> {/if}
                {if $IMOVELSHOW->terraco != ''} <li>Terraço(s): <strong>{$IMOVELSHOW->terraco+0}</strong></li> {/if}
                {if $IMOVELSHOW->vagagaragem != ''} <li>Vaga(s) de Garagem: <strong>{$IMOVELSHOW->vagagaragem+0}</strong></li> {/if}
                {if $IMOVELSHOW->varanda != ''} <li>Varanda(s): <strong>{$IMOVELSHOW->varanda+0}</strong></li> {/if}
            </ul>
        </div>
    </div>
</div>