{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>tourenhotel</p>
    <p>Partnerhaus AMPEL-RABATT</p>
  <h1>{$user->name}</h1>
</div>
{include 'includes/messages.tpl'}
<div class="card mb-3">
    <div class="card-body" style="text-align: left;">
        Sehr geehrter Frau / Herr  <span class="text-nowrap">{$p3['verantwortlicher']}</span>,<br />
        <br />
        Wunschgemäß haben wir für Sie mit sofortiger Wirkung und bis auf Ihren Wiederruf folgende Rabatte in unseren tourenhotel Portalen
        veröffentlicht; also für alle Seitenbesucher sichtbar dargestellt.
    </div>
        <div class="card-body">
            {$prozent['prozent_name']} {$aktion['aktion_name']}<br />
            Gültig von {$p1['von']} bis {$p1['bis']}<br />
            <a href="/phpinfo.php">Zur Musteransicht</a><br />
        </div>
        <div class="card-body">
            Sollten Sie nicht damit einverstanden sein, öffnen Sie bitte erneut Ihre <a href="/prozente.php">Administration</a>
        </div>
            <div class="card-body">
                Achtung: Die von Ihnen nun eingestellten Rabatte  sind bis zu Ihren nächsten Änderungen für Sie gegenüber Ihren Gästen über den
                angegebenen Gültigkeitszeitraum auf Vorlage verpflichtent. Sie haben dies verbindlich durch Ihre Akzeptanz unseres Datenschutzes,
                unserer AGB, Ihrer Freigabe, sowie der Nennung des Ansprechpartners bestätigt.<br />
                <br />
                Die Rabatteinstellung ist für Sie SELBSTVERANTWORTLICH und kann natürlich jederzeit in einem Wiederruf in Ihrer Administration geändert 
                oder 0% deaktiviert werden.<br />
                <br />
                Eine Bestätigungmail Ihrer Rabatteinstellung geht an Ihre eMail sowie zur Kontrolle an tourenhotel.<br />
                <br />
                Wir wünschen Ihnen viel Erfolg und eine gute Saison.<br />
                Mit freundlichen Grüßen,<br />
                Ihr tourenhotel-Team<br />
                <br />
                rimVERLAG / redaktion-i-media<br />
                Ressort: tourenhotel<br />
                015117535448<br />
            </div>
</div>
