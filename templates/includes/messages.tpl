{if isset($message) && !is_array($message)}
<div class="alert alert-warning">
  <strong>Achtung!</strong> {$message}
</div>
{/if}
{if isset($message) && is_array($message)}
<div class="alert alert-warning">
{foreach from=$message item=$item}
    <div class="row">
        <div class="col">
            {$item}
        </div>
    </div>
{/foreach}
</div>
{/if}
