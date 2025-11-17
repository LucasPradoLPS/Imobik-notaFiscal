<?php
/**
 * CrmView
 * Front-end simples para consumir EspoCRM via proxy interno (EspoCrmProxy).
 * Ação do menu pode passar #entity=Contact|Lead|Account.
 */
class CrmView extends TPage
{
    private string $entity;
    private int $pageSize = 20;

    public function __construct()
    {
        parent::__construct();
        $this->entity = $_GET['entity'] ?? 'Contact';
        // Container base
        $wrapper = new TElement('div');
        $wrapper->{'style'} = 'padding:10px;';

        $title = new TElement('h3');
        $title->add('CRM - ' . htmlspecialchars($this->entity));
        $wrapper->add($title);

        // Barra de ações
        // Abas de entidade
        $tabs = new TElement('div');
        $tabs->{'id'} = 'crm_tabs';
        $tabs->{'style'} = 'margin-bottom:8px; display:flex; gap:6px; flex-wrap:wrap;';
        foreach ([
          ['Contact','Contatos'],
          ['Lead','Leads'],
          ['Account','Contas']
        ] as $tab) {
          $btn = new TElement('button');
          $btn->add($tab[1]);
          $btn->{'type'} = 'button';
          $btn->{'class'} = 'btn btn-sm btn-light';
          $btn->{'data-entity'} = $tab[0];
          $tabs->add($btn);
        }
        $wrapper->add($tabs);

        // Barra de ações
        $bar = new TElement('div');
        $bar->{'style'} = 'margin-bottom:10px; display:flex; gap:8px; flex-wrap:wrap;';

        // Input busca
        $searchInput = new TElement('input');
        $searchInput->{'type'} = 'text';
        $searchInput->{'placeholder'} = 'Buscar (nome / email)';
        $searchInput->{'id'} = 'crm_search';
        $searchInput->{'style'} = 'flex:1; min-width:200px;';
        $bar->add($searchInput);

        // Botão atualizar
        $btnReload = new TElement('button');
        $btnReload->add('Recarregar');
        $btnReload->{'type'} = 'button';
        $btnReload->{'onclick'} = 'CrmView.reload()';
        $btnReload->{'class'} = 'btn btn-sm btn-primary';
        $bar->add($btnReload);

        // Botão novo
        $btnNew = new TElement('button');
        $btnNew->add('Novo');
        $btnNew->{'type'} = 'button';
        $btnNew->{'onclick'} = 'CrmView.openCreate()';
        $btnNew->{'class'} = 'btn btn-sm btn-success';
        $bar->add($btnNew);


        $wrapper->add($bar);

        // Área de status
        $status = new TElement('div');
        $status->{'id'} = 'crm_status';
        $status->{'style'} = 'margin-bottom:6px; font-size:12px; color:#555;';
        $wrapper->add($status);

        // Tabela
        $table = new TElement('table');
        $table->{'class'} = 'table table-striped table-sm';
        $table->{'id'} = 'crm_table';
        $thead = new TElement('thead');
        $trh = new TElement('tr');
        foreach (['ID','Nome','Email','Imóveis','Ações'] as $col) {
            $th = new TElement('th');
            $th->add($col);
            $trh->add($th);
        }
        $thead->add($trh);
        $table->add($thead);
        $tbody = new TElement('tbody');
        $tbody->{'id'} = 'crm_tbody';
        $table->add($tbody);
        $wrapper->add($table);

        // Paginação
        $pager = new TElement('div');
        $pager->{'id'} = 'crm_pager';
        $pager->{'style'} = 'display:flex; gap:6px; margin-top:8px;';
        $wrapper->add($pager);

        // Modal registro (view/create)
        $modal = new TElement('div');
        $modal->{'id'} = 'crm_modal';
        $modal->{'style'} = 'display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.35); z-index:9999;';
        $modalInner = new TElement('div');
        $modalInner->{'style'} = 'background:#fff; max-width:460px; margin:60px auto; padding:18px; border-radius:6px; box-shadow:0 2px 10px rgba(0,0,0,.3);';
        $modalInner->{'id'} = 'crm_modal_inner';
        $modal->add($modalInner);
        $wrapper->add($modal);

        // Script JS inline
        $script = new TElement('script');
        $script->add( $this->buildJavascript() );
        $wrapper->add($script);

        parent::add($wrapper);
    }

    public function onShow($param = null)
    {
        // Nada específico, JS fará carga inicial.
    }

    // Método de saúde removido

    private function buildJavascript(): string
    {
        $entity = addslashes($this->entity);
        $pageSize = (int)$this->pageSize;
        $js = <<<'JS'
(function(){
const ENTITY='__ENTITY__';
const PAGESIZE=__PAGESIZE__;
if (window.CrmView) {
  // Já existe: apenas atualiza entidade e pageSize e evita redeclarar
  window.CrmView.entity = ENTITY;
  window.CrmView.pageSize = PAGESIZE;
  return;
}

window.CrmView = {
  entity: ENTITY,
  offset: 0,
  pageSize: PAGESIZE,
  lastTotal: 0,
  imovelIntent: {},
  setEntity(ent) {
    if (!ent || this.entity === ent) return;
    this.entity = ent;
    this.offset = 0;
    this.updateTabs();
    this.reload(true);
  },
  fetchJson(url, options={}) {
    return fetch(url, Object.assign({ headers: { 'Accept':'application/json' } }, options))
      .then(async r => {
        const text = await r.text();
        try { return JSON.parse(text); } catch(e) {
          throw new Error('Resposta não JSON recebida. Trecho: ' + text.substring(0,200));
        }
      });
  },
  updateTabs() {
    const container = document.getElementById('crm_tabs');
    if (!container) return;
    const btns = container.querySelectorAll('button[data-entity]');
    btns.forEach(b=>{
      if (b.getAttribute('data-entity') === this.entity) {
        b.className = 'btn btn-sm btn-primary';
      } else {
        b.className = 'btn btn-sm btn-light';
      }
    });
  },
  buildUrl() {
    const base = `engine.php?class=EspoCrmProxy&method=list&entity=${this.entity}`;
    return base + `&maxSize=${this.pageSize}&offset=${this.offset}`;
  },
  reload(reset=false) {
    if (reset) this.offset = 0;
    const url = this.buildUrl();
    document.getElementById('crm_status').innerText = 'Carregando...';
    this.fetchJson(url)
      .then(j=>{
        this.lastTotal = j.count || 0;
        const statusEl = document.getElementById('crm_status');
        if (j.success) {
          // Sucesso: não exibir mensagem de status
          statusEl.innerText = '';
        } else {
          // Falha: exibir erro resumido
          statusEl.innerText = 'Erro ' + j.status + ': ' + (j.error || 'verifique servidor CRM');
        }
        const tbody = document.getElementById('crm_tbody');
        tbody.innerHTML='';
        const term = document.getElementById('crm_search').value.trim().toLowerCase();
        const data = Array.isArray(j.data)? j.data: [];
        data.forEach(row => {
          const name = (row.name || row.firstName && row.lastName ? `${row.firstName||''} ${row.lastName||''}`.trim() : (row.firstName||''));
          const email = row.emailAddress || row.email || '';
          if (term && !name.toLowerCase().includes(term) && !email.toLowerCase().includes(term)) return;
          const tr = document.createElement('tr');
          const tdId = document.createElement('td'); tdId.textContent = row.id || ''; tr.appendChild(tdId);
          const tdName = document.createElement('td'); tdName.textContent = name; tr.appendChild(tdName);
          const tdEmail = document.createElement('td'); tdEmail.textContent = email; tr.appendChild(tdEmail);
          // Coluna Imóveis -> seletor de intenção
          const tdImv = document.createElement('td');
          const sel = document.createElement('select');
          sel.className = 'form-select form-select-sm';
          const options = ['indiferente','comprar','vender','alugar','locar','financiamento','avaliação','consorcio','financeiro','serviços'];
          options.forEach(opt=>{
            const o = document.createElement('option');
            o.value = opt; o.textContent = opt.charAt(0).toUpperCase()+opt.slice(1);
            sel.appendChild(o);
          });
          if (row.id && CrmView.imovelIntent[row.id]) {
            sel.value = CrmView.imovelIntent[row.id];
          }
          sel.onchange = ()=>{
            CrmView.setImovelIntent(row.id, sel.value);
          };
          tdImv.appendChild(sel);
          tr.appendChild(tdImv);
          const tdAct = document.createElement('td');
          const btnView = document.createElement('button'); btnView.textContent='Ver'; btnView.className='btn btn-sm btn-outline-secondary';
          btnView.style.marginRight='4px';
          btnView.onclick=()=>CrmView.viewRecord(row.id);
          tdAct.appendChild(btnView);
          const btnEdit = document.createElement('button'); btnEdit.textContent='Editar'; btnEdit.className='btn btn-sm btn-outline-primary';
          btnEdit.onclick=()=>CrmView.openEdit(row.id);
          tdAct.appendChild(btnEdit);
          tr.appendChild(tdAct);
          tbody.appendChild(tr);
        });
        CrmView.renderPager();
      })
      .catch(e=>{
        document.getElementById('crm_status').innerText = 'Erro: ' + e;
        console.error('CRM fetch error', e);
      });
  },
  viewRecord(id) {
    if (!id) return;
    this.fetchJson(`engine.php?class=EspoCrmProxy&method=get&entity=${this.entity}&id=${encodeURIComponent(id)}`)
      .then(j=>{
        CrmView.showModal(CrmView.renderRecord(j.data));
      }).catch(e=> alert('Erro ao carregar registro: '+ e));
  },
  renderRecord(data) {
    if (!data || typeof data !== 'object') return '<p>Sem dados.</p>';
    const safe = k => (data[k] ?? '');
    let html = '<h4 style="margin-top:0">Registro</h4><table class="table table-sm">';
    ['id','name','firstName','lastName','emailAddress','email','phoneNumber'].forEach(k=>{
      if (data[k]) html += `<tr><th style="width:140px">${k}</th><td>${String(data[k])}</td></tr>`;
    });
    html += '</table><div style="text-align:right; margin-top:10px">';
    html += '<button class="btn btn-sm btn-secondary" onclick="CrmView.closeModal()">Fechar</button>';
    if (data.id) {
      html += ' <button class="btn btn-sm btn-primary" onclick="CrmView.openEdit(\''+data.id+'\')">Editar</button>';
      html += ' <button class="btn btn-sm btn-danger" onclick="CrmView.deleteRecord(\''+data.id+'\')">Excluir</button>'; 
    }
    html += '</div>';
    return html;
  },
  openEdit(id){
    if(!id) return;
    CrmView.fetchJson(`engine.php?class=EspoCrmProxy&method=get&entity=${CrmView.entity}&id=${encodeURIComponent(id)}`)
      .then(j=>{
        const data = j.data || {};
        const fields = CrmView.getCreateFields(); // reuse create fields for edit
        let form = '<h4 style="margin-top:0">Editar '+CrmView.entity+'</h4><form id="crm_edit_form">';
        fields.forEach(f=>{
          const val = data[f.name] || '';
          form += `<div style="margin-bottom:6px"><label style="font-size:12px">${f.label}<br><input type="text" name="${f.name}" value="${String(val).replace(/"/g,'&quot;')}" class="form-control form-control-sm" /></label></div>`;
        });
        form += '<div style="text-align:right"><button type="button" class="btn btn-sm btn-secondary" onclick="CrmView.closeModal()">Cancelar</button> <button type="submit" class="btn btn-sm btn-primary">Salvar</button></div></form>';
        CrmView.showModal(form);
        const frm = document.getElementById('crm_edit_form');
        frm.addEventListener('submit', e=>{
          e.preventDefault();
          const payload = {};
          fields.forEach(f=>{ payload[f.name] = frm.querySelector(`[name="${f.name}"]`).value.trim(); });
          CrmView.updateRecord(id, payload);
        });
      })
      .catch(e=>{ document.getElementById('crm_status').innerText='Erro carregar para editar: '+ e; });
  },
  updateRecord(id, payload){
    CrmView.fetchJson(`engine.php?class=EspoCrmProxy&method=update&entity=${CrmView.entity}&id=${encodeURIComponent(id)}`, {
      method:'PUT',
      headers:{'Content-Type':'application/json','Accept':'application/json'},
      body: JSON.stringify(payload)
    }).then(j=>{
      if(j.success){
        document.getElementById('crm_status').innerText='Atualizado';
        CrmView.closeModal();
        CrmView.reload(false);
      } else {
        document.getElementById('crm_status').innerText='Falha ao atualizar: '+ (j.error||'');
      }
    }).catch(e=>{
      document.getElementById('crm_status').innerText='Erro atualizar: '+ e;
    });
  },
  
  openCreate() {
    const fields = CrmView.getCreateFields();
    let form = '<h4 style="margin-top:0">Novo '+CrmView.entity+'</h4><form id="crm_create_form">';
    fields.forEach(f=>{
      form += `<div style="margin-bottom:6px"><label style="font-size:12px">${f.label}<br><input type="text" name="${f.name}" class="form-control form-control-sm" /></label></div>`;
    });
    form += '<div style="text-align:right"><button type="button" class="btn btn-sm btn-secondary" onclick="CrmView.closeModal()">Cancelar</button> <button type="submit" class="btn btn-sm btn-success">Salvar</button></div></form>';
    CrmView.showModal(form);
    const frm = document.getElementById('crm_create_form');
    frm.addEventListener('submit', e=>{
      e.preventDefault();
      const data = {};
      fields.forEach(f=>{ data[f.name] = frm.querySelector(`[name="${f.name}"]`).value.trim(); });
      CrmView.createRecord(data);
    });
  },
  getCreateFields() {
    switch (CrmView.entity) {
      case 'RealEstateProperty': return [
        {name:'name', label:'Nome do Imóvel'}
      ];
      case 'Lead': return [
        {name:'firstName', label:'Nome'},
        {name:'lastName', label:'Sobrenome'},
        {name:'emailAddress', label:'Email'}
      ];
      case 'Account': return [
        {name:'name', label:'Nome da Conta'},
        {name:'phoneNumber', label:'Telefone'}
      ];
      default: return [
        {name:'firstName', label:'Nome'},
        {name:'lastName', label:'Sobrenome'},
        {name:'emailAddress', label:'Email'}
      ];
    }
  },
  createRecord(payload) {
    CrmView.fetchJson(`engine.php?class=EspoCrmProxy&method=create&entity=${CrmView.entity}`, {
      method:'POST',
      headers:{'Content-Type':'application/json','Accept':'application/json'},
      body: JSON.stringify(payload)
    }).then(j=>{
      if (j.success) {
        document.getElementById('crm_status').innerText = 'Criado com sucesso';
        CrmView.closeModal();
        CrmView.reload(true);
      } else {
        document.getElementById('crm_status').innerText = 'Falha ao criar: '+ (j.error||'');
      }
    }).catch(e=>{
      document.getElementById('crm_status').innerText = 'Erro criar: '+ e;
    });
  },
  deleteRecord(id) {
    if (!confirm('Confirma excluir?')) return;
    CrmView.fetchJson(`engine.php?class=EspoCrmProxy&method=delete&entity=${CrmView.entity}&id=${encodeURIComponent(id)}`)
      .then(j=>{
        if (j.success) {
          document.getElementById('crm_status').innerText = 'Excluído';
          CrmView.closeModal();
          CrmView.reload(true);
        } else {
          document.getElementById('crm_status').innerText = 'Falha ao excluir: '+ (j.error||'');
        }
      }).catch(e=>{
        document.getElementById('crm_status').innerText = 'Erro excluir: '+ e;
      });
  },
  setImovelIntent(id, intent){
    if (!id) return;
    this.imovelIntent[id] = intent;
    // Não exibir mensagem no status ao trocar a preferência
  },
  showModal(html) {
    const modal = document.getElementById('crm_modal');
    const inner = document.getElementById('crm_modal_inner');
    inner.innerHTML = html;
    modal.style.display = 'block';
    modal.onclick = (ev)=>{ if (ev.target === modal) CrmView.closeModal(); };
  },
  closeModal() {
    const modal = document.getElementById('crm_modal');
    modal.style.display = 'none';
    document.getElementById('crm_modal_inner').innerHTML='';
  },
  renderPager() {
    const pager = document.getElementById('crm_pager');
    pager.innerHTML='';
    const back = document.createElement('button'); back.textContent='«'; back.className='btn btn-sm btn-light';
    back.disabled = this.offset<=0;
    back.onclick=()=>{ if(this.offset>0){ this.offset -= this.pageSize; this.reload(); } };
    pager.appendChild(back);
    const info = document.createElement('span'); info.style.padding='4px 8px'; info.textContent = `Página ${(this.offset/this.pageSize)+1}`;
    pager.appendChild(info);
    const next = document.createElement('button'); next.textContent='»'; next.className='btn btn-sm btn-light';
    next.disabled = (this.lastTotal < this.pageSize);
    next.onclick=()=>{ if(this.lastTotal >= this.pageSize){ this.offset += this.pageSize; this.reload(); } };
    pager.appendChild(next);
  }
};

// Inicial (robusto para conteúdo injetado após DOMContentLoaded)
function initCrmView(){
  const el = document.getElementById('crm_search');
  if (el && !el.dataset.cvInit) {
    el.addEventListener('keyup', ()=>CrmView.reload(false));
    el.dataset.cvInit = '1';
  }
  // Tabs
  const tabs = document.getElementById('crm_tabs');
  if (tabs && !tabs.dataset.cvInit) {
    tabs.addEventListener('click', (ev)=>{
      const target = ev.target.closest('button[data-entity]');
      if (target) {
        CrmView.setEntity(target.getAttribute('data-entity'));
      }
    });
    tabs.dataset.cvInit = '1';
  }
  CrmView.updateTabs();
  CrmView.reload(true);
}
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCrmView);
} else {
  initCrmView();
}
})();
JS;
        return str_replace(['__ENTITY__','__PAGESIZE__'], [$entity, $pageSize], $js);
    }
}
?>