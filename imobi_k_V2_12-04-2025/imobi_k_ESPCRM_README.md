# Integração EspoCRM

Guia de uso do cliente EspoCRM e da interface CRM (`EspoCrmView`).

## Arquivos principais
- `app/lib/EspoCrmClient.php` – cliente REST (CRUD básico + metadata) via cURL.
- `app/service/EspoCrmProxy.php` – proxy interno seguro (não expõe a chave ao front-end).
- `app/control/imobiliaria/CrmView.php` – interface web (listar / buscar / paginação / criar / excluir / modal detalhe).
- `app/scripts/espocrm_debug.php` – debug de requisições (lista e responde status).
- `app/scripts/espocrm_env.php` – mostra variáveis ESPOCRM carregadas.

## Configuração de ambiente
Crie um arquivo `.env` (já ignorado via `.gitignore`) na raiz `imobi_k_V2_...` com:

```
ESPOCRM_BASE_URL=https://seu-espocrm.example
ESPOCRM_API_KEY=COLOQUE_SUA_CHAVE_AQUI
; ESPOCRM_AUTH_TYPE é opcional. Por padrão ('auto') o cliente envia ambos
; os cabeçalhos (Authorization: Bearer e X-Api-Key/Api-Key) para compatibilidade.
; Descomente se quiser forçar um modo específico: 'bearer' ou 'apikey'
; ESPOCRM_AUTH_TYPE=bearer
ESPOCRM_CONNECT_TIMEOUT=5
ESPOCRM_TIMEOUT=15
ESPOCRM_LOG=1              # 1 para logar última request em tmp/espocrm_last.json
```

O `init.php` carrega automaticamente `.env` e popula `getenv()`. Se preferir usar variáveis nativas do sistema, basta exportá‑las e o loader não sobrescreve.

Exemplo manual (PowerShell):
```powershell
$env:ESPOCRM_BASE_URL='https://seu-espocrm.example'
$env:ESPOCRM_API_KEY='SUA_CHAVE_AQUI'
$env:ESPOCRM_AUTH_TYPE='bearer'
php .\app\scripts\espocrm_test.php
```

## Uso da interface CRM
Acesse: `http://127.0.0.1:8080/engine.php?class=EspoCrmView`

Funções:
- Selecionar entidade (Contact / Lead / Account) via menu.
- Buscar por texto (campo genérico `q`).
- Paginação (offset + página). Botão "Próxima" / "Anterior".
- "Novo" abre modal com campos básicos; ao salvar chama proxy `create`.
- Ícone de visualizar abre modal de detalhes (JSON formatado).
- Botão "Delete" remove registro após confirmação.
- Status inferior mostra sucesso / erro e responde com mensagem detalhada quando a API retorna 4xx/5xx.

## Proxy interno
Chamadas front-end vão para `EspoCrmProxy` que:
- Valida operação (`list`, `get`, `create`, `delete`).
- Monta saída JSON padronizada: `{ success, status, data|error }`.
- Oculta a chave real.

## Logging de requisições
Com `ESPOCRM_LOG=1`, cada chamada a `EspoCrmClient::request()` cria/atualiza `tmp/espocrm_last.json` contendo:
- URL
- Método
- Headers (reduzidos, sem chave explícita)
- Payload enviado
- Resposta crua (raw) e corpo decodificado (body)
- Timestamp

Use isso para diagnosticar erros 500 ou problemas de autenticação.

## Autenticação
Autenticação
- Padrão: modo automático (sem `ESPOCRM_AUTH_TYPE`) envia `Authorization: Bearer <chave>` e `X-Api-Key`/`Api-Key` juntos.
- Forçar modo: defina `ESPOCRM_AUTH_TYPE=bearer` ou `ESPOCRM_AUTH_TYPE=apikey` se sua instalação exigir um só.

## Scripts úteis
- `espocrm_debug.php <Entidade>`: Faz list direto e imprime status/trecho de resposta.
- `espocrm_env.php`: Conferir se variáveis foram carregadas.

## Erros comuns
| Situação | Correção |
|----------|----------|
| "Defina ESPOCRM_BASE_URL e ESPOCRM_API_KEY" | Verifique `.env` e se o servidor foi reiniciado. |
| 401 Unauthorized | Confirme chave e tipo de auth (`bearer` vs `apikey`). |
| 404 na entidade | Verifique nome da entidade (ex: `Contact` vs `Contacts`). |
| 500 genérico | Consulte `tmp/espocrm_last.json` para ver resposta real do EspoCRM. |

## Segurança
- A chave permanece apenas em `.env` (ignorado no Git). Não commit.
- Rotacione a chave se houver vazamento.
- Para produção, considere remover `EspoCrmProxy` de `public_classes` e exigir sessão autenticada.

## Próximos aprimoramentos (opcional)
- Suporte a edição (update) no modal.
- Filtros avançados (ex: por campos específicos em vez de busca genérica `q`).
- Tratamento de rate limit / retries exponenciais.

## Licença / Avisos
Este módulo é específico da integração interna e não substitui validações adicionais de segurança em ambiente de produção.
