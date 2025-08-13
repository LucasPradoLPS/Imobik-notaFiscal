<!--
<div class="full-row bg-primary py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <h3 class="text-white xs-text-center my-20 font-400">Are you looking for a House or Property Customer?</h3>
            </div>
            <div class="col-lg-3 col-md-4">
                <a href="#" class="btn btn-white y-center position-relative d-table xs-mx-auto ms-auto">Subscribe Now</a>
            </div>
        </div>
    </div>
</div>
-->

<!--============== Footer Section Start ==============-->
<footer class="full-row footer-default-dark bg-footer" style="padding-bottom: 30px">
    <div class="container">
        <div class="row row-cols-lg-4 row-cols-md-2 row-cols-1">
            <div class="col">
                <div class="footer-widget mb-4">
                    <div class="footer-logo mb-4">
                        <a href="#"><img src="{$URLSYSTEM}{$CONFIG->logomarca}" alt="" /></a>
                    </div>
                    <ul class="list-unstyled mb-2">
                        {if $CONFIG->creci|trim != ""}
                            <li><a class="link-sm link-secondary"></i>CRECI: {$CONFIG->creci}</a></li>
                        {/if}
                    </ul>
                    <a class="link-sm link-secondary"></i>{$SITE->endereco|nl2br}</a>
                </div>
                <div class="footer-widget media-widget mb-4">
                    <br><br>
                    {if $SITE->facebook|trim != ""}
                        <a href="{$SITE->facebook}" target="_blank"><i class="fab fa-facebook-f fa-xl"></i></a>
                    {/if}
                    {if $SITE->instagran|trim != ""}
                        <a href="{$SITE->instagran}" target="_blank"><i class="fab fa-instagram fa-xl"></i></a>
                    {/if}
                    {if $SITE->telegram|trim != ""}
                        <a href="{$SITE->telegram}" target="_blank"><i class="fab fa-telegram fa-xl"></i></a>
                    {/if}
                    {if $SITE->youtube|trim != ""}
                        <a href="{$SITE->youtube}" target="_blank"><i class="fab fa-youtube fa-xl"></i></a>
                    {/if}
                    {if $SITE->whatsapp|trim != ""}
                        <a href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1" target="_blank"><i class="fab fa-whatsapp fa-xl"></i></a>
                    {/if}
                </div>
            </div>
            <div class="col">
                <div class="footer-widget contact-widget mb-4">
                    <h3 class="widget-title mb-4">Imóveis</h3>
                    <ul>
                        {if $USEMAP == true}
                            <li class="{$HIDDENLOCACAO}"><a href="javascript:void(0)" role="button" onclick="js_MenuDirecionaFooterMap('1,5','');">Para Alugar</a></li>
                            <li class="{$HIDDENVENDA}"><a href="javascript:void(0)" role="button" onclick="js_MenuDirecionaFooterMap('3,5','');">Para Comprar</a></li>
                            <li class="{$HIDDENTEMPORADA}"><a href="javascript:void(0)" role="button" onclick="js_MenuDirecionaFooterMap('10','');">Para Temporada</a></li>
                        {else}
                            <li class="{$HIDDENLOCACAO}"><a href="javascript:void(0)" role="button" onclick="js_MenuDirecionaFooter('1,5','');">Para Alugar</a></li>
                            <li class="{$HIDDENVENDA}"><a href="javascript:void(0)" role="button" onclick="js_MenuDirecionaFooter('3,5','');">Para Comprar</a></li>
                            <li class="{$HIDDENTEMPORADA}"><a href="javascript:void(0)" role="button" onclick="js_MenuDirecionaFooter('10','');">Para Temporada</a></li>
                        {/if}
                    </ul>
                    <h3 class="widget-title mb-4">Ligue</h3>
                    <ul>
                        {if $SITE->telefone|trim != ""}
                            <li><a href="tel:{$SITE->telefone}"><i class="fa fa-phone"></i>&nbsp;&nbsp;{$SITE->telefone}</a></li>
                        {/if}
                        {if $SITE->whatsapp|trim != ""}
                            <li><a href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1"><i class="fab fa-whatsapp"></i>&nbsp;&nbsp;{$SITE->whatsapp}</a></li>
                        {/if}
                        {if $SITE->whatsappphone|trim != ""}
                            <li><a href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsappphone}&text=Ol%C3%A1"><i class="fab fa-whatsapp"></i>&nbsp;&nbsp;{$SITE->whatsappphone}</a></li>
                        {/if}
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget contact-widget mb-4">
                    <h3 class="widget-title mb-4">Anuncie seu imóvel</h3>
                    <ul>
                        <li class="{$HIDDENLOCACAO}"><a href="anuncie-seu-imovel/locacao/">Para Locação</a></li>
                        <li class="{$HIDDENVENDA}"><a href="anuncie-seu-imovel/venda/">Para Venda</a></li>
                    </ul>
                    <h3 class="widget-title mb-4">A Empresa</h3>
                    <ul>
                        <li><a href="sobre-nos/">Sobre Nós</a></li>
                        <li><a href="contato/">Contato</a></li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget contact-widget mb-4">
                    <h4 class="widget-title mb-4">Links</h4>
                    <ul>
                        <li><a href="{$CONFIG->appdomain}" target="_blank">Gestão</a></li>
                    </ul>
                    {if $SITE->customerbutton == true}
                        <a href="http://portal.imobik.com.br" target="_blank" class="btn btn-primary w-100">Portal do Cliente</a>                            
                    {/if}
                </div>
            </div>
        </div>
    </div>
</footer>
<!--============== Footer Section End ==============-->

<!--============== Copyright Section Start ==============-->
<div class="copyright bg-footer text-default py-4">
    <div class="container">
        <div class="row row-cols-md-3 row-cols-1">
            <div class="col">
                <span class="text-white">{$SITE->rodape|nl2br}</span>
            </div>
            <div class="col text-white text-center">
                Site integrado à &nbsp; 
                <a href="https://www.imobik.com.br" target="_blank">
                    <img src="assets/v1/img/logo-imobik-3.png" style="max-width:65px;margin-bottom:13px;">
                </a>
                <br><br>
            </div>
            <div class="col">
                <ul class="line-menu float-end list-color-gray">
                    <li>
                        <a href="#">Política de Privacidade </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                        <a href="#">Termos de Uso </a><br>
                        <a href="#">Política de Cookies </a>&nbsp;&nbsp;|&nbsp;&nbsp;
                        <a href="sitemap/">Mapa do Site </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--============== Copyright Section End ==============-->

<!-- Scroll to top -->
<div class="scroll-top-vertical bg-primary" id="scroll">Topo <i class="ms-2 fa-solid fa-arrow-right-long"></i></div>

<div id="whats-fixed-1">
    <p style="display:none;padding: 10px 15px; background-color: #fff; border-radius: 5px;" class="ls-l bg-light border text-center" data-ls="offsetxin:0; offsetyin:200; easingin:easeOutBack; rotatein:0; transformoriginin:30px 360px 0; offsetxout:-80; delayin:500; durationout:400; parallax:false; parallaxlevel:1;"><span class="text-primary">{$SITE->whatsapp}</span></p>        
</div>
<div id="whats-fixed-2">
    <div class="rounded-circle p-2" style="background-color:#dbdbdb;width:58px;height:58px;">
        <div class="d-grid text-center">
            <a class="text-center" target="_blank" href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1">
                <i class="fa-brands fa-whatsapp text-primary" style="font-size:40px;"></i>
            </a>
        </div>
    </div>
</div>
<div id="whats-fixed-3">
    <p style="padding: 5px 15px; background-color: #fff; border-radius: 5px;" class="ls-l bg-primary border text-white" data-ls="offsetxin:0; offsetyin:200; easingin:easeOutBack; rotatein:0; transformoriginin:30px 360px 0; offsetxout:-80; delayin:900; durationout:400; parallax:false; parallaxlevel:1;">
        <a class="text-center text-white" target="_blank" href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1">
            Contate-nos
        </a>
    </p>        
</div>
<!-- End Scroll To top -->

<!--============== Quick View ==============-->
<div class="overlay-dark modal fade quick-view-modal" id="quick-view">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="close view-close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body property-block summary p-3" id="modalImovelView">
                
            </div>
        </div>
    </div>
</div>
<!-- End Quick View -->    

<!--============== LGPD Cookies ==============-->
<style>
.lgpd-accept {
    left: 50%;
    transform: translate(-50%, -10%);
	width: 90%;
	background-color: #ffffff;
	box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
	position: fixed;
	bottom: 0px;
	font-family: 'Exo 2';
	display: none;
	justify-content: center;
	align-items: center;
	border-radius: 10px;
}

.lgpd-accept-div {
	display: flex;
	position: relative;
	max-width: 1230px;
	width: 90%
}

.lgpd-accept-div-left {
	line-height: 1.7;
	width: 45%;
	padding: 30px 20px 30px 10px;
	font-size: 13px;
	color: black;
    text-align: justify;
	font-weight: 100;
    font-family: var(--theme-hiperlink-font);
}

.lgpd-accept-div-right {
	display: flex;
	width: 55%;
	justify-content: space-around;
    align-items: center;	
}

.lgpd-accept-div-right input{
	width: 45%;
}

.lgpd-accept-btn-allow {
	background-color: var(--theme-primary-color);
	border: 0px;
	padding: 10px 30px;
	border-radius: 10px;
	color: #ffffff;
	font-size: 15px;
	font-weight: 900;
	cursor: pointer;
    font-family: var(--theme-hiperlink-font);
}

.lgpd-accept-btn-not-allow {
	background-color: #f2f2f2;
	border: 0px;
	padding: 10px 30px;
	border-radius: 10px;
	color: #1d1d1d;
	font-size: 15px;
	cursor: pointer;
    font-family: var(--theme-hiperlink-font);
}

@media screen and (max-width: 980px) {

	.lgpd-accept-div {
		display: block;		
	}	

	.lgpd-accept-div-right {
		display: block;
		margin-bottom: 30px;
	}	

	.lgpd-accept-div-right input{
		width: 100%;
		margin: 10px;
	}

	.lgpd-accept-div-left, .lgpd-accept-div-right  {
		width: 95%;		
	}	
}

@media screen and (max-width: 650px) {

	.lgpd-accept-div {
		display: block;
	}	

	.lgpd-accept-div-right {
		display: block;
		margin-bottom: 30px;
	}	

	.lgpd-accept-div-right input{
		width: 100%;
		margin: 10px;
	}
}

</style>
<div id="lgpd-accept" class="lgpd-accept">
	<div class="lgpd-accept-div">
		<div class="lgpd-accept-div-left">
            {$SITE->msgcookies}
		</div>
		<div class="lgpd-accept-div-right">
			<button class="lgpd-accept-btn-allow" onclick="js_aceitaCookie();">Aceitar todos os Cookies</button>
		</div>
	</div>
</div>
<!-- End Quick View -->    