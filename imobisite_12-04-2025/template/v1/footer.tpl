<footer class="bg-light">
  <div class="container pb-1 pb-lg-7">
    <div class="row content-space-t-2">
      <div class="col-6 col-lg-2 mb-lg-0">
        <div class="mb-2">
          <a class="navbar-brand" href="home/" aria-label="Space">
            <img class="navbar-brand-logo" src="{$URLSYSTEM}{$CONFIG->logomarca}" alt="Image Description">
          </a>
        </div>
        <ul class="list-unstyled mb-2">
          {if $CONFIG->creci|trim != ""}
            <li><a class="link-sm link-secondary"></i>CRECI: {$CONFIG->creci}</a></li>
          {/if}
        </ul>
      </div>
      {if $SITE->telefone|trim != "" || $SITE->whatsapp|trim != "" || $SITE->whatsappphone|trim != ""}
      <div class="col-6 col-sm mb-7 mb-sm-0">
        <h5 class="mb-3">Ligue</h5>
        <ul class="list-unstyled list-py-1 mb-0">
          {if $SITE->telefone|trim != ""}
            <li><a class="link-sm link-secondary form-check-label" onclick="location.href='tel:{$SITE->telefone}'"><i class="bi-telephone-inbound-fill me-1"></i>{$SITE->telefone}</a></li>
          {/if}
          {if $SITE->whatsapp|trim != ""}
            <li><a class="link-sm link-secondary form-check-label" onclick="location.href='https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1'"><i class="bi-whatsapp me-1"></i>{$SITE->whatsapp}</a></li>
          {/if}
          {if $SITE->whatsappphone|trim != ""}
            <li><a class="link-sm link-secondary form-check-label" onclick="location.href='https://api.whatsapp.com/send?phone=+55{$SITE->whatsappphone}&text=Ol%C3%A1'"><i class="bi-whatsapp me-1"></i>{$SITE->whatsappphone}</a></li>
          {/if}
        </ul>
      </div>
      {/if}
      <div class="col-6 col-sm mb-7 mb-sm-0">
        <h5 class="mb-3">Imóveis</h5>
        <ul class="list-unstyled list-py-1 mb-0">
          <li class="{$HIDDENLOCACAO}"><a class="link-sm link-secondary form-check-label" onclick="js_MenuDirecionaFooter('1,5','');">Para alugar</a></li>
          <li class="{$HIDDENVENDA}"><a class="link-sm link-secondary form-check-label" onclick="js_MenuDirecionaFooter('3,5','');">Para comprar</a></li>
        </ul>
      </div>
      <div class="col-6 col-sm mb-7 mb-sm-0">
        <h5 class="mb-3">Anuncie seu imóvel</h5>
        <ul class="list-unstyled list-py-1 mb-0">
          <li class="{$HIDDENLOCACAO}"><a class="link-sm link-secondary form-check-label" onclick="location.href='anuncie-seu-imovel/locacao/'">Para Locação</a></li>
          <li class="{$HIDDENVENDA}"><a class="link-sm link-secondary form-check-label" onclick="location.href='anuncie-seu-imovel/venda/'">Para Venda</a></li>
        </ul>
      </div>
      <div class="col-6 col-sm">
        <h5 class="mb-3">A Empresa</h5>
        <ul class="list-unstyled list-py-1 mb-0">
          <li><a class="link-sm link-secondary form-check-label" onclick="location.href='sobre-nos/'">Sobre Nós</a></li>
          <li><a class="link-sm link-secondary form-check-label" onclick="location.href='contato/'">Fale conosco</a></li>
        </ul>
      </div>
      <div class="col-6 col-sm">
        <h5 class="mb-3">Links</h5>
        <ul class="list-unstyled list-py-1 mb-5">
          <li><a class="link-sm link-secondary form-check-label" onclick="window.open('https://{$CONFIG->appdomain}')"><i class="bi-pie-chart-fill me-1"></i> Gestão</a></li>
          {if $SITE->customerbutton == true}
            <li><a class="link-sm link-secondary form-check-label" onclick="window.open('http://portal.imobik.com.br')"><i class="bi-person-circle me-1"></i> Portal do Cliente</a></li>
          {/if}
        </ul>
      </div>
    </div>
    <div class="row mt-0 mb-7">
      <a class="link-sm link-secondary"></i>{$SITE->endereco|nl2br}</a>
    </div>
    <div class="border-top my-7"></div>
    <div class="row mb-7">
      <div class="col-lg-9 col-sm-12 mb-3 mb-sm-0">
        <ul class="list-inline list-separator mb-0 text-center">
          <li class="list-inline-item">
            <a class="form-check-label" onclick="location.href='#'">Política de Privacidade</a>
          </li>
          <li class="list-inline-item">
            <a class="form-check-label" onclick="location.href='#'">Termos de Uso</a>
          </li>
          <li class="list-inline-item">
            <a class="form-check-label" onclick="location.href='#'">Política de Cookies</a>
          </li>
          <li class="list-inline-item">
            <a class="form-check-label" onclick="location.href='#'">Mapa do Site</a>
          </li>
        </ul>
      </div>
      <div class="col-lg-3 col-sm-12">
        <ul class="list-inline mb-0 text-center">
          {if $SITE->facebook|trim != ""}
          <li class="list-inline-item">
            <a class="btn btn-soft-secondary btn-xs btn-icon" target="_blank" href="{$SITE->facebook}">
              <i class="bi-facebook" style="font-size:20px"></i>
            </a>
          </li>
          {/if}
          {if $SITE->instagran|trim != ""}
          <li class="list-inline-item">
            <a class="btn btn-soft-secondary btn-xs btn-icon" target="_blank" href="{$SITE->instagran}">
              <i class="bi-instagram" style="font-size:20px"></i>
            </a>
          </li>
          {/if}
          {if $SITE->telegram|trim != ""}
          <li class="list-inline-item">
            <a class="btn btn-soft-secondary btn-xs btn-icon" target="_blank" href="{$SITE->telegram}">
              <i class="bi-telegram" style="font-size:20px"></i>
            </a>
          </li>
          {/if}
          {if $SITE->youtube|trim != ""}
          <li class="list-inline-item">
            <a class="btn btn-soft-secondary btn-xs btn-icon" target="_blank" href="{$SITE->youtube}">
              <i class="bi-youtube" style="font-size:20px"></i>
            </a>
          </li>
          {/if}
          {if $SITE->whatsapp|trim != ""}
          <li class="list-inline-item">
            <a class="btn btn-soft-secondary btn-xs btn-icon" target="_blank" href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1">
              <i class="bi-whatsapp" style="font-size:20px"></i>
            </a>
          </li>
          {/if}
        </ul>
      </div>
    </div>
    <div class="w-md-85 text-center mx-lg-auto small">
      <p class="text-muted small">{$SITE->rodape|nl2br}</p>
    </div>
    <div class="w-md-85 text-center mx-lg-auto">
      <p class="text-muted">
        <sub>Site integrado à</sub>
        <a href="https://www.imobik.com.br" target="_blank">
          <img src="assets/v1/img/logo-imobik-3.png" width="45" valign="middle">
        </a>
      </p>
    </div>
  </div>
</footer>
<!-- ========== SECONDARY CONTENTS ========== -->
<a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;"
     data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": "2rem"
         },
         "show": {
           "bottom": "2rem"
         },
         "hide": {
           "bottom": "-2rem"
         }
       }
     }'>
    <i class="bi-chevron-up"></i>
</a>
{if $ACCEPTCOOKIE == false}
  <div class="container position-fixed bottom-0 start-0 end-0 zi-3">
    <div class="alert alert-white bg-light border-primary w-lg-75 shadow-sm mx-auto justify-content-center" role="alert">
      <h5 class="text-dark">Controle de Privacidade</h5>
      <p class="small text-dark">
        <span class="fw-semi-bold">Aviso!</span>
        {$SITE->msgcookies|nl2br}
      </p>
      <div class="row align-items-sm-center">
        <div class="col-sm-8 mb-3 mb-sm-0">
        </div>
        <div class="col-sm-4 text-sm-end">
          <button onclick="js_aceitaCookie();" type="button" class="btn btn-primary btn-transition" data-bs-dismiss="alert" aria-label="Close">Aceitar</button>
        </div>
      </div>
    </div>
  </div>
{/if}
</body>
</html>
<!-- ========== END SECONDARY CONTENTS ========== -->
