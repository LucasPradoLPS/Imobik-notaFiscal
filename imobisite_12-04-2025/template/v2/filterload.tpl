<select id="bairroImv" name="bairroImv" class="form-control">
  <option value="0" selected>Todos os bairros</option>
  {foreach from=$IMOVELBAIRRO item="ITEMBAIRRO"}
    <option value="{$ITEMBAIRRO->bairro}">{$ITEMBAIRRO->bairro}</option>
  {/foreach}
</select>