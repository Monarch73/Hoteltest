{include 'includes/header.tpl'}
<div class="jumbotron text-center" style="margin-bottom:0">
    <p>tourenhotel</p>
    <p>Partnerhaus AMPEL-RABATT</p>
  <h1>{$user->name}</h1>
</div>
{include 'includes/messages.tpl'}
<div class="container" style="margin-top:30px">
<div class="row">
    <div class="col-sm-8">
        <form action="#" method="post">
            <div class="row" style="margin: 30px">
                {foreach from=$prozente item=prozentItem}
                    <div class="col">
                        <label class="btn btn-primary" style="margin: 5px">
                            <input type="radio" name="prozente_id" id="option1" autocomplete="off" value="{$prozentItem['prozent_id']}" {if $post['prozente_id'] == $prozentItem['prozent_id']}checked='checked'{/if} style="min-width: 120px">{$prozentItem['prozent_name']}
                        </label>
                    </div>
                {/foreach}
            </div>
            <div class="form-group">
                    <div class="input-group date">
                        <input type="text" name="von" class="form-control" placeholder="gültig von" value="{$post['von']}"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
            </div>
            <div class="form-group">
                    <div class="input-group date">
                        <input type="text" name="bis" class="form-control" placeholder="gültig bis" value="{$post['bis']}"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
            </div>
            <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-primary btn-lg" name="weiter" id="weiter">weiter</button>
                    </div>
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
