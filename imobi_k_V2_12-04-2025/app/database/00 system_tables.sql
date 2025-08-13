CREATE TABLE app_change_log
(
    id  SERIAL PRIMARY KEY NOT NULL,
    titulo varchar(100),
    dtchangelog date,
    tipo varchar(100),
    changelog text
); 

CREATE TABLE desktop
(
    iddesktop integer PRIMARY KEY NOT NULL,
    iduser integer NOT NULL,
    titulo varchar(200) NOT NULL,
    classe varchar(200) NOT NULL,
    icone varchar(200) NOT NULL,
    cor varchar(200) NOT NULL,
    posicao integer
); 

CREATE TABLE guestbook( 
      idguestbook  SERIAL  NOT NULL,
      browser varchar(100), 
      conteudo text, 
      createdat timestamp, 
      ipvisitante varchar(100), 
      service text
);

CREATE TABLE guiatransferencias
(
    idguiatransferencias integer PRIMARY KEY NOT NULL,
    codtransferencia text,
    database varchar(200),
    createdat timestamp,
    updatedat timestamp,
    processado boolean DEFAULT false,
    registracaixa char(1)
);

CREATE TABLE siteconnect
(
    idsiteconnect SERIAL PRIMARY KEY NOT NULL,
    idunit integer,
    idsite integer,
    database varchar(255) NOT NULL,
    domain text NOT NULL
);

CREATE TABLE system_document
(
    id integer PRIMARY KEY NOT NULL,
    category_id integer NOT NULL,
    system_user_id integer,
    title text NOT NULL,
    description text,
    submission_date date,
    archive_date date,
    filename text
);

CREATE TABLE system_document_category
(
    id integer PRIMARY KEY NOT NULL,
    name text NOT NULL
);

CREATE TABLE system_document_group
(
    id integer PRIMARY KEY NOT NULL,
    document_id integer NOT NULL,
    system_group_id integer NOT NULL
);

CREATE TABLE system_document_user
(
    id integer PRIMARY KEY NOT NULL,
    document_id integer NOT NULL,
    system_user_id integer NOT NULL
);

CREATE TABLE system_group
(
    id integer PRIMARY KEY NOT NULL,
    name text NOT NULL,
    uuid varchar(36)
);

CREATE TABLE system_group_program
(
    id integer PRIMARY KEY NOT NULL,
    system_group_id integer NOT NULL,
    system_program_id integer NOT NULL,
    actions text
);

CREATE TABLE system_message
(
    id integer PRIMARY KEY NOT NULL,
    system_user_id integer NOT NULL,
    system_user_to_id integer NOT NULL,
    subject text NOT NULL,
    message text,
    dt_message timestamp,
    checked char(1)
);

CREATE TABLE system_notification
(
    id integer PRIMARY KEY NOT NULL,
    system_user_id integer NOT NULL,
    system_user_to_id integer NOT NULL,
    subject text,
    message text,
    dt_message timestamp,
    action_url text,
    action_label text,
    icon text,
    checked char(1)
);

CREATE TABLE system_parent_account
(
    id_system_parent_account integer PRIMARY KEY NOT NULL,
    system_parent_account varchar(100),
    email varchar(100),
    login varchar(100),
    password char(100),
    asaas_system varchar(50),
    walletid text,
    apikey text,
    obs text
);

CREATE TABLE system_preference
(
    id varchar(255) PRIMARY KEY NOT NULL,
    preference text
);

CREATE TABLE system_program
(
    id integer PRIMARY KEY NOT NULL,
    name text NOT NULL,
    controller text NOT NULL,
    actions text
);

CREATE TABLE system_unit
(
    id integer PRIMARY KEY NOT NULL,
    name text NOT NULL,
    connection_name text
);

CREATE TABLE system_user_group
(
    id integer PRIMARY KEY NOT NULL,
    system_user_id integer NOT NULL,
    system_group_id integer NOT NULL
);

CREATE TABLE system_user_program
(
    id integer PRIMARY KEY NOT NULL,
    system_user_id integer NOT NULL,
    system_program_id integer NOT NULL
);

CREATE TABLE system_users
(
    id integer PRIMARY KEY NOT NULL,
    name text NOT NULL,
    login text NOT NULL,
    password text NOT NULL,
    email text,
    frontpage_id integer,
    system_unit_id integer,
    active char(1),
    accepted_term_policy_at text,
    accepted_term_policy char(1)
);

CREATE TABLE system_user_unit
(
    id integer PRIMARY KEY NOT NULL,
    system_user_id integer NOT NULL,
    system_unit_id integer NOT NULL
);

 
  
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_2 FOREIGN KEY(category_id) references system_document_category(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_1 FOREIGN KEY(system_user_id) references system_users(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_2 FOREIGN KEY(document_id) references system_document(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_1 FOREIGN KEY(system_group_id) references system_group(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_2 FOREIGN KEY(document_id) references system_document(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_1 FOREIGN KEY(system_user_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY(system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY(system_group_id) references system_group(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_1 FOREIGN KEY(system_user_id) references system_users(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_2 FOREIGN KEY(system_user_to_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_1 FOREIGN KEY(system_user_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_2 FOREIGN KEY(system_user_to_id) references system_users(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY(system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY(system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY(system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY(system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY(system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY(frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY(system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY(system_unit_id) references system_unit(id); 
 
CREATE index idx_system_document_category_id on system_document(category_id); 
CREATE index idx_system_document_system_user_id on system_document(system_user_id); 
CREATE index idx_system_document_group_document_id on system_document_group(document_id); 
CREATE index idx_system_document_group_system_group_id on system_document_group(system_group_id); 
CREATE index idx_system_document_user_document_id on system_document_user(document_id); 
CREATE index idx_system_document_user_system_user_id on system_document_user(system_user_id); 
CREATE index idx_system_group_program_system_program_id on system_group_program(system_program_id); 
CREATE index idx_system_group_program_system_group_id on system_group_program(system_group_id); 
CREATE index idx_system_message_system_user_id on system_message(system_user_id); 
CREATE index idx_system_message_system_user_to_id on system_message(system_user_to_id); 
CREATE index idx_system_notification_system_user_id on system_notification(system_user_id); 
CREATE index idx_system_notification_system_user_to_id on system_notification(system_user_to_id); 
CREATE index idx_system_user_group_system_group_id on system_user_group(system_group_id); 
CREATE index idx_system_user_group_system_user_id on system_user_group(system_user_id); 
CREATE index idx_system_user_program_system_program_id on system_user_program(system_program_id); 
CREATE index idx_system_user_program_system_user_id on system_user_program(system_user_id); 
CREATE index idx_system_users_system_unit_id on system_users(system_unit_id); 
CREATE index idx_system_users_frontpage_id on system_users(frontpage_id); 
CREATE index idx_system_user_unit_system_user_id on system_user_unit(system_user_id); 
CREATE index idx_system_user_unit_system_unit_id on system_user_unit(system_unit_id); 

INSERT INTO system_group(id,name,uuid) VALUES(1,'Admin',null); 
INSERT INTO system_group(id,name,uuid) VALUES(2,'Standard',null);

INSERT INTO system_program(id,name,controller,actions) VALUES(1,'System Group Form','SystemGroupForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(2,'System Group List','SystemGroupList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(3,'System Program Form','SystemProgramForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(4,'System Program List','SystemProgramList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(5,'System User Form','SystemUserForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(6,'System User List','SystemUserList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(7,'Common Page','CommonPage',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(8,'System PHP Info','SystemPHPInfoView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(9,'System ChangeLog View','SystemChangeLogView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(10,'Welcome View','WelcomeView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(11,'System Sql Log','SystemSqlLogList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(12,'System Profile View','SystemProfileView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(13,'System Profile Form','SystemProfileForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(14,'System SQL Panel','SystemSQLPanel',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(15,'System Access Log','SystemAccessLogList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(16,'System Message Form','SystemMessageForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(17,'System Message List','SystemMessageList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(18,'System Message Form View','SystemMessageFormView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(19,'System Notification List','SystemNotificationList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(20,'System Notification Form View','SystemNotificationFormView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(21,'System Document Category List','SystemDocumentCategoryFormList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(22,'System Document Form','SystemDocumentForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(23,'System Document Upload Form','SystemDocumentUploadForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(24,'System Document List','SystemDocumentList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(25,'System Shared Document List','SystemSharedDocumentList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(26,'System Unit Form','SystemUnitForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(27,'System Unit List','SystemUnitList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(28,'System Access stats','SystemAccessLogStats',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(29,'System Preference form','SystemPreferenceForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(30,'System Support form','SystemSupportForm',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(31,'System PHP Error','SystemPHPErrorLogView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(32,'System Database Browser','SystemDatabaseExplorer',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(33,'System Table List','SystemTableList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(34,'System Data Browser','SystemDataBrowser',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(35,'System Menu Editor','SystemMenuEditor',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(36,'System Request Log','SystemRequestLogList',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(37,'System Request Log View','SystemRequestLogView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(38,'System Administration Dashboard','SystemAdministrationDashboard',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(39,'System Log Dashboard','SystemLogDashboard',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(40,'System Session dump','SystemSessionDumpView',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(41,'Files diff','SystemFilesDiff',null); 
INSERT INTO system_program(id,name,controller,actions) VALUES(42,'System Information','SystemInformationView',null); 

-- APP
INSERT INTO system_program(id,name,controller,actions) VALUES(43,'Banco Form List', 'BancoFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(44,'Bancopixtipo Form List', 'BancopixtipoFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(45,'Bancotipoconta Form List', 'BancotipocontaFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(46,'Pessoa List', 'PessoaList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(47,'Pessoa Form', 'PessoaForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(48,'Pessoa Arquivo Morto List', 'PessoaArquivoMortoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(49,'Pessoa Cep Seek Form', 'PessoaCepSeekForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(50,'Pessoa Seek Window', 'PessoaSeekWindow' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(51,'Contrato Imovel Seek', 'ContratoImovelSeek' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(52,'Imovel Album Form', 'ImovelAlbumForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(53,'Imovel Arquivo Morto List', 'ImovelArquivoMortoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(54,'Imovel Card Document', 'ImovelCardDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(55,'Imovel Cep Seek Form', 'ImovelCepSeekForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(56,'Imovel Form', 'ImovelForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(57,'Imovel Material Form List', 'ImovelMaterialFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(58,'Imovel Tipo Form List', 'ImovelTipoFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(59,'Imovel To Sign Form', 'ImovelToSignForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(60,'Imovel List', 'ImovelList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(61,'Imovel Detalhe Form List', 'ImovelDetalheFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(62,'Imovelweb Cliente Form', 'ImovelwebClienteForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(63,'Contrato Aditivar Form', 'ContratoAditivarForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(64,'Contrato Alteracao Form', 'ContratoAlteracaoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(65,'Contrato Atualizacao Form', 'ContratoAtualizacaoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(66,'Contrato Extincao Form', 'ContratoExtincaoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(67,'Contrato Form', 'ContratoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(68,'Contrato Historico Cortina Time Line', 'ContratoHistoricoCortinaTimeLine' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(69,'Contrato Historico Time Line', 'ContratoHistoricoTimeLine' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(70,'Contrato List', 'ContratoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(71,'Contrato Prorrogacao Form', 'ContratoProrrogacaoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(72,'Contrato Transferencia Form', 'ContratoTransferenciaForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(73,'Vistoria Contestacao Form', 'VistoriaContestacaoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(74,'Vistoria Document', 'VistoriaDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(75,'Vistoria Form', 'VistoriaForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(76,'Vistoria Historico Cortina Time Line', 'VistoriaHistoricoCortinaTimeLine' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(77,'Vistoria Historico Time Line', 'VistoriaHistoricoTimeLine' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(78,'Vistoria Inconformidade Form', 'VistoriaInconformidadeForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(79,'Vistoria Minuta Document', 'VistoriaMinutaDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(80,'Vistoria List', 'VistoriaList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(81,'Vistoria Print Form', 'VistoriaPrintForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(82,'Vistoria Reset Form', 'VistoriaResetForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(83,'Vistoria To Sing Form', 'VistoriaToSingForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(84,'Vistoriadetalheimg Form List', 'VistoriadetalheimgFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(85,'Documento Creat Form', 'DocumentoCreatForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(86,'Documento Form To Sign', 'DocumentoFormToSign' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(87,'Documento Form View', 'DocumentoFormView' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(88,'Documento List', 'DocumentoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(89,'Documento Send Form', 'DocumentoSendForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(90,'Documentotipo Form List', 'DocumentotipoFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(91,'Fatura Wizard Form1', 'FaturaWizardForm1' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(92,'Fatura Wizard Form2', 'FaturaWizardForm2' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(93,'Fatura Wizard Form3', 'FaturaWizardForm3' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(94,'Fatura Wizard Form4', 'FaturaWizardForm4' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(95,'Fatura Wizard Form5', 'FaturaWizardForm5' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(96,'Fatura Wizard Form6', 'FaturaWizardForm6' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(97,'Fatura Wizard Form7', 'FaturaWizardForm7' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(98,'Wizard Busca Contrato', 'WizardBuscaContrato' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(99,'Fatura Caixa Form', 'FaturaCaixaForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(100,'Fatura Conta Pag Form', 'FaturaContaPagForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(101,'Fatura Conta Pag Seek Window', 'FaturaContaPagSeekWindow' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(102,'Fatura Conta Rec Document', 'FaturaContaRecDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(103,'Fatura Conta Rec Edit Form', 'FaturaContaRecEditForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(104,'Fatura Conta Rec Form', 'FaturaContaRecForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(105,'Fatura Contrato Seek Window', 'FaturaContratoSeekWindow' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(106,'Fatura Delete Batch', 'FaturaDeleteBatch' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(107,'Fatura List', 'FaturaList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(108,'Fatura Pay Batch', 'FaturaPayBatch' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(109,'Fatura Seek Window', 'FaturaSeekWindow' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(110,'Faturadetalheitem Form List', 'FaturadetalheitemFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(111,'Caixa Form', 'CaixaForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(112,'Caixa List', 'CaixaList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(113,'Caixa Pconta Form', 'CaixaPcontaForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(114,'Caixa Recibo Document', 'CaixaReciboDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(115,'Caixa Recibo Form', 'CaixaReciboForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(116,'Fatura Conta Pag Lote Form', 'FaturaContaPagLoteForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(117,'Extrato Bancario Document', 'ExtratoBancarioDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(118,'Relatorios Bancarios Form', 'RelatoriosBancariosForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(120,'Cidade Form List', 'CidadeFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(121,'Config Form', 'ConfigForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(122,'Site List', 'SiteList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(123,'Site Form', 'SiteForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(124,'Site Head Text Form List', 'SiteHeadTextFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(125,'Site Secao Form List', 'SiteSecaoFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(126,'Site Slide Form List', 'SiteSlideFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(127,'Site Template Form List', 'SiteTemplateFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(128,'Calendar Event Form View', 'CalendarEventFormView' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(129,'Calendar Event Form', 'CalendarEventForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(130,'Mural Recados Form', 'MuralRecadosForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(131,'Conta Pai Form', 'ContaPaiForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(132,'Conta Pai Header List', 'ContaPaiHeaderList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(133,'Cep Seek', 'CepSeek' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(134,'Contrato Arquivo Morto List', 'ContratoArquivoMortoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(135,'Pconta Form List', 'PcontaFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(136,'Webhook Assinaturas List', 'WebhookAssinaturasList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(137,'Webhook Pagamentos List', 'WebhookPagamentosList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(138,'Webhook Transferencia List', 'WebhookTransferenciaList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(139,'Fatura Pix Ted Form', 'FaturaPixTedForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(140,'Guestbook List', 'GuestbookList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(141,'Guiatransferencias List', 'GuiatransferenciasList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(142,'Template Form', 'TemplateForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(143,'Template List', 'TemplateList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(144,'Imovel Report', 'ImovelReport' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(145,'Resumo Financeiro', 'ResumoFinanceiro' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(146,'Extrato Contrato List', 'ExtratoContratoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(147,'Fatura Extrato Imobiliaria Document', 'FaturaExtratoImobiliariaDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(148,'Fatura Extrato Inquilino Document', 'FaturaExtratoInquilinoDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(149,'Fatura Extrato Locador Document', 'FaturaExtratoLocadorDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(150,'Extrato Transferencia Document', 'ExtratoTransferenciaDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(151,'Transferencia Avulsa List', 'TransferenciaAvulsaList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(152,'Pix Avulso Form', 'PixAvulsoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(153,'Ted Avulso Form', 'TedAvulsoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(154,'Contrato Report Form', 'ContratoReportForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(155,'Pessoa New Form', 'PessoaNewForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(156,'Fatura Sintetico Imobiliaria Document', 'FaturaSinteticoImobiliariaDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(157,'Fatura Sintetico Inquilino Document', 'FaturaSinteticoInquilinoDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(158,'Fatura Sintetico Locador Document', 'FaturaSinteticoLocadorDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(159,'Fatura Report Form', 'FaturaReportForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(160,'Depoimento Form', 'DepoimentoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(161,'Depoimentos List', 'DepoimentosList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(162,'Versionamento Wiew Form', 'VersionamentoWiewForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(163,'Fatura Print Boleto Batch', 'FaturaPrintBoletoBatch' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(164,'Base De Conhecimento', 'BaseDeConhecimento' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(165,'Consulta Cobrancas Report', 'ConsultaCobrancasReport' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(166,'Faturaevento Time Line', 'FaturaeventoTimeLine' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(167,'Extraordinary Collection Operations', 'ExtraordinaryCollectionOperations' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(168,'Transferencia Entre Contras', 'TransferenciaEntreContras' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(169,'Desktop Form List', 'DesktopFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(170,'Desktop View', 'DesktopView' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(171,'Caixa Report Form', 'CaixaReportForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(172,'Documento Signatario Config Temp Form', 'DocumentoSignatarioConfigTempForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(173,'Dashboard Atendente', 'DashboardAtendente' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(174,'Wizard Reembolso List', 'WizardReembolsoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(175,'Caixa Estorno Form', 'CaixaEstornoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(176,'Fatura Detalhe List', 'FaturaDetalheList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(177,'Caixa Estrutural List', 'CaixaEstruturalList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(178,'Extrato Imobiliaria Batch Document', 'ExtratoImobiliariaBatchDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(179,'Extrato Inquilinos Batch Document', 'ExtratoInquilinosBatchDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(180,'Extrato Locadores Batch Document', 'ExtratoLocadoresBatchDocument' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(181,'Relatorio Favorito Novo Form', 'RelatorioFavoritoNovoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(182,'Relatorios Favoritos View', 'RelatoriosFavoritosView' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(183,'Relatorio Form List', 'RelatorioFormList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(184,'Open Ai Assunto List', 'OpenAiAssuntoList' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(185,'Openai Assunto Form', 'OpenaiAssuntoForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(186,'Openaiapi Form', 'OpenaiapiForm' , null);
INSERT INTO system_program(id,name,controller,actions) VALUES(187,'Dimob Form', 'DimobForm' , null);
INSERT INTO system_users(id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy) VALUES(1,'Administrator','admin','$2y$10$qYDiL.IdsD3X3qIu7bj6N.QiWukhX6r8GRaby3VKMSmJW7gZpZrBC','admin,admin.net',10,null,'Y','',''); 
INSERT INTO system_users(id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy) VALUES(2,'User','user','ee11cbb19052e40b07aac0ca060c23ee','user,user.net',7,null,'Y','',''); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(1,1,1,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(2,1,2,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(3,1,3,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(4,1,4,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(5,1,5,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(6,1,6,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(7,1,8,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(8,1,9,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(9,1,11,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(10,1,14,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(11,1,15,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(12,2,10,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(13,2,12,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(14,2,13,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(15,2,16,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(16,2,17,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(17,2,18,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(18,2,19,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(19,2,20,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(20,1,21,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(21,2,22,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(22,2,23,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(23,2,24,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(24,2,25,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(25,1,26,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(26,1,27,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(27,1,28,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(28,1,29,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(29,2,30,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(30,1,31,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(31,1,32,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(32,1,33,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(33,1,34,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(34,1,35,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(35,1,36,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(36,1,37,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(37,1,38,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(38,1,39,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(39,1,40,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(40,1,41,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(41,1,42,null); 

INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(42,1,43,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(43,1,44,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(44,1,45,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(45,1,46,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(46,1,47,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(47,1,48,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(48,1,49,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(49,1,50,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(50,1,51,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(51,1,52,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(52,1,53,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(53,1,54,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(54,1,55,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(55,1,56,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(56,1,57,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(57,1,58,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(58,1,59,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(59,1,60,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(60,1,61,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(61,1,62,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(62,1,63,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(63,1,64,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(64,1,65,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(65,1,66,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(66,1,67,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(67,1,68,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(68,1,69,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(69,1,70,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(70,1,71,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(71,1,72,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(72,1,73,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(73,1,74,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(74,1,75,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(75,1,76,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(76,1,77,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(77,1,78,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(78,1,79,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(79,1,80,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(80,1,81,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(81,1,82,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(82,1,83,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(83,1,84,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(84,1,85,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(85,1,86,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(86,1,87,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(87,1,88,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(88,1,89,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(89,1,90,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(90,1,91,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(91,1,92,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(92,1,93,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(93,1,94,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(94,1,95,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(95,1,96,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(96,1,97,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(97,1,98,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(98,1,99,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(99,1,100,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(100,1,101,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(101,1,102,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(102,1,103,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(103,1,104,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(104,1,105,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(105,1,106,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(106,1,107,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(107,1,108,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(108,1,109,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(109,1,110,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(110,1,111,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(111,1,112,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(112,1,113,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(113,1,114,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(114,1,115,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(115,1,116,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(116,1,117,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(117,1,118,null); 
-- INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(118,1,119,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(119,1,120,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(120,1,121,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(121,1,122,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(122,1,123,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(123,1,124,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(124,1,125,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(125,1,126,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(126,1,127,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(127,1,128,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(128,1,129,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(129,1,130,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(130,1,131,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(131,1,132,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(132,1,133,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(133,1,134,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(134,1,135,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(135,1,136,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(136,1,137,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(137,1,138,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(138,1,139,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(139,1,140,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(140,1,141,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(141,1,142,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(142,1,143,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(143,1,144,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(144,1,145,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(145,1,146,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(146,1,147,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(147,1,148,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(148,1,149,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(149,1,150,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(150,1,151,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(151,1,152,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(152,1,153,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(153,1,154,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(154,1,155,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(155,1,156,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(156,1,157,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(157,1,158,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(158,1,159,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(159,1,160,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(160,1,161,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(161,1,162,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(162,1,163,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(163,1,164,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(164,1,165,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(165,1,166,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(166,1,167,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(167,1,168,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(168,1,169,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(169,1,170,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(170,1,171,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(171,1,172,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(172,1,173,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(173,1,174,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(174,1,175,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(175,1,176,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(176,1,177,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(177,1,178,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(178,1,179,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(179,1,180,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(180,1,181,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(181,1,182,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(182,1,183,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(183,1,184,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(184,1,185,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(185,1,186,null); 
INSERT INTO system_group_program(id,system_group_id,system_program_id,actions) VALUES(186,1,187,null); 



INSERT INTO system_parent_account(id_system_parent_account,system_parent_account,email,login,password,asaas_system,walletid,apikey,obs) VALUES(1,'Kabongo','contato,imobik.com.br','contato,imobik.com.br','kabongo#pma,16,imobik.com.br','sandbox','338b0f53-1781-416e-b362-cf3af872bf2b','21a10b4c2d8d0f48cc1528d8db01b8141f39d5e539a4809316a2ae34ac4800cf','Sistema Demo da Kabongo'); 
INSERT INTO system_preference(id,preference) VALUES('mail_from','noreplay.kabongo,outlook.com'); 
INSERT INTO system_preference(id,preference) VALUES('smtp_auth','1'); 
INSERT INTO system_preference(id,preference) VALUES('smtp_host','smtp.office365.com'); 
INSERT INTO system_preference(id,preference) VALUES('smtp_port','587'); 
INSERT INTO system_preference(id,preference) VALUES('smtp_user','noreplay.kabongo,outlook.com'); 
INSERT INTO system_preference(id,preference) VALUES('smtp_pass','j1l9v6f4'); 
INSERT INTO system_preference(id,preference) VALUES('mail_support','kabongo.joao,gmail.com, contato,imobik.com.br, comercial,kabongo.com.br'); 
INSERT INTO system_preference(id,preference) VALUES('term_policy','Esta polÃ­tica de Termos de Uso Ã© vÃ¡lida a partir de Abr 2022.TERMOS DE USO â€” Imobi-k<div><br></div><div>Imobi-k,pessoa jurÃ­dica de direito privado descreve, atravÃ©s deste documento, as regras de uso do site www.imobik.com.br e qualquer outro site, loja ou aplicativo operado pelo proprietÃ¡rio.</div><div><br></div><div>Ao navegar neste website, consideramos que vocÃª estÃ¡ de acordo com os Termos de Uso abaixo.</div><div><br></div><div>Caso vocÃª nÃ£o esteja de acordo com as condiÃ§Ãµes deste contrato, pedimos que nÃ£o faÃ§a mais uso deste website, muito menos cadastre-se ou envie os seus dados pessoais.</div><div><br></div><div>Se modificarmos nossos Termos de Uso, publicaremos o novo texto neste website, com a data de revisÃ£o atualizada. Podemos alterar este documento a qualquer momento. Caso haja alteraÃ§Ã£o significativa nos termos deste contrato, podemos informÃ¡-lo por meio das informaÃ§Ãµes de contato que tivermos em nosso banco de dados ou por meio de notificaÃ§Ãµes.</div><div><br></div><div>A utilizaÃ§Ã£o deste website apÃ³s as alteraÃ§Ãµes significa que vocÃª aceitou os Termos de Uso revisados. Caso, apÃ³s a leitura da versÃ£o revisada, vocÃª nÃ£o esteja de acordo com seus termos, favor encerrar o seu acesso.</div><div><br></div><div>SeÃ§Ã£o 1 - UsuÃ¡rio</div><div><br></div><div>A utilizaÃ§Ã£o deste website atribui de forma automÃ¡tica a condiÃ§Ã£o de UsuÃ¡rio e implica a plena aceitaÃ§Ã£o de todas as diretrizes e condiÃ§Ãµes incluÃ­das nestes Termos.</div><div><br></div><div>SeÃ§Ã£o 2 - AdesÃ£o em conjunto com a PolÃ­tica de Privacidade</div><div><br></div><div>A utilizaÃ§Ã£o deste website acarreta a adesÃ£o aos presentes Termos de Uso e a versÃ£o mais atualizada da PolÃ­tica de Privacidade de Imobi-k .</div><div><br></div><div>SeÃ§Ã£o 3 - CondiÃ§Ãµes de acesso</div><div><br></div><div>Em geral, o acesso ao website da Imobi-k possui carÃ¡ter gratuito e nÃ£o exige prÃ©via inscriÃ§Ã£o ou registro.</div><div><br></div><div>Contudo, para usufruir de algumas funcionalidades, o usuÃ¡rio poderÃ¡ precisar efetuar um cadastro, criando uma conta de usuÃ¡rio com login e senha prÃ³prios para acesso.</div><div><br></div><div>Ã‰ de total responsabilidade do usuÃ¡rio fornecer apenas informaÃ§Ãµes corretas, autÃªnticas, vÃ¡lidas, completas e atualizadas, bem como nÃ£o divulgar o seu login e senha para terceiros.</div><div><br></div><div>Partes deste website oferecem ao usuÃ¡rio a opÃ§Ã£o de publicar comentÃ¡rios em determinadas Ã¡reas. Imobi-k nÃ£o consente com a publicaÃ§Ã£o de conteÃºdos que tenham natureza discriminatÃ³ria, ofensiva ou ilÃ­cita, ou ainda infrinjam direitos de autor ou quaisquer outros direitos de terceiros.</div><div><br></div><div>A publicaÃ§Ã£o de quaisquer conteÃºdos pelo usuÃ¡rio deste website, incluindo mensagens e comentÃ¡rios, implica em licenÃ§a nÃ£o-exclusiva, irrevogÃ¡vel e irretratÃ¡vel, para sua utilizaÃ§Ã£o, reproduÃ§Ã£o e publicaÃ§Ã£o pela Imobi-k no seu website, plataformas e aplicaÃ§Ãµes de internet, ou ainda em outras plataformas, sem qualquer restriÃ§Ã£o ou limitaÃ§Ã£o.</div><div><br></div><div>SeÃ§Ã£o 4 - Cookies</div><div><br></div><div>InformaÃ§Ãµes sobre o seu uso neste website podem ser coletadas a partir de cookies. Cookies sÃ£o informaÃ§Ãµes armazenadas diretamente no computador que vocÃª estÃ¡ utilizando. Os cookies permitem a coleta de informaÃ§Ãµes tais como o tipo de navegador, o tempo despendido no website, as pÃ¡ginas visitadas, as preferÃªncias de idioma, e outros dados de trÃ¡fego anÃ´nimos. NÃ³s e nossos prestadores de serviÃ§os utilizamos informaÃ§Ãµes para proteÃ§Ã£o de seguranÃ§a, para facilitar a navegaÃ§Ã£o, exibir informaÃ§Ãµes de modo mais eficiente, e personalizar sua experiÃªncia ao utilizar este website, assim como para rastreamento online. TambÃ©m coletamos informaÃ§Ãµes estatÃ­sticas sobre o uso do website para aprimoramento contÃ­nuo do nosso design e funcionalidade, para entender como o website Ã© utilizado e para auxiliÃ¡-lo a solucionar questÃµes relevantes.</div><div><br></div><div>Caso nÃ£o deseje que suas informaÃ§Ãµes sejam coletadas por meio de cookies, hÃ¡ um procedimento simples na maior parte dos navegadores que permite que os cookies sejam automaticamente rejeitados, ou oferece a opÃ§Ã£o de aceitar ou rejeitar a transferÃªncia de um cookie(ou cookies) especÃ­fico(s) de um site determinado para o seu computador. Entretanto, isso pode gerar inconvenientes no uso do website.</div><div><br></div><div>As definiÃ§Ãµes que escolher podem afetar a sua experiÃªncia de navegaÃ§Ã£o e o funcionamento que exige a utilizaÃ§Ã£o de cookies. Neste sentido, rejeitamos qualquer responsabilidade pelas consequÃªncias resultantes do funcionamento limitado deste website provocado pela desativaÃ§Ã£o de cookies no seu dispositivo(incapacidade de definir ou ler um cookie).</div><div><br></div><div>SeÃ§Ã£o 5 - Propriedade Intelectual</div><div><br></div><div>Todos os elementos de Imobi-k sÃ£o de propriedade intelectual da mesma ou de seus licenciados. Estes Termos ou a utilizaÃ§Ã£o do website nÃ£o concede a vocÃª qualquer licenÃ§a ou direito de uso dos direitos de propriedade intelectual da Imobi-k ou de terceiros.</div><div><br></div><div>SeÃ§Ã£o 6 - Links para sites de terceiros</div><div><br></div><div>Este website poderÃ¡, de tempos a tempos, conter links de hipertexto que redirecionarÃ¡ vocÃª para sites das redes dos nossos parceiros, anunciantes, fornecedores etc. Se vocÃª clicar em um desses links para qualquer um desses sites, lembre-se que cada site possui as suas prÃ³prias prÃ¡ticas de privacidade e que nÃ£o somos responsÃ¡veis por essas polÃ­ticas. Consulte as referidas polÃ­ticas antes de enviar quaisquer Dados Pessoais para esses sites.</div><div><br></div><div>NÃ£o nos responsabilizamos pelas polÃ­ticas e prÃ¡ticas de coleta, uso e divulgaÃ§Ã£o(incluindo prÃ¡ticas de proteÃ§Ã£o de dados) de outras organizaÃ§Ãµes, tais como Facebook, Apple, Google, Microsoft, ou de qualquer outro desenvolvedor de software ou provedor de aplicativo, loja de mÃ­dia social, sistema operacional, prestador de serviÃ§os de internet sem fio ou fabricante de dispositivos, incluindo todos os Dados Pessoais que divulgar para outras organizaÃ§Ãµes por meio dos aplicativos, relacionadas a tais aplicativos, ou publicadas em nossas pÃ¡ginas em mÃ­dias sociais. NÃ³s recomendamos que vocÃª se informe sobre a polÃ­tica de privacidade e termos de uso de cada site visitado ou de cada prestador de serviÃ§o utilizado.</div><div><br></div><div>SeÃ§Ã£o 7 - Prazos e alteraÃ§Ãµes</div><div><br></div><div>O funcionamento deste sistema se dÃ¡ por prazo determinado mensalmente ou anualmente, conforme o plano contratado.</div><div><br></div><div>O ERP - Sistema de GestÃ£o ImobiliÃ¡ria todo ou em cada uma das suas seÃ§Ãµes, pode ser encerrado, suspenso ou interrompido unilateralmente por Imobi-k,a qualquer momento e sem necessidade de prÃ©vio aviso.</div><div><br></div><div>SeÃ§Ã£o 8 - Dados pessoais</div><div><br></div><div>Durante a utilizaÃ§Ã£o deste website, certos dados pessoais serÃ£o coletados e tratados por Imobi-k e/ou pelos Parceiros. As regras relacionadas ao tratamento de dados pessoais de Imobi-k estÃ£o estipuladas na PolÃ­tica de Privacidade.</div><div><br></div><div>SeÃ§Ã£o 9 - Contato</div><div><br></div><div>Caso vocÃª tenha qualquer dÃºvida sobre os Termos de Uso, por favor, entre em contato pelo e-mail contato,imobik.com.br.</div><div><br></div><div><br></div>'); 
INSERT INTO system_unit(id,name,connection_name) VALUES(1,'Matriz','matriz'); 
INSERT INTO system_user_group(id,system_user_id,system_group_id) VALUES(1,1,1); 
INSERT INTO system_user_group(id,system_user_id,system_group_id) VALUES(2,2,2); 
INSERT INTO system_user_group(id,system_user_id,system_group_id) VALUES(3,1,2); 
INSERT INTO system_user_program(id,system_user_id,system_program_id) VALUES(1,2,7); 
INSERT INTO system_user_unit(id,system_user_id,system_unit_id) VALUES(1,1,1); 
SELECT setval('app_change_log_id_seq', coalesce(max(id),0) + 1, false) FROM app_change_log;
SELECT setval('guestbook_idguestbook_seq', coalesce(max(idguestbook),0) + 1, false) FROM guestbook;
SELECT setval('siteconnect_idsiteconnect_seq', coalesce(max(idsiteconnect),0) + 1, false) FROM siteconnect;