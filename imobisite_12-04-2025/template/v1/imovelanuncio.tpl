{include file="header.tpl"}
<main id="content" role="main">
  <form name="form_imvgeral" id="form_imvgeral" method="POST">
    <div class="container content-space-2">
      <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
        <h2>Venda e alugue o seu imóvel<br>sem complicações</h2>
        <span class="text-cap">Conte com a gente para te ajudar a fazer o melhor negócio</span>
      </div>
      <ul class="step step-md step-centered step-icon-lg">
        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-primary"><i class="bi-ui-checks text-primary" style="font-size:40px"></i></span>
            <div class="step-content">
              <h3>Pré-cadastro do imóvel</h3>
              <p>Utilize o formulário abaixo para preencher os seus dados e as informações do seu imóvel.</p>
            </div>
          </div>
        </li>
        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-primary"><i class="bi-telephone-inbound-fill text-primary" style="font-size:40px"></i></span>
            <div class="step-content">
              <h3>Nós entramos em cena</h3>
              <p>Receberemos suas informações em nosso email e entraremos em contato com você.</p>
            </div>
          </div>
        </li>
        <li class="step-item">
          <div class="step-content-wrapper">
            <span class="step-icon step-icon-soft-primary"><i class="bi bi-check-square-fill text-primary" style="font-size:40px"></i></i></span>
            <div class="step-content">
              <h3>Imóvel cadastrado</h3>
              <p>Após firmarmos o acordo, seu imóvel já estará disponível em nosso site.</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="container ">
      <div class="w-lg-80 mx-lg-auto">
        <div class="mb-5">
          <h4 class="my-7">Informações do anunciante</h4>
          <div class="row">
            <div class="col-sm-6">
              <div class="mb-4">
                <label class="form-label" for="formAnuncioNome">Nome Completo</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-prepend input-group-text">
                    <i class="bi-person-fill"></i>
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
                    <i class="bi-telephone-inbound-fill"></i>
                  </span>
                  <input type="text" class="js-input-mask form-control form-control-lg" name="formAnuncioFone" id="formAnuncioFone" placeholder="(xx)xxxxx-xxxx" aria-label="(xx)xxxxx-xxxx" data-hs-mask-options='{literal}{"mask": "(00)00000-0000"}{/literal}'>
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
                    <i class="bi-briefcase-fill"></i>
                  </span>
                  <input type="text" class="form-control form-control-lg" name="formAnuncioEmail" id="formAnuncioEmail" placeholder="email@site.com" aria-label="email@site.com">
                </div>
              </div>
            </div>
          </div>
          <h4 class="my-7">Tipo do Imóvel</h4>
          <div class="row gx-3">
            <div class="col-6 col-md-3 mb-3">
              <div class="form-check form-check-card text-center">
                <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo1" value="1" checked>
                <label class="form-check-label" for="formAnuncioTipo1">
                  <img class="w-50 mb-3" src="assets/v1/svg/illustrations/small-house.svg" alt="SVG">
                  <span class="d-block">Casa</span>
                </label>
              </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
              <div class="form-check form-check-card text-center">
                <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo2" value="2">
                <label class="form-check-label" for="formAnuncioTipo2">
                  <img class="w-50 mb-3" src="assets/v1/svg/illustrations/flat-house.svg" alt="SVG">
                  <span class="d-block">Apartamento</span>
                </label>
              </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
              <div class="form-check form-check-card text-center">
                <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo3" value="3">
                <label class="form-check-label" for="formAnuncioTipo3">
                  <img class="w-50 mb-3" src="assets/v1/svg/illustrations/farm-land.svg" alt="SVG">
                  <span class="d-block">Rural</span>
                </label>
              </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
              <div class="form-check form-check-card text-center">
                <input class="form-check-input" type="radio" name="formAnuncioTipo" id="formAnuncioTipo4" value="4">
                <label class="form-check-label" for="formAnuncioTipo4">
                  <img class="w-50 mb-3" src="assets/v1/svg/illustrations/multi-family-house.svg" alt="SVG">
                  <span class="d-block">Outros</span>
                </label>
              </div>
            </div>
          </div>
          <h4 class="my-7">Finalidade</h4>
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
          <h4 class="my-7">Informações do Imóvel</h4>
          <div class="row">
            <div class="col-sm-6 {$HIDDENLOCACAO}" id="divLocacao">
              <div class="mb-4">
                <label class="form-label" for="formAnuncioLocacao">Valor Locação</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-prepend input-group-text">
                    <span class="svg-icon svg-icon-xs svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 288 512"><path d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"/></svg>
                    </span>
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
                    <span class="svg-icon svg-icon-xs svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 288 512"><path d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"/></svg>
                    </span>
                  </span>
                  <input type="text" class="form-control form-control-lg" name="formAnuncioVenda" id="formAnuncioVenda" placeholder="Valor para Venda" aria-label="Valor para Venda">
                </div>
              </div>
            </div>
            {if $OPCAO.L == "selected"}
              <script>
                $("#divLocacao").css("display","block");
                $("#divVenda").css("display","none");
              </script>
            {/if}
            {if $OPCAO.V == "selected"}
              <script>
                $("#divLocacao").css("display","none");
                $("#divVenda").css("display","block");
              </script>
            {/if}
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="mb-4">
                <label class="form-label" for="formAnuncioEndereco">Endereço</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-prepend input-group-text">
                    <i class="bi-geo-alt-fill"></i>
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
                    <i class="bi-building"></i>
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
                    <i class="bi-building"></i>
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
                    <i class="bi-envelope-open-fill"></i>
                  </span>
                  <input type="text" class="js-input-mask form-control form-control-lg" name="formAnuncioCep" id="formAnuncioCep" placeholder="xxxxx-xxx" aria-label="xxxxx-xxx" data-hs-mask-options='{literal}{"mask": "00000-000"}{/literal}'>
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
                    <span class="svg-icon svg-icon-xs svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 512"><path d="M176 256c44.11 0 80-35.89 80-80s-35.89-80-80-80-80 35.89-80 80 35.89 80 80 80zm352-128H304c-8.84 0-16 7.16-16 16v144H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v352c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16v-48h512v48c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V240c0-61.86-50.14-112-112-112z"/></svg>
                    </span>
                  </span>
                  <select name="formAnuncioQuarto" id="formAnuncioQuarto" class="form-select form-select-lg">
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
                    <span class="svg-icon svg-icon-xs svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512"><path d="M304,320a16,16,0,1,0,16,16A16,16,0,0,0,304,320Zm32-96a16,16,0,1,0,16,16A16,16,0,0,0,336,224Zm32,64a16,16,0,1,0-16-16A16,16,0,0,0,368,288Zm-32,32a16,16,0,1,0-16-16A16,16,0,0,0,336,320Zm-32-64a16,16,0,1,0,16,16A16,16,0,0,0,304,256Zm128-32a16,16,0,1,0-16-16A16,16,0,0,0,432,224Zm-48,16a16,16,0,1,0,16-16A16,16,0,0,0,384,240Zm-16-48a16,16,0,1,0,16,16A16,16,0,0,0,368,192Zm96,32a16,16,0,1,0,16,16A16,16,0,0,0,464,224Zm32-32a16,16,0,1,0,16,16A16,16,0,0,0,496,192Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,432,256Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,400,288Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,336,352Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,304,384Zm64-64a16,16,0,1,0,16,16A16,16,0,0,0,368,320Zm21.65-218.35-11.3-11.31a16,16,0,0,0-22.63,0L350.05,96A111.19,111.19,0,0,0,272,64c-19.24,0-37.08,5.3-52.9,13.85l-10-10A121.72,121.72,0,0,0,123.44,32C55.49,31.5,0,92.91,0,160.85V464a16,16,0,0,0,16,16H48a16,16,0,0,0,16-16V158.4c0-30.15,21-58.2,51-61.93a58.38,58.38,0,0,1,48.93,16.67l10,10C165.3,138.92,160,156.76,160,176a111.23,111.23,0,0,0,32,78.05l-5.66,5.67a16,16,0,0,0,0,22.62l11.3,11.31a16,16,0,0,0,22.63,0L389.65,124.28A16,16,0,0,0,389.65,101.65Z"/></svg>
                    </span>
                  </span>
                  <select name="formAnuncioBanheiro" id="formAnuncioBanheiro" class="form-select form-select-lg">
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
                    <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 28 28"><path d="M23.5 7c.276 0 .5.224.5.5v.511c0 .793-.926.989-1.616.989l-1.086-2h2.202zm-1.441 3.506c.639 1.186.946 2.252.946 3.666 0 1.37-.397 2.533-1.005 3.981v1.847c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1h-13v1c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1.847c-.608-1.448-1.005-2.611-1.005-3.981 0-1.414.307-2.48.946-3.666.829-1.537 1.851-3.453 2.93-5.252.828-1.382 1.262-1.707 2.278-1.889 1.532-.275 2.918-.365 4.851-.365s3.319.09 4.851.365c1.016.182 1.45.507 2.278 1.889 1.079 1.799 2.101 3.715 2.93 5.252zm-16.059 2.994c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm10 1c0-.276-.224-.5-.5-.5h-7c-.276 0-.5.224-.5.5s.224.5.5.5h7c.276 0 .5-.224.5-.5zm2.941-5.527s-.74-1.826-1.631-3.142c-.202-.298-.515-.502-.869-.566-1.511-.272-2.835-.359-4.441-.359s-2.93.087-4.441.359c-.354.063-.667.267-.869.566-.891 1.315-1.631 3.142-1.631 3.142 1.64.313 4.309.497 6.941.497s5.301-.184 6.941-.497zm2.059 4.527c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm-18.298-6.5h-2.202c-.276 0-.5.224-.5.5v.511c0 .793.926.989 1.616.989l1.086-2z"/></svg>
                    </span>
                  </span>
                  <select name="formAnuncioVaga" id="formAnuncioVaga" class="form-select form-select-lg">
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
                    <i class="bi-rulers"></i>
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
          <h4 class="my-7">Upload de Imagens</h4>
          <div class="row">
            <div class="col-lg-12 mb-3">
              <label class="form-label">Imagens do Imóvel (Máximo de 10 imagens)</label>
              <div id="imageDropzone" class="js-dropzone dz-dropzone dz-dropzone-card">
                <div class="dz-message">
                  <img class="avatar mb-3" src="assets/v1/svg/illustrations/add-file.svg" alt="SVG">
                  <span class="d-block">Busque no seu dispositivo e faça upload de suas imagens</span>
                  <span class="d-block text-muted small">Maximo de 10 imagens</span>
                  <span class="d-block text-muted small">Tamanho Maximo de 2MB por cada imagem</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <div class="mb-2">
          <div class="g-recaptcha mt-2" data-sitekey="{$SITE->sitekeyemail}"></div>
        </div>
        <div class="d-grid">
          <button type="submit" id="submit-all" class="btn btn-primary btn-lg">Enviar Anúncio</button>
          <a style="visibility:hidden" id="idModal" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#anuncioModal">Modal</a>
        </div>
      </div>
    </div>
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
  </form>
  <br>
  <br>
</main>
{include file="footer.tpl"}
{include file="scripts.tpl"}
