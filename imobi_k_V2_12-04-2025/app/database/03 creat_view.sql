-- 1
CREATE OR REPLACE VIEW cidadefull AS 
SELECT
    cidade.idcidade AS idcidade,
    cidade.cidade AS cidade,
    (cidade.cidade || ' (' || uf.uf || ')')::character varying(200) AS cidadeuf,
    cidade.iduf AS iduf,
    cidade.latilongi AS latilongi,
    uf.uf AS uf,
    uf.ufextenso AS ufextenso,
    cidade.codreceita AS codreceita,
    cidade.codibge AS codibge,
	cidade.deletedat AS deletedat
   FROM cidade
   INNER JOIN uf ON cidade.iduf = uf.iduf;
 
 -- 2
CREATE OR REPLACE VIEW templatefull AS 
 SELECT
    template.idtemplate AS idtemplate,
    template.idtemplatetipo AS idtemplatetipo,
    templatetipo.templatetipo AS templatetipo,
    template.view AS view,
    template.titulo AS titulo,
    template.template AS template,
    template.deletedat AS deletedat
   FROM template, templatetipo
  WHERE template.idtemplatetipo = templatetipo.idtemplatetipo;

-- 3
CREATE VIEW pessoa.pessoafull AS
SELECT
	pessoa.idpessoa AS idpessoa,
	lpad(cast(pessoa.idpessoa AS text),6,'0') AS idpessoachar,
	pessoa.idunit AS idunit,
	pessoa.pessoa AS pessoa,
	pessoa.politico AS politico,
	pessoa.idsystemuser AS idsystemuser, 
	pessoa.systemuseractive AS systemuseractive,
	pessoa.systemuserid AS systemuserid,
	pessoa.ehcorretor AS ehcorretor,
	pessoa.cep AS cep,
	pessoa.idcidade AS idcidade,
	cidadefull.cidadeuf AS cidadeuf,
	cidadefull.cidade AS cidade,
	cidadefull.uf AS sigla,
	cidadefull.ufextenso AS estado,
	pessoa.cnpjcpf AS cnpjcpf,
	pessoa.createdat AS createdat,
	pessoa.ativo AS ativo,
	pessoa.admin AS admin,
	pessoa.asaasid AS asaasid,
	pessoa.walletid AS walletid,
	pessoa.apikey AS apikey,
	pessoa.selfie AS selfie,
	pessoa.updatedat AS updatedat,
	pessoa.deletedat AS deletedat,
	pessoa.bancoagencia AS bancoagencia,
	pessoa.bancoagenciadv AS bancoagenciadv,
	pessoa.bancoconta AS bancoconta,
	pessoa.bancocontadv AS bancocontadv,
	pessoa.bancocontatipoid AS bancocontatipoid,
	financeiro.bancotipoconta.bancotipoconta AS bancocontatipo,
	financeiro.bancotipoconta.bankaccounttype AS bankaccounttype,
	pessoa.bancoid AS bancoid,
	banco.banco AS banco,
	banco.codbanco AS bancocod,
	banco.ispb AS ispb,
	pessoa.bancochavepix AS bancochavepix,
	pessoa.bancopixtipoid AS bancopixtipoid,
	bancopixtipo.bancopixtipo AS bancopixtipo,
	bancopixtipo.pixaddresskeytype AS pixaddresskeytype,
    CASE
        WHEN pessoa.cnpjcpf IS NULL THEN (pessoa.pessoa || '<font color=red size=-2> [Lead]</font>')
        ELSE pessoa.pessoa
    END AS pessoalead,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 1 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS bairro,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 2 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS bancolist,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 3 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS bcoagencia,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 4 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS bcocc,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 5 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS bconomedeposito,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 6 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS ceplist,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 7 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS conjuge,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 8 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS dependente,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 9 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS dtfundacao,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 10 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS dtnascimento,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 11 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS email,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 12 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS endereco,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 13 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS estadocivil,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 14 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS fones,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 15 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS inscestadual,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 16 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS inscmunicipal,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 17 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS nacionalidade,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 18 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS naturalidade,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 19 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS nomefantasia,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 20 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS observacoes,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 21 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS pasta,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 22 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS profissao,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 23 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS responsaveis,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 24 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS rg,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 25 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS senha,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 26 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS site,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 27 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS socios,
	( SELECT pessoadetalheitem.pessoadetalheitem
	FROM pessoa.pessoadetalheitem
          WHERE pessoadetalheitem.idpessoadetalhe = 28 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS tipoempresa,
	( SELECT pessoadetalheitem.pessoadetalheitem
           FROM pessoa.pessoadetalheitem
          WHERE pessoadetalheitem.idpessoadetalhe = 29 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS celular,
    ( SELECT pessoadetalheitem.pessoadetalheitem
           FROM pessoa.pessoadetalheitem
          WHERE pessoadetalheitem.idpessoadetalhe = 30 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS endereconro,
    ( SELECT pessoadetalheitem.pessoadetalheitem
           FROM pessoa.pessoadetalheitem
          WHERE pessoadetalheitem.idpessoadetalhe = 31 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS enderecocomplemento,
	( SELECT pessoadetalheitem.pessoadetalheitem
		FROM pessoa.pessoadetalheitem
		WHERE pessoadetalheitem.idpessoadetalhe = 32 AND pessoadetalheitem.idpessoa = pessoa.idpessoa) AS creci
FROM pessoa.pessoa
LEFT JOIN public.cidadefull ON pessoa.pessoa.idcidade = public.cidadefull.idcidade
LEFT JOIN financeiro.banco ON pessoa.pessoa.bancoid = financeiro.banco.idbanco
LEFT JOIN financeiro.bancotipoconta ON pessoa.pessoa.bancocontatipoid = financeiro.bancotipoconta.idbancotipoconta
LEFT JOIN financeiro.bancopixtipo ON pessoa.pessoa.bancopixtipoid = financeiro.bancopixtipo.idbancopixtipo
ORDER BY pessoa.idpessoa;

-- 4
CREATE OR REPLACE VIEW pessoa.pessoadetalheitemfull AS
SELECT
    pessoadetalheitem.idpessoadetalheitem AS idpessoadetalheitem,
    pessoadetalheitem.idpessoa AS idpessoa,
    pessoa.pessoa AS pessoa,
    pessoadetalheitem.idpessoadetalhe AS idpessoadetalhe,
    pessoadetalhe.pessoadetalhe AS pessoadetalhe,
    pessoadetalheitem.pessoadetalheitem AS pessoadetalheitem
FROM pessoa.pessoa,
    pessoa.pessoadetalhe,
    pessoa.pessoadetalheitem
WHERE pessoa.idpessoa = pessoadetalheitem.idpessoa AND pessoadetalheitem.idpessoadetalhe = pessoadetalhe.idpessoadetalhe
ORDER BY pessoadetalheitem.idpessoadetalheitem;

-- 5
CREATE OR REPLACE VIEW configfull AS 
SELECT
	public.config.idconfig AS idconfig,
	public.config.idcidade AS idcidade,
	public.config.appdomain AS appdomain,
	public.cidadefull.cidade AS cidade,
	public.cidadefull.cidadeuf AS cidadeuf,
	public.cidadefull.iduf AS iduf,
	public.cidadefull.uf AS uf,
	public.cidadefull.ufextenso AS ufextenso,
	public.cidadefull.codreceita AS codreceita,
	public.cidadefull.codibge AS codibge,
	public.cidadefull.latilongi AS latilongi,
	public.config.idresponsavel AS idresponsavel,
	pessoa.pessoafull.pessoa AS responsavel,
	pessoa.pessoafull.cnpjcpf AS responsavelcpf,
    pessoa.pessoafull.fones AS responsavelfone,
    pessoa.pessoafull.email AS responsavelemail,	
	public.config.razaosocial AS razaosocial,
	public.config.nomefantasia AS nomefantasia,
	public.config.creci AS creci,
	public.config.cnpjcpf AS cnpjcpf,
		CASE
			WHEN length(config.cnpjcpf) = 11 THEN 'F'
			WHEN length(config.cnpjcpf) = 14 THEN 'J'
            ELSE NULL::text
        END AS persontype,
        CASE
            WHEN length(config.cnpjcpf) = 11 THEN 'FISICA'
            WHEN length(config.cnpjcpf) = 14 THEN 'JURIDICA'
            ELSE NULL
        END AS persontypeext,	
	public.config.inscestadual AS inscestadual,
	public.config.inscmunicipal AS inscmunicipal,
	public.config.endereco AS endereco,
	public.config.bairro AS bairro,
	public.config.cep AS cep,
	public.config.fone AS fone,
	public.config.email AS email,
	public.config.dtatualizacao AS dtatualizacao,
	public.config.dtfundacao AS dtfundacao,
	public.config.companytype AS companytype,
        CASE
            WHEN config.companytype = 'M'::bpchar THEN 'MEI'
            WHEN config.companytype = 'L'::bpchar THEN 'LIMITED'
            WHEN config.companytype = 'I'::bpchar THEN 'INDIVIDUAL'
            WHEN config.companytype = 'A'::bpchar THEN 'ASSOCIATION'
            ELSE NULL::text
        END AS companytypeeng,
        CASE
            WHEN config.companytype = 'M'::bpchar THEN 'MEI'
            WHEN config.companytype = 'L'::bpchar THEN 'LIMITADA'
            WHEN config.companytype = 'I'::bpchar THEN 'INDIVIDUAL'
            WHEN config.companytype = 'A'::bpchar THEN 'ASSOCIAÇÃO'
            ELSE NULL::text
        END AS companytypeptbr,	
	public.config.mobilephone AS mobilephone,
	public.config.addressnumber AS addressnumber,
	public.config.complement AS complement,
	public.config.walletid AS walletid,
	public.config.apikey AS apikey,
	public.config.system AS system,
	public.config.dtregistro AS dtregistro,
	public.config.simplesnacional AS simplesnacional,
	public.config.culturalprojectspromoter AS culturalprojectspromoter,
	public.config.cnae AS cnae,
	public.config.specialtaxregime AS specialtaxregime,
	public.config.servicelistitem AS servicelistitem,
	public.config.rpsserie AS rpsserie,
	public.config.rpsnumber AS rpsnumber,
	public.config.lotenumber AS lotenumber,
	public.config.username AS username,
	public.config.password AS password,
	public.config.accesstoken AS accesstoken,
	public.config.certificatefile AS certificatefile,
	public.config.certificatepassword AS certificatepassword,
	public.config.logobackgroundcolor AS logobackgroundcolor,
	public.config.infobackgroundcolor AS infobackgroundcolor,
	public.config.fontcolor AS fontcolor,
	public.config.enabled AS enabled,
	public.config.logofile AS logofile,
	public.config.whurl AS whurl,
	public.config.whemail AS whemail,
	public.config.whapiversion AS whapiversion,
	public.config.whenabled AS whenabled,
	public.config.whinterrupted AS whinterrupted,
	public.config.whauthtoken AS whauthtoken,
	public.config.whnurl AS whnurl,
	public.config.whnemail AS whnemail,
	public.config.whnapiversion AS whnapiversion,
	public.config.whnenabled AS whnenabled,
	public.config.whninterrupted AS whninterrupted,
	public.config.whnauthtoken AS whnauthtoken,
	public.config.whtapiversion AS whtapiversion,
	public.config.whtauthtoken AS whtauthtoken,
	public.config.whtemail AS whtemail,
	public.config.whtenabled AS whtenabled,
	public.config.whtinterrupted AS whtinterrupted,
	public.config.whturl AS whturl,
	public.config.idcontapai AS idcontapai,
	public.config.database AS database,
	public.config.clientes AS clientes,
	public.config.clientesvalue AS clientesvalue,
	public.config.contratos AS contratos,
	public.config.contratosvalue AS contratosvalue,
	public.config.imagens AS imagens,
	public.config.imagensbackup AS imagensbackup,
	public.config.imagensvalue AS imagensvalue,
	public.config.imoveis AS imoveis,
	public.config.imoveisvalue AS imoveisvalue,	
	public.config.logomarca AS logomarca,
	public.config.marcadagua AS marcadagua,
	public.config.marcadaguatransparencia AS marcadaguatransparencia,
	public.config.mensagens AS mensagens,
	public.config.mensagensvalue AS mensagensvalue,
	public.config.templates AS templates,
	public.config.templatesvalue AS templatesvalue,
	public.config.usuarios AS usuarios,
	public.config.usuariosvalue AS usuariosvalue,
	public.config.vistorias AS vistorias,
	public.config.vistoriasvalue AS vistoriasvalue,
	public.config.reconhecimentofacial AS reconhecimentofacial,
	public.config.reconhecimentofacialvalue AS reconhecimentofacialvalue,
	public.config.sigfranquia AS sigfranquia,
	public.config.sigfranquiavalue AS sigfranquiavalue,
	public.config.templatecaixaentrada AS templatecaixaentrada,
	public.config.templatecaixasaida AS templatecaixasaida,
	public.config.templatecontratolocacao AS templatecontratolocacao,
	public.config.templatefaturainstrucao AS templatefaturainstrucao,
	public.config.templateimovel AS templateimovel,
	public.config.templatevistoriaconferencia AS templatevistoriaconferencia,
	public.config.templatevistoriaentrada AS templatevistoriaentrada,
	public.config.templatevistoriasaida AS templatevistoriasaida,
	public.config.transferencias AS transferencias,
	public.config.transferenciasvalue AS transferenciasvalue,
	public.config.zsauthmode AS zsauthmode,
	public.config.zsblankemail AS zsblankemail,
	public.config.zsbrandlogo AS zsbrandlogo,
	public.config.zsbrandname AS zsbrandname,
	public.config.zsbrandprimarycolor AS zsbrandprimarycolor,
	public.config.zscreatedby AS zscreatedby,
	public.config.zscustommessage AS zscustommessage,
	public.config.zsdisablesigneremails AS zsdisablesigneremails,
	public.config.zsfolderpath AS zsfolderpath,
	public.config.zshideemail AS zshideemail,
	public.config.zshidephone AS zshidephone,
	public.config.zslang AS zslang,
	public.config.zslockemail AS zslockemail,
	public.config.zslockname AS zslockname,
	public.config.zslockphone AS zslockphone,
	public.config.zsobservers AS zsobservers,
	public.config.zspermitirreconhecimento AS zspermitirreconhecimento,
	public.config.zsredirectlink AS zsredirectlink,
	public.config.zsremindereveryndays AS zsremindereveryndays,
	public.config.zsrequiredocumentphoto AS zsrequiredocumentphoto,
	public.config.zsrequireselfiephoto AS zsrequireselfiephoto,
	public.config.zssandbox AS zssandbox,
	public.config.zsselfievalidationtype AS zsselfievalidationtype,
	public.config.zssendautomaticemail AS zssendautomaticemail,
	public.config.zssendautomaticwhatsapp AS zssendautomaticwhatsapp,
	public.config.zssignatureorderactive AS zssignatureorderactive,
	public.config.zssignedfileonlyfinished AS zssignedfileonlyfinished,
	public.config.zstoken AS zstoken,
	public.config.incomevalue AS incomevalue
FROM
	public.config INNER JOIN public.cidadefull ON public.config.idcidade = public.cidadefull.idcidade
	INNER JOIN pessoa.pessoafull ON public.config.idresponsavel = pessoa.pessoafull.idpessoa;


-- 6
CREATE OR REPLACE VIEW imovel.imovelproprietariofull AS
SELECT
	imovel.imovelproprietario.idimovelproprietario AS idimovelproprietario,
	imovel.imovelproprietario.idimovel AS idimovel,
	imovel.imovel.logradouro AS logradouro,
	imovel.imovel.bairro AS bairro,
	imovel.imovelproprietario.idpessoa AS idpessoa,
	pessoa.pessoa.pessoa AS pessoa,
	imovel.imovelproprietario.fracao AS fracao
FROM	imovel.imovelproprietario LEFT JOIN imovel.imovel ON imovel.imovelproprietario.idimovel = imovel.imovel.idimovel
	LEFT JOIN pessoa.pessoa ON imovel.imovelproprietario.idpessoa = pessoa.pessoa.idpessoa
ORDER BY imovel.imovelproprietario.idimovel;

   
-- 7
CREATE OR REPLACE VIEW imovel.imovelfull AS
	SELECT
	imovel.idimovel AS idimovel,
	lpad(cast(imovel.idimovel AS text),6,'0') AS idimovelchar,
	imovel.idcidade AS idcidade,
	imovel.idimoveldestino AS idimoveldestino,
	imovel.idimovelmaterial AS idimovelmaterial,
	imovel.idimovelsituacao AS idimovelsituacao,
	imovel.idimoveltipo AS idimoveltipo,
	imovel.idsystemuser AS idsystemuser,
	imovel.idunit AS idunit,
	imovel.idlisting AS idlisting,
	imovel.aluguel AS aluguel,
	imovel.area AS area,
	imovel.bairro AS bairro,
	imovel.capaimg AS capaimg,
	imovel.caracteristicas AS caracteristicas,
	imovel.cep AS cep,
	cidadefull.cidade AS cidade,
	cidadefull.cidadeuf AS cidadeuf,
	imovel.claviculario AS claviculario,
	cidadefull.codreceita AS codreceita,
	imovel.complemento AS complemento,
	imovel.condominio AS condominio,
	imovel.createdat AS createdat,
	imovel.deletedat AS deletedat,
	imovel.divulgar AS divulgar,
	imovel.logradouro || ', Nº: ' || COALESCE(imovel.logradouronro, 'N/C') AS endereco,
	imovel.logradouro || ', Nº: ' || COALESCE(imovel.logradouronro, 'N/C') || ', Bairro: ' || COALESCE(imovel.bairro, ' N/C')|| ', CEP: ' || COALESCE(imovel.cep, ' N/C') || ', Cidade: ' || COALESCE(cidadefull.cidade, 'N/C') AS enderecofull,
	imovel.etiquetamodelo AS etiquetamodelo,
	imovel.etiquetanome AS etiquetanome,
	imovel.exibealuguel AS exibealuguel,
	imovel.exibelogradouro AS exibelogradouro,
	imovel.exibevalorvenda AS exibevalorvenda,
	( SELECT patch FROM imovel.imovelalbum WHERE idimovel = imovel.idimovel ORDER BY orderby LIMIT 1) AS fotocapa,
	imovel.grupozap AS grupozap,
	imoveldestino.imoveldestino AS imoveldestino,
	imovelmaterial.imovelmaterial AS imovelmaterial,
	imovel.imovelregistro AS imovelregistro,
	imovelsituacao.imovelsituacao AS imovelsituacao,
	imoveltipo.imoveltipo AS imoveltipo,
	imovel.imovelweb AS imovelweb,
	imovel.iptu AS iptu,
	imovel.labelnovalvalues AS labelnovalvalues,
	imovel.lancamento AS lancamento,
	imovel.lancamentoimg AS lancamentoimg,
	imovel.logradouro AS logradouro,
	imovel.logradouronro AS logradouronro,
	imovel.lote AS lote,
	imovel.mapa AS mapa,
	imovel.obs AS obs,
	imovel.outrataxa AS outrataxa,
	imovel.outrataxavalor AS outrataxavalor,
	imovel.perimetro AS perimetro,
	array_to_string((select array(select (' ' ||pessoa)::text from imovel.imovelproprietariofull where imovel.imovelproprietariofull.idimovel = imovel.imovel.idimovel ) ), ',', '{removido}') AS pessoas,
	imovel.prefeituramatricula AS prefeituramatricula,
	imovel.proposta AS proposta,
	imovel.quadra AS quadra,
	imovel.setor AS setor,
	cidadefull.uf AS uf,
	cidadefull.ufextenso AS ufextenso,
	imovel.updatedat AS updatedat,
	imovel.venda AS venda,
	imovel.video AS video,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 1 AND imoveldetalheitem.idimovel = imovel.idimovel) AS abrigo,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 2 AND imoveldetalheitem.idimovel = imovel.idimovel) AS aquecedor,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 3 AND imoveldetalheitem.idimovel = imovel.idimovel) AS areaservico,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 4 AND imoveldetalheitem.idimovel = imovel.idimovel) AS banheiro,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 5 AND imoveldetalheitem.idimovel = imovel.idimovel) AS biblioteca,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 6 AND imoveldetalheitem.idimovel = imovel.idimovel) AS churrasqueira,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 7 AND imoveldetalheitem.idimovel = imovel.idimovel) AS closet,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 8 AND imoveldetalheitem.idimovel = imovel.idimovel) AS condicionador,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 9 AND imoveldetalheitem.idimovel = imovel.idimovel) AS copa,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 10 AND imoveldetalheitem.idimovel = imovel.idimovel) AS dependenciaemp,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 11 AND imoveldetalheitem.idimovel = imovel.idimovel) AS despensa,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 12 AND imoveldetalheitem.idimovel = imovel.idimovel) AS dormitorio,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 13 AND imoveldetalheitem.idimovel = imovel.idimovel) AS escritorio,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 14 AND imoveldetalheitem.idimovel = imovel.idimovel) AS homeoffice,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 15 AND imoveldetalheitem.idimovel = imovel.idimovel) AS lareira,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 16 AND imoveldetalheitem.idimovel = imovel.idimovel) AS lavabo,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 17 AND imoveldetalheitem.idimovel = imovel.idimovel) AS lavanderia,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 18 AND imoveldetalheitem.idimovel = imovel.idimovel) AS living,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 19 AND imoveldetalheitem.idimovel = imovel.idimovel) AS mesanino,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 20 AND imoveldetalheitem.idimovel = imovel.idimovel) AS outros,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 21 AND imoveldetalheitem.idimovel = imovel.idimovel) AS patio,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 22 AND imoveldetalheitem.idimovel = imovel.idimovel) AS piscina,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 23 AND imoveldetalheitem.idimovel = imovel.idimovel) AS quartocasal,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 24 AND imoveldetalheitem.idimovel = imovel.idimovel) AS quartohospede,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 25 AND imoveldetalheitem.idimovel = imovel.idimovel) AS quartosolteiro,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 26 AND imoveldetalheitem.idimovel = imovel.idimovel) AS sacada,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 27 AND imoveldetalheitem.idimovel = imovel.idimovel) AS salaestar,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 28 AND imoveldetalheitem.idimovel = imovel.idimovel) AS salajantar,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 29 AND imoveldetalheitem.idimovel = imovel.idimovel) AS sala,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 30 AND imoveldetalheitem.idimovel = imovel.idimovel) AS salao,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 31 AND imoveldetalheitem.idimovel = imovel.idimovel) AS split,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 32 AND imoveldetalheitem.idimovel = imovel.idimovel) AS suite,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 33 AND imoveldetalheitem.idimovel = imovel.idimovel) AS terraco,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 34 AND imoveldetalheitem.idimovel = imovel.idimovel) AS vagagaragem,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 35 AND imoveldetalheitem.idimovel = imovel.idimovel) AS varanda,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 36 AND imoveldetalheitem.idimovel = imovel.idimovel) AS destaque,
    ( SELECT imoveldetalheitem.imoveldetalheitem
           FROM imovel.imoveldetalheitem
          WHERE imoveldetalheitem.idimoveldetalhe = 37 AND imoveldetalheitem.idimovel = imovel.idimovel) AS cozinha
FROM imovel.imovel
	JOIN imovel.imoveldestino ON imovel.idimoveldestino = imoveldestino.idimoveldestino
	JOIN imovel.imovelsituacao ON imovel.idimovelsituacao = imovelsituacao.idimovelsituacao
	JOIN cidadefull ON imovel.idcidade = cidadefull.idcidade
	JOIN imovel.imoveltipo ON imovel.idimoveltipo = imoveltipo.idimoveltipo
	JOIN imovel.imovelmaterial ON imovel.idimovelmaterial = imovelmaterial.idimovelmaterial
	ORDER BY idimovel;

-- 8
CREATE OR REPLACE VIEW imovel.imoveldetalhefull AS 
 WITH RECURSIVE arvore AS (
         SELECT
			imoveldetalhe_1.idimoveldetalhe AS idimoveldetalhe,
            imoveldetalhe_1.imoveldetalhe AS imoveldetalhe,
            imoveldetalhe_1.idparent AS idparent,
            imoveldetalhe_1.imoveldetalhe::text AS family,
            imoveldetalhe_1.caracterizacao AS caracterizacao,
            imoveldetalhe_1.flagimovel AS flagimovel,
            imoveldetalhe_1.flagvistoria  AS flagvistoria
           FROM imovel.imoveldetalhe imoveldetalhe_1
          WHERE imoveldetalhe_1.idparent IS NULL
        UNION ALL
         SELECT
			imoveldetalhe_1.idimoveldetalhe AS idimoveldetalhe,
            imoveldetalhe_1.imoveldetalhe AS imoveldetalhe,
            imoveldetalhe_1.idparent AS idparent,
            (arvore_1.family || ' > '::text) || imoveldetalhe_1.imoveldetalhe::text AS family,
            imoveldetalhe_1.caracterizacao AS caracterizacao,
            imoveldetalhe_1.flagimovel AS flagimovel,
            imoveldetalhe_1.flagvistoria AS flagvistoria
           FROM imovel.imoveldetalhe imoveldetalhe_1
             JOIN arvore arvore_1 ON imoveldetalhe_1.idparent = arvore_1.idimoveldetalhe
        )
 SELECT
	arvore.idimoveldetalhe AS idimoveldetalhe,
    arvore.imoveldetalhe AS imoveldetalhe,
    arvore.idparent AS idparent,
    arvore.family AS family,
    arvore.caracterizacao AS caracterizacao,
    arvore.flagimovel AS flagimovel,
    arvore.flagvistoria AS flagvistoria
   FROM arvore
     LEFT JOIN imovel.imoveldetalhe ON imoveldetalhe.idimoveldetalhe = arvore.idimoveldetalhe
  ORDER BY arvore.family;

-- 9
CREATE OR REPLACE VIEW contrato.contratopessoafull AS
SELECT
	contrato.contratopessoa.idcontratopessoa AS idcontratopessoa,
	contrato.contratopessoa.idcontrato AS idcontrato,
	contrato.contratopessoa.idpessoa AS idpessoa,
	pessoa.pessoafull.pessoa AS pessoa,
	pessoa.pessoafull.cnpjcpf AS cnpjcpf,
	pessoa.pessoafull.celular AS celular,
	pessoa.pessoafull.email AS email,
	contrato.contratopessoa.idcontratopessoaqualificacao AS idcontratopessoaqualificacao,
	contrato.contratopessoaqualificacao.contratopessoaqualificacao AS contratopessoaqualificacao,
	contrato.contratopessoa.cota AS cota
FROM 	contrato.contratopessoa
	INNER JOIN pessoa.pessoafull ON contrato.contratopessoa.idpessoa = pessoa.pessoafull.idpessoa
	INNER JOIN contrato.contratopessoaqualificacao ON contrato.contratopessoa.idcontratopessoaqualificacao = contrato.contratopessoaqualificacao.idcontratopessoaqualificacao;


-- 10
CREATE OR REPLACE VIEW contrato.contratofull AS
SELECT
	contrato.contrato.idcontrato AS idcontrato,
	lpad(cast(contrato.contrato.idcontrato AS text),6,'0') AS idcontratochar,
	contrato.contrato.idimovel AS idimovel,
	lpad(cast(contrato.contrato.idimovel AS text),6,'0') AS idimovelchar,
	imovel.imovelfull.endereco AS imovel,
	'#' || lpad(cast(contrato.contrato.idimovel AS text),6,'0') || ' - ' ||imovel.imovelfull.endereco AS idendereco,
	imovel.imovelfull.logradouro AS logradouro,
	imovel.imovelfull.logradouronro AS logradouronro,
	imovel.imovelfull.complemento AS complemento,
	imovel.imovelfull.bairro AS bairro,
	imovel.imovelfull.cep AS cep,
	imovel.imovelfull.cidade AS cidade,
	imovel.imovelfull.cidadeuf AS cidadeuf,
	array_to_string(( SELECT ARRAY( SELECT ' ' || contratopessoafull.pessoa AS text
                   FROM contrato.contratopessoafull
				   WHERE contratopessoafull.idcontrato = contrato.idcontrato AND contratopessoafull.idcontratopessoaqualificacao = 6) AS "array"), ','::text, '{removido}'::text) AS fiador,
	array_to_string(( SELECT ARRAY( SELECT ' ' || contratopessoafull.pessoa AS text
                   FROM contrato.contratopessoafull
				   WHERE contratopessoafull.idcontrato = contrato.idcontrato AND contratopessoafull.idcontratopessoaqualificacao = 2) AS "array"), ','::text, '{removido}'::text) AS inquilino,
	array_to_string(( SELECT ARRAY( SELECT ' ' || contratopessoafull.cnpjcpf AS text
                   FROM contrato.contratopessoafull
				   WHERE contratopessoafull.idcontrato = contrato.idcontrato AND contratopessoafull.idcontratopessoaqualificacao = 2) AS "array"), ','::text, '{removido}'::text) AS inquilinocnpjcpf,
	array_to_string(( SELECT ARRAY( SELECT contratopessoafull.idpessoa AS integer
                   FROM contrato.contratopessoafull
				   WHERE contratopessoafull.idcontrato = contrato.idcontrato AND contratopessoafull.idcontratopessoaqualificacao = 2) AS "array"), ','::text, '{removido}'::text) AS idinquilino,
	array_to_string(( SELECT ARRAY( SELECT ' ' || contratopessoafull.pessoa AS text
                   FROM contrato.contratopessoafull
				   WHERE contratopessoafull.idcontrato = contrato.idcontrato AND contratopessoafull.idcontratopessoaqualificacao = 3) AS "array"), ','::text, '{removido}'::text) AS locador,
	array_to_string(( SELECT ARRAY( SELECT ' ' || contratopessoafull.pessoa AS text
                   FROM contrato.contratopessoafull
				   WHERE contratopessoafull.idcontrato = contrato.idcontrato AND contratopessoafull.idcontratopessoaqualificacao = 4) AS "array"), ','::text, '{removido}'::text) AS procurador,
	array_to_string(( SELECT ARRAY( SELECT ' ' || contratopessoafull.pessoa AS text
                   FROM contrato.contratopessoafull
				   WHERE contratopessoafull.idcontrato = contrato.idcontrato AND contratopessoafull.idcontratopessoaqualificacao = 5) AS "array"), ','::text, '{removido}'::text) AS testemunha,
	contrato.contrato.prazo AS prazo,
	contrato.contrato.dtcelebracao AS dtcelebracao,
	contrato.contrato.dtinicio AS dtinicio,
	contrato.contrato.dtfim AS dtfim,
	contrato.contrato.dtextincao AS dtextincao,
	contrato.contrato.dtproxreajuste AS dtproxreajuste,
	contrato.contrato.aluguel AS aluguel,
	contrato.contrato.aluguelgarantido AS aluguelgarantido,
	contrato.contrato.jurosmora AS jurosmora,
	contrato.contrato.melhordia AS melhordia,
	contrato.contrato.multamora AS multamora,
	contrato.contrato.multafixa AS multafixa,
	contrato.contrato.comissao AS comissao,
	contrato.contrato.comissaofixa AS comissaofixa,
	contrato.contrato.caucao AS caucao,
	contrato.contrato.caucaoobs AS caucaoobs,
	contrato.contrato.obs AS obs,
	contrato.contrato.periodicidade AS periodicidade,
	contrato.contrato.prazorepasse AS prazorepasse,
	contrato.contrato.prorrogar AS prorrogar,
	contrato.contrato.vistoriado AS vistoriado,
	contrato.contrato.processado AS processado,
	contrato.contrato.renovadoalterado AS renovadoalterado,
	contrato.contrato.rescindido AS rescindido,
	contrato.contrato.createdat AS createdat,
	contrato.contrato.deletedat AS deletedat,
	contrato.contrato.idsystemuser AS idsystemuser,
	CASE
		WHEN contrato.dtextincao IS NOT NULL THEN 'Extinto'
		WHEN contrato.vistoriado THEN 'A Vistoriar'
		WHEN NOT contrato.processado THEN 'Novo'
		WHEN dtproxreajuste < CURRENT_DATE THEN 'Reajustar'
		WHEN dtfim < CURRENT_DATE THEN 'Vencido'
		WHEN contrato.processado THEN 'Ativo'
	END AS status,	
	contrato.contrato.consenso AS consenso	
FROM contrato.contrato
	INNER JOIN imovel.imovelfull ON contrato.contrato.idimovel = imovel.imovelfull.idimovel
ORDER BY idcontrato;

-- 11
CREATE OR REPLACE VIEW contrato.contratoview AS 
SELECT
    contrato.idcontrato AS cgcont,
    -- array_to_string((select array(select (' ' ||pessoa) from imovel.imovelproprietariofull where imovel.imovelproprietariofull.idimovel = imovel.imovel.idimovel ) ), ',', '{removido}') AS pessoas,
    contrato.prazo AS cgcont_prazo,
    contrato.dtcelebracao AS cgcont_dtcelebracao,
    contrato.dtinicio AS cgcont_dtinicio,
    contrato.dtfim AS cgcont_dtfim,
    contrato.aluguel AS cgcont_aluguel,
    contrato.jurosmora AS cgcont_juros,
    contrato.multamora AS cgcont_multa,
    contrato.obs AS cgcont_obs,
    imovelfull.idimovel AS cgi,
    imovelfull.cidade AS cgi_cidade,
    imovelfull.imovelsituacao AS cgi_situacao,
    imovelfull.imoveldestino AS cgi_destino,
    imovelfull.imoveltipo AS cgi_tipo,
    imovelfull.imovelmaterial AS cgi_construcao,
    imovelfull.imovelregistro AS cgi_registro,
    imovelfull.prefeituramatricula AS cgi_matricula,
    imovelfull.logradouro AS cgi_logradouro,
    imovelfull.complemento AS cgi_complemento,
    imovelfull.bairro AS cgi_bairro,
    imovelfull.cep AS cgi_cep,
    imovelfull.area AS cgi_area,
    imovelfull.setor AS cgi_setor,
    imovelfull.quadra AS cgi_quadra,
    imovelfull.lote AS cgi_lote,
    imovelfull.caracteristicas AS cgi_caracteristicas,
    imovelfull.obs AS cgi_obs,
    imovelfull.area AS cgi_detalhes
FROM contrato.contrato
   JOIN imovel.imovelfull ON contrato.idimovel = imovelfull.idimovel
  ORDER BY contrato.idcontrato;

-- 12
CREATE OR REPLACE VIEW vistoria.vistoriafull AS 
SELECT
	vistoria.vistoria.idvistoria AS idvistoria,
	lpad(cast(vistoria.vistoria.idvistoria AS text),6,'0') AS idvistoriachar,
	vistoria.vistoria.idvistoriatipo AS idvistoriatipo,
	vistoria.vistoriatipo.vistoriatipo AS vistoriatipo,
	vistoria.vistoria.idvistoriastatus AS idvistoriastatus,
	vistoria.vistoriastatus.vistoriastatus AS vistoriastatus,
	vistoria.vistoria.idimovel AS idimovel,
	lpad(cast(vistoria.vistoria.idimovel AS text),6,'0') AS idimovelchar,
	imovel.imovelfull.logradouro AS logradouro,
	imovel.imovelfull.logradouronro AS logradouronro,
	imovel.imovelfull.endereco AS endereco,
	imovel.imovelfull.bairro AS bairro,
	imovel.imovelfull.idcidade AS idcidade,
	imovel.imovelfull.cidade AS cidade,
	imovel.imovelfull.uf AS uf,
	imovel.imovelfull.cidadeuf AS cidadeuf,
	vistoria.vistoria.idcontrato AS idcontrato,
	lpad(cast(vistoria.vistoria.idcontrato AS text),6,'0') AS idcontratochar,
	contratofull.inquilino AS inquilino,
	contratofull.locador AS locador,
	vistoria.vistoria.idvistoriador AS idvistoriador,
	pessoa.pessoa.pessoa AS vistoriador,
	pessoa.pessoa.cnpjcpf AS vistoriadorcnpjcpf,
	vistoria.vistoria.notificado AS notificado,
	vistoria.vistoria.dtagendamento AS dtagendamento,
	vistoria.vistoria.agendado AS agendado,
	vistoria.vistoria.dtvistoriado AS dtvistoriado,
	vistoria.vistoria.pzcontestacao AS pzcontestacao,
	vistoria.vistoria.laudoentrada AS laudoentrada,
	vistoria.vistoria.laudosaida AS laudosaida,
	vistoria.vistoria.laudoconferencia AS laudoconferencia,
	vistoria.vistoria.videolink AS videolink,
	vistoria.vistoria.obs AS obs,
	vistoria.vistoria.aceite AS aceite
FROM 	vistoria.vistoria
	LEFT JOIN vistoria.vistoriatipo ON vistoria.vistoria.idvistoriatipo = vistoria.vistoriatipo.idvistoriatipo
	LEFT JOIN vistoria.vistoriastatus ON vistoria.vistoria.idvistoriastatus = vistoria.vistoriastatus.idvistoriastatus
	LEFT JOIN imovel.imovelfull ON vistoria.vistoria.idimovel = imovel.imovelfull.idimovel
	LEFT JOIN pessoa.pessoa ON vistoria.vistoria.idvistoriador = pessoa.pessoa.idpessoa
	LEFT JOIN contrato.contratofull ON vistoria.idcontrato = contratofull.idcontrato
ORDER BY vistoria.vistoria.idvistoria;

-- 13
CREATE OR REPLACE VIEW financeiro.pcontafull
 AS
 WITH RECURSIVE arvore AS (
         SELECT genealogy_1.idgenealogy,
            genealogy_1.people,
            genealogy_1.idparent,
            genealogy_1.people::text AS family,
            genealogy_1.idgenealogy::text AS patch,
            1 AS geracao,
            genealogy_1.createdat,
            genealogy_1.deletedat,
            genealogy_1.updatedat
           FROM financeiro.pconta genealogy_1
          WHERE genealogy_1.idparent IS NULL
        UNION ALL
         SELECT genealogy_1.idgenealogy,
            genealogy_1.people,
            genealogy_1.idparent,
            (arvore_1.family || ' > '::text) || genealogy_1.people::text AS family,
            (arvore_1.patch || ','::text) || genealogy_1.idgenealogy::text AS patch,
            arvore_1.geracao + 1 AS geracao,
            genealogy_1.createdat,
            genealogy_1.deletedat,
            genealogy_1.updatedat
           FROM financeiro.pconta genealogy_1
             JOIN arvore arvore_1 ON genealogy_1.idparent = arvore_1.idgenealogy
        )
 SELECT arvore.idgenealogy,
    arvore.people,
    arvore.idparent,
    arvore.family,
    arvore.patch,
    arvore.geracao,
    arvore.createdat,
    arvore.deletedat,
    arvore.updatedat
   FROM arvore
     LEFT JOIN financeiro.pconta ON pconta.idgenealogy = arvore.idgenealogy
  ORDER BY arvore.family;

-- 14  
CREATE OR REPLACE VIEW financeiro.faturafull AS
	SELECT
	financeiro.fatura.idfatura AS idfatura,
	financeiro.fatura.idfaturaorigemrepasse AS idfaturaorigemrepasse,
	financeiro.fatura.idcaixa AS idcaixa,
	financeiro.fatura.background AS background,
	financeiro.caixa.valor AS caixavalor,
	financeiro.caixa.juros AS caixajuros,
	financeiro.caixa.multa AS caixamulta,
	financeiro.caixa.dtcaixa AS dtcaixa,
	CASE WHEN (financeiro.caixa.dtcaixa IS NULL ) THEN 'aberta'
		 WHEN (financeiro.caixa.dtcaixa IS NOT NULL ) THEN 'quitada'
	END AS dtcaixastatus,	
	financeiro.fatura.idcontrato AS idcontrato,
	contrato.contrato.idimovel AS idimovel,
	financeiro.fatura.idfaturaformapagamento AS idfaturaformapagamento,
	financeiro.faturaformapagamento.billingtype AS billingtype,
	financeiro.faturaformapagamento.faturaformapagamento AS faturaformapagamento,
	financeiro.fatura.idpessoa AS idpessoa,
	pessoa.pessoafull.pessoa AS pessoa,
	pessoa.pessoafull.cnpjcpf AS cnpjcpf,
	pessoa.pessoafull.fones AS fone,
	pessoa.pessoafull.celular AS celular,
	pessoa.pessoafull.endereco || ', ' || pessoa.pessoafull.endereconro AS endereco,
	pessoa.pessoafull.email AS email,
	pessoa.pessoafull.bairro AS bairro,
	pessoa.pessoafull.cidadeuf AS cidade,
	financeiro.fatura.idsystemuser AS idsystemuser,
	financeiro.fatura.parcela AS parcela,
	financeiro.fatura.parcelas AS parcelas,
	financeiro.fatura.createdat AS createdat,
	financeiro.fatura.deducoes AS deducoes,
	financeiro.fatura.deletedat AS deletedat,
	financeiro.fatura.descontodiasant AS descontodiasant,
	financeiro.fatura.descontotipo AS descontotipo,
	financeiro.fatura.descontovalor AS descontovalor,
	financeiro.fatura.dtpagamento AS dtpagamento,
	CASE WHEN (financeiro.fatura.dtpagamento IS NULL ) THEN 'aberta'
		 WHEN (financeiro.fatura.dtpagamento IS NOT NULL ) THEN 'quitada'
	END AS dtpagamentostatus,
	financeiro.fatura.dtvencimento AS dtvencimento,
	CASE WHEN (financeiro.fatura.dtvencimento >= now()::date ) AND (financeiro.fatura.dtpagamento IS NULL ) THEN 'vincenda'
		 WHEN (financeiro.fatura.dtvencimento < now()::date ) AND (financeiro.fatura.dtpagamento IS NULL )THEN 'vencida'
	END AS dtvencimentostatus,
	CASE WHEN (contrato.contrato.aluguelgarantido = 'A' OR contrato.contrato.aluguelgarantido = 'M' ) THEN false
	 ELSE true
	END AS editavel,
	financeiro.fatura.emiterps AS emiterps,
	financeiro.fatura.es AS es,
	financeiro.fatura.fatura AS fatura,
	financeiro.fatura.gerador AS gerador,	
	financeiro.fatura.instrucao AS instrucao,
	financeiro.fatura.juros AS juros,
	financeiro.fatura.multa AS multa,
	financeiro.fatura.multafixa AS multafixa,
	financeiro.fatura.periodofinal AS periodofinal,
	financeiro.fatura.periodoinicial AS periodoinicial,	
	financeiro.fatura.registrado AS registrado,	
	financeiro.fatura.referencia AS referencia,
	SUBSTRING(split_part(financeiro.fatura.referencia , '_'::text, 2) , 1, 16) AS externaltoken,
	financeiro.fatura.repasse AS repasse,
	financeiro.fatura.servicopostal AS servicopostal,
	financeiro.fatura.updatedat AS updatedat,
	financeiro.fatura.valortotal AS valortotal,
	CASE WHEN (financeiro.fatura.es = 'E') THEN financeiro.fatura.valortotal END AS valortotale,
	CASE WHEN (financeiro.fatura.es = 'S') THEN financeiro.fatura.valortotal END AS valortotals,
	financeiro.faturaresponse.idfaturaresponse AS idfaturaresponse,
	financeiro.faturaresponse.idasaasfatura AS idasaasfatura,
	financeiro.faturaresponse.anticipated AS anticipated,
	financeiro.faturaresponse.bankslipurl AS bankslipurl,
	financeiro.faturaresponse.billingtype AS responsebillingtype,
	financeiro.faturaresponse.canbepaidafterduedate AS canbepaidafterduedate,
	financeiro.faturaresponse.candelete AS candelete,
	financeiro.faturaresponse.canedit AS canedit,
	financeiro.faturaresponse.cannotbedeletedreason AS cannotbedeletedreason,
	financeiro.faturaresponse.cannoteditreason AS cannoteditreason,
	financeiro.faturaresponse.chargebackreason AS chargebackreason,
	financeiro.faturaresponse.chargebackstatus AS chargebackstatus,
	financeiro.faturaresponse.clientpaymentdate AS clientpaymentdate,
	financeiro.faturaresponse.confirmeddate AS confirmeddate,
	financeiro.faturaresponse.customer AS customer,
	financeiro.faturaresponse.datecreated AS datecreated,
	financeiro.faturaresponse.deleted AS deleted,
	financeiro.faturaresponse.description AS description,
	financeiro.faturaresponse.discountduedatelimitdays AS discountduedatelimitdays,
	financeiro.faturaresponse.discounttype AS discounttype,
	financeiro.faturaresponse.discountvalue AS discountvalue,
	financeiro.faturaresponse.docavailableafterpayment AS docavailableafterpayment,
	financeiro.faturaresponse.docdeleted AS docdeleted,
	financeiro.faturaresponse.docfiledownloadurl AS docfiledownloadurl,
	financeiro.faturaresponse.docfileextension AS docfileextension,
	financeiro.faturaresponse.docfileoriginalname AS docfileoriginalname,
	financeiro.faturaresponse.docfilepreviewurl AS docfilepreviewurl,
	financeiro.faturaresponse.docfilepublicid AS docfilepublicid,
	financeiro.faturaresponse.docfilesize AS docfilesize,
	financeiro.faturaresponse.docid AS docid,
	financeiro.faturaresponse.docname AS docname,
	financeiro.faturaresponse.docobject AS docobject,
	financeiro.faturaresponse.doctype AS doctype,
	financeiro.faturaresponse.duedate AS duedate,
	financeiro.faturaresponse.externalreference AS externalreference,
	financeiro.faturaresponse.finevalue AS finevalue,
	financeiro.faturaresponse.installment AS installment,
	financeiro.faturaresponse.installmentnumber AS installmentnumber,
	financeiro.faturaresponse.interestovalue AS interestovalue,
	financeiro.faturaresponse.interestvalue AS interestvalue,
	financeiro.faturaresponse.invoicenumber AS invoicenumber,
	financeiro.faturaresponse.invoiceurl AS invoiceurl,
	financeiro.faturaresponse.municipalinscription AS municipalinscription,
	financeiro.faturaresponse.netvalue AS netvalue,
	financeiro.faturaresponse.nossonumero AS nossonumero,
	financeiro.faturaresponse.object AS object,	
	financeiro.faturaresponse.originalduedate AS originalduedate,
	financeiro.faturaresponse.originalvalue AS originalvalue,
	financeiro.faturaresponse.paymentdate AS paymentdate,
	financeiro.faturaresponse.paymentlink AS paymentlink,
	financeiro.faturaresponse.pixqrcodeid AS pixqrcodeid,
	financeiro.faturaresponse.pixtransaction AS pixtransaction,
	financeiro.faturaresponse.postalservice AS postalservice,
	financeiro.faturaresponse.refundsdatecreated AS refundsdatecreated,
	financeiro.faturaresponse.refundsdescription AS refundsdescription,
	financeiro.faturaresponse.refundsstatus AS refundsstatus,
	financeiro.faturaresponse.refundstransactionreceipturl AS refundstransactionreceipturl,
	financeiro.faturaresponse.refundsvalue AS refundsvalue,
	financeiro.faturaresponse.splitfixedvalue AS splitfixedvalue,
	financeiro.faturaresponse.splitpercentualvalue AS splitpercentualvalue,
	financeiro.faturaresponse.splitrefusalreason AS splitrefusalreason,
	financeiro.faturaresponse.splitstatus AS splitstatus,
	financeiro.faturaresponse.splitwalletid AS splitwalletid,
	financeiro.faturaresponse.stateinscription AS stateinscription,
	financeiro.faturaresponse.status AS status,
	financeiro.faturaresponse.subscription AS subscription,
	financeiro.faturaresponse.transactionreceipturl AS transactionreceipturl,
	financeiro.faturaresponse.value AS value,
	financeiro.faturaresponse.daysafterduedatetocancellationregistration AS daysafterduedatetocancellationregistration,
	financeiro.transferenciaresponse.idtransferenciaresponse AS tridtransferenciaresponse,
	financeiro.transferenciaresponse.codtransferencia AS trcodtransferencia,
	financeiro.transferenciaresponse.datecreated AS trdatecreated,
	financeiro.transferenciaresponse.value AS trvalue,
	financeiro.transferenciaresponse.netvalue AS trnetvalue,
	financeiro.transferenciaresponse.status AS trstatus,
	financeiro.transferenciaresponse.transferfee AS trtransferfee,
	financeiro.transferenciaresponse.effectivedate AS treffectivedate,
	financeiro.transferenciaresponse.scheduledate AS trscheduledate,
	financeiro.transferenciaresponse.authorized AS trauthorized,
	financeiro.transferenciaresponse.failreason AS trfailreason,
	financeiro.transferenciaresponse.bankispb AS trbankispb,
	financeiro.transferenciaresponse.bankcode AS trbankcode,
	financeiro.transferenciaresponse.bankname AS trbankname,
	financeiro.transferenciaresponse.bankaccountname AS trbankaccountname,
	financeiro.transferenciaresponse.bankownername AS trbankownername,
	financeiro.transferenciaresponse.bankcpfcnpj AS trbankcpfcnpj,
	financeiro.transferenciaresponse.bankagency AS trbankagency,
	financeiro.transferenciaresponse.bankaccount AS trbankaccount,
	financeiro.transferenciaresponse.bankaccountdigit AS trbankaccountdigit,
	financeiro.transferenciaresponse.bankpixaddresskey AS trbankpixaddresskey,
	financeiro.transferenciaresponse.transactionreceipturl AS trtransactionreceipturl,
	financeiro.transferenciaresponse.operationtype AS troperationtype,
	financeiro.transferenciaresponse.description AS trdescription
FROM financeiro.fatura
	LEFT JOIN contrato.contrato ON financeiro.fatura.idcontrato = contrato.contrato.idcontrato
	INNER JOIN financeiro.faturaformapagamento ON financeiro.fatura.idfaturaformapagamento = financeiro.faturaformapagamento.idfaturaformapagamento
	INNER JOIN pessoa.pessoafull ON financeiro.fatura.idpessoa = pessoa.pessoafull.idpessoa
	LEFT JOIN financeiro.faturaresponse ON financeiro.fatura.idfatura = financeiro.faturaresponse.idfatura
	LEFT JOIN financeiro.transferenciaresponse ON financeiro.fatura.idfatura = financeiro.transferenciaresponse.idfatura
	LEFT JOIN financeiro.caixa ON financeiro.fatura.idcaixa = financeiro.caixa.idcaixa
	ORDER BY financeiro.fatura.idfatura;


-- 15
CREATE OR REPLACE VIEW financeiro.faturadetalhefull AS 
SELECT
	financeiro.faturadetalhe.idfaturadetalhe AS idfaturadetalhe,
	financeiro.faturadetalhe.idfaturadetalheitem AS idfaturadetalheitem,
	financeiro.faturadetalhe.idfatura AS idfatura,
	financeiro.fatura.referencia AS referencia,
	financeiro.fatura.idcontrato AS idcontrato,
	financeiro.faturadetalhe.idpconta AS idpconta,
	financeiro.pcontafull.family AS family,
	financeiro.faturadetalhe.qtde AS qtde,
	financeiro.faturadetalhe.valor AS valor,
	financeiro.faturadetalhe.desconto AS desconto,
	((financeiro.faturadetalhe.qtde * financeiro.faturadetalhe.valor) - financeiro.faturadetalhe.desconto)::numeric(15,2) AS totalcomdesconto,
	(financeiro.faturadetalhe.qtde * financeiro.faturadetalhe.valor)::numeric(15,2) AS totalsemdesconto,
	financeiro.faturadetalhe.repassevalor AS repassevalor,
	financeiro.faturadetalhe.comissaovalor AS comissaovalor,
	CASE WHEN (financeiro.fatura.es = 'E') THEN
	    ((financeiro.faturadetalhe.qtde * financeiro.faturadetalhe.valor) - financeiro.faturadetalhe.desconto)::numeric(15,2)
	    ELSE NULL
	END AS receber,
	CASE WHEN (financeiro.fatura.es = 'S') THEN
	    ((financeiro.faturadetalhe.qtde * financeiro.faturadetalhe.valor) - financeiro.faturadetalhe.desconto)::numeric(15,2)
	    ELSE NULL
	END AS pagar,
	financeiro.faturadetalhe.tipopagamento AS tipopagamento,
	CASE
		 WHEN faturadetalhe.tipopagamento = 'O'  THEN 'Obrigação'
		 WHEN faturadetalhe.tipopagamento = 'I'  THEN 'Indenização'
		 WHEN faturadetalhe.tipopagamento = 'R'  THEN 'Repasse'
		 ELSE  'Indefinido'
	END	AS tipopagamentoext,
	CASE
		 WHEN financeiro.fatura.dtpagamento IS NULL THEN 'aberta'
		 WHEN financeiro.fatura.dtpagamento IS NOT NULL THEN 'quitada'
	END	AS situacao,
	financeiro.faturadetalheitem.faturadetalheitem AS faturadetalheitem,
	financeiro.faturadetalheitem.ehservico AS ehservico,
	financeiro.faturadetalheitem.ehdespesa AS ehdespesa,
	financeiro.faturadetalhe.repasselocador AS repasselocador,
	financeiro.fatura.es AS es,
	financeiro.fatura.dtvencimento AS dtvencimento,
	financeiro.fatura.dtpagamento AS dtpagamento,
	financeiro.fatura.idpessoa AS idpessoa,
	pessoa.pessoa.pessoa AS pessoa,
	pessoa.pessoa.cnpjcpf AS cnpjcpf,
	financeiro.fatura.deletedat AS deletedat,
	financeiro.fatura.createdat AS createdat,
	financeiro.fatura.createdat AS updatedat
FROM financeiro.faturadetalhe
	INNER JOIN financeiro.fatura ON financeiro.faturadetalhe.idfatura = financeiro.fatura.idfatura
	LEFT JOIN pessoa.pessoa ON financeiro.fatura.idpessoa = pessoa.pessoa.idpessoa
	LEFT JOIN contrato.contrato ON financeiro.fatura.idcontrato = contrato.contrato.idcontrato
	INNER JOIN financeiro.faturadetalheitem ON financeiro.faturadetalhe.idfaturadetalheitem = financeiro.faturadetalheitem.idfaturadetalheitem
	LEFT JOIN financeiro.pcontafull ON financeiro.faturadetalhe.idpconta = financeiro.pcontafull.idgenealogy
ORDER BY financeiro.faturadetalhe.idfaturadetalhe;

-- 16
CREATE OR REPLACE VIEW financeiro.caixafull AS
SELECT
	financeiro.caixa.idcaixa AS idcaixa,
	financeiro.caixa.idcaixaespecie AS idcaixaespecie,
	financeiro.caixaespecie.caixaespecie AS caixaespecie,
	financeiro.caixa.idfatura AS idfatura,
	financeiro.faturafull.referencia AS referencia,
	financeiro.faturafull.dtvencimento AS faturadtvencimento,
	financeiro.faturafull.idcontrato AS idcontrato,
	financeiro.faturafull.invoiceurl AS invoiceurl,
	financeiro.faturafull.transactionreceipturl AS transactionreceipturl,
	transferenciaresponse.transactionreceipturl AS comprovantetransferencia,
	financeiro.caixa.idpconta AS idpconta,
	financeiro.pcontafull.family AS family,
	financeiro.caixa.idpessoa AS idpessoa,
	financeiro.caixa.pessoa AS pessoa,
	financeiro.caixa.cnpjcpf AS cnpjcpf,
	financeiro.caixa.idsystemuser AS idsystemuser,
	financeiro.caixa.es AS es,
	financeiro.caixa.dtcaixa AS dtcaixa,
	financeiro.caixa.dtvencimento AS dtvencimento,
	financeiro.caixa.estornado AS estornado,
	financeiro.caixa.historico AS historico,
	financeiro.caixa.createdat AS createdat,
	financeiro.caixa.deletedat AS deletedat,
	financeiro.caixa.updatedat AS updatedat,
	financeiro.caixa.juros AS juros,
	financeiro.caixa.multa AS multa,
	financeiro.caixa.despesa AS despesa,
	financeiro.caixa.desconto AS desconto,
	financeiro.caixa.valor AS valor,
	financeiro.caixa.valorentregue AS valorentregue,
	(COALESCE(caixa.valor, 0::numeric) + COALESCE(caixa.juros, 0::numeric) + COALESCE(caixa.multa, 0::numeric) + COALESCE(caixa.despesa, 0::numeric) - COALESCE(caixa.desconto, 0::numeric))::numeric(15,2) AS valortotal,
	COALESCE(caixa.valorentregue, 0::numeric) - (COALESCE(caixa.valor, 0::numeric) + COALESCE(caixa.juros, 0::numeric) + COALESCE(caixa.multa, 0::numeric) + COALESCE(caixa.despesa, 0::numeric) - COALESCE(caixa.desconto, 0::numeric))::numeric(15,2) AS troco,
	CASE WHEN (caixa.es = 'E') THEN 
		(COALESCE(caixa.valor, 0::numeric) + COALESCE(caixa.juros, 0::numeric) + COALESCE(caixa.multa, 0::numeric) + COALESCE(caixa.despesa, 0::numeric) - COALESCE(caixa.desconto, 0::numeric))::numeric(15,2)	
	END AS valorrecebido,
	CASE WHEN (caixa.es = 'S') THEN 
		(COALESCE(caixa.valor, 0::numeric) + COALESCE(caixa.juros, 0::numeric) + COALESCE(caixa.multa, 0::numeric) + COALESCE(caixa.despesa, 0::numeric) - COALESCE(caixa.desconto, 0::numeric))::numeric(15,2)
	END AS valorpago
FROM 
	financeiro.caixa INNER JOIN financeiro.caixaespecie ON financeiro.caixa.idcaixaespecie = financeiro.caixaespecie.idcaixaespecie
	LEFT JOIN financeiro.faturafull ON financeiro.caixa.idfatura = financeiro.faturafull.idfatura
	LEFT JOIN financeiro.pcontafull ON financeiro.caixa.idpconta = financeiro.pcontafull.idgenealogy
	LEFT JOIN financeiro.transferenciaresponse ON caixa.idcaixa = transferenciaresponse.idcaixa
ORDER BY idcaixa;

-- 17
CREATE OR REPLACE VIEW imovel.imovelarquivomorto AS
SELECT 
    imovelfull.idimovel AS idimovel,
    imovelfull.enderecofull AS enderecofull,
	imovelfull.deletedat AS deletedat,
	imovelfull.idsystemuser AS idsystemuser
FROM imovel.imovelfull
WHERE deletedat IS NOT NULL; 


-- 18
CREATE OR REPLACE VIEW pessoa.pessoaarquivomorto AS
SELECT 
    pessoa.idpessoa AS idpessoa,
    pessoa.pessoa AS pessoa,
	pessoa.cnpjcpf AS cnpjcpf,
	pessoa.idsystemuser AS idsystemuser
FROM pessoa.pessoa
WHERE deletedat IS NOT NULL; 


-- 19
CREATE OR REPLACE VIEW contrato.contratoarquivomorto AS
SELECT 
    contratofull.idcontrato AS idcontrato,
    contratofull.idendereco AS idendereco,
	contratofull.bairro AS bairro,
	contratofull.cep AS cep,
	contratofull.cidade AS cidade,
	contratofull.inquilino AS inquilino,
	contratofull.locador AS locador,
	contratofull.deletedat AS deletedat,
	contratofull.idsystemuser AS idsystemuser
FROM contrato.contratofull
WHERE deletedat IS NOT NULL; 


-- 20
CREATE OR REPLACE VIEW autenticador.documentofull AS
SELECT
	autenticador.documento.iddocumento AS iddocumento,
	lpad(cast(autenticador.documento.iddocumento AS text),6,'0') AS iddocumentochar,
	autenticador.documento.docname AS docname,
	autenticador.documento.deletedat AS deletedat,
	autenticador.documento.iddocumentotipo AS iddocumentotipo,
	autenticador.documentotipo.documentotipo AS documentotipo,
	autenticador.documento.status AS status,
	CASE
		WHEN autenticador.documento.status = 'signed' THEN 'Assinado'
		WHEN autenticador.documento.status = 'pending' THEN 'Pendente'
		ELSE NULL
	END AS statusbr,	
	autenticador.documento.createdat AS createdat,
	array_to_string(( SELECT ARRAY( SELECT ' ' || signatario.nome AS text
                   FROM autenticador.signatario
				   WHERE documento.iddocumento = signatario.iddocumento) AS "array"), ',', '') AS signatarios
FROM autenticador.documento
	LEFT JOIN autenticador.documentotipo ON autenticador.documento.iddocumentotipo = autenticador.documentotipo.iddocumentotipo
ORDER BY iddocumento;

-- 21
CREATE OR REPLACE VIEW vistoria.vistoriadetalhefull AS
SELECT
	vistoria.vistoriadetalhe.idvistoriadetalhe AS idvistoriadetalhe,
	vistoria.vistoriadetalhe.idvistoria AS idvistoria,
	vistoria.vistoriadetalhe.idvistoriadetalheestado AS idvistoriadetalheestado,
	vistoria.vistoriadetalheestado.vistoriadetalheestado AS vistoriadetalheestado,
	vistoria.vistoriadetalhe.idimoveldetalhe AS idimoveldetalhe,
	imovel.imoveldetalhefull.family AS imoveldetalhe,
	vistoria.vistoriadetalhe.idimg AS idimg,
	vistoria.vistoriadetalhe.avaliacao AS avaliacao,
	vistoria.vistoriadetalhe.caracterizacao AS caracterizacao,
	vistoria.vistoriadetalhe.descricao AS descricao,
	vistoria.vistoriadetalhe.index AS index,
	vistoria.vistoriadetalhe.dtcontestacao AS dtcontestacao,
	vistoria.vistoriadetalhe.contestacaoargumento AS contestacaoargumento,
	vistoria.vistoriadetalhe.contestacaoimg AS contestacaoimg,
	vistoria.vistoriadetalhe.contestacaoresposta AS contestacaoresposta,
	vistoria.vistoriadetalhe.dtinconformidade AS dtinconformidade,
	vistoria.vistoriadetalhe.inconformidade AS inconformidade,
	vistoria.vistoriadetalhe.inconformidadevalor AS inconformidadevalor,
	vistoria.vistoriadetalhe.inconformidadeimg AS inconformidadeimg,
	vistoria.vistoriadetalhe.inconformidadereparo AS inconformidadereparo
FROM vistoria.vistoriadetalhe
	LEFT JOIN vistoria.vistoriadetalheestado ON vistoria.vistoriadetalhe.idvistoriadetalheestado = vistoria.vistoriadetalheestado.idvistoriadetalheestado
	LEFT JOIN imovel.imoveldetalhefull ON vistoria.vistoriadetalhe.idimoveldetalhe = imovel.imoveldetalhefull.idimoveldetalhe
ORDER BY index;

-- 22
CREATE OR REPLACE VIEW imovel.imoveldetalheitemfull AS
SELECT
    imoveldetalhe.idimoveldetalhe,
    imoveldetalheitem.idimovel,
    imoveldetalhe.imoveldetalhe,
    imoveldetalheitem.imoveldetalheitem
FROM imovel.imoveldetalhe
    JOIN imovel.imoveldetalheitem ON imoveldetalhe.idimoveldetalhe = imoveldetalheitem.idimoveldetalhe;
    

-- 23
--CREATE OR REPLACE VIEW financeiro.extratorepassemensal AS
CREATE OR REPLACE VIEW financeiro.extratocomissaomensal AS
SELECT
    idcontrato AS idcontrato,
    idpessoa AS idpessoa,
    pessoa AS pessoa,
    cnpjcpf AS cnpjcpf,
    TO_CHAR(dtpagamento, 'YYYY')::integer AS anocaledario,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 1 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_jan,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 2 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_fev,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 3 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_mar,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 4 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_abr,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 5 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_mai,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 6 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_jun,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 7 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_jul,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 8 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_ago,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 9 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_set,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 10 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_out,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 11 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_nov,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 12 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS comissao_dez
FROM
    financeiro.faturadetalhefull
WHERE
    dtpagamento IS NOT NULL
    AND ehservico = true
    AND deletedat IS NULL
    AND idcontrato > 0
    AND es = 'S'
GROUP BY 
    idcontrato, idpessoa, pessoa, cnpjcpf, anocaledario
ORDER BY 
    idcontrato, idpessoa, anocaledario;


-- 24
CREATE OR REPLACE VIEW financeiro.extratoaluguelmensal AS
SELECT
    idcontrato AS idcontrato,
    idpessoa AS idpessoa,
    pessoa AS pessoa,
    cnpjcpf AS cnpjcpf,
    TO_CHAR(dtpagamento, 'YYYY')::integer AS anocaledario,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 1 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_jan,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 1 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_jan,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 2 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_fev,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 2 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_fev,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 3 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_mar,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 3 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_mar,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 4 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_abr,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 4 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_abr,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 5 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_mai,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 5 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_mai,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 6 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_jun,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 6 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_jun,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 7 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_jul,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 7 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_jul,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 8 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_ago,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 8 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_ago,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 9 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_set,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 9 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_set,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 10 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_out,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 10 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_out,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 11 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_nov,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 11 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_nov,
    SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 12 THEN totalcomdesconto ELSE 0 END)::numeric(15,2) AS aluguel_dez,
	SUM(CASE WHEN EXTRACT(MONTH FROM dtpagamento) = 12 THEN repassevalor ELSE 0 END)::numeric(15,2) AS repasse_dez
FROM
    financeiro.faturadetalhefull
WHERE
    dtpagamento IS NOT NULL
    AND ehservico = true
    AND deletedat IS NULL
    AND idcontrato > 0
    AND es = 'E'
GROUP BY 
    idcontrato, idpessoa, pessoa, cnpjcpf, anocaledario
ORDER BY 
    idcontrato, idpessoa, anocaledario;

-- 25
CREATE OR REPLACE VIEW financeiro.extratocontratopessoas AS
SELECT
    faturadetalhefull.idcontrato AS idcontrato,
    faturadetalhefull.idpessoa AS idpessoa,
    faturadetalhefull.es AS es,
    to_char(faturadetalhefull.dtpagamento::timestamp with time zone, 'YYYY'::text) AS anocaledario
FROM
    financeiro.faturadetalhefull
WHERE
    faturadetalhefull.ehservico = true
    AND faturadetalhefull.idcontrato > 0
    AND faturadetalhefull.dtpagamento IS NOT NULL
GROUP BY
    faturadetalhefull.idcontrato,
    faturadetalhefull.idpessoa,
    faturadetalhefull.es,
    (to_char(faturadetalhefull.dtpagamento, 'YYYY'))
ORDER BY
    faturadetalhefull.idcontrato,
    faturadetalhefull.es,
    faturadetalhefull.idpessoa;