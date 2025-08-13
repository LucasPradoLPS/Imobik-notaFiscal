<div class="widget widget_send_message mb-30">
    <h6 class="mb-4">Peça-me mais informações</h6>
    <div class="form-row quick-search">
        <div class="col-12 mb-10">
            <input name="formCorretorDestinatarioEmail" type="hidden" class="form-control exclude" id="formCorretorDestinatarioEmail" value="{$VIEWCORRETOR->email}">
            <input name="formCorretorDestinatarioNome" type="hidden" class="form-control exclude" id="formCorretorDestinatarioNome" value="{$VIEWCORRETOR->pessoa|lower|ucwords}">
            <label for="fullNamePropertyOverviewContactForm" class="form-label text-muted">Informe como quer ser contatado</label>
            <select name="formCorretorAssunto" id="formCorretorAssunto" class="form-select mb-2 exclude">
                <option value=""></option>
                <option value="1">Por Email</option>
                <option value="2" selected>Por Telefone/Whatsapp</option>
            </select>
        </div>
        <div class="col-12 mb-10">
            <label for="fullNamePropertyOverviewContactForm" class="form-label visually-hidden">Nome Completo</label>
            <input name="formCorretorNome" type="text" class="form-control exclude" id="formCorretorNome" placeholder="Nome Completo" aria-label="Nome Completo">
        </div>
        <div class="col-12 mb-10">
            <label for="emailPropertyOverviewContactForm" class="form-label visually-hidden">Email</label>
            <input name="formCorretorEmail" type="email" class="form-control exclude" id="formCorretorEmail" placeholder="Email" aria-label="Email">
        </div>
        <div class="col-12 mb-10">
            <label for="phoneNumberPropertyOverviewContactForm" class="form-label visually-hidden">Telefone</label>
            <input name="formCorretorFone" type="tel" class="js-input-mask form-control exclude" id="formCorretorFone" placeholder="(xx)xxxxx-xxxx">
        </div>
        <div class="col-12 mb-10">
            <label for="questionPropertyOverviewContactForm" class="form-label visually-hidden">Mensasgem</label>
            <textarea name="formCorretorMensagem" class="form-control exclude" id="formCorretorMensagem" placeholder="Eu gostaria de..." aria-label="Eu gostaria de..." rows="4"></textarea>
        </div>
        <div class="col-12 mb-10">
            <div class="g-recaptcha mt-2 exclude" data-sitekey="{$SITE->sitekeyemail}"></div>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="js_ValidaCorretorForm()">Solicitar informações</button>
        </div>
    </div>
</div>
<!-- ========== SECONDARY CONTENTS ========== -->
<a style="display:none" id="idCorretorModal" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#corretorModal">Modal</a>
<div class="modal fade" id="corretorModal" tabindex="-1" aria-labelledby="contatoModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="border border-1 rounded shadow-sm p-3 bg-light text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h3 class="modal-title" id="corretorModalLabel">Enviando sua mensagem...aguarde</h3>
      </div>
    </div>
  </div>
</div>
