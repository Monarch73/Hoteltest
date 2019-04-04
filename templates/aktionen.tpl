{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>tourenhotel</p>
    <p>Partnerhaus AMPEL-RABATT</p>
  <h1>{$user->name}</h1>
</div>
{include 'includes/messages.tpl'}
<div class="container" style="margin-top:30px">
 <form method="post" action="#">
  <div class="row">
    <div class="col-sm-4">
        <button class="btn btn-primary" style="margin: 5px">{$prozent['prozent_name']}</button>
        Rabatte sind gültig<br />
        von: {$page1['von']}<br />
        bis: {$page1['bis']}<br />
    </div>
  </div>
     <div class="row">
         <div class="col-sm-4">
             {foreach from=$aktionen item=aktion}
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" {if $post['aktion']==$aktion.aktion_id}checked="checked"{/if} name="aktion" value="{$aktion.aktion_id}">{$aktion.aktion_name}
                    </label>
                </div>
             {/foreach}
         </div>
     </div>
     <div class="input-group align-middle">
        <button type="submit" class="btn btn-primary float-left" style="margin: 5px" name="zurueck" id="zurueck">zurueck</button>
        <button type="submit" class="btn btn-primary float-right" style="margin: 5px" name="weiter" id="weiter">weiter</button>
     </div>
 </form>

</div>
{include 'includes/footer.tpl'}
