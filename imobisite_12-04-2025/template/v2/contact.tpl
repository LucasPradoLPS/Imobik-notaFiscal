{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate2.tpl"}
<form name="form_imvgeral" id="form_imvgeral" method="POST">
<div class="full-row bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="text-secondary">Contato</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="home/">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Contato</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="full-row pt-30 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 mb-30">
                <div class="border rounded bg-white p-30 text-center">
                    <img class="card-img-bottom" src="assets/v1/img/illustrations/click.png" alt="Image Description" style="width:30%">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 order-xl-1">
                <div class="border rounded bg-white p-30">
                    <div class="mb-1">
                        <h5>Entre em contato</h5>
                        <p>Adoraríamos saber como podemos ajudá-lo.</p>
                    </div>
                    <div class="row mb-5">
                        {if $SITE->iframe|strpos:"iframe"}
                            {$SITE->iframe}
                        {elseif $SITE->iframe|strpos:"@"}
                            {$arrayCoordenadas = '@'|explode:$SITE->iframe}
                            <iframe 
                                width="100%"
                                height="370"
                                src="//maps.google.com/maps?q={$arrayCoordenadas[0]},{$arrayCoordenadas[1]}+('aaaaaaaaaa')&z=14&output=embed">
                            </iframe>
                        {/if}
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="mb-1">Telefone:</h5>
                            <p><a class="link-sm link-secondary dz-dropzone" onclick="location.href='tel:{$SITE->telefone}'"><i class="fa-solid fa-phone text-primary me-2"></i>{$SITE->telefone}</a></p>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="mb-1">Whatsapp:</h5>
                            <p><a class="link-sm link-secondary dz-dropzone" onclick="location.href='https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1'"><i class="fa-brands fa-whatsapp text-primary me-2"></i>{$SITE->whatsapp}</a></p>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="mb-1">Endereço:</h5>
                            <p><i class="fa-solid fa-location-dot text-primary me-2"></i>{$SITE->endereco}</p>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="mb-1">Email:</h5>
                            <p><a class="link-sm link-secondary dz-dropzone" onclick="location.href='mailto:{$CONFIG->email}'"><i class="fa-solid fa-envelope text-primary me-2"></i>{$CONFIG->email}</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 order-xl-2">
                <div class="border rounded bg-white p-30 quick-search">
                    <h5 class="card-header-title">Informe seus dados e mande-nos sua mensagem</h5>
                    <div class="card-body">
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
                                    <input name="formContatoFone" type="tel" class="js-input-mask form-control form-control-lg" id="formContatoFone" placeholder="(xx)xxxxx-xxxx">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="formMensagem">Mensagem</label>
                            <textarea class="form-control form-control-lg" name="formContatoMensagem" id="formContatoMensagem" placeholder="Conte-nos sobre..." aria-label="Conte-nos sobre..." rows="4"></textarea>
                        </div>
                        <div class="mb-2">
                            <div class="g-recaptcha mt-2" data-sitekey="{$SITE->sitekeyemail}"></div>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" onclick="js_ValidaContatoForm()">Enviar</button>
                        </div>
                        <div class="text-center">
                            <p class="form-text">Em breve entraremos em contato.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== SECONDARY CONTENTS ========== -->
<a style="display:none" id="idContatoModal" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#contatoModal">Modal</a>
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

{include file="footer.tpl"}
{include file="scripts.tpl"}
