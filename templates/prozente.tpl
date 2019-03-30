{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>tourenhotel</p>
    <p>Partnerhaus AMPEL-RABATT</p>
  <h1>{$user->name}</h1>
</div>
<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-4">

        <form action="/aktion.php" method="post">

            {foreach from=$prozente item=prozentname}
            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
                S1: {$prozentname}
            </button>
            {/foreach}

            <div class="input-group date">
                <input type="text" class="form-control" placeholder="gültig von"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>

            <div class="input-group date">
                <input type="text" class="form-control" placeholder="gültig bis"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>

            <div class="input-group align-middle">
                <button type="submit" name="weiter" id="weiter">weiter</button>
            </div>

        </form>
    </div>
  </div>
</div>
<script>
    $('.input-group.date').datepicker({
    format: "dd.mm.yyyy",
    todayBtn: true,
    language: "de",
    autoclose: true,
    toggleActive: true
});
</script>
{include 'includes/footer.tpl'}
