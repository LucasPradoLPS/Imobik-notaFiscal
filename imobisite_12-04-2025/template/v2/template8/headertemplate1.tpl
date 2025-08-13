<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-light">

    {include file="menufullbgwhite.tpl"}

    <div class="full-row p-0 overflow-hidden" style="padding-top:120px;">
        <div id="slider-v2-t08" class="overflow-hidden" style="width:1920px; height:700px; margin:0 auto;margin-bottom: 0px;">
            {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}
                {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
                {$file_headers = get_headers($img_lancamento)}
                {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                    {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                {else}
                    {$img_destaque = $img_lancamento}
                {/if}
                {$nomeSeo = $LANCAMENTO->imoveltipo|cat:" "|cat:$LANCAMENTO->imoveldestino|cat:" "|cat:$LANCAMENTO->cidade|cat:" "|cat:$LANCAMENTO->bairro}
                <div class="ls-slide" data-ls="kenburnsscale:1.2; duration:7000;">
                    <img width="1920" height="1280" src="{$img_destaque}" class="ls-bg" alt="">
                    <div style="width:100%; height:100%; background:rgba(37, 40, 43, 0.49); top:50%; left:50%;" class="ls-l" data-ls="easingin:easeOutQuint; durationin:1500; durationout:400; parallaxlevel:0; position:fixed;"></div>
                    <div style="top:0px; left:0px; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; height:860px; width:460px; background:#181a1d; font-size:13px; opacity:0.8;" class="ls-l" data-ls="showinfo:1; delayin:400; fadein:false; widthin:0; offsetxout:left; easingout:easeInQuint; skewxout:-10;"></div>
                    <div style="top:0px; left:0px; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; height:860px; width:460px; background:#181a1d; font-size:13px; opacity:1;" class="ls-l" data-ls="showinfo:1; delayin:400; fadein:false; widthin:0; offsetxout:left; easingout:easeInQuint; skewxout:-10;"></div>
                    <div style="letter-spacing: -7px; top:90px; left:60px; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; font-family:Verdana; font-size:40px; height:2px; width:55px; opacity:.75; border-radius:10px;"
                        class="ls-l bg-primary" data-ls="showinfo:1; durationin:1500; delayin:400; fadein:false; clipin:0 100% 0 0; offsetxout:left;"></div>
                    <p style="top:60px; left:60px; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; font-size:18px; color:#fff;" class="ls-l" data-ls="showinfo:1; offsetyin:top; delayin:400; easingin:easeOutQuint; offsetxout:left; skewxout:-10; texttransitionin:true; texttypein:chars_asc; textshiftin:20; textoffsetyin:-70lh; textdurationin:800; texteasingin:easeOutQuint; textfadein:false; textstartatin:transitioninstart + 0;">
                        {$LANCAMENTO->imovelsituacao}
                    </p>
                    <h2 style="top:120px; left:60px; line-height: 50px; text-align:initial; white-space: normal; width: 360px; text-decoration:none; mix-blend-mode:normal; color:#fff; padding-right:20px;" class="ls-l font-400" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:400; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        {$LANCAMENTO->imoveltipo}
                    </h2>
                    <h6 style="top:150px; left:60px; line-height: 50px; text-align:initial; white-space: normal; width: 360px; text-decoration:none; mix-blend-mode:normal; color:gray; padding-right:20px;" class="ls-l font-400" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:400; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        <small>Código {$LANCAMENTO->idimovel}</small>
                    </h6>
                    <h6 style="top:235px; left:60px; text-align:initial; font-weight:400; text-decoration:none; mix-blend-mode:normal; padding-right:20px;" class="ls-l text-primary" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:400; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        {$LANCAMENTO->bairro|lower|ucwords} - {$LANCAMENTO->cidade|lower|ucwords} ({$LANCAMENTO->uf})
                    </h6>
                    <h4 style="top:290px; left:60px; text-align:initial; text-decoration:none; mix-blend-mode:normal; padding-right:20px;" class="ls-l text-white font-400" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:400; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        {$exibeValorPrimario = ""}
                        {if $LANCAMENTO->idimovelsituacao == "1"}
                            {$valorPrimario = $LANCAMENTO->aluguel+$LANCAMENTO->iptu+$LANCAMENTO->condominio+$LANCAMENTO->outrataxavalor}
                            {$valorPrimario = $valorPrimario|number_format:2:",":"."}
                            {$valorPrimario = "Locação R$ "|cat:$valorPrimario}
                            {if $LANCAMENTO->exibealuguel == false }
                                {$exibeValorPrimario = "d-none"}
                            {/if}
                        {else}
                            {$valorPrimario = $LANCAMENTO->venda|number_format:2:",":"."}
                            {$valorPrimario = "Venda R$ "|cat:$valorPrimario}
                            {if $LANCAMENTO->exibevalorvenda == false }
                                {$exibeValorPrimario = "d-none"}
                            {/if}
                        {/if}
                        <span class="{$exibeValorPrimario}">{$valorPrimario}</span>
                    </h4>
                    <p style="top:350px; left:60px; width:300px; text-align:initial; text-decoration:none; white-space:normal; mix-blend-mode:normal; line-height:28px; color:#a1a1a1; padding-right:20px;" class="ls-l" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:600; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        {$LANCAMENTO->caracteristicas|substr:0:300|nl2br}
                    </p>
                    {if $LANCAMENTO->dormitorio+0 > 0}
                        <p style="top:550px; left:60px; text-decoration:none; mix-blend-mode:normal; color:#fff; padding-right:20px;" class="ls-l" data-ls="showinfo:1; rotatexin:45; durationin:1500; delayin:600; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                            <i class="flaticon-bed flat-small text-primary me-2"></i> {$LANCAMENTO->dormitorio+0}
                        </p>
                    {/if}
                    {if $LANCAMENTO->banheiro+0 > 0}
                        <p style="top:550px; left:150px; text-decoration:none; mix-blend-mode:normal; color:#fff; padding-right:20px;" class="ls-l" data-ls="showinfo:1; rotatexin:45; durationin:1500; delayin:600; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                            <i class="flaticon-bathroom flat-small text-primary me-2"></i> {$LANCAMENTO->banheiro+0}
                        </p>
                    {/if}                    
                    {if $LANCAMENTO->vagagaragem+0 > 0}                    
                        <p style="top:550px; left:240px; text-decoration:none; mix-blend-mode:normal; color:#fff; padding-right:20px;" class="ls-l" data-ls="showinfo:1; rotatexin:45; durationin:1500; delayin:600; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                            <i class="flaticon-car flat-small text-primary me-2"></i> {$LANCAMENTO->vagagaragem+0}
                        </p>
                    {/if}                    
                    <a onclick="js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')" class="ls-l" href="#1" target="_self" data-ls="delayin:800; easingin:easeOutBack; rotatexin:-360; offsetxout:-80; durationout:400; hover:true; hoverdurationin:300; hoveropacity:1; hoverbgcolor:#ffffff; hovercolor:#0c2109; parallaxlevel:0;">
                        <p style="cursor:pointer; padding-top:20px; padding-right:35px; padding-bottom:20px; padding-left:35px; font-weight:600; font-size:15px; color:#fff; border-radius:0; top:90%; left:60px; text-align:center; letter-spacing:2px;" class="bg-primary">
                            Quero ver mais
                        </p>
                    </a>
                </div>
            {/foreach}            
        </div>
    </div>