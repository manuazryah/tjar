<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'submit-reviews']);
?>
<div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Reviews</h4>
        </div>

        <div class="modal-body">
                <div class="media">

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                <a style="float: none;" class="thumbnail " href="#">
                                        <?php
                                        $product_image = Yii::$app->basePath . '/../uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_master_details->id) . '/' . $product_master_details->id . '/profile/' . $product_master_details->canonical_name . '_thumb.' . $product_master_details->gallery_images;
                                        if (file_exists($product_image)) {
                                                ?>
                                                <img class="media-object"src="<?= Yii::$app->homeUrl . '/uploads/products/' . Yii::$app->UploadFile->folderName(0, 1000, $product_master_details->id) . '/' . $product_master_details->id . '/profile/' . $product_master_details->canonical_name . '_thumb.' . $product_master_details->gallery_images ?>">
                                        <?php } else { ?>
                                                <img src="<?= Yii::$app->homeUrl . 'uploads/products/gallery_dummy.png' ?>?scale.height=400" alt=""/>
                                        <?php } ?>
                                </a>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6"><h5 class="review-h5"><?= $product_master_details->product_name ?></h5>
                                <fieldset class="rating">
                                        <input type="radio" id="star5" name="rating" value="5" onclick="postToController();"/><label for="star5" title="I love it">5 stars</label>
                                        <input type="radio" id="star4" name="rating" value="4" onclick="postToController();"/><label for="star4" title="I like it">4 stars</label>
                                        <input type="radio" id="star3" name="rating" value="3" onclick="postToController();"/><label for="star3" title="It's okay">3 stars</label>
                                        <input type="radio" id="star2" name="rating" value="2" onclick="postToController();"/><label for="star2" title="I don't like it">2 stars</label>
                                        <input type="radio" id="star1" name="rating" value="1" onclick="postToController();"/><label for="star1" title="I hate it">1 star</label>
                                </fieldset>
                                <?php echo $form->field($model_review, 'rating')->hiddenInput(['value' => $type, 'id' => 'rating'])->label(false); ?>

                        </div>
                </div>


                <?= $form->field($model_review, 'product_id')->hiddenInput(['maxlength' => true, 'value' => $product_details->id])->label(FALSE) ?>


                <div class="row">
                        <div class="col-md-12">
                                <?= $form->field($model_review, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title', 'required' => ''])->label(FALSE) ?>
                        </div>

                </div>

                <div class="row">
                        <div class="col-md-12">
                                <?= $form->field($model_review, 'description')->textarea(['rows' => 5, 'style' => 'height:auto', 'placeholder' => 'Description', 'required' => ''])->label(FALSE) ?>
                        </div>

                </div>

        </div>

        <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
</div>
<?php ActiveForm::end(); ?>


<style>
        .review-h5{
                font-size: 14px !important;
                color: #000 !important;
                font-weight: bold !important;
        }
</style>

<script>
        function postToController() {
                for (i = 0; i < document.getElementsByName('rating').length; i++) {
                        if (document.getElementsByName('rating')[i].checked == true) {
                                var ratingValue = document.getElementsByName('rating')[i].value;
                                break;
                        }
                }
                $('#rating').val(ratingValue);
        }
</script>