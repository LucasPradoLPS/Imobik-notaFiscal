<div class="full-row bg-light">
    <div class="container {$HIDDENTESTEMUNHO}">
        <div class="row">
            <div class="col mb-5">
                <span class="text-primary tagline pb-2 d-table m-auto">Depoimentos</span>
                <h2 class="down-line w-50 mx-auto mb-4 text-center w-sm-100">{$SECAO->sitesecaotitulo}</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="testimonial-simple text-center px-5">
                    <div class="text-carusel owl-carousel">
                        {foreach from=$SITE_TESTEMUNHO item="TESTEMUNHO"}                    
                            <div class="item">
                                <i class="flaticon-right-quote flat-large text-primary d-table mx-auto"></i>
                                <blockquote class="text-secondary fs-5 fst-italic">“ {$TESTEMUNHO->depoimento|nl2br} ”</blockquote>
                                <div style="display: flex;flex-wrap: wrap;justify-content: center;align-content: center;">
                                    <div class="rounded-circle" style="width:160px; min-height: 160px; background-image: url('{$URLSYSTEM|cat:$TESTEMUNHO->filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;"></div>
                                </div>
                                <h4 class="mt-4 font-400">{$TESTEMUNHO->nome}</h4>
                                <span class="text-primary font-fifteen">{$TESTEMUNHO->cargo}</span>
                            </div>
                        {/foreach}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>