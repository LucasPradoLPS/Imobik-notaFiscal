{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate2.tpl"}
<form name="form_imvgeral" id="form_imvgeral" method="POST">
<div class="full-row bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="text-secondary">Anuncie seu imóvel</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="home/">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Anuncie seu imóvel</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="full-row px-40 py-30 xs-p-0 bg-light">
    <br>
    <div class="container">
        <div class="row">
            <div class="col mb-30">
                <div class="border rounded bg-white p-30">
                    <div class="container content-space-2">
                        <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
                            <h2>Venda e alugue o seu imóvel<br>sem complicações</h2>
                            <span class="text-cap">Conte com a gente para te ajudar a fazer o melhor negócio</span>
                        </div>
                        <ul class="step step-md step-centered step-icon-lg">
                            <li class="step-item">
                            <div class="step-content-wrapper">
                                <span class="step-icon step-icon-soft-primary"><i class="fa-solid fa-list text-primary" style="font-size:40px"></i></span>
                                <div class="step-content">
                                <h3>Pré-cadastro do imóvel</h3>
                                <p>Utilize o formulário abaixo para preencher os seus dados e as informações do seu imóvel.</p>
                                </div>
                            </div>
                            </li>
                            <li class="step-item">
                            <div class="step-content-wrapper">
                                <span class="step-icon step-icon-soft-primary"><i class="fa-solid fa-phone-volume text-primary" style="font-size:40px"></i></span>
                                <div class="step-content">
                                <h3>Nós entramos em cena</h3>
                                <p>Receberemos suas informações em nosso email e entraremos em contato com você.</p>
                                </div>
                            </div>
                            </li>
                            <li class="step-item">
                            <div class="step-content-wrapper">
                                <span class="step-icon step-icon-soft-primary"><i class="fa-solid fa-check-to-slot text-primary" style="font-size:40px"></i></i></span>
                                <div class="step-content">
                                <h3>Imóvel cadastrado</h3>
                                <p>Após firmarmos o acordo, seu imóvel já estará disponível em nosso site.</p>
                                </div>
                            </div>
                            </li>
                        </ul>
                    </div>                
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col mb-30">
                <div class="border rounded bg-white p-30 quick-search">
                    <h4 class="my-7">Informações do anunciante</h4>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioNome">Nome Completo</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-user text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioNome" id="formAnuncioNome" placeholder="Nome Completo" aria-label="Nome Completo">
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="id="formAnuncioFone">Telefone</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-phone text-primary"></i>
                            </span>
                            <input type="text" class="js-input-mask form-control form-control-lg" name="formAnuncioFone" id="formAnuncioFone" placeholder="(xx)xxxxx-xxxx" aria-label="(xx)xxxxx-xxxx">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioEmail">Email</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-envelope text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioEmail" id="formAnuncioEmail" placeholder="email@site.com" aria-label="email@site.com">
                            </div>
                        </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col mb-30">
                <div class="border rounded bg-white p-30">
                    <h4 class="my-7">Tipo do Imóvel</h4>
                    <br>
                    <div class="row gx-3">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="form-check form-check-card text-center">
                                <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo1" value="1" checked>
                                <label class="form-check-label" for="formAnuncioTipo1">
                                <i class="fa-solid fa-house-chimney text-primary" style="font-size:80px;"></i>
                                <span class="d-block">Casa</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="form-check form-check-card text-center">
                                <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo2" value="2">
                                <label class="form-check-label" for="formAnuncioTipo2">
                                <i class="fa-solid fa-building text-primary" style="font-size:80px;"></i>
                                <span class="d-block">Apartamento</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="form-check form-check-card text-center">
                                <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo3" value="3">
                                <label class="form-check-label" for="formAnuncioTipo3">
                                <i class="fa-solid fa-tractor text-primary" style="font-size:80px;"></i>
                                <span class="d-block">Rural</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                        <div class="form-check form-check-card text-center">
                            <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo4" value="4">
                            <label class="form-check-label" for="formAnuncioTipo4">
                            <i class="fa-solid fa-mountain-sun text-primary" style="font-size:80px;"></i>
                            <span class="d-block">Outros</span>
                            </label>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col mb-30">
                <div class="border rounded bg-white p-30 quick-search">
                    <h4 class="my-7">Finalidade</h4>
                    <br>
                    <label class="form-label" for="formAnuncioSituacao">
                        Informe o tipo de transação
                    </label>
                    <div class="row gx-3">
                        <select id="formAnuncioSituacao" name="formAnuncioSituacao" class="form-select" onchange="js_SetaInputValores(this.value)">
                        <option value="" {$OPCAO.0}>Escolha a sua opção</option>
                        <option class="{$HIDDENLOCACAO}" value="L" {$OPCAO.L}>Locação</option>
                        <option class="{$HIDDENVENDA}" value="V" {$OPCAO.V}>Venda</option>
                        <option class="{$HIDDENLOCACAO} {$HIDDENVENDA}" value="LV" {$OPCAO.LV}>Locação e Venda</option>
                        </select>
                    </div>
                    <br><br>
                    <h4 class="my-7">Informações do Imóvel</h4>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 {$HIDDENLOCACAO}" id="divLocacao">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioLocacao">Valor Locação</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-dollar-sign text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioLocacao" id="formAnuncioLocacao" placeholder="Valor Locação" aria-label="Valor Locação">
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6 {$HIDDENVENDA}" id="divVenda">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioVenda">Valor para Venda</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-dollar-sign text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioVenda" id="formAnuncioVenda" placeholder="Valor para Venda" aria-label="Valor para Venda">
                            </div>
                        </div>
                        </div>
                        {if $OPCAO.L == "selected"}
                        <script>
                            document.getElementById("divLocacao").style.display = "block";
                            document.getElementById("divVenda").style.display = "none";
                        </script>
                        {/if}
                        {if $OPCAO.V == "selected"}
                        <script>
                            document.getElementById("divLocacao").style.display = "none";
                            document.getElementById("divVenda").style.display = "block";
                        </script>
                        {/if}
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioEndereco">Endereço</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-location-dot text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioEndereco" id="formAnuncioEndereco" placeholder="Logradouro e número" aria-label="Logradouro e número">
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioBairro">Bairro</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-building text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioBairro" id="formAnuncioBairro" placeholder="Bairro" aria-label="Bairro">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioCidade">Cidade</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-city text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioCidade" id="formAnuncioCidade" placeholder="Cidade" aria-label="Cidade">
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="id="formAnuncioCep">CEP</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-envelope-open text-primary"></i>
                            </span>
                            <input type="text" class="js-input-mask form-control form-control-lg" name="formAnuncioCep" id="formAnuncioCep" placeholder="xxxxx-xxx" aria-label="xxxxx-xxx">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioQuarto">Quartos</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-bed text-primary"></i>
                            </span>
                            <select name="formAnuncioQuarto" id="formAnuncioQuarto" class="form-select">
                                <option value="" selected>Selecione a quantidade</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5+</option>
                            </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioBanheiro">Banheiros</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-bath text-primary"></i>
                            </span>
                            <select name="formAnuncioBanheiro" id="formAnuncioBanheiro" class="form-select">
                                <option value=""selected>Selecione a quantidade</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5+</option>
                            </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioVaga">Vagas</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-car text-primary"></i>
                            </span>
                            <select name="formAnuncioVaga" id="formAnuncioVaga" class="form-select">
                                <option value="" selected>Selecione a quantidade</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5+</option>
                            </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="formAnuncioArea">Área m²</label>
                            <div class="input-group input-group-merge">
                            <span class="input-group-prepend input-group-text">
                                <i class="fa-solid fa-ruler-combined text-primary"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="formAnuncioArea" id="formAnuncioArea" placeholder="Área m²" aria-label="Área m²">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Descrição</label>
                        <textarea name="formAnuncioMensagem" class="form-control" id="formAnuncioMensagem" placeholder="Descreva seu imóvel aqui..." aria-label="Descreva seu imóvel aqui..." rows="4"></textarea>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col mb-30">
                <div class="border rounded bg-white p-30">
                    <div class="mb-5">
                        <h4 class="my-7">Upload de Imagens</h4>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                            <label class="form-label">Imagens do Imóvel (Máximo de 10 imagens)</label>
                            <div id="imageDropzone" class="js-dropzone dz-dropzone dz-dropzone-card">
                                <div class="dz-message">
                                <i class="fa-solid fa-upload text-primary" style="font-size:50px;"></i>
                                <span class="d-block">Busque no seu dispositivo e faça upload de suas imagens</span>
                                <span class="d-block text-muted small">Maximo de 10 imagens</span>
                                <span class="d-block text-muted small">Tamanho Maximo de 2MB por cada imagem</span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="g-recaptcha mt-2" data-sitekey="{$SITE->sitekeyemail}"></div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" id="submit-all" class="btn btn-primary btn-lg">Enviar Anúncio</button>
                        <a style="visibility:hidden" id="idModal" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#anuncioModal">Modal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>        
</form>
<!-- ========== SECONDARY CONTENTS ========== -->
<div class="modal fade" id="anuncioModal" tabindex="-1" aria-labelledby="anuncioModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="border border-1 rounded shadow-sm p-3 bg-light text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h3 class="modal-title" id="anuncioModalLabel">Enviando seu anúncio...aguarde</h3>
        </div>
    </div>
    </div>
</div>
{include file="footer.tpl"}
{include file="scripts.tpl"}
