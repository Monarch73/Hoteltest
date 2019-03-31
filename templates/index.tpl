{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Partnerhaus Rabatt-Ampel</h1>
  <p>Partnerhaus tourenhotel.de</p> 
</div>
{include 'includes/messages.tpl'}
<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-4">
        <form method="post" action="/login.php">
          <div class="form-group">
            <label for="InputEmail1">Email address</label>
            <input type="email" class="form-control" id="InputEmail1" name="InputEmail1" aria-describedby="emailHelp" placeholder="eMail">
            <small id="emailHelp" class="form-text text-muted">Die eMailAdresse mit der Sie bei uns gemeldet sind.</small>
          </div>
          <div class="form-group">
            <label for="InputPassword1">Passwort</label>
            <input type="password" class="form-control" id="InputPassword1" name="InputPassword1" placeholder="Passwort">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
  </div>
    <div>
        <a href="/passwort_vergessen.php">Passwort vergessen</a>
    </div>
 </div>
{include 'includes/footer.tpl'}
