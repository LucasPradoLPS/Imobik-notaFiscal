{include file="header.tpl"}
<main id="content" role="main">
  <form name="form_imvgeral" id="form_imvgeral" method="POST">
    <div class="container content-space-t-1 content-space-t-lg-2 content-space-b-2">
      <div class="row">
        <div class="col-lg-4 mb-9 mb-lg-5">
        </div>
        <div class="col-lg-4 mb-9 mb-lg-5">
          <img class="card-img-bottom" src="assets/v1/img/illustrations/click.png" alt="Image Description">
        </div>
        <div class="col-lg-4 mb-9 mb-lg-5">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 mb-9 mb-lg-0">
          <div class="mb-5">
            <h1>Entre em contato</h1>
            <p>Adoraríamos saber como podemos ajudá-lo.</p>
          </div>
          <div class="row mb-5">
           {$SITE->iframe}
          </div>
          <div class="row">
            <div class="col-sm-6">
              <h5 class="mb-1">Telefone:</h5>
              <p><a class="link-sm link-secondary dz-dropzone" onclick="location.href='tel:{$SITE->telefone}'"><i class="bi-telephone-inbound-fill me-2"></i>{$SITE->telefone}</a></p>
            </div>
            <div class="col-sm-6">
              <h5 class="mb-1">Whatsapp:</h5>
              <p><a class="link-sm link-secondary dz-dropzone" onclick="location.href='https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1'"><i class="bi-whatsapp me-1"></i>{$SITE->whatsapp}</a></p>
            </div>
            <div class="col-sm-6">
              <h5 class="mb-1">Endereço:</h5>
              <p><i class="bi-geo-alt-fill me-1"></i>{$SITE->endereco}</p>
            </div>
            <div class="col-sm-6">
              <h5 class="mb-1">Email:</h5>
              <p><a class="link-sm link-secondary dz-dropzone" onclick="location.href='mailto:{$CONFIG->email}'"><i class="bi-envelope-fill me-2"></i>{$CONFIG->email}</a></p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="ps-lg-5">
            <div class="card">
              <div class="card-header border-bottom text-center">
                <h3 class="card-header-title">Informe seus dados e<br>mande-nos sua mensagem</h3>
              </div>
              <div class="card-body">
                <form>
                  <div class="row gx-3">
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label class="form-label" for="formNome">Nome Completo</label>
                        <input type="text" class="form-control form-control-lg" name="formContatoNome" id="formContatoNome" placeholder="Nome Completo" aria-label="Nome Completo">
                      </div>
                    </div>
                  </div>
                  <div class="row gx-3">
                    <div class="col-sm-6">
                      <div class="mb-3">
                        <label class="form-label" for="formEmail">Email</label>
                        <input type="email" class="form-control form-control-lg" name="formContatoEmail" id="formContatoEmail" placeholder="email@site.com" aria-label="email@site.com">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="mb-3">
                        <label class="form-label" for="formFone">Telefone</span></label>
                        <input name="formContatoFone" type="tel" class="js-input-mask form-control form-control-lg" id="formContatoFone" placeholder="(xx)xxxxx-xxxx"
                        data-hs-mask-options='{
                        "mask": "(00)00000-0000"
                        }'>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="formMensagem">Mensagem</label>
                    <textarea class="form-control form-control-lg" name="formContatoMensagem" id="formContatoMensagem" placeholder="Conte-nos sobre..." aria-label="Conte-nos sobre..." rows="4"></textarea>
                  </div>
                  <script src='https://www.google.com/recaptcha/api.js'></script>
                  <div class="mb-2">
                    <div class="g-recaptcha mt-2" data-sitekey="{$SITE->sitekeyemail}"></div>
                  </div>
                  <div class="d-grid">
                    <button type="button" class="btn btn-primary" onclick="js_ValidaContatoForm()">Enviar</button>
                  </div>
                  <div class="text-center">
                    <p class="form-text">Em breve entraremos em contato.</p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ========== SECONDARY CONTENTS ========== -->
    <a style="visibility:hidden" id="idContatoModal" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#contatoModal">Modal</a>
    <div class="modal fade" id="contatoModal" tabindex="-1" aria-labelledby="contatoModalLabel" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="border border-1 rounded shadow-sm p-3 bg-light text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <h3 class="modal-title" id="contatoModalLabel">Enviando sua mensagem...aguarde</h3>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>
{include file="footer.tpl"}
{include file="scripts.tpl"}
<script>
js_RolaTela(".ps-lg-5");
</script>
