{if $IMOVELCORRETOR|count > 0}
    <div class="property-overview border rounded bg-white p-30 mb-30">
        <div class="row">
            <div class="col">
                <div class="align-items-center d-flex">
                    <div class="me-auto">
                        {if $IMOVELCORRETOR|count > 1}
                            <h5 class="d-table down-line">Corretores</h5>
                        {else}
                            <h5 class="d-table down-line">Corretor</h5>
                        {/if}
                    </div>
                </div>
            </div>
        </div>    
        <div class="row row-cols-1">
            <div class="col">
                <div id="comments" class="comments">
                    {foreach from=$IMOVELCORRETOR item="CORRETOR"}
                        <div class="media mt-4">
                            {if isset($CORRETOR->selfie)}
                                {$filename = $URLSYSTEM|cat:$CORRETOR->selfie}
                            {else}
                                {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
                            {/if}
                            {$file_headers = get_headers($filename)}
                            {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                                {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
                            {/if}
                            <div class="me-3 rounded-circle" style="width:120px; min-height: 120px; background-image: url('{$filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;"></div>
                            <div class="media-body">
                                <div class="row d-flex align-items-center">
                                    <h6 class="col-auto mb-0">{$CORRETOR->pessoa|lower|ucwords}</h6>
                                    <!--
                                    <div class="col-auto">
                                        <span class="d-inline-block font-mini text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        <span class="d-inline-block">(5 out of 5)</span>
                                    </div>
                                    -->
                                </div>
                                {if isset($CORRETOR->creci)}
                                    <div class="comments-date mb-2">
                                        <span>Creci:</span>
                                        <a class="btn-ghost-secondary dz-dropzone">&nbsp;&nbsp;{$CORRETOR->creci}</a>
                                    </div>
                                {/if}
                                {if $CORRETOR->fones|trim != ""}
                                    <span class="d-block small mb-1">
                                        <a class="btn-ghost-secondary dz-dropzone" href="tel:{$CORRETOR->fones}">
                                        <i class="fa-solid fa-phone fa-lg"></i>&nbsp;&nbsp;{$CORRETOR->fones}
                                        </a>
                                    </span>
                                {/if}
                                {if $CORRETOR->celular|trim != ""}
                                    <span class="d-block small mb-1">
                                        <a class="btn-ghost-secondary dz-dropzone" href="https://api.whatsapp.com/send?phone=+55{$CORRETOR->celular}&text=Olá, quero mais informações sobre o imóvel código {$IMOVELSHOW->idimovel}" target="_blank">
                                        <i class="fa-brands fa-whatsapp fa-lg"></i>&nbsp;&nbsp;{$CORRETOR->celular}
                                        </a>
                                    </span>
                                {/if}
                                {if $CORRETOR->email|trim != ""}
                                    <span class="d-block small mb-1">
                                        <a class="btn-ghost-secondary dz-dropzone" href="mailto:{$CORRETOR->email}">
                                        <i class="fa-solid fa-envelope fa-lg"></i>&nbsp;&nbsp;{$CORRETOR->email}
                                        </a>
                                    </span>
                                {/if}
                                <h6 class="product-offer-item">
                                    <a class="link listing-title" href="javascript:js_CorretorView({$CORRETOR->idpessoa},'{$CORRETOR->pessoa}')">Imóveis deste corretor</a>
                                </h6>
                            </div>
                        </div>
                        <hr>    
                    {/foreach}                
                </div>
            </div>
        </div>
    </div>
{/if}