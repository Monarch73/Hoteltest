{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>tourenhotel</p>
    <p>Partnerhaus AMPEL-RABATT</p>
  <h1>{$user->name}</h1>
</div>
  <div class="card">
      <div class="card-body">
          Sehr geehrter Frau/ Herr {$user->owner},<br>
          <br>
          Um Ihr Passwort zurück zusetzen, müssen Sie auf diesen Link klicken:
          {$url nofilter}<br>
          <br>
          Auf der folgenden Webseite müssen Sie dann Ihr Passwort festlegen.<br>
          Bitte beachten Sie, das Ihr Passwort aus mindestens 8 Zeichen, mindestens 1 Großbuchstaben,<br>
          mindestens 1 Kleinbuchstaben und mindestens 1 Zahl bestehen sollte.<br>
          <br>
          Mit freundlichen Grüßen,<br>
          Ihr tourenhotel-Team<br>
          <br>
          rimVERLAG / redaktion-i-media<br>
          Ressort: tourenhotel<br>
          015117535448<br>
      </div>
  </div>
{include 'includes/footer.tpl}
  