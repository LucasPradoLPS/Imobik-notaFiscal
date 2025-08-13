<div class="widget widget_contact bg-white border p-30 shadow-one rounded mb-30 quick-search">
    <div class="d-flex align-items-center mb-4">
        <div class="flex-shrink-0">
            <a class="navbar-brand" href="home/" aria-label="Space">
                <img style="width:100px" class="navbar-brand-logo" src="{$URLSYSTEM}{$CONFIG->logomarca}" alt="Image Description">
            </a>
        </div>
        <div class="flex-grow-1 ms-3">
            <h6 class="card-title">Peça-me mais informações</h6>
        </div>
    </div>

    <select name="formInfoImovelAssunto" id="formInfoImovelAssunto" class="form-select mb-2">
        <option value="1">Quero mais informações</option>
        <option value="2">Quero agendar uma visita</option>
    </select>
    <div class="mb-2">
        <label for="fullNamePropertyOverviewContactForm" class="form-label visually-hidden">Nome Completo</label>
        <input name="formInfoImovelNome" type="text" class="form-control" id="formInfoImovelNome" placeholder="Nome Completo" aria-label="Nome Completo">
    </div>
    <div class="mb-2">
        <label for="emailPropertyOverviewContactForm" class="form-label visually-hidden">Email</label>
        <input name="formInfoImovelEmail" type="email" class="form-control" id="formInfoImovelEmail" placeholder="Email" aria-label="Email">
    </div>
    <div class="mb-2">
        <label for="phoneNumberPropertyOverviewContactForm" class="form-label visually-hidden">Telefone</label>
        <input name="formInfoImovelFone" type="tel" class="js-input-mask form-control" id="formInfoImovelFone" placeholder="(xx)xxxxx-xxxx">
    </div>
    <div class="mb-2">
        <label for="questionPropertyOverviewContactForm" class="form-label visually-hidden">Mensasgem</label>
        <textarea name="formInfoImovelMensagem" class="form-control" id="formInfoImovelMensagem" placeholder="Eu gostaria de..." aria-label="Eu gostaria de..." rows="4"></textarea>
    </div>
    <div class="mb-2" id="div_captcha_info">
        <div class="g-recaptcha mt-2" data-sitekey="{$SITE->sitekeyemail}"></div>    
    </div>
    <div class="d-grid mb-2">
        <button type="button" class="btn btn-primary" onclick="js_ValidaInfoImovelForm()">Solicitar informações</button>
    </div>
    {if $IMOVELSHOW->proposta == true}
        <div class="d-grid">
            <a id="abreProposta" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#propostaModal">Fazer Proposta</a>
        </div>
    {/if}
</div>
<!-- ========== SECONDARY CONTENTS ========== -->
<a style="display:none" id="idInfoImovelModal" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#infoimovelModal">Modal</a>
<div class="modal fade" id="infoimovelModal" tabindex="-1" aria-labelledby="contatoModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="border border-1 rounded shadow-sm p-3 bg-light text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h3 class="modal-title" id="infoimovelModalLabel">Enviando sua mensagem...aguarde</h3>
      </div>
    </div>
  </div>
</div>
