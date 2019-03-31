{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Partnerhaus Rabatt-Ampel</h1>
  <p>Partnerhaus tourenhotel.de</p> 
</div>
{include 'includes/messages.tpl'}
<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-4">
        <form method="post" action="#">
        {if isset($setpassword)}
          <div class="form-group">
            <label for="psw">Neues Passwort</label>
                <input type="password" id="psw" name="psw" pattern="{$pattern}"  required>
            <input type="submit" value="Passwort setzen">   
           </div>
            <div>
                <p>Das Passwort muss aus mindestens 8 Zeichen bestehen, mindestens einen Groß- und einen Kleinbuchstaben und mindestens eine Zahl beinhalten.</p>
            </div>
        {else}
          <div class="form-group">
            <label for="InputEmail1">Email address</label>
            <input type="email" class="form-control" id="InputEmail1" name="InputEmail1" aria-describedby="emailHelp" placeholder="eMail">
            <small id="emailHelp" class="form-text text-muted">Die eMailAdresse mit der Sie bei uns gemeldet sind.</small>
          </div>
          <button type="submit" class="btn btn-primary">Passwort zusenden</button>
        {/if}
        </form>
    </div>
  </div>
 </div>
{include 'includes/footer.tpl'}