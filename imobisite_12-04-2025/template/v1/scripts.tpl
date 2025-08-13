{if !isset($TOTALLANCAMENTO)}
 {$TOTALLANCAMENTO = 0}
{/if}
<script src="assets/v1/vendor/swiper/swiper-bundle.js"></script>

<script src="assets/v1/vendor/fslightbox/index.js"></script>
<script src="assets/v1/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/v1/vendor/leaflet/dist/leaflet.js"></script>
<script src="assets/v1/js/ajaxupload.js"></script>
<script src="assets/v1/vendor/fancybox/jquery.fancybox.min.js"></script>
<script>

function js_aceitaCookie(){

  var sUrl    = 'sAction=TRUE';
  var sFile   = 'ajaxcookie.php';
  {literal}jQuery.ajax({type:'post',url:sFile,data:sUrl,dataType:'html',success:function(data){js_retornoAceitaCookie(data);}}){/literal};

}

function js_retornoAceitaCookie(retorno){}

function js_MenuDirecionaFooter(code,code2){

  document.getElementById('form_headergeral').reset();
  document.form_headergeral.situacaoImv.value = code;
  document.form_headergeral.zonaImv.value = code2;
  if(code=="1,5"){
    document.getElementById('form_headergeral').action = 'grid-busca-imoveis/locacao/';
  }else if(code=="3,5"){
    document.getElementById('form_headergeral').action = 'grid-busca-imoveis/venda/';
  }else{
    document.getElementById('form_headergeral').action = 'grid-busca-imoveis/geral/';
  }
  document.getElementById('form_headergeral').submit();
  
}

function js_MenuDireciona(code){

  document.getElementById('form_headergeral').reset();
  document.form_headergeral.situacaoImv.value = code;
  if(code=="1,5"){
    document.getElementById('form_headergeral').action = 'grid-busca-imoveis/locacao/';
  }else if(code=="3,5"){
    document.getElementById('form_headergeral').action = 'grid-busca-imoveis/venda/';
  }else{
    document.getElementById('form_headergeral').action = 'grid-busca-imoveis/geral/';
  }
  document.getElementById('form_headergeral').submit();
}


(function() {

  // INITIALIZATION OF SWIPER
  // =======================================================
  var sliderThumbs = new Swiper('.js-swiper-shop-hero-thumbs', {
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    history: false,
    slidesPerView: {$TOTALLANCAMENTO},
    spaceBetween: 10,
    on: {
      beforeInit: (swiper) => {
        const css = `.swiper-slide-thumb-active .swiper-thumb-progress .swiper-thumb-progress-path {
              opacity: 1;
              -webkit-animation: 5000ms linear 0ms forwards swiperThumbProgressDash;
              animation: 5000ms linear 0ms forwards swiperThumbProgressDash;
          }`
          style = document.createElement('style')
        document.head.appendChild(style)
        style.type = 'text/css'
        style.appendChild(document.createTextNode(css));

        swiper.el.querySelectorAll('.js-swiper-thumb-progress')
        .forEach(slide => {
          slide.insertAdjacentHTML('beforeend', '<span class="swiper-thumb-progress"><svg version="1.1" viewBox="0 0 160 160"><path class="swiper-thumb-progress-path" d="M 79.98452083651917 4.000001576345426 A 76 76 0 1 1 79.89443752470656 4.0000733121155605 Z"></path></svg></span>')
        })
      },
    },
  });

  var swiper = new Swiper('.js-swiper-shop-classic-hero',{
    autoplay: true,
    loop: false,
    navigation: {
      nextEl: '.js-swiper-shop-classic-hero-button-next',
      prevEl: '.js-swiper-shop-classic-hero-button-prev',
    },
    thumbs: {
      swiper: sliderThumbs
    }
  });

  // INITIALIZATION OF MEGA MENU
  // =======================================================
  new HSMegaMenu('.js-mega-menu', {
      desktop: {
        position: 'left'
      }
    })

  // INITIALIZATION OF BOOTSTRAP VALIDATION
  // =======================================================
  HSBsValidation.init('.js-validate', {
    onSubmit: data => {
      data.event.preventDefault()
      alert('Submited')
    }
  })

  // INITIALIZATION OF BOOTSTRAP DROPDOWN
  // =======================================================
  HSBsDropdown.init()

  // INITIALIZATION OF GO TO
  // =======================================================
  new HSGoTo('.js-go-to')

  // INITIALIZATION OF TEXT ANIMATION (TYPING)
  // =======================================================
  HSCore.components.HSTyped.init('.js-typedjs')

  // INITIALIZATION OF INPUT MASK
  // =======================================================
  HSCore.components.HSMask.init('.js-input-mask')

  // INITIALIZATION OF STICKY BLOCKS
  // =======================================================
  new HSStickyBlock('.js-sticky-block', {
    targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
  })

  // INITIALIZATION OF NAV SCROLLER
  // =======================================================
  new HsNavScroller('.js-nav-scroller')

  // INITIALIZATION OF FILE ATTACH
  // =======================================================
  new HSFileAttach('.js-file-attach')

  // INITIALIZATION OF COUNT CHARACTERS
  // =======================================================
  new HSCountCharacters('.js-count-characters')

  // INITIALIZATION OF QUILLJS EDITOR
  // =======================================================
  HSCore.components.HSQuill.init('.js-quill')

  // INITIALIZATION OF SELECT
  // =======================================================
  HSCore.components.HSTomSelect.init('.js-select')

  // INITIALIZATION OF LIVE TOAST
  // =======================================================
  if(document.querySelector('#liveToast')){
    const liveToast = new bootstrap.Toast(document.querySelector('#liveToast'))
    document.querySelector('#liveToastBtn').addEventListener('click', () => liveToast.show())
  }

  /*
  // INITIALIZATION OF LEAFLET
  // =======================================================
  const leaflet = HSCore.components.HSLeaflet.init(document.getElementById('mapEg3'))

  {literal}L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',{id: 'mapbox/light-v9'}).addTo(leaflet){/literal}

  // INITIALIZATION OF CHARTJS
  // =======================================================
  document.querySelectorAll('.js-chart').forEach(item => {
    HSCore.components.HSChartJS.init(item)
  })

  var rangeReady = false

  document.querySelector('#priceFilterFormDropdown').addEventListener('shown.bs.dropdown', el => {
    if (!rangeReady) {
      HSCore.components.HSNoUISlider.init('.js-nouislider')
    }

    return rangeReady = true
  })
  */

})()

function validacaoEmail(field){

  usuario = field.value.substring(0, field.value.indexOf("@"));
  dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);
  if ((usuario.length >=1) &&
    (dominio.length >=3) &&
    (usuario.search("@")==-1) &&
    (dominio.search("@")==-1) &&
    (usuario.search(" ")==-1) &&
    (dominio.search(" ")==-1) &&
    (dominio.search(".")!=-1) &&
    (dominio.indexOf(".") >=1)&&
    (dominio.lastIndexOf(".") < dominio.length - 1)) {
    return true;
  }else{
    return false;
  }

}

function js_ValidaContatoForm(form){

  if(document.form_imvgeral.formContatoNome.value==""){
    alert("Informe o Nome");
    js_RolaTela("#formContatoNome");
    document.form_imvgeral.formContatoNome.focus();
    return false;
  }
  if(document.form_imvgeral.formContatoEmail.value==""){
    alert("Informe o Email");
    js_RolaTela("#formContatoEmail");
    document.form_imvgeral.formContatoEmail.focus();
    return false;
  }
  if(validacaoEmail(document.form_imvgeral.formContatoEmail)==false){
    alert("Email Inválido");
    js_RolaTela("#formContatoEmail");
    document.form_imvgeral.formContatoEmail.focus();
    return false;
  }
  if(document.form_imvgeral.formContatoFone.value==""){
    alert("Informe o Telefone");
    js_RolaTela("#formContatoFone");
    document.form_imvgeral.formContatoFone.focus();
    return false;
  }
  if(document.form_imvgeral.formContatoMensagem.value==""){
    alert("Informe a Mensagem");
    js_RolaTela("#formContatoMensagem");
    document.form_imvgeral.formContatoMensagem.focus();
    return false;
  }
  var v = grecaptcha.getResponse();
  if(v.length == 0){
    alert("Você não pode deixar o captcha vazio");
    return false;
  }
  document.getElementById("idContatoModal").click();

  sForm = jQuery('#form_imvgeral').serialize();
  var sFile   = 'ajaxsendmail.php';
  {literal}jQuery.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaContatoForm(data);}}){/literal};

}
function js_retornoValidaContatoForm(retorno){

  alert(retorno);
  location.href = "contato/";

}
// INITIALIZATION OF DROPZONE
// =======================================================

HSCore.components.HSDropzone.init('.js-dropzone', {
    url: 'ajaxsendmail.php',
    paramName: 'imageFile',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 10,
    maxFiles: 10,
    maxFilesize: 2, //MB
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    dictInvalidFileType: 'Tipo de arquivo não permitido. Use somente imagens!',
    dictFileTooBig: '{literal}Arquivo muito grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MiB.{/literal}',
    dictRemoveFile: 'Remover',
    dictMaxFilesExceeded: "{literal}Limite de {{maxFiles}} arquivos excedido. Removendo arquivo!{/literal}",
    init: function() {
      dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

      // for Dropzone to process the queue (instead of default form behavior):
      document.getElementById("submit-all").addEventListener("click", function(e) {

        // Make sure that the form isn't actually being sent.
        e.preventDefault();
        e.stopPropagation();
        if(document.form_imvgeral.formAnuncioNome.value==""){
          alert("Informe o nome completo");
          js_RolaTela("#formAnuncioNome");
          document.form_imvgeral.formAnuncioNome.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioFone.value==""){
          alert("Informe o Telefone");
          js_RolaTela("#formAnuncioFone");
          document.form_imvgeral.formAnuncioFone.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioEmail.value==""){
          alert("Informe o Email");
          js_RolaTela("#formAnuncioEmail");
          document.form_imvgeral.formAnuncioEmail.focus();
          return false;
        }
        if(validacaoEmail(document.form_imvgeral.formAnuncioEmail)==false){
          alert("Email Inválido");
          js_RolaTela("#formAnuncioEmail");
          document.form_imvgeral.formAnuncioEmail.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioSituacao.value==""){
          alert("Informe a finalidade");
          js_RolaTela("#formAnuncioSituacao");
          document.form_imvgeral.formAnuncioSituacao.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioSituacao.value=="L"){
          if(document.form_imvgeral.formAnuncioLocacao.value=="" || parseInt(document.form_imvgeral.formAnuncioLocacao.value)=="0"){
            alert("Informe o Valor do aluguel");
            js_RolaTela("#formAnuncioLocacao");
            document.form_imvgeral.formAnuncioLocacao.focus();
            return false;
          }
        }else if(document.form_imvgeral.formAnuncioSituacao.value=="V"){
          if(document.form_imvgeral.formAnuncioVenda.value=="" || parseInt(document.form_imvgeral.formAnuncioVenda.value)=="0"){
            alert("Informe o Valor para venda");
            js_RolaTela("#formAnuncioVenda");
            document.form_imvgeral.formAnuncioVenda.focus();
            return false;
          }
        }else if(document.form_imvgeral.formAnuncioSituacao.value=="LV"){
          if(document.form_imvgeral.formAnuncioLocacao.value=="" || parseInt(document.form_imvgeral.formAnuncioLocacao.value)=="0"){
            alert("Informe o Valor do aluguel");
            js_RolaTela("#formAnuncioLocacao");
            document.form_imvgeral.formAnuncioLocacao.focus();
            return false;
          }
          if(document.form_imvgeral.formAnuncioVenda.value=="" || parseInt(document.form_imvgeral.formAnuncioVenda.value)=="0"){
            alert("Informe o Valor para venda");
            js_RolaTela("#formAnuncioVenda");
            document.form_imvgeral.formAnuncioVenda.focus();
            return false;
          }
        }

        if(document.form_imvgeral.formAnuncioEndereco.value==""){
          alert("Informe o endereço");
          js_RolaTela("#formAnuncioEndereco");
          document.form_imvgeral.formAnuncioEndereco.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioBairro.value==""){
          alert("Informe o bairro");
          js_RolaTela("#formAnuncioBairro");
          document.form_imvgeral.formAnuncioBairro.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioCidade.value==""){
          alert("Informe a cidade");
          js_RolaTela("#formAnuncioCidade");
          document.form_imvgeral.formAnuncioCidade.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioCep.value==""){
          alert("Informe o CEP");
          js_RolaTela("#formAnuncioCep");
          document.form_imvgeral.formAnuncioCep.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioQuarto.value==""){
          alert("Informe a quantidade de quartos");
          js_RolaTela("#formAnuncioQuarto");
          document.form_imvgeral.formAnuncioQuarto.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioBanheiro.value==""){
          alert("Informe a quantidade de banheiros");
          js_RolaTela("#formAnuncioBanheiro");
          document.form_imvgeral.formAnuncioBanheiro.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioVaga.value==""){
          alert("Informe a quantidade de vagas");
          js_RolaTela("#formAnuncioVaga");
          document.form_imvgeral.formAnuncioVaga.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioArea.value=="" || parseInt(document.form_imvgeral.formAnuncioArea.value)=="0"){
          alert("Informe a área");
          js_RolaTela("#formAnuncioArea");
          document.form_imvgeral.formAnuncioArea.focus();
          return false;
        }
        if(document.form_imvgeral.formAnuncioMensagem.value==""){
          alert("Informe a descrição");
          js_RolaTela("#formAnuncioMensagem");
          document.form_imvgeral.formAnuncioMensagem.focus();
          return false;
        }
        if(dzClosure.getAcceptedFiles().length=="0"){
          alert("Informe alguma imagem");
          return false;
        }
        var v = grecaptcha.getResponse();
        if(v.length == 0){
          alert("Você não pode deixar o captcha vazio");
          return false;
        }
        document.getElementById("idModal").click();
        dzClosure.processQueue();

      });

      //send all the form data along with the files:
      this.on("sendingmultiple", function(data, xhr, formData) {
          formData.append("formAnuncioNome", $("#formAnuncioNome").val());
          formData.append("formAnuncioFone", $("#formAnuncioFone").val());
          formData.append("formAnuncioEmail", $("#formAnuncioEmail").val());
          formData.append("formAnuncioTipo", document.form_imvgeral.formAnuncioTipo.value);
          formData.append("formAnuncioSituacao", $("#formAnuncioSituacao").val());
          if($("#formAnuncioSituacao").val()=="L"){
            formData.append("formAnuncioLocacao", $("#formAnuncioLocacao").val());
          }else if($("#formAnuncioSituacao").val()=="V"){
            formData.append("formAnuncioVenda", $("#formAnuncioVenda").val());
          }else if($("#formAnuncioSituacao").val()=="LV"){
            formData.append("formAnuncioLocacao", $("#formAnuncioLocacao").val());
            formData.append("formAnuncioVenda", $("#formAnuncioVenda").val());
          }
          formData.append("formAnuncioEndereco", $("#formAnuncioEndereco").val());
          formData.append("formAnuncioBairro", $("#formAnuncioBairro").val());
          formData.append("formAnuncioCidade", $("#formAnuncioCidade").val());
          formData.append("formAnuncioCep", $("#formAnuncioCep").val());

          formData.append("formAnuncioQuarto", $("#formAnuncioQuarto").val());
          formData.append("formAnuncioBanheiro", $("#formAnuncioBanheiro").val());
          formData.append("formAnuncioVaga", $("#formAnuncioVaga").val());
          formData.append("formAnuncioArea", $("#formAnuncioArea").val());
          formData.append("formAnuncioMensagem", $("#formAnuncioMensagem").val());
          formData.append("g-recaptcha-response", $("#g-recaptcha-response").val());
      });
      this.on('successmultiple', function(files, response) {
        alert(response);
        location.href = "anuncie-seu-imovel/";
      });
      this.on('maxfilesexceeded', function(file) {
        dzClosure.removeFile(file);
      });
      this.on('errormultiple', function(files, response) {
        alert(response);
        dzClosure.removeFile(files[0]);
      });
      this.on("thumbnail", function (file) {
        if (file.height > 5 && file.width > 5) {
          /*alert("Tamanho máximo permitido é X x Y ");
          dzClosure.removeFile(file);*/
        }
      });


    }

})

function js_SetaInputValores(valor){

  if(valor=="L"){
    $("#divLocacao").css("display","block");
    $("#divVenda").css("display","none");
  }else if(valor=="V"){
    $("#divLocacao").css("display","none");
    $("#divVenda").css("display","block");
  }else if(valor=="LV"){
    $("#divLocacao").css("display","block");
    $("#divVenda").css("display","block");
  }else if(valor==""){
    $("#divLocacao").css("display","block");
    $("#divVenda").css("display","block");
  }

}

function js_BuscaGeral(){

  if(document.form_imvgeral.situacaoImv[0].checked == true){
    document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/locacao/';
  }else if(document.form_imvgeral.situacaoImv[1].checked == true){
    document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/venda/';
  }else{
    document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
  }
  document.form_imvgeral.submit();

}

function js_BuscaGridLista(file){

  document.form_imvgeral.paginationId.value = 0;
  if(file=="imovelgrid.php"){
    if(document.form_imvgeral.situacaoImv[0].checked == true){
      document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/locacao/';
    }else if(document.form_imvgeral.situacaoImv[1].checked == true){
      document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/venda/';
    }else{
      document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
    }
  }else if(file=="imovellist.php"){
    if(document.form_imvgeral.situacaoImv[0].checked == true){
      document.getElementById('form_imvgeral').action = 'list-busca-imoveis/locacao/';
    }else if(document.form_imvgeral.situacaoImv[1].checked == true){
      document.getElementById('form_imvgeral').action = 'list-busca-imoveis/venda/';
    }else{
      document.getElementById('form_imvgeral').action = 'list-busca-imoveis/geral/';
    }
  }
  document.form_imvgeral.submit();

}

function js_BuscaGridCorretor(base,code,name){

  document.form_imvgeral.paginationId.value = 0;
  a = jQuery("input:not(.exclude)").serialize()+"&";
  b = jQuery("select:not(.exclude)").serialize();
  url = base+'corretor/'+code+'/'+js_GeraNomeSeo(name)+'/'+a+b;
  location.href = url;

}

function js_limpaFiltro(opt,campo){

  if(opt=="1"){
    eval("document.form_imvgeral."+campo+"[0].checked = false");
    eval("document.form_imvgeral."+campo+"[1].checked = false");
  }
  if(opt=="2"){
    eval("document.form_imvgeral."+campo+".value = ''");
  }
  if(opt=="3"){
    document.form_imvgeral.areaImvMin.value = "";
    document.form_imvgeral.areaImvMax.value = "";
  }
  if(opt=="4"){
    eval("document.form_imvgeral."+campo+"[4].checked = true");
  }
  if(opt=="5"){
    $("#"+campo).val("0");
  }
  if(opt=="6"){
    document.form_imvgeral.valorMinimo.value = "";
    document.form_imvgeral.valorMaximo.value = "";
  }
  $('#encontrarImv').click();

}

function js_Search(busca){
  if(busca==""){
    alert("Informe algum termo para pesquisa!");
    return false;
  }
  document.form_imvgeral.reset();
  document.form_imvgeral.buscaHero.value = busca;
  document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
  document.form_imvgeral.submit();
}

function js_Pagination(pg){

  document.form_imvgeral.paginationId.value = pg;
  document.form_imvgeral.submit();

}

function js_PaginationCorretor(pg,base,code,name){

  document.form_imvgeral.paginationId.value = pg;
  a = jQuery("input:not(.exclude)").serialize()+"&";
  b = jQuery("select:not(.exclude)").serialize();
  url = base+'corretor/'+code+'/'+js_GeraNomeSeo(name)+'/'+a+b;
  location.href = url;

}

$("#botaoGrid").click(function () {

  if(document.form_imvgeral.situacaoImv[0].checked == true){
    document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/locacao/';
  }else if(document.form_imvgeral.situacaoImv[1].checked == true){
    document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/venda/';
  }else{
    document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
  }
  document.getElementById('form_imvgeral').submit();
  
});

$("#botaoLista").click(function () {

  if(document.form_imvgeral.situacaoImv[0].checked == true){
    document.getElementById('form_imvgeral').action = 'list-busca-imoveis/locacao/';
  }else if(document.form_imvgeral.situacaoImv[1].checked == true){
    document.getElementById('form_imvgeral').action = 'list-busca-imoveis/venda/';
  }else{
    document.getElementById('form_imvgeral').action = 'list-busca-imoveis/geral/';
  }
  document.getElementById('form_imvgeral').submit();
  
});

function js_ImovelView(code,nomeseo){

  url = 'imovel/'+code+'/'+js_GeraNomeSeo(nomeseo)+'/';
  location.href = url;

}

function js_CorretorView(code,nomeseo){

  url = 'corretor/'+code+'/'+js_GeraNomeSeo(nomeseo)+'/';
  location.href = url;

}

function js_ValidaInfoImovelForm(form){

  if(document.form_imvgeral.formInfoImovelNome.value==""){
    alert("Informe o Nome");
    js_RolaTela("#formInfoImovelNome");
    document.form_imvgeral.formInfoImovelNome.focus();
    return false;
  }
  if(document.form_imvgeral.formInfoImovelEmail.value==""){
    alert("Informe o Email");
    js_RolaTela("#formInfoImovelEmail");
    document.form_imvgeral.formInfoImovelEmail.focus();
    return false;
  }
  if(validacaoEmail(document.form_imvgeral.formInfoImovelEmail)==false){
    alert("Email Inválido");
    js_RolaTela("#formInfoImovelEmail");
    document.form_imvgeral.formInfoImovelEmail.focus();
    return false;
  }
  if(document.form_imvgeral.formInfoImovelFone.value==""){
    alert("Informe o Telefone");
    js_RolaTela("#formInfoImovelFone");
    document.form_imvgeral.formInfoImovelFone.focus();
    return false;
  }
  if(document.form_imvgeral.formInfoImovelMensagem.value==""){
    alert("Informe a Mensagem");
    js_RolaTela("#formInfoImovelMensagem");
    document.form_imvgeral.formInfoImovelMensagem.focus();
    return false;
  }
  var v = grecaptcha.getResponse();
  if(v.length == 0){
    alert("Você não pode deixar o captcha vazio");
    return false;
  }
  document.form_imvgeral.formPropostaEmail.value = "";
  document.getElementById("idInfoImovelModal").click();

  sForm1 = jQuery('#form_imvgeral').serialize();
  sForm2 = jQuery("[name='imvSelect']").serialize();
  sForm = sForm1+"&"+sForm2;
  var sFile   = 'ajaxsendmail.php';
  {literal}jQuery.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaInfoImovelForm(data);}}){/literal};

}

function js_retornoValidaInfoImovelForm(retorno){

  msg = retorno.split("|");
  alert(msg[0]);
  js_ImovelView(msg[1],msg[2]);

}

function js_ValidaPropostaForm(form){

  if(document.form_imvgeral.formPropostaSituacao.value==" "){
    alert("Selecione a opção para a proposta");
    document.form_imvgeral.formPropostaSituacao.focus();
    return false;
  }
  if(document.form_imvgeral.formPropostaValor.value=="" || parseInt(document.form_imvgeral.formPropostaValor.value=="0")){
    alert("Informe um valor");
    document.form_imvgeral.formPropostaValor.focus();
    return false;
  }
  if(document.form_imvgeral.formPropostaMensagem.value==""){
    alert("Justifique a sua proposta");
    document.form_imvgeral.formPropostaMensagem.focus();
    return false;
  }
  if(document.form_imvgeral.formPropostaNome.value==""){
    alert("Informe o Nome");
    document.form_imvgeral.formPropostaNome.focus();
    return false;
  }
  if(document.form_imvgeral.formPropostaEmail.value==""){
    alert("Informe o Email");
    document.form_imvgeral.formPropostaEmail.focus();
    return false;
  }
  if(validacaoEmail(document.form_imvgeral.formPropostaEmail)==false){
    alert("Email Inválido");
    return false;
  }
  if(document.form_imvgeral.formPropostaFone.value==""){
    alert("Informe o Telefone");
    document.form_imvgeral.formPropostaFone.focus();
    return false;
  }
  var v = grecaptcha.getResponse();
  if(v.length == 0){
    alert("Você não pode deixar o captcha vazio");
    return false;
  }
  document.form_imvgeral.formInfoImovelEmail.value = "";
  document.getElementById("propostaModal").style.display = "none";
  document.getElementById("idPropostaModalMsg").click();

  sForm1 = jQuery('#form_imvgeral').serialize();
  sForm2 = jQuery("[name='imvSelect']").serialize();
  sForm = sForm1+"&"+sForm2;
  var sFile   = 'ajaxsendmail.php';
  {literal}jQuery.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaPropostaForm(data);}}){/literal};

}

function js_retornoValidaPropostaForm(retorno){

  msg = retorno.split("|");
  alert(msg[0]);
  js_ImovelView(msg[1],msg[2]);

}

function js_ValidaCorretorForm(form){

  if(document.form_imvgeral.formCorretorAssunto.value==""){
    alert("Informe como quer ser contatado");
    document.form_imvgeral.formCorretorAssunto.focus();
    return false;
  }
  if(document.form_imvgeral.formCorretorNome.value==""){
    alert("Informe o Nome Completo");
    document.form_imvgeral.formCorretorNome.focus();
    return false;
  }
  if(document.form_imvgeral.formCorretorEmail.value==""){
    alert("Informe o Email");
    document.form_imvgeral.formCorretorEmail.focus();
    return false;
  }
  if(validacaoEmail(document.form_imvgeral.formCorretorEmail)==false){
    alert("Email Inválido");
    return false;
  }
  if(document.form_imvgeral.formCorretorFone.value==""){
    alert("Informe o Telefone");
    document.form_imvgeral.formCorretorFone.focus();
    return false;
  }
  if(document.form_imvgeral.formCorretorMensagem.value==""){
    alert("Informe a Mensagem");
    document.form_imvgeral.formCorretorMensagem.focus();
    return false;
  }
  var v = grecaptcha.getResponse();
  if(v.length == 0){
    alert("Você não pode deixar o captcha vazio");
    return false;
  }
  document.getElementById("idCorretorModal").click();

  sForm1 = jQuery('#form_imvgeral').serialize();
  sForm2 = jQuery("[name='imvCorretor']").serialize();
  sForm = sForm1+"&"+sForm2;
  var sFile   = 'ajaxsendmail.php';
  {literal}jQuery.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaCorretorForm(data);}}){/literal};

}

function js_retornoValidaCorretorForm(retorno){

  msg = retorno.split("|");
  alert(msg[0]);
  js_CorretorView(msg[1],msg[2]);

}

function js_Caminho(tipo,situacao,valor){
  document.getElementById('form_headergeral').reset();
  if(situacao=="1"){
    situacao = "1,5";
    redir = "locacao";
  }else{
    situacao = "3,5";
    redir = "venda";
  }
  if(tipo=="S"){
    document.form_headergeral.situacaoImv.value = situacao;
    document.form_headergeral.cidadeImv.value = "";
    document.form_headergeral.bairroImv.value = "";
  }else if(tipo=="C"){
    document.form_headergeral.situacaoImv.value = situacao;
    document.form_headergeral.cidadeImv.value = valor;
  }else if(tipo=="B"){
    document.form_headergeral.situacaoImv.value = situacao;
    document.form_headergeral.bairroImv.value = valor;
  }
  document.getElementById('form_headergeral').action = 'grid-busca-imoveis/'+redir+'/';
  document.getElementById('form_headergeral').submit();
}

function js_GeraNomeSeo(txt){

  txt = txt.replace(/[\s]/gi, '-'); //Transforma espaço em traço
  txt = txt.toLowerCase();
  txt = txt.replace(/[^a-z--]/gi, ''); //Remove tudo que não for letras, números ou traço
  return txt;
  
}

$("#buttonShare").click(function(){

    copyToClipboard(document.getElementById("url_copy").value);
    $("#liveToastBtn").click();

})

function copyToClipboard(text) {

  if (window.clipboardData && window.clipboardData.setData) {
    return window.clipboardData.setData("Text", text);
  }else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
  
    var textarea = document.createElement("textarea");
    textarea.textContent = text;
    textarea.style.position = "fixed";
    document.body.appendChild(textarea);
    textarea.select();
    try {
      return document.execCommand("copy");
    }
    catch (ex) {
      console.warn("Falha na cópia!", ex);
      return false;
    }
    finally {
        document.body.removeChild(textarea);
    }
  }
}

function js_LimpaFiltro(base,code,name){
  location.href = base+'corretor/'+code+'/'+js_GeraNomeSeo(name);
}

function js_BuscaBairro(codeCity){
  jQuery("#selectBairro").load("filterload.php","idCidade="+codeCity);
}

function js_BuscaBairroCorretor(codeCity,codeCorretor){
  jQuery("#selectBairro").load("filterload.php","idCidade="+codeCity+"&idCorretor="+codeCorretor);
}

function js_RolaTela(elem){
  jQuery('html,body').animate({literal}{scrollTop: (jQuery(elem).offset().top)-150}{/literal},700);
}


jQuery("#valorMinimo").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
jQuery("#valorMaximo").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
jQuery("#areaImvMin").maskMoney({literal}{prefix:'m² ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
jQuery("#areaImvMax").maskMoney({literal}{prefix:'m² ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
jQuery("#formAnuncioLocacao").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
jQuery("#formAnuncioVenda").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
jQuery("#formAnuncioArea").maskMoney({literal}{prefix:'m² ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
jQuery("#formPropostaValor").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});

jQuery('input').on("input", function(e) {
  jQuery(this).val($(this).val().replace(/['<>]/g, ""));
});

jQuery('textarea').on("input", function(e) {
  jQuery(this).val($(this).val().replace(/['<>]/g, ""));
});

jQuery("#abreProposta").click(function () {

  jQuery("#div_captcha_proposta").load("loadcaptcha.php");
  jQuery("#div_captcha_info").html("");

});

jQuery("#abrePropostaMobile").click(function () {

  jQuery("#div_captcha_proposta").load("loadcaptcha.php");
  jQuery("#div_captcha_info").html("");

});

jQuery("#propostaModal").on('hide.bs.modal', function(){

  jQuery("#div_captcha_info").load("loadcaptcha.php");
  jQuery("#div_captcha_proposta").html("");
  
});



</script>
