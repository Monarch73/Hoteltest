{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>tourenhotel</p>
    <p>Partnerhaus AMPEL-RABATT</p>
  <h1>{$user->name}</h1>
</div>
{include 'includes/messages.tpl'}
<form action="#" method="post">
<div class="card">
<div class="card-body" style="text-align: center">
    <div class="row">
        <div class="col" style="text-align: right">
            <button class="btn btn-primary btn-lg" style="margin: 5px;">{$prozent['prozent_name']}</button>
        </div>
        <div class="col" style="text-align: left">
    Rabatte sind gültig<br />
    von: {$p1['von']}<br />
    bis: {$p1['bis']}<br />
    auf: {$aktion['aktion_name']}
    </div>
    </div>
</div>
<div class="card-body" style="text-align: center">
    <input type="text" id="verantwortlicher" name="verantwortlicher" style="min-width: 500px" placeholder="Verantwortlicher/ Ansprechpartner" value="{$post['verantwortlicher']}">
</div>
    <div class='card-body' style="text-align: center"><small>
        Achtung: Die von Ihnen nun eingestellten Rabatte sind sofort nach Ihrer Freigabe
        auf all Ihren tourenhotel-Partner-Darstelltungsseiten sichtbar und bis zu Ihrer
        nächsten Änderrung für Sie zu Ihren Gästen über den angegebenen Gültigkeitszeitraum 
        auf deren Vorlage verpflichtent.
        </small></div>
<div class="card-body" style="text-align: center">
      <div class="form-check">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="option1" value="1">Ich akzeptiere den Datenschutz
        </label>
      </div>
      <div class="form-check">
        <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="option2" value="1">Ich akzeptiere und möchte Veröffentlichen.
        </label>
      </div>
</div>
<div class="card-body" style="text-align: center">
        <button type="submit" class="btn btn-lg btn-primary" name="weiter">Verbindlich auf der Webseite darstellen!</button>
</div>
    <div class="card-body" style="text-align: center">
        <small>Eine Bestätigungmail Ihrer Rabatteinstellung geht an Ihre eMail sowie zur Kontrolle an tourenhotel.</small>
    </div>
<div class="card-body" style="text-align: center">
   <button type="submit" class="btn btn-outline-info" style="margin: 5px" name="zurueck" id="zurueck">zurueck</button>
</div>
</div>
</form>
{include 'includes/footer.tpl'}

