<div class="full-row bg-light">
    <div class="container {$HIDDENTESTEMUNHO}">
        <div class="row">
            <div class="col">
                <div class="tagline text-primary pb-1 d-table mx-auto">Depoimentos</div>
                <h2 class="down-line text-center">{$SECAO->sitesecaotitulo}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Slider HTML markup -->
                <div id="layer-testimonial" style="width:1280px; height:500px; margin:0 auto;margin-bottom: 0px;">
                    <!-- Slide 1-->
                    <div class="ls-slide" data-ls="duration:4000; kenburnsscale:1.2;">
                        {if isset($SITE_TESTEMUNHO[0])}
                            <div class="rounded-circle ls-l" style="width:160px; min-height: 160px; background-image: url('{$URLSYSTEM|cat:$SITE_TESTEMUNHO[0]->filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;top:95px; left:501px;" data-ls="offsetyin:-100; durationin:800; delayin:600; easingin:easeOutExpo; scaleyin:0.8; offsetyout:-300; durationout:400; parallaxlevel:0;"></div>
                            <h6 style="line-height:36px; top:82px; left:165px;" class="ls-l font-400" data-ls="offsetyin:-130; durationin:700; delayin:700; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[0]->cargo}</h6>                        
                            <h3 style="line-height:36px; top:107px; left:165px;" class="ls-l font-400" data-ls="offsetyin:-130; durationin:700; delayin:700; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[0]->nome}</h3>
                            <p style="width:320px; font-size:16px; line-height:30px; top:155px; left:165px; white-space:normal;" class="ls-l" data-ls="offsetyin:-100; durationin:800; delayin:800; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">"{$SITE_TESTEMUNHO[0]->depoimento|nl2br}"</p>
                        {/if}
                        {if isset($SITE_TESTEMUNHO[1])}
                            <div class="rounded-circle ls-l" style="width:160px; min-height: 160px; background-image: url('{$URLSYSTEM|cat:$SITE_TESTEMUNHO[1]->filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;top:185px; left:619px;" data-ls="offsetyin:100; durationin:800; delayin:1300; easingin:easeOutExpo; scaleyin:0.8; offsetyout:300; durationout:400; parallaxlevel:0;"></div>
                            <h6 style="line-height:36px; top:185px; left:812px;" class="ls-l font-400" data-ls="offsetyin:100; durationin:700; delayin:1400; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[1]->cargo}</h6>
                            <h3 style="line-height:36px; top:210px; left:812px;" class="ls-l font-400" data-ls="offsetyin:100; durationin:700; delayin:1400; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[1]->nome}</h3>
                            <p style="width:330px; font-size:16px; line-height:30px; top:255px; left:810px; white-space:normal;" class="ls-l" data-ls="offsetyin:100; durationin:800; delayin:1500; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">"{$SITE_TESTEMUNHO[1]->depoimento|nl2br}"</p>
                        {/if}
                    </div>
                    <!-- Slide 2-->
                    <div class="ls-slide" data-ls="duration:4000; kenburnsscale:1.2;">
                        {if isset($SITE_TESTEMUNHO[2])}
                            <div class="rounded-circle ls-l" style="width:160px; min-height: 160px; background-image: url('{$URLSYSTEM|cat:$SITE_TESTEMUNHO[2]->filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;top:195px; left:501px;" data-ls="offsetyin:100; durationin:800; delayin:600; easingin:easeOutExpo; scaleyin:0.8; offsetyout:300; durationout:400; parallaxlevel:0;"></div>
                            <h6 style="line-height:36px; top:185px; left:164px;" class="ls-l font-400" data-ls="offsetyin:100; durationin:700; delayin:700; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[2]->cargo}</h6>
                            <h3 style="line-height:36px; top:210px; left:164px;" class="ls-l font-400" data-ls="offsetyin:100; durationin:700; delayin:700; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[2]->nome}</h3>
                            <p style="width:330px; font-size:16px; line-height:30px; top:257px; left:165px; white-space:normal;" class="ls-l" data-ls="offsetyin:100; durationin:800; delayin:800; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">"{$SITE_TESTEMUNHO[2]->depoimento|nl2br}"</p>
                        {/if}
                        {if isset($SITE_TESTEMUNHO[3])}
                            <div class="rounded-circle ls-l" style="width:160px; min-height: 160px; background-image: url('{$URLSYSTEM|cat:$SITE_TESTEMUNHO[3]->filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;top:115px; left:619px;" data-ls="offsetyin:-100; durationin:800; delayin:1300; easingin:easeOutExpo; scaleyin:0.8; offsetyout:-300; durationout:400; parallaxlevel:0;"></div>
                            <h6 style="line-height:36px; top:87px; left:810px;" class="ls-l font-400" data-ls="offsetyin:-100; durationin:700; delayin:1400; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[3]->cargo}</h6>
                            <h3 style="line-height:36px; top:112px; left:810px;" class="ls-l font-400" data-ls="offsetyin:-100; durationin:700; delayin:1400; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">{$SITE_TESTEMUNHO[3]->nome}</h3>
                            <p style="width:330px; font-size:16px; line-height:25px; top:161px; left:810px; white-space:normal;" class="ls-l" data-ls="offsetyin:-100; durationin:800; delayin:1500; easingin:easeOutExpo; durationout:400; parallaxlevel:0;">"{$SITE_TESTEMUNHO[3]->depoimento|nl2br}"</p>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>