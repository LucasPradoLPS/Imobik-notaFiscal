<select id="bairroImv" name="bairroImv" class="js-select js-select-2 form-select" data-hs-tom-select-options='{literal}{"hideSearch": false}{/literal}'>
  <option value="0" selected>Todos os Bairros</option>
  {foreach from=$IMOVELBAIRRO item="ITEMBAIRRO"}
    <option value="{$ITEMBAIRRO->bairro}">{$ITEMBAIRRO->bairro}</option>
  {/foreach}
</select>
<script>
(function() {
  HSCore.components.HSTomSelect.init('.js-select-2');
})()
</script>
