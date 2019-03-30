{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>tourenhotel</p>
    <p>Partnerhaus AMPEL-RABATT</p>
  <h1>{$user->name}</h1>
</div>
<div class="container" style="margin-top:30px">
 <form method="post" action="/login.php">

  <div class="row">
    <div class="col-sm-4">
            <button class="btn btn-primary">15% </button>
    </div>
    <div class="col-sm-4">
        Rabatte sind gültig<br />
        von:<br />
        bis:<br />
    </div>
  </div>
     <div class="row">
         <div class="col-sm-4">
             {foreach from=aktionen item=aktion}
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="optradio">{$aktion.aktion_name}
                    </label>
                </div>
             {/foreach}
         </div>
     </div>
     <div class="input-group align-middle">
        <button type="submit" name="weiter" id="weiter">weiter</button>
     </div>
 </form>

</div>
{include 'includes/footer.tpl'}
