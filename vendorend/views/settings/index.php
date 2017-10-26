<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
?>
<style>
    .address-box{
        background: #eeeeee;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 25px;
    }
    .address-box:hover{
        background-color: #cdeefe;
    }
    .edit-box{
        padding: 10px 0px;
        border-top: 1px solid #FFC107;
    }
    .addresses{
        padding-bottom: 10px;
    }
    .addresses h4{
        color:#232121;
        font-weight: 600;
    }
    .addresses p{
        line-height: 6px;
    }
    .option_btn{
        display: none;
    }
</style>
<div>
    <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> Add New Location', ['/settings/add-new-location'], ['class' => 'btn btn-blue', 'style' => 'float:right;']) ?>
    <h3>Locations</h3>
</div>
<div class="clearfix"></div>
<div class="panel panel-default">
    <div class="panel-body" style="padding-top:0px;">

        <?php foreach ($model as $value) { ?>
            <div class="col-md-4" id="address_div-<?= $value->id ?>">
                <div class="address-box">
                    <div class="addresses">
                        <h4><?= $value->first_name ?> <?= $value->last_name ?></h4>
                        <p>City, Street</p>
                        <p><?= $value->building_no ?></p>
                        <p><?= $value->mobile_no ?></p>
                    </div>
                    <div class="edit-box">
                        <input type="hidden" class="<?= $value->dafault_address == 1 ? 'primary-btn' : '' ?>" value="<?= $value->dafault_address == 1 ? $value->id : '' ?>"/>
                        <label>
                            <input type="radio" name="default_address" class="default_address" id="<?= $value->id ?>" value="" <?= $value->dafault_address == 1 ? 'checked' : '' ?>> <span id="primary_address-<?= $value->id ?>"><?= $value->dafault_address == 1 ? 'Primary' : 'Set as Primary' ?></span>
                        </label>
                        <?= Html::a('&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true"></i> Delete ', [''], ['class' => $value->dafault_address == 1 ? 'delete-default option_btn' : 'delete-default', 'style' => 'float:right;color: #2196F3;', 'id' => 'delete_btn-' . $value->id]) ?>
                        <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i> Edit', ['/settings/edit-location', 'id' => $value->id], ['class' => $value->dafault_address == 1 ? 'option_btn' : '', 'style' => 'float:right;color: #2196F3;', 'id' => 'edit_btn-' . $value->id]) ?>
                    </div>
                </div>
            </div>
        <?php }
        ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $(".default_address").on('click', function () {
            var arr = $(this).attr('id');
            var primary = $('.primary-btn').val();
            $.ajax({
                url: '<?= Yii::$app->homeUrl; ?>settings/change-default-address',
                type: "POST",
                data: {id: arr},
                success: function (data) {
                    if (data != 0) {
                        $('.primary-btn').val(arr);
                        $('#primary_address-' + arr).text('Primary');
                        $('#primary_address-' + data).text('Set as primary');
                        $("#delete_btn-" + primary).removeClass("option_btn");
                        $('#delete_btn-' + arr).addClass("option_btn");
                        $("#edit_btn-" + primary).removeClass("option_btn");
                        $('#edit_btn-' + arr).addClass("option_btn");
                    }
                }
            });
        });
        $(".delete-default").on('click', function () {
            var str = $(this).attr('id');
            var arr = str.split("-");
            alert(arr);
            $.ajax({
                url: '<?= Yii::$app->homeUrl; ?>settings/delete-address',
                type: "POST",
                data: {id: arr},
                success: function (data) {
                    if (data != 0) {
                        $('#address_div-' + arr).remove();
                    }
                }
            });
        });
    });
</script>