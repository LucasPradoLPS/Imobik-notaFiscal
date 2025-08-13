CREATE TABLE public.uf
(
  iduf serial PRIMARY KEY NOT NULL,
  ufextenso character varying(100) NOT NULL,
  uf character(2) NOT NULL
);

CREATE TABLE public.cidade
( 
    idcidade serial PRIMARY KEY NOT NULL,
    iduf integer NOT NULL CONSTRAINT fk_iduf REFERENCES public.uf(iduf),
    cidade varchar(255) UNIQUE,
    codreceita character varying(20),
    codibge character varying(20),
    deletedat timestamp,
    latilongi text
); 

CREATE TABLE public.templatetipo
(
  idtemplatetipo serial PRIMARY KEY NOT NULL,
  templatetipo character varying(255)
);

CREATE TABLE public.template
(
  idtemplate serial PRIMARY KEY NOT NULL,
  idtemplatetipo serial NOT NULL CONSTRAINT fk_idtemplatetipo REFERENCES templatetipo (idtemplatetipo),
  view character varying(200),
  titulo character varying(255),
  template text,
  deletedat timestamp
);

CREATE TABLE calendar_event
(
  id serial PRIMARY KEY NOT NULL,
  color character varying(200),
  description text,
  end_time timestamp,
  notificar integer, -- usuário a ser notificado
  privado boolean DEFAULT false,
  start_time timestamp,
  systemuser integer,
  title character varying(200)
);

CREATE TABLE mural
(
idmural serial PRIMARY KEY NOT NULL,
idsystemuser integer,
dtinclusao date DEFAULT now(),
dtpublicacao date NOT NULL DEFAULT now(),
titulo character varying(200),
post text NOT NULL
);

CREATE TABLE webhook
(
    idwebhook serial PRIMARY KEY NOT NULL,
    dtpost timestamp DEFAULT now(),
    post text
);

CREATE TABLE webhooktransferencia
(
    idwebhooktransferencia serial PRIMARY KEY NOT NULL,
    createdat timestamp DEFAULT now(),
    post text
);

CREATE TABLE public.zswebhook
(
  idzswebhook serial PRIMARY KEY NOT NULL,
  createdat timestamp DEFAULT now(),
  post text
);

CREATE TABLE public.openai_config
(
    id serial PRIMARY KEY NOT NULL,
    apiKey text NOT NULL,
    apiUrl text NOT NULL,
    data_model text NOT NULL,
    max_tokens integer NOT NULL,
    prompt text NOT NULL,
    temperature float NOT NULL,
    system_content text NOT NULL
);
------------------------------------------------- Schema: pessoa
CREATE SCHEMA pessoa;

CREATE TABLE pessoa.pessoa
(
  idpessoa serial PRIMARY KEY NOT NULL,
  idcidade integer CONSTRAINT fk_idcidade REFERENCES public.cidade(idcidade),
  idsystemuser integer, -- Usuário que criou a conta
   admin boolean NOT NULL DEFAULT false,
  apikey character varying(256),
  asaasid character varying(255),
  ativo boolean NOT NULL DEFAULT true,
  bancoagencia character varying(10),
  bancoagenciadv character varying(10),
  bancochavepix character varying(200),
  bancoconta character varying(20),
  bancocontadv character varying(10),
  bancocontatipoid integer,
  bancoid integer,
  bancopixtipoid integer,
  cep character varying(8),
  cnpjcpf character varying(14),
  createdat timestamp,
  customer text,
  deletedat timestamp,
  ehcorretor boolean DEFAULT false,
  idunit integer,
  -- Aviso de cobrança criada - PAYMENT_CREATED
  nt1emailenabledforcustomer boolean DEFAULT false, -- habilita/desabilita o email enviado para o seu cliente
  nt1emailenabledforprovider boolean DEFAULT true, -- habilita/desabilita o email enviado para você
  nt1enabled boolean DEFAULT true, -- Habilita/desabilita a notificação
  nt1phonecallenabledforcustomer boolean DEFAULT false, -- habilita/desabilita a notificação por voz enviada para o seu cliente
  nt1scheduleoffset smallint DEFAULT 0, -- Especifica quantos dias antes do vencimento a notificação deve se enviada.
  nt1smsenabledforcustomer boolean DEFAULT false, -- habilita/desabilita o SMS enviado para o seu cliente
  nt1smsenabledforprovider boolean DEFAULT false, -- habilita/desabilita o SMS enviado para você
  nt1whatsappenabledforcustomer boolean DEFAULT false, -- habilita/desabilita a mensagem de WhatsApp para seu cliente
  nt1whatsappenabledforprovider boolean DEFAULT false, -- habilita/desabilita a mensagem de WhatsApp para você
  -- Aviso de cobrança atualizada - PAYMENT_UPDATED
  nt2emailenabledforcustomer boolean DEFAULT true,
  nt2emailenabledforprovider boolean DEFAULT false,
  nt2enabled boolean DEFAULT true,
  nt2phonecallenabledforcustomer boolean DEFAULT false,
  nt2scheduleoffset smallint DEFAULT 0,
  nt2smsenabledforcustomer boolean DEFAULT false,
  nt2smsenabledforprovider boolean DEFAULT false,
  nt2whatsappenabledforcustomer boolean DEFAULT false,
  nt2whatsappenabledforprovider boolean DEFAULT false,
  -- Aviso 10 dias antes do vencimento - PAYMENT_DUEDATE_WARNING
  nt3emailenabledforcustomer boolean DEFAULT true,
  nt3emailenabledforprovider boolean DEFAULT false,
  nt3enabled boolean DEFAULT true,
  nt3phonecallenabledforcustomer boolean DEFAULT false,
  nt3scheduleoffset smallint DEFAULT 10,
  nt3smsenabledforcustomer boolean DEFAULT false,
  nt3smsenabledforprovider boolean DEFAULT false,
  nt3whatsappenabledforcustomer boolean DEFAULT false,
  nt3whatsappenabledforprovider boolean DEFAULT false,
  -- Aviso no dia do vencimento- PAYMENT_DUEDATE_WARNING
  nt4emailenabledforcustomer boolean DEFAULT true,
  nt4emailenabledforprovider boolean DEFAULT true,
  nt4enabled boolean DEFAULT true,
  nt4phonecallenabledforcustomer boolean DEFAULT false,
  nt4scheduleoffset smallint DEFAULT 0,
  nt4smsenabledforcustomer boolean DEFAULT false,
  nt4smsenabledforprovider boolean DEFAULT false,
  nt4whatsappenabledforcustomer boolean DEFAULT false,
  nt4whatsappenabledforprovider boolean DEFAULT false,
  -- Linha digitável no dia do vencimento - SEND_LINHA_DIGITAVEL 7
  nt5emailenabledforcustomer boolean DEFAULT true,
  nt5emailenabledforprovider boolean DEFAULT false,
  nt5enabled boolean DEFAULT true,
  nt5phonecallenabledforcustomer boolean DEFAULT false,
  nt5scheduleoffset smallint DEFAULT 0,
  nt5smsenabledforcustomer boolean DEFAULT false,
  nt5smsenabledforprovider boolean DEFAULT false,
  nt5whatsappenabledforcustomer boolean DEFAULT false,
  nt5whatsappenabledforprovider boolean DEFAULT false,
  -- Aviso de cobrança vencida - PAYMENT_OVERDUE
  nt6emailenabledforcustomer boolean DEFAULT true,
  nt6emailenabledforprovider boolean DEFAULT true,
  nt6enabled boolean DEFAULT true,
  nt6phonecallenabledforcustomer boolean DEFAULT false,
  nt6scheduleoffset smallint DEFAULT 0,
  nt6smsenabledforcustomer boolean DEFAULT false,
  nt6smsenabledforprovider boolean DEFAULT false,
  nt6whatsappenabledforcustomer boolean DEFAULT false,
  nt6whatsappenabledforprovider boolean DEFAULT false,
  -- Aviso a cada 7 dias após vencimento: - PAYMENT_OVERDUE
  nt7emailenabledforcustomer boolean DEFAULT true,
  nt7emailenabledforprovider boolean DEFAULT false,
  nt7enabled boolean DEFAULT true,
  nt7phonecallenabledforcustomer boolean DEFAULT false,
  nt7scheduleoffset smallint DEFAULT 7,
  nt7smsenabledforcustomer boolean DEFAULT false,
  nt7smsenabledforprovider boolean DEFAULT false,
  nt7whatsappenabledforcustomer boolean DEFAULT false,
  nt7whatsappenabledforprovider boolean DEFAULT false,
  -- Aviso de cobrança recebida - PAYMENT_RECEIVED
  nt8emailenabledforcustomer boolean DEFAULT true,
  nt8emailenabledforprovider boolean DEFAULT true,
  nt8enabled boolean DEFAULT true,
  nt8phonecallenabledforcustomer boolean DEFAULT false,
  nt8scheduleoffset smallint DEFAULT 0,
  nt8smsenabledforcustomer boolean DEFAULT false,
  nt8smsenabledforprovider boolean DEFAULT false,
  nt8whatsappenabledforcustomer boolean DEFAULT false,
  nt8whatsappenabledforprovider boolean DEFAULT false,
  pessoa character varying(255) NOT NULL,
  politico boolean DEFAULT false,
  selfie text,
  systemuseractive boolean DEFAULT false,
  systemuserid integer, -- Código da pessoa como USUARIO do sistema
  updatedat timestamp,
  walletid character varying(256)
 );


CREATE TABLE pessoa.pessoadetalhe
(
  idpessoadetalhe serial PRIMARY KEY NOT NULL,
  pessoadetalhe character varying(255) NOT NULL,
  requerido boolean DEFAULT false
);

CREATE TABLE pessoa.pessoadetalheitem
(
  idpessoadetalheitem serial PRIMARY KEY NOT NULL,
  idpessoa serial CONSTRAINT fk_idpessoa REFERENCES pessoa.pessoa(idpessoa),
  idpessoadetalhe serial CONSTRAINT fk_idpessoadetalhe REFERENCES pessoa.pessoadetalhe(idpessoadetalhe),
  pessoadetalheitem character varying(200)
 );
 
 
CREATE TABLE pessoa.serasa( 
	  id serial PRIMARY KEY NOT NULL, 
	  idpessoa serial CONSTRAINT fk_idpessoa REFERENCES pessoa.pessoa(idpessoa) NOT NULL,
	  idconsulta text, 
	  datecreated date, 
	  downloadurl text, 
	  createdat timestamp, 
	  base64arquivo text
);

CREATE TABLE pessoa.pessoasystemusergroup
(
	idpessoasystemusergroup serial PRIMARY KEY NOT NULL,
	idpessoa integer,
	idgorup integer
) ; 

------------------------------------------------- Schema: Public com dependencias em pessoas

CREATE TABLE config
(
  idconfig integer PRIMARY KEY NOT NULL,
  idcidade integer NOT NULL CONSTRAINT fk_idcidade REFERENCES cidade(idcidade),
  idresponsavel integer NOT NULL CONSTRAINT fk_idresponsavel REFERENCES pessoa.pessoa(idpessoa),
  accesstoken character varying(300),
  addressnumber character varying(30),
  apikey character varying(256),
  appdomain text,
  bairro character varying(100),
  cep character varying(10),
  certificatefile text,
  certificatepassword character varying(300),
  clientes integer,
  clientesvalue numeric(10,2),
  cnae character varying(300),
  cnpjcpf character varying(14),
  companytype character(1), -- M - MEI / L - LIMITED / I - INDIVIDUAL / A - ASSOCIATION
  complement character varying(255),
  contratos integer,
  contratosvalue numeric(10,2),
  convertewebp boolean DEFAULT true,
  creci character varying(10),
  culturalprojectspromoter boolean,
  database character varying(100),
  dtatualizacao timestamp, -- 29/07/2024 Atualização de cadastro Asaas
  dtfundacao date,
  dtregistro date DEFAULT now(),
  email character varying(100),
  enabled boolean DEFAULT true,
  endereco character varying(255) NOT NULL,
  fone character varying(15),
  fontcolor character varying(255),
  idcontapai integer,
  imagens integer,
  imagensbackup boolean DEFAULT true,
  imagensvalue numeric(10,2),
  imoveis integer,
  imoveisvalue numeric(10,2),
  infobackgroundcolor character varying(255),
  inscestadual character varying(20),
  inscmunicipal character varying(20),
  incomevalue numeric(15,2), -- 04/03/2024 Por exigência do Bacen - Faturamento/Renda mensal P/ Asaas
  logobackgroundcolor character varying(255),
  logofile character varying,
  logomarca text,
  lotenumber integer,
  marcadagua text,
  marcadaguabackgroundcolor character varying(20),
  marcadaguaposition smallint,
  marcadaguatransparencia smallint,
  mensagens integer,
  mensagensvalue numeric(10,2),
  mobilephone character varying(15),
  nomefantasia character varying(255),
  password character varying(100),
  razaosocial character varying(255) NOT NULL,
  reconhecimentofacial integer,
  reconhecimentofacialvalue numeric(10,2),
  rpsnumber integer,
  rpsserie character varying(10),
  servicelistitem character varying(300),
  sigfranquia integer,
  sigfranquiavalue numeric(10,2),
  simplesnacional boolean,
  specialtaxregime character varying(300),
  system character varying(30),
  templatecaixaentrada integer,
  templatecaixasaida integer,
  templatecontratolocacao integer,
  templatefaturainstrucao integer,
  templateimovel integer,
  templates integer,
  templatesvalue numeric(10,2),
  templatevistoriaconferencia integer,
  templatevistoriaentrada integer,
  templatevistoriasaida integer,
  transferencias integer,
  transferenciasvalue numeric(10,2),
  username character varying(300),
  usuarios integer,
  usuariosvalue numeric(10,2),
  vistorias integer,
  vistoriasvalue numeric(10,2),
  walletid character varying(256),
  whapiversion smallint,
  whauthtoken character varying(255),
  whemail character varying(255),
  whenabled boolean DEFAULT false,
  whinterrupted boolean DEFAULT true,
  whurl character varying(255),
  whnapiversion smallint,
  whnauthtoken character varying(255),
  whnemail character varying(255),
  whnenabled boolean DEFAULT false,
  whninterrupted boolean DEFAULT true,
  whnurl character varying(255),
  whtapiversion smallint,
  whtauthtoken character varying(255),
  whtemail character varying(255),
  whtenabled boolean DEFAULT false,
  whtinterrupted boolean DEFAULT true,
  whturl character varying(255),
  zsauthmode character varying(200) DEFAULT 'assinaturaTela',
  zsblankemail boolean DEFAULT false,
  zsblankphone boolean DEFAULT false,
  zsbrandlogo character varying(200),
  zsbrandname character varying(100),
  zsbrandprimarycolor character varying(200),
  zscreatedby character varying(200),
  zscustommessage text,
  zsdisablesigneremails boolean DEFAULT false,
  zsfolderpath character varying(255),
  zshideemail boolean DEFAULT false,
  zshidephone boolean DEFAULT false,
  zslang character varying(10) DEFAULT 'pt-br',
  zsobservers text,
  zslockemail boolean DEFAULT false,
  zslockname boolean DEFAULT false,
  zslockphone boolean DEFAULT false,
  zspermitewhatsapp boolean DEFAULT false,
  zspermitirreconhecimento boolean DEFAULT false,
  zsphonecountry character varying(5) DEFAULT '55',
  zsredirectlink text,
  zsremindereveryndays integer,
  zsrequiredocumentphoto boolean DEFAULT false,
  zsrequireselfiephoto boolean DEFAULT false,
  zssandbox boolean DEFAULT true,
  zsselfievalidation boolean DEFAULT false,
  zsselfievalidationtype character varying(200) DEFAULT 'none',
  zssendautomaticemail boolean DEFAULT false,
  zssendautomaticwhatsapp boolean DEFAULT false,
  zssignatureorderactive boolean DEFAULT false,
  zssignedfileonlyfinished boolean DEFAULT false,
  zstoken text
);


------------------------------------------------- Schema: imovel
CREATE SCHEMA imovel;

CREATE TABLE imovel.imovelsituacao
(
  idimovelsituacao serial PRIMARY KEY NOT NULL,
  imovelsituacao character varying(255) NOT NULL
);

CREATE TABLE imovel.imoveldestino
(
  idimoveldestino serial PRIMARY KEY NOT NULL,
  imoveldestino character varying(255) NOT NULL
);

CREATE TABLE imovel.imoveltipo
(
  idimoveltipo serial PRIMARY KEY NOT NULL,
  imoveltipo character varying(255) NOT NULL
);


CREATE TABLE imovel.imovelmaterial
(
  idimovelmaterial serial PRIMARY KEY NOT NULL,
  imovelmaterial character varying(255) NOT NULL
);

CREATE TABLE imovel.imoveldetalhe
(
  idimoveldetalhe serial PRIMARY KEY NOT NULL,
  imoveldetalhe character varying(255) NOT NULL,
  caracterizacao text,
  flagimovel boolean DEFAULT false,
  flagvistoria boolean DEFAULT true,
  idparent integer
);

CREATE TABLE imovel.imovel
(
  idimovel serial PRIMARY KEY NOT NULL,
  idcidade integer NOT NULL CONSTRAINT fk_idcidade REFERENCES public.cidade(idcidade),
  idimoveldestino integer NOT NULL CONSTRAINT fk_idimoveldestino REFERENCES imovel.imoveldestino(idimoveldestino),
  idimovelmaterial integer NOT NULL CONSTRAINT fk_idimovelmaterial REFERENCES imovel.imovelmaterial(idimovelmaterial),
  idimovelsituacao integer NOT NULL CONSTRAINT fk_idimovelsituacao REFERENCES imovel.imovelsituacao(idimovelsituacao),
  idimoveltipo integer NOT NULL CONSTRAINT fk_idimoveltipo REFERENCES imovel.imoveltipo(idimoveltipo),
  idsystemuser integer,
  idunit integer,
  idlisting integer,
  aluguel numeric(10,2),
  area numeric(10,2),
  bairro character varying(255),
  capaimg text,
  caracteristicas text,
  cep character varying(10),
  claviculario character varying(10),
  complemento character varying(200),
  condominio numeric(10,2),
  createdat timestamp,
  deletedat timestamp,
  divulgar boolean DEFAULT true,
  etiquetamodelo integer,
  etiquetanome character varying(100),
  exibealuguel boolean DEFAULT true,
  exibelogradouro boolean DEFAULT false,
  exibevalorvenda boolean DEFAULT true,
  grupozap boolean DEFAULT false,
  imovelregistro character varying(200),
  imovelweb boolean DEFAULT false,
  iptu numeric(10,2),
  labelnovalvalues character varying(30) DEFAULT 'Consulte',
  lancamento boolean DEFAULT false,
  lancamentoimg text,
  logradouro character varying(255) NOT NULL,
  logradouronro character varying(10),
  lote character varying(200),
  mapa text,
  obs text,
  outrataxa character varying(100),
  outrataxavalor numeric(10,2),
  perimetro character(1) NOT NULL,
  prefeituramatricula character varying(200),
  proposta boolean DEFAULT false,
  quadra character varying(200),
  setor character varying(200),
  updatedat timestamp,
  venda numeric(15,2),
  video text
);

CREATE TABLE imovel.imoveldetalheitem
(
  idimoveldetalheitem serial PRIMARY KEY NOT NULL,
  idimovel serial NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel (idimovel) ON UPDATE CASCADE ON DELETE CASCADE,
  idimoveldetalhe serial NOT NULL CONSTRAINT fk_idimoveldetalhe REFERENCES imovel.imoveldetalhe (idimoveldetalhe) ON UPDATE CASCADE ON DELETE CASCADE,
  imoveldetalheitem character varying(255) NOT NULL
);

ALTER TABLE IF EXISTS imovel.imoveldetalheitem ADD CONSTRAINT uk_idimovel_idimoveldetalhe UNIQUE (idimovel, idimoveldetalhe);

CREATE TABLE imovel.imovelcorretor
(
  idimovelcorretor serial PRIMARY KEY NOT NULL,
  idimovel integer NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel(idimovel),
  idcorretor integer NOT NULL CONSTRAINT fk_idcorretor REFERENCES pessoa.pessoa(idpessoa),
  divulgarsite boolean
);

CREATE TABLE imovel.imovelproprietario
(
  idimovelproprietario serial PRIMARY KEY NOT NULL,
  idimovel integer NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel (idimovel),
  idpessoa integer NOT NULL CONSTRAINT fk_idpessoa REFERENCES pessoa.pessoa (idpessoa),
  fracao numeric(10,3) NOT NULL
);

CREATE TABLE imovel.imovelalbum
(
  idimovelalbum serial PRIMARY KEY NOT NULL,
  idimovel integer NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel(idimovel) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  idunit integer,
  backup text,
  orderby integer,
  patch text,
  legenda character varying(150)
);

CREATE TABLE imovel.imovelplanta
(
  idimovelplanta serial PRIMARY KEY NOT NULL,
  idimovel integer NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel(idimovel) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  idunit integer,
  patch text,
  legenda character varying(150)
);

CREATE TABLE imovel.imovelvideo
(
  idimovelvideo serial PRIMARY KEY NOT NULL,
  idimovel integer NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel(idimovel) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  idunit integer,
  patch text,
  legenda character varying(150)
);

CREATE TABLE imovel.imoveltur360
(
  idimoveltur360 serial PRIMARY KEY NOT NULL,
  idimovel integer NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel(idimovel) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  idunit integer,
  patch text,
  legenda character varying(150)
);

CREATE TABLE imovel.imovelretiradachave
(
  idimovelretiradachave serial PRIMARY KEY NOT NULL,
  idimovel serial NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel (idimovel),
  idpessoa serial NOT NULL CONSTRAINT fk_idpessoa REFERENCES pessoa.pessoa (idpessoa),
  dtretirada timestamp,
  prazo timestamp,
  dtentrega timestamp
);



------------------------------------------------- Schema: GrupoZap
CREATE SCHEMA grupozap;

CREATE TABLE grupozap.listing
(
  idlisting serial PRIMARY KEY NOT NULL,
  idimovel integer UNIQUE NOT NULL,
  title character varying(100),
  transactiontype character varying(50),
  displayaddress character varying(50),
  country character varying(100) DEFAULT 'Brasil',
  countryabbreviation character varying(3) DEFAULT 'br',
  state character varying(100),
  stateabbreviation character varying(3),
  city character varying(100),
  zone character varying(100),
  neighborhood character varying(100),
  address character varying(100),
  streetnumber character varying(10),
  complement character varying(100),
  postalcode character varying(20),
  latitude character varying(100),
  longitude character varying(100),
  publicationtype character varying(50),
  virtualtourlink text,
  publicado date
);


----------------------------------------------- Schema: Autenticador
CREATE SCHEMA autenticador;

CREATE TABLE autenticador.documentotipo
(
  iddocumentotipo serial PRIMARY KEY NOT NULL,
  documentotipo character varying(200) UNIQUE NOT NULL 
 );

CREATE TABLE autenticador.documento
(
  iddocumento serial PRIMARY KEY NOT NULL,
  iddocumentotipo serial NOT NULL CONSTRAINT fk_iddocumentotipo REFERENCES autenticador.documentotipo(iddocumentotipo),
  tabela character varying(50),
  pkey integer,
  dtregistro date DEFAULT now(),
  brandlogo character varying(255),
  brandname character varying(100),
  brandprimarycolor character varying(100),
  createdat timestamp,
  createdby character varying(100),
  createdthrough character varying(100),
  datelimittosign character varying(100),
  deleted boolean DEFAULT false,
  deletedat timestamp,
  disablesigneremails boolean DEFAULT false,
  docname character varying(255),
  endpoint character varying(255),
  eventtype character varying(100),
  externalid character varying(255),
  folderpath character varying(255),
  lang character varying(10),
  lastupdateat character varying(100),
  observers text,
  openid integer,
  originalfile text,
  sandox boolean DEFAULT true,
  signatureorderactive boolean DEFAULT false,
  signedfile text,
  signedfileonlyfinished boolean DEFAULT false,
  status character varying(100),
  token character varying(100)
);

CREATE TABLE autenticador.signatario
(
  idsignatario serial PRIMARY KEY NOT NULL,
  iddocumento serial NOT NULL CONSTRAINT fk_iddocumento REFERENCES autenticador.documento (iddocumento) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  idpessoa integer REFERENCES pessoa.pessoa(idpessoa),
  authmode character varying(50),
  blankemail boolean DEFAULT false,
  blankphone boolean DEFAULT false,
  custommessage text,
  documentphotourl text,
  documentversephotourl text,
  email character varying(200),
  externalid character varying(50),
  geolatitude character varying(100),
  geolongitude character varying(100),
  hideemail boolean DEFAULT false,
  hidephone boolean DEFAULT false,
  lastviewat character varying(100),
  lockemail boolean DEFAULT false,
  lockname boolean DEFAULT false,
  lockphone boolean DEFAULT false,
  nome character varying(50),
  ordergroup integer,
  phonecountry character varying(2) DEFAULT '55',
  phonenumber character varying(50),
  qualification character varying(150),
  redirectlink text,
  requiredocumentphoto boolean DEFAULT false,
  requireselfiephoto boolean DEFAULT false,
  selfiephotourl text,
  selfiephotourl2 text,
  selfievalidationtype text,
  sendautomaticemail boolean DEFAULT true,
  sendautomaticwhatsapp boolean DEFAULT false,
  sendvia character varying(100),
  signatureimage text,
  signedat character varying(100),
  signurl text,
  status character varying(100),
  timesviewed integer,
  token character varying(100),
  vistoimage text
);


CREATE TABLE autenticador.signatarioconfigtemp
(
	signatarioconfigtemp serial PRIMARY KEY NOT NULL,
	externalid varchar(50),
	nome varchar(50),
	lockname boolean DEFAULT false,
	authmode varchar(50) DEFAULT 'assinaturaTela',
	requireselfiephoto boolean DEFAULT false,
	requiredocumentphoto boolean DEFAULT false,
	selfievalidationtype text DEFAULT 'none',
	email varchar(200) NOT NULL,
	blankemail boolean DEFAULT false,
	sendautomaticemail boolean DEFAULT true,
	hideemail boolean DEFAULT false,
	lockemail boolean DEFAULT false,
	custommessage text,
	phonecountry varchar(2) DEFAULT '55',
	phonenumber varchar(50),
	lockphone boolean DEFAULT false,
	blankphone boolean DEFAULT false,
	hidephone boolean DEFAULT false,
	sendautomaticwhatsapp boolean DEFAULT false,
	ordergroup integer,
	redirectlink text
);

----------------------------------------------- Schema: site
CREATE SCHEMA site;

CREATE TABLE site.sitetemplate
(
	idsitetemplate serial PRIMARY KEY NOT NULL,
	sitetemplate character varying(100) NOT NULL,
	path text NOT NULL,
	description text,
	image text,
	versao integer
);

CREATE TABLE site.site
(
	idsite serial PRIMARY KEY NOT NULL,
	idsitetemplate serial NOT NULL CONSTRAINT fk_idsitetemplate REFERENCES site.sitetemplate(idsitetemplate) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
	about text,
	active boolean NOT NULL DEFAULT true,
	apikeygooglemaps text,
	collordefault character varying(100) NOT NULL,
	collordefaulttext character varying(100) NOT NULL DEFAULT '#ff0008',
	customerbutton boolean NOT NULL DEFAULT true,
	customerfolder character varying(255),
	description text,
	domain character varying(250) UNIQUE NOT NULL,
	enddate date,
	endereco text,
	facebook character varying(250),
	idanalityc character varying(250),
	idunit integer NOT NULL,	
	idwatermark bigint DEFAULT 0,
	iframe text,
	instagran character varying(250),
	keysecretemail character varying(250),
	keywords text,
	logomarca character varying(250),
	mission text,
	msgcookies text,
	orderalbum character(1) DEFAULT 'A' CHECK (orderalbum = 'A' OR orderalbum = 'D'), 
	patchphotos character varying(250) NOT NULL,
	rodape text,
	sitekeyemail character varying(250),
	startdate date DEFAULT now(),
	telefone character varying(100),
	telegram character varying(250),
	textsectionmain text,
	title character varying(250) NOT NULL,
	transparency smallint,
	watermark text,
	whatsapp character varying(100),
	whatsappphone character varying(100),
	youtube character varying(250)
);


CREATE TABLE site.siteheadtext
(
	idsiteheadtext serial PRIMARY KEY NOT NULL,
	idsite integer NOT NULL CONSTRAINT fk_idsite REFERENCES site.site(idsite) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
	siteheadtext character varying(100) NOT NULL,
	templatesection character varying(100) NOT NULL
);

CREATE TABLE site.siteslide
(
	idsiteslide serial PRIMARY KEY NOT NULL,
	idsite integer NOT NULL CONSTRAINT fk_idsite REFERENCES site.site(idsite) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
	siteslide text NOT NULL,
	templatesection character varying(100) NOT NULL
);

CREATE TABLE site.sitesecao
(
    idsitesecao serial PRIMARY KEY NOT NULL,
    nome character varying(100) NOT NULL,
    filename character varying(100) NOT NULL,
	versao integer
);


CREATE TABLE site.sitesecaotitulo
(
	idsitesecaotitulo serial PRIMARY KEY NOT NULL,
	idsite integer NOT NULL CONSTRAINT fk_idsite REFERENCES site.site (idsite) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE, 
	idsitesecao integer NOT NULL CONSTRAINT fk_idsitesecao REFERENCES site.sitesecao (idsitesecao) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
	sitesecaotitulo character varying(100) NOT NULL,
	ordenacao integer
);

CREATE TABLE site.sitetestemunho
(
	idsitetestemunho serial PRIMARY KEY NOT NULL,
	idsite integer NOT NULL CONSTRAINT fk_idsite REFERENCES site.site (idsite) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
	nome character varying(100) NOT NULL,
	cargo character varying(100) NOT NULL,
	depoimento text NOT NULL,
	filename text  NOT NULL,
	ativo boolean NOT NULL DEFAULT true
);

------------------------------------------------- Schema: Contrato

CREATE SCHEMA contrato;

CREATE TABLE contrato.contratopessoaqualificacao
(
  idcontratopessoaqualificacao serial PRIMARY KEY NOT NULL,
  contratopessoaqualificacao character varying(200)
);

CREATE TABLE contrato.contratoato( 
	  idcontratoato serial PRIMARY KEY NOT NULL, 
	  contratoato character varying(50) NOT NULL
 );
 
 
 CREATE TABLE contrato.contratoalteracaotipo( 
	  idcontratoalteracaotipo serial PRIMARY KEY NOT NULL,
	  idcontratoato integer NOT NULL  CONSTRAINT fk_idcontratoato REFERENCES contrato.contratoato(idcontratoato),
	  contratoalteracaotipo character varying(100) NOT NULL
);


CREATE TABLE contrato.contrato
(
  idcontrato serial PRIMARY KEY NOT NULL,
  idimovel integer NOT NULL CONSTRAINT fk_idimovel REFERENCES imovel.imovel (idimovel),
  idsystemuser integer NOT NULL,
  aluguel numeric(10,2),
  aluguelgarantido character(1) NOT NULL, -- SIM (M)anual SIM (A)utomático (N)ão
  comissao numeric(10,2), -- alterar valores
  comissaofixa boolean DEFAULT false, -- novo
  caucao numeric(10,2), -- novo
  caucaoobs text, -- novo
  consenso text,
  createdat timestamp, -- novo
  deletedat timestamp, -- novo
  dtcelebracao date NOT NULL DEFAULT now(),
  dtfim date,
  dtextincao date,
  dtinicio date NOT NULL DEFAULT now(),
  dtproxreajuste date,
  jurosmora numeric(6,2),
  melhordia smallint, -- novo
  multamora numeric(6,2),
  multafixa boolean DEFAULT false, -- Se a multa é fixa(R$) ou variável (%) 13-03-24
  obs text,
  periodicidade character varying(100),
  prazo integer,
  prazorepasse smallint, -- novo
  processado boolean NOT NULL DEFAULT false,
  prorrogar boolean NOT NULL DEFAULT true,
  renovadoalterado boolean NOT NULL DEFAULT false,
  rescindido boolean DEFAULT false,
  restituicao character(1) NOT NULL DEFAULT 'R',
  updatedat timestamp, -- novo
  valorrecisorio numeric(10,2),
  vistoriado boolean NOT NULL DEFAULT false 
);

CREATE TABLE contrato.contratopessoa
(
  idcontratopessoa serial PRIMARY KEY NOT NULL ,
  idcontrato integer NOT NULL CONSTRAINT fk_idcontrato REFERENCES contrato.contrato(idcontrato),
  idpessoa integer NOT NULL CONSTRAINT fk_idpessoa REFERENCES pessoa.pessoa(idpessoa),
  idcontratopessoaqualificacao integer NOT NULL CONSTRAINT fk_idcontratopessoaqualificacao REFERENCES contrato.contratopessoaqualificacao (idcontratopessoaqualificacao),
  cota numeric(10,4)
 );


CREATE TABLE contrato.contratoalteracao( 
	  idcontratoaleracao serial PRIMARY KEY NOT NULL,
	  idcontrato integer NOT NULL CONSTRAINT fk_idcontrato REFERENCES contrato.contrato(idcontrato),
	  idsystemuser integer,
	  idcontratoalteracaotipo integer,
	  aluguelant numeric(10,2),
	  aluguelatual numeric(10,2),
	  comissaoant numeric(10,2),
	  comissaoatual numeric(10,2),
	  createdat timestamp,
	  deletedat timestamp,
	  dtfimant date,
	  dtfimatual date,
	  instrucoes text,
	  jurosmoraant numeric(6,2),
	  jurosmoraatual numeric(6,2),
	  multamoraant numeric(6,2),
	  multamoraatual numeric(6,2),
	  newpersons json,
	  oldpersons json,
	  termos text,
	  updatedat timestamp,
	  valorrecisorio numeric(10,2)
);
 
CREATE TABLE contrato.contratoalteracaocontaparcela
(
	idcontratoalteracaocontaparcela serial PRIMARY KEY NOT NULL  ,
	idcontratoalteracao integer NOT NULL CONSTRAINT fk_idcontratoalteracao REFERENCES contrato.contratoalteracao(idcontratoaleracao), 
	parcela integer, 
	parcelavalor numeric(6,2),
	parcelavencimento date
);


CREATE TABLE contrato.historico
(
    idhistorico serial PRIMARY KEY NOT NULL,
    idcontrato integer NOT NULL CONSTRAINT fk_idcontrato REFERENCES contrato.contrato (idcontrato),
    idatendente integer,
    aluguel numeric(10,2),
    createdat timestamp,
    deletedat timestamp,
    dtalteracao date DEFAULT now(),
    dtfim date,
    dtinicio date,
    historico text,
    idfiador1 integer,
    idfiador2 integer,
    idfiador3 integer,
    idtestemunha integer,
    index integer,
    prazo smallint,
    tabeladerivada character varying(200),
    updatedat timestamp
);




------------------------------------------------- Schema: Imovelweb - 05/10/2022 - v 1.07

CREATE SCHEMA imovelweb;

CREATE TABLE imovelweb.imovelwebcliente
(
  idimovelwebcliente serial PRIMARY KEY NOT NULL,
  imovelwebcliente text,
  ambiente text,
  clientsecret text,
  codigoimobiliaria character varying(255),
  emailcontato character varying(255),
  emailusuario character varying(255),
  nomecontato character varying(100),
  telefonecontato character varying(20)
);

CREATE TABLE imovelweb.imovelwebcategoria
(
  idimovelwebcategoria serial PRIMARY KEY NOT NULL,
  imovelwebcategoria character varying(100)
);

CREATE TABLE imovelweb.imovelwebtipo
(
  idimovelwebtipo serial PRIMARY KEY NOT NULL,
  idimovelwebcategoria integer CONSTRAINT fk_idimovelwebcategoria REFERENCES imovelweb.imovelwebcategoria (idimovelwebcategoria),
  imovelwebtipo character varying(100)
);

CREATE TABLE imovelweb.imovelwebsubtipo
(
  idimovelwebsubtipo serial PRIMARY KEY NOT NULL,
  idimovelwebtipo integer,
  imovelwebsubtipo character varying(255)
);

CREATE TABLE imovelweb.imovelwebcaracteristicas
(
  idimovelwebcaracteristicas character varying(50) PRIMARY KEY NOT NULL,
  idimovelwebtipo integer[],
  imovelwebcaracteristicas character varying(255),
  alias character varying(255),
  valor integer,
  idvalor character varying(20)[],
  valornombre character varying(50)[],
  idimoveldetalhe integer
);

CREATE TABLE imovelweb.imovelwebimovel
(
  idimovelwebimovel serial PRIMARY KEY NOT NULL,
  codigoanuncio integer,
  idtipo integer,
  idsubtipo integer,
  codigoreferencia character varying(255),
  titulo text,
  mostrarmapa character varying(50),
  descricao text,
  publicado date,
  deletedat date
);

CREATE TABLE imovelweb.imovelwebarea
(
  idimovelwebarea serial PRIMARY KEY NOT NULL,
  idimovelwebimovel integer CONSTRAINT fk_idimovelwebimovel REFERENCES imovelweb.imovelwebimovel (idimovelwebimovel),
  imovelwebarea character varying(50)
);


----------------------------------------------- Schema: Vistoria
CREATE SCHEMA vistoria;

CREATE TABLE vistoria.vistoriatipo
(
  idvistoriatipo serial PRIMARY KEY NOT NULL,
  vistoriatipo character varying(255) NOT NULL
);

CREATE TABLE vistoria.vistoriastatus
(
  idvistoriastatus serial PRIMARY KEY NOT NULL,
  vistoriastatus character varying(255) NOT NULL
);

CREATE TABLE vistoria.vistoria
(
  idvistoria serial PRIMARY KEY NOT NULL,
  idvistoriatipo serial NOT NULL CONSTRAINT fk_idvistoriatipo REFERENCES vistoria.vistoriatipo (idvistoriatipo),
  idvistoriastatus serial NOT NULL CONSTRAINT fk_idvistoriastatus REFERENCES vistoria.vistoriastatus (idvistoriastatus),
  idimovel integer,
  idcontrato integer,
  idvistoriador integer,
  aceite boolean,
  agendado boolean DEFAULT false,
  dtagendamento timestamp,
  dtinclusao date DEFAULT now(),
  dtvistoriado date,
  laudoconferencia text,
  laudoentrada text,
  laudosaida text,
  notificado boolean DEFAULT false,
  obs text,
  pzcontestacao date,
  videolink text
);

CREATE TABLE vistoria.vistoriadetalheestado
(
  idvistoriadetalheestado serial PRIMARY KEY NOT NULL,
  vistoriadetalheestado character varying(255) NOT NULL
);

CREATE TABLE vistoria.vistoriadetalhe
(
  idvistoriadetalhe serial PRIMARY KEY NOT NULL,
  idvistoria serial NOT NULL CONSTRAINT fk_idvistoria REFERENCES vistoria.vistoria (idvistoria) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  idvistoriadetalheestado serial NOT NULL CONSTRAINT fk_idvistoriadetalheestado REFERENCES vistoria.vistoriadetalheestado (idvistoriadetalheestado),
  idimoveldetalhe serial NOT NULL CONSTRAINT fk_idimoveldetalhe REFERENCES imovel.imoveldetalhe (idimoveldetalhe),
  idimg character varying(13),
  avaliacao text,
  caracterizacao text,
  contestacaoargumento text,
  contestacaoimg text,
  contestacaoresposta text,
  descricao character varying(255),
  dtcontestacao date,
  dtinconformidade date,
  editado boolean DEFAULT false,
  inconformidade text,
  inconformidadeimg text,
  inconformidadereparo boolean DEFAULT false,
  inconformidadevalor numeric(10,2),
  index character varying(50)
);

CREATE TABLE vistoria.vistoriadetalheimg
(
	idvistoriadetalheimg serial PRIMARY KEY NOT NULL ,
	idvistoria serial CONSTRAINT fk_idvistoria REFERENCES vistoria.vistoria (idvistoria) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
	idvistoriadetalhe serial CONSTRAINT fk_idvistoriadetalhe REFERENCES vistoria.vistoriadetalhe (idvistoriadetalhe) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
	idimg text,
	vistoriadetalheimg text,
	legenda character varying(255),
	dtinclusao date DEFAULT now()
);


CREATE TABLE vistoria.vistoriahistorico
(
      idvistoriahistorico serial PRIMARY KEY NOT NULL,
      idvistoria integer,
      idcontrato integer,
      idimovel integer,
      idsystemuser integer,
      iddocumento integer,
      createdat timestamp DEFAULT now(),
      titulo character varying(100) NOT NULL,
      historico text
);

------------------------------------------------- Schema: financeiro

CREATE SCHEMA financeiro;

CREATE TABLE financeiro.banco
(
  idbanco serial PRIMARY KEY NOT NULL,
  codbanco character varying(10) NOT NULL,
  banco character varying(250) NOT NULL,
  ispb character varying(50)
);

CREATE TABLE financeiro.bancotipoconta
(
  idbancotipoconta serial PRIMARY KEY NOT NULL,
  bancotipoconta character varying(250) NOT NULL,
  bankaccounttype character varying(250) NOT NULL
);

CREATE TABLE financeiro.bancopixtipo
(
  idbancopixtipo serial PRIMARY KEY NOT NULL,
  bancopixtipo character varying(250) NOT NULL,
  pixaddresskeytype character varying(250) NOT NULL
);

CREATE TABLE IF NOT EXISTS financeiro.pconta
(
    idgenealogy serial PRIMARY KEY NOT NULL,
    people character varying(255),
    idparent integer,
    createdat timestamp without time zone,
    deletedat timestamp without time zone,
    updatedat timestamp without time zone,
    CONSTRAINT pconta_idparent_fkey FOREIGN KEY (idparent)
        REFERENCES financeiro.pconta (idgenealogy) MATCH SIMPLE
);


CREATE TABLE financeiro.faturaformapagamento
(
  idfaturaformapagamento serial PRIMARY KEY NOT NULL,
  billingType character varying(100) NOT NULL,
  deletedat timestamp without time zone,
  faturaformapagamento character varying(100) NOT NULL
);

CREATE TABLE financeiro.fatura
(
  idfatura serial PRIMARY KEY NOT NULL,
  idfaturaorigemrepasse integer,
  idcaixa integer,
  idcontrato integer,
  idfaturaformapagamento integer REFERENCES financeiro.faturaformapagamento (idfaturaformapagamento),
  idpessoa integer NOT NULL REFERENCES pessoa.pessoa (idpessoa) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  idsystemuser integer,
  background character varying(10),
  createdat timestamp,
  deducoes numeric(15,2),
  deletedat timestamp,
  descontodiasant smallint, -- Desconto Dias Antecipacao
  descontotipo character varying(50), -- FIXED: Valor fixo - PERCENTAGE: Valor percentual
  descontovalor numeric(10,2),
  dtpagamento date,
  dtvencimento date,
  emiterps boolean DEFAULT false, 
  es character(1) NOT NULL, -- Contas Pag(S) Rec(E)
  fatura boolean DEFAULT false, -- Se é fatura (T) ou Conta PagRec (F)
  gerador text, -- uuid para identificar o gerador da fatura
  instrucao text,
  juros numeric(10,2),
  multa numeric(10,2),
  multafixa boolean DEFAULT false,
  parcela integer,
  parcelas integer,
  periodofinal date,
  periodoinicial date,
  registrado boolean DEFAULT false,
  referencia text,
  repasse boolean DEFAULT true,
  servicopostal boolean DEFAULT false, --Asaas: Define se a cobrança será enviada via Correios
  updatedat timestamp,
  valortotal numeric(15,2)
);


CREATE TABLE financeiro.faturadetalheitem
(
  idfaturadetalheitem serial PRIMARY KEY NOT NULL,
  cofins numeric(6,2),
  csll numeric(6,2),
  ehdespesa boolean DEFAULT false,
  ehservico boolean DEFAULT false,
  faturadetalheitem character varying(150),
  inss numeric(6,2),
  ir numeric(6,2),
  iss numeric(6,2),
  municipalservicecode text,
  municipalserviceid text,
  municipalservicename text,
  pis numeric(6,2),
  retainiss boolean DEFAULT false
);

CREATE TABLE financeiro.faturadetalhe
(
    idfaturadetalhe serial PRIMARY KEY NOT NULL,
    idfaturadetalheitem integer NOT NULL,
    idfatura integer,
    comissaopercent numeric(10,2),
    comissaovalor numeric(15,2),
    desconto numeric(10,2),
    descontoobs character varying(250),
    ehdespesa boolean,
    ehservico boolean,
    idpconta integer,
    qtde numeric(6,2),
    repasseidpessoa integer,
    repasselocador character varying(2),
    repassepercent numeric(10,2),
    repassevalor numeric(15,2),
    tipopagamento character(1) DEFAULT 'O',
    valor numeric(15,2),
    CONSTRAINT faturadetalhe_idfaturadetalheitem_fkey FOREIGN KEY (idfaturadetalheitem)
        REFERENCES financeiro.faturadetalheitem (idfaturadetalheitem) MATCH SIMPLE,
    CONSTRAINT fk_idfatura FOREIGN KEY (idfatura)
        REFERENCES financeiro.fatura (idfatura) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID,
    CONSTRAINT faturadetalhe_tipopagamento_check CHECK (tipopagamento = 'O' OR tipopagamento = 'I' OR tipopagamento = 'R')
);


CREATE TABLE financeiro.faturasplit
(
  idfaturasplit serial PRIMARY KEY NOT NULL,
  idfatura integer REFERENCES financeiro.fatura (idfatura),
  idpessoa integer REFERENCES pessoa.pessoa (idpessoa),
  spliidpessoawalletid character varying(255),
  splitfixedvalue numeric(10,2),
  splitpercentualvalue numeric(10,2)
);

CREATE TABLE financeiro.faturaresponse
(
  idfaturaresponse serial PRIMARY KEY NOT NULL,
  idfatura integer REFERENCES financeiro.fatura (idfatura),
  idasaasfatura text,
  anticipable boolean,
  anticipated boolean,
  bankslipurl text,
  billingtype character varying(100),
  canbepaidafterduedate boolean,
  candelete text,
  canedit text,
  cannotbedeletedreason text,
  cannoteditreason text,
  chargebackreason text,
  chargebackstatus character varying(50),
  clientpaymentdate date,
  confirmeddate date,
  customer text,
  dateCreated date,
  daysafterduedatetocancellationregistration integer,
  deleted boolean,
  description text,
  discountduedatelimitdays integer,
  discounttype character varying(100),
  discountvalue numeric(10,2),
  docavailableafterpayment boolean,
  docdeleted boolean,
  docfiledownloadurl text,
  docfileextension character varying(150),
  docfileoriginalname text,
  docfilepreviewurl text,
  docfilepublicid text,
  docfilesize integer,
  docid text,
  docname text,
  docobject text,
  doctype text,
  duedate date,
  externalreference text,
  finetype character varying(100),
  finevalue numeric(10,2),
  installment text,
  installmentnumber integer,
  interestovalue numeric(10,2),
  interestvalue numeric(15,2),
  invoicenumber text,
  invoiceurl text,
  municipalinscription character varying(150),
  netvalue numeric(15,2),
  nossonumero text,
  object text,
  originalduedate date,
  originalvalue numeric(15,2),
  paymentdate date,
  paymentlink text,
  pixqrcodeid text,
  pixtransaction text,
  postalservice boolean,
  refundsdatecreated date,
  refundsdescription text,
  refundsstatus character varying(50),
  refundstransactionreceipturl text,
  refundsvalue numeric(15,2),
  restituicao character(1) NOT NULL DEFAULT 'R',
  splitfixedvalue numeric(15,2),
  splitpercentualvalue numeric(10,2),
  splitrefusalreason text,
  splitstatus character varying(50),
  splitwalletid text,
  stateInscription character varying(150),
  status character varying(100),
  subscription text,
  transactionreceipturl text,
  value numeric(15,2)
 );


CREATE TABLE financeiro.extratocc
(
    id serial PRIMARY KEY NOT NULL,
    idconfig integer,
    balance numeric(15,2),
    date date,
    description text,
    paymentid text,
    type text,
    value numeric(15,2)
);


CREATE TABLE financeiro.extratotransferencia
(
    id serial PRIMARY KEY NOT NULL,
    idconfig integer,
    accountname text,
    datecreated date,
    description text,
    effectivedate date,
    failreason text,
    operationtype text,
    ownername text,
    scheduledate date,
    status text,
    statusbr text,
    transactionreceipturl text,
    value numeric(15,2)
);


-- Criado em 14/04/2024
-- PAYMENT_CREATED - Geração de nova cobrança.
-- PAYMENT_AWAITING_RISK_ANALYSIS - Pagamento em cartão aguardando aprovação pela análise manual de risco.
-- PAYMENT_APPROVED_BY_RISK_ANALYSIS - Pagamento em cartão aprovado pela análise manual de risco.
-- PAYMENT_REPROVED_BY_RISK_ANALYSIS - Pagamento em cartão reprovado pela análise manual de risco.
-- PAYMENT_AUTHORIZED - Pagamento em cartão que foi autorizado e precisa ser capturado.
-- PAYMENT_UPDATED - Alteração no vencimento ou valor de cobrança existente.
-- PAYMENT_CONFIRMED - Cobrança confirmada (pagamento efetuado, porém o saldo ainda não foi disponibilizado).
-- PAYMENT_RECEIVED - Cobrança recebida.
-- PAYMENT_CREDIT_CARD_CAPTURE_REFUSED - Falha no pagamento de cartão de crédito
-- PAYMENT_ANTICIPATED - Cobrança antecipada.
-- PAYMENT_OVERDUE - Cobrança vencida.
-- PAYMENT_DELETED - Cobrança removida.
-- PAYMENT_RESTORED - Cobrança restaurada.
-- PAYMENT_REFUNDED - Cobrança estornada.
-- PAYMENT_REFUND_IN_PROGRESS - Estorno em processamento (liquidação já está agendada, cobrança será estornada após executar a liquidação).
-- PAYMENT_RECEIVED_IN_CASH_UNDONE - Recebimento em dinheiro desfeito.
-- PAYMENT_CHARGEBACK_REQUESTED - Recebido chargeback.
-- PAYMENT_CHARGEBACK_DISPUTE - Em disputa de chargeback (caso sejam apresentados documentos para contestação).
-- PAYMENT_AWAITING_CHARGEBACK_REVERSAL - Disputa vencida, aguardando repasse da adquirente.
-- PAYMENT_DUNNING_RECEIVED - Recebimento de negativação.
-- PAYMENT_DUNNING_REQUESTED - Requisição de negativação.
-- PAYMENT_BANK_SLIP_VIEWED - Boleto da cobrança visualizado pelo cliente.
-- PAYMENT_CHECKOUT_VIEWED - Fatura da cobrança visualizada pelo cliente.

CREATE TABLE financeiro.faturaevento
(
  idfaturaevento serial PRIMARY KEY NOT NULL,
  idfatura integer NOT NULL,
  idevento text,
  dtevento timestamp,
  event character varying(200),
  evento character varying(200),
  eventodescricao text,
  referencia text
);

CREATE TABLE financeiro.faturaresumo
( 
    idfaturaresumo serial PRIMARY KEY NOT NULL,
    idcontrato integer,
    idinquilino integer,
    idlocador integer,
    idpagador integer,
    aluguel numeric(15,2),
    comissao numeric(15,2),
    createdat timestamp,
    createdby integer,
    desconto numeric(10,2),
    gerador text,
    indenizacao numeric(15,2),
    juros numeric(10,2),
    multa numeric(10,2),
    parcelas integer,
    repassealuguel numeric(15,2),
    repasseoutros numeric(15,2),
    totalfatura numeric(15,2),
    updatedat timestamp,
    updatedby integer
);


------------ Schema: financeiro : Caixa

CREATE TABLE financeiro.caixaespecie
(
  idcaixaespecie serial PRIMARY KEY NOT NULL,
  caixaespecie varchar(200) NOT NULL
);


CREATE TABLE financeiro.caixa
(
  idcaixa serial PRIMARY KEY NOT NULL,
  idcaixaespecie serial NOT NULL REFERENCES financeiro.caixaespecie (idcaixaespecie),
  idfatura integer,
  idpconta integer,
  idpessoa integer,
  idsystemuser integer,
  cnpjcpf character(20),
  createdat timestamp,
  deletedat timestamp,
  desconto numeric(10,2),
  despesa numeric(10,2),
  dtcaixa date NOT NULL DEFAULT now(),
  dtvencimento date,
  es character(1) CONSTRAINT ck_es CHECK (es = 'E' OR es = 'S'),
  estornado boolean NOT NULL DEFAULT false,
  historico text,
  juros numeric(10,2),
  multa numeric(10,2),
  pessoa character varying(200),
  updatedat timestamp,
  valor numeric(15,2),
  valorentregue numeric(15,2)
);


CREATE TABLE financeiro.transferenciaresponse
(
	idtransferenciaresponse serial PRIMARY KEY NOT NULL,
	idcaixa integer,
	idfatura integer,
	authorized boolean,
	bankaccount varchar(100),
	bankaccountdigit varchar(10),
	bankaccountname text,
	bankagency varchar(50),
	bankcode varchar(100),
	bankcpfcnpj varchar(50),
	bankispb varchar(200),
	bankname varchar(255),
	bankownername text,
	bankpixaddresskey text,
	canbecancelled text,
	codtransferencia text,
	confirmeddate date,
	datecreated date,
	description text,
	effectivedate date,
	endToEndIdentifier text,
	failreason text,
	netvalue numeric(15,2),
	operationtype varchar(50),
	scheduledate date,
	status varchar(200),
	transactionreceipturl text,
	transferfee numeric(15,2),
	value numeric(15,2),
	walletId text
);

CREATE INDEX idx_codtransferencia ON financeiro.transferenciaresponse (codtransferencia);

-- Criado em 12/09/2024
CREATE TABLE public.relatorio
(
    idrelatorio serial PRIMARY KEY NOT NULL,
    classe text,
    cor varchar(50),
    createdat timestamp,
    createdby integer,
    deletedat timestamp,
    deletedby integer,
    descricao text NOT NULL,
    estilo varchar(50),
    format varchar(50),
    icone varchar(200),
    orientacao varchar(200),
    ordem varchar(100),
    posicao integer,
    sentido varchar(200),
    titulo varchar(200)NOT NULL,
    updatedat timestamp,
    updatedby integer
); 

-- Criado em 12/09/2024
CREATE TABLE public.relatoriodetalhe
(
    idrelatoriodetalhe serial PRIMARY KEY NOT NULL,
    idrelatorio integer NOT NULL REFERENCES public.relatorio (idrelatorio) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
    coluna text,
    largura integer,
    totais varchar(200)
);

ALTER TABLE relatoriodetalhe ADD CONSTRAINT fk_relatoriodetalhe_relatorio FOREIGN KEY (idrelatorio) references public.relatorio(idrelatorio); 
 
CREATE index idx_relatoriodetalhe_idrelatorio on relatoriodetalhe(idrelatorio); 
SELECT setval('relatoriodetalhe_idrelatoriodetalhe_seq', coalesce(max(idrelatoriodetalhe),0) + 1, false) FROM relatoriodetalhe;


------------ Schema: OpenAI 12/10/2024
create schema openai; 

CREATE TABLE openai.openaiapi
( 
    idopenaiapi serial PRIMARY KEY NOT NULL,
    apikey text NOT NULL DEFAULT 'sua_chave_de_api_aqui',
    apiurl text NOT NULL DEFAULT 'https://api.openai.com/v1/chat/completions'
);

CREATE TABLE openai.openaiassunto
(
    idonpenaiassunto serial PRIMARY KEY NOT NULL,
    idopenaiapi integer NOT NULL REFERENCES openai.openaiapi(idopenaiapi),
    assunto varchar(200) NOT NULL,
    data_model text NOT NULL DEFAULT 'gpt-4',
    max_tokens integer NOT NULL DEFAULT 500,
    prompt text NOT NULL,
    temperature float NOT NULL DEFAULT 0.7,
    system_content text NOT NULL
);


---- CREAT INDEX
CREATE INDEX IF NOT EXISTS idx_caixa_idcaixaespecie on financeiro.caixa(idcaixaespecie);
CREATE INDEX IF NOT EXISTS idx_caixa_idfatura on financeiro.caixa(idfatura);
CREATE INDEX IF NOT EXISTS idx_cidade_iduf on public.cidade(iduf);
CREATE INDEX IF NOT EXISTS idx_config_idresponsavel on public.config(idresponsavel);
CREATE INDEX IF NOT EXISTS idx_config_idcidade on public.config(idcidade);
CREATE INDEX IF NOT EXISTS idx_contrato_idimovel on contrato.contrato(idimovel);
CREATE INDEX IF NOT EXISTS idx_contrato_idcontrato on contrato.contrato(idcontrato);
CREATE INDEX IF NOT EXISTS idx_contratoalteracao_idcontrato on contrato.contratoalteracao(idcontrato);
CREATE INDEX IF NOT EXISTS idx_contratoalteracao_idcontratoalteracaotipo on contrato.contratoalteracao(idcontratoalteracaotipo);
CREATE INDEX IF NOT EXISTS idx_contratoalteracaocontaparcela_idcontratoalteracao on contrato.contratoalteracaocontaparcela(idcontratoalteracao);
CREATE INDEX IF NOT EXISTS idx_contratoalteracaotipo_idcontratoato on contrato.contratoalteracaotipo(idcontratoato);
CREATE INDEX IF NOT EXISTS idx_contratopessoa_idcontrato on contrato.contratopessoa(idcontrato);
CREATE INDEX IF NOT EXISTS idx_contratopessoa_idpessoa on contrato.contratopessoa(idpessoa);
CREATE INDEX IF NOT EXISTS idx_contratopessoa_idcontratopessoaqualificacao on contrato.contratopessoa(idcontratopessoaqualificacao);
CREATE INDEX IF NOT EXISTS idx_documento_iddocumentotipo on autenticador.documento(iddocumentotipo);
CREATE INDEX IF NOT EXISTS idx_extratocc_idconfig on financeiro.extratocc(idconfig);
CREATE INDEX IF NOT EXISTS idx_extratotransferencia_idconfig on financeiro.extratotransferencia(idconfig);
CREATE INDEX IF NOT EXISTS idx_fatura_idpessoa on financeiro.fatura(idpessoa);
CREATE INDEX IF NOT EXISTS idx_fatura_idfaturaformapagamento on financeiro.fatura(idfaturaformapagamento);
CREATE INDEX IF NOT EXISTS idx_fatura_idcontrato on financeiro.fatura(idcontrato);
CREATE INDEX IF NOT EXISTS idx_faturadetalhe_idfatura on financeiro.faturadetalhe(idfatura);
CREATE INDEX IF NOT EXISTS idx_faturadetalhe_idfaturadetalheitem on financeiro.faturadetalhe(idfaturadetalheitem);
CREATE INDEX IF NOT EXISTS idx_faturadetalhe_repasseidpessoa on financeiro.faturadetalhe(repasseidpessoa);
CREATE INDEX IF NOT EXISTS idx_faturadetalhe_idpconta on financeiro.faturadetalhe(idpconta);
CREATE INDEX IF NOT EXISTS idx_faturaevento_idfatura on financeiro.faturaevento(idfatura);
CREATE INDEX IF NOT EXISTS idx_faturaresponse_idfatura on financeiro.faturaresponse(idfatura);
CREATE INDEX IF NOT EXISTS idx_faturaresumo_idlocador on financeiro.faturaresumo(idlocador);
CREATE INDEX IF NOT EXISTS idx_faturaresumo_idinquilino on financeiro.faturaresumo(idinquilino);
CREATE INDEX IF NOT EXISTS idx_faturaresumo_idpagador on financeiro.faturaresumo(idpagador);
CREATE INDEX IF NOT EXISTS idx_faturaresumo_idcontrato on financeiro.faturaresumo(idcontrato);
CREATE INDEX IF NOT EXISTS idx_faturasplit_idfatura on financeiro.faturasplit(idfatura);
CREATE INDEX IF NOT EXISTS idx_faturasplit_idpessoa on financeiro.faturasplit(idpessoa);
CREATE INDEX IF NOT EXISTS idx_historico_idcontrato on contrato.historico(idcontrato);
CREATE INDEX IF NOT EXISTS idx_imovel_idcidade on imovel.imovel(idcidade);
CREATE INDEX IF NOT EXISTS idx_imovel_idimovelsituacao on imovel.imovel(idimovelsituacao);
CREATE INDEX IF NOT EXISTS idx_imovel_idimoveldestino on imovel.imovel(idimoveldestino);
CREATE INDEX IF NOT EXISTS idx_imovel_idimovelmaterial on imovel.imovel(idimovelmaterial);
CREATE INDEX IF NOT EXISTS idx_imovel_idlisting on imovel.imovel(idlisting);
CREATE INDEX IF NOT EXISTS idx_imovelalbum_idimovel on imovel.imovelalbum(idimovel);
CREATE INDEX IF NOT EXISTS idx_imovelcorretor_idimovel on imovel.imovelcorretor(idimovel);
CREATE INDEX IF NOT EXISTS idx_imovelcorretor_idcorretor on imovel.imovelcorretor(idcorretor);
CREATE INDEX IF NOT EXISTS idx_imoveldetalheitem_idimovel on imovel.imoveldetalheitem(idimovel);
CREATE INDEX IF NOT EXISTS idx_imoveldetalheitem_idimoveldetalhe on imovel.imoveldetalheitem(idimoveldetalhe);
CREATE INDEX IF NOT EXISTS idx_imovelplanta_idimovel on imovel.imovelplanta(idimovel);
CREATE INDEX IF NOT EXISTS idx_imovelproprietario_idimovel on imovel.imovelproprietario(idimovel);
CREATE INDEX IF NOT EXISTS idx_imovelproprietario_idpessoa on imovel.imovelproprietario(idpessoa);
CREATE INDEX IF NOT EXISTS idx_imovelretiradachave_idimovel on imovel.imovelretiradachave(idimovel);
CREATE INDEX IF NOT EXISTS idx_imovelretiradachave_idpessoa on imovel.imovelretiradachave(idpessoa);
CREATE INDEX IF NOT EXISTS idx_imoveltur360_idimovel on imovel.imoveltur360(idimovel);
CREATE INDEX IF NOT EXISTS idx_imovelvideo_idimovel on imovel.imovelvideo(idimovel);
CREATE INDEX IF NOT EXISTS idx_openaiassunto_idopenaiapi on openai.openaiassunto(idopenaiapi);
CREATE INDEX IF NOT EXISTS idx_pessoa_bancoid on pessoa.pessoa(bancoid);
CREATE INDEX IF NOT EXISTS idx_pessoa_bancocontatipoid on pessoa.pessoa(bancocontatipoid);
CREATE INDEX IF NOT EXISTS idx_pessoa_bancopixtipoid on pessoa.pessoa(bancopixtipoid);
CREATE INDEX IF NOT EXISTS idx_pessoadetalheitem_idpessoadetalhe on pessoa.pessoadetalheitem(idpessoadetalhe);
CREATE INDEX IF NOT EXISTS idx_pessoadetalheitem_idpessoa on pessoa.pessoadetalheitem(idpessoa);
CREATE INDEX IF NOT EXISTS idx_pessoasystemusergroup_idpessoa on pessoa.pessoasystemusergroup(idpessoa);
CREATE INDEX IF NOT EXISTS idx_relatoriodetalhe_idrelatorio on public.relatoriodetalhe(idrelatorio);
CREATE INDEX IF NOT EXISTS idx_serasa_idpessoa on pessoa.serasa(idpessoa);
CREATE INDEX IF NOT EXISTS idx_signatario_idpessoa on autenticador.signatario(idpessoa);
CREATE INDEX IF NOT EXISTS idx_signatario_iddocumento on autenticador.signatario(iddocumento);
CREATE INDEX IF NOT EXISTS idx_site_idsitetemplate on site.site(idsitetemplate);
CREATE INDEX IF NOT EXISTS idx_siteheadtext_idsite on site.siteheadtext(idsite);
CREATE INDEX IF NOT EXISTS idx_sitesecaotitulo_idsite on site.sitesecaotitulo(idsite);
CREATE INDEX IF NOT EXISTS idx_sitesecaotitulo_idsitesecao on site.sitesecaotitulo(idsitesecao);
CREATE INDEX IF NOT EXISTS idx_siteslide_idsite on site.siteslide(idsite);
CREATE INDEX IF NOT EXISTS idx_sitetestemunho_idsite on site.sitetestemunho(idsite);
CREATE INDEX IF NOT EXISTS idx_template_idtemplatetipo on public.template(idtemplatetipo);
CREATE INDEX IF NOT EXISTS idx_transferenciaresponse_idcaixa on financeiro.transferenciaresponse(idcaixa);
CREATE INDEX IF NOT EXISTS idx_transferenciaresponse_idfatura on financeiro.transferenciaresponse(idfatura);
CREATE INDEX IF NOT EXISTS idx_vistoria_idvistoriatipo on vistoria.vistoria(idvistoriatipo);
CREATE INDEX IF NOT EXISTS idx_vistoria_idvistoriastatus on vistoria.vistoria(idvistoriastatus);
CREATE INDEX IF NOT EXISTS idx_vistoria_idimovel on vistoria.vistoria(idimovel);
CREATE INDEX IF NOT EXISTS idx_vistoria_idcontrato on vistoria.vistoria(idcontrato);
CREATE INDEX IF NOT EXISTS idx_vistoria_idvistoriador on vistoria.vistoria(idvistoriador);
CREATE INDEX IF NOT EXISTS idx_vistoriadetalhe_idvistoria on vistoria.vistoriadetalhe(idvistoria);
CREATE INDEX IF NOT EXISTS idx_vistoriadetalhe_idvistoriadetalheestado on vistoria.vistoriadetalhe(idvistoriadetalheestado);
CREATE INDEX IF NOT EXISTS idx_vistoriadetalhe_idimoveldetalhe on vistoria.vistoriadetalhe(idimoveldetalhe);
CREATE INDEX IF NOT EXISTS idx_vistoriadetalheimg_idvistoriadetalhe on vistoria.vistoriadetalheimg(idvistoriadetalhe);
CREATE INDEX IF NOT EXISTS idx_vistoriahistorico_idcontrato on vistoria.vistoriahistorico(idcontrato);
CREATE INDEX IF NOT EXISTS idx_vistoriahistorico_idvistoria on vistoria.vistoriahistorico(idvistoria);
CREATE INDEX IF NOT EXISTS idx_vistoriahistorico_idimovel on vistoria.vistoriahistorico(idimovel);

------------ Criar Função para o site -----
CREATE OR REPLACE FUNCTION pessoa.sem_acento(
	text)
    RETURNS text
    LANGUAGE 'sql'
    COST 100
    IMMUTABLE STRICT PARALLEL UNSAFE
AS $BODY$
select translate($1,'áàâãäéèêëíìïóòôõöúùûüÁÀÂÃÄÉÈÊËÍÌÏÓÒÔÕÖÚÙÛÜñÑçÇ','aaaaaeeeeiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUnNcC');
$BODY$;