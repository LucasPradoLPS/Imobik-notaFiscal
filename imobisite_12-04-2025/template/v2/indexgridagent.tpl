<div class="full-row">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="align-items-center d-flex">
                    <div class="me-auto">
                        <h2 class="d-table down-line">{$SECAO->sitesecaotitulo}</h2>
                    </div>
                    <!--<a href="property-grid-v1.html" class="ms-auto btn-link">View All Agents</a>-->
                </div>
            </div>
        </div>
        <div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 mt-5">
            <div class="4block-carusel nav-disable owl-carousel">
            {foreach from=$IMOVELCORRETORES item="CORRETOR"}        
                {if isset($CORRETOR->selfie)}
                    {$filename = $URLSYSTEM|cat:$CORRETOR->selfie}
                {else}
                    {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
                {/if}            
                {$file_headers = get_headers($filename)}
                {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                    {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
                {/if}
                <div class="col p-2">
                    <div class="thumb-team-simple">
                        <div class="item card-transition" style="min-height: 22rem; background-image: url('{$filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;" ></div>
                        <div class="user-info py-2">
                            <h6 class="text-dark mb-2 font-400"><a href="javascript:js_CorretorView({$CORRETOR->idpessoa},'{$CORRETOR->pessoa}')">{$CORRETOR->pessoa}</a></h6>
                        </div>                        
                        <div class="user-info d-flex">
                            <div class="me-auto">
                                <span class="text-secondary font-fifteen">{$CORRETOR->email}</span>                                
                            </div>
                            <div class="member-score font-small bg-primary d-table text-white ms-auto">
                                <span>CRECI:&nbsp;&nbsp;{$CORRETOR->creci}</span>
                            </div>
                        </div>
                        <div class="user-info d-flex">
                            <div class="me-auto">
                                {if $CORRETOR->celular|trim != ""}
                                    <span class="d-block small mb-1">
                                        <a class="btn-ghost-secondary dz-dropzone" href="https://api.whatsapp.com/send?phone=+55{$CORRETOR->celular}&text=Olá, quero mais informações" target="_blank">
                                            <i class="fa-brands fa-whatsapp fa-lg"></i>&nbsp;&nbsp;{$CORRETOR->celular}
                                        </a>
                                    </span>
                                {/if}
                            </div>
                            <div class="">
                                <h6 class="product-offer-item">
                                    <a class="link" style="color:#666666" href="javascript:js_CorretorView({$CORRETOR->idpessoa},'{$CORRETOR->pessoa}')">Imóveis deste corretor</a>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
            </div>
        </div>
    </div>
</div>