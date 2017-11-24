<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\ProductCategory;
use common\models\Features;

if (!empty($categ)) {
        $category = ProductCategory::findOne(['id' => $categ]);
        $min_amount = $category->min_amount;
        $max_amount = $category->max_amount;
}
?>
<style>
        .summary{
                display: none;
        }
</style>
<div id="product-page">
        <div class="container">
                <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 padright10">

                                <div class="breadcrumb bg-white hidden-lg hidden-md hidden-sm">
                                        <ol class="path">
                                                <li><a href="index.php">Home</a></li>
                                                <li><a href="#">About Us</a></li>
                                                <li class="active">products</li>
                                        </ol>
                                        <p class="current-page">products</p>
                                </div>

                                <div class="left-menu">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h4 class="heading">Product Categories</h4>

                                                <div class="panel-group" id="accordion">


                                                        <?php
                                                        $j = 0;
                                                        if (!empty($filters)) {
                                                                foreach ($filters as $value) {


                                                                        $feature_detail = Features::findOne($value->features);
                                                                        $model_name = $feature_detail->model_name;

                                                                        if (!empty($categ))
                                                                                $filter_values = $model_name::find()->where(['category' => $categ])->all();
                                                                        elseif (!empty($sub_categ))
                                                                                $filter_values = $model_name::find()->where(['subcategory' => $sub_categ])->all();
                                                                        elseif (!empty($categ) && !empty($sub_categ))
                                                                                $filter_values = $model_name::find()->where(['category' => $categ, 'subcategory' => $sub_categ])->all();
                                                                        ?>
                                                                        <div class="panel panel-default">
                                                                                <div class="panel-heading">
                                                                                        <h4 class="panel-title">
                                                                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?= $j ?>">
                                                                                                        <?= $feature_detail->filter_tittle ?>
                                                                                                </a>
                                                                                        </h4>
                                                                                </div><!--/.panel-heading -->

                                                                                <div id="collapse_<?= $j ?>" class="panel-collapse collapse">
                                                                                        <div class="panel-body">

                                                                                                <form>
                                                                                                        <?php
                                                                                                        foreach ($filter_values as $filter_value) {
                                                                                                                if ($feature_detail->canonical_name == 'brand') {
                                                                                                                        ?>
                                                                                                                        <label for="mi">
                                                                                                                                <input type="checkbox" class="test"id="<?= $feature_detail->canonical_name . '_' . $filter_value->brand_name ?>" value="" name="<?= $filter_value->brand_name ?>"/>
                                                                                                                                <!--<input type="checkbox" id="mi" name="mi" value="1" >-->
                                                                                                                                <?= $filter_value->brand_name ?>
                                                                                                                        </label>
                                                                                                                        <?php
                                                                                                                } else {
                                                                                                                        ?>
                                                                                                                        <label for="mi">
                                                                                                                                <input type="checkbox" class="test"id="<?= $feature_detail->canonical_name . '_' . $filter_value->value ?>" value="" name="<?= $filter_value->value ?>"/>
                                                                                                                                <!--<input type="checkbox" id="mi" name="mi" value="1" >-->
                                                                                                                                <?= $filter_value->value ?>
                                                                                                                        </label>
                                                                                                                        <?php
                                                                                                                }
                                                                                                        }
                                                                                                        ?>

                                                                                                </form>

                                                                                        </div><!--/.panel-body -->
                                                                                </div><!--/.panel-collapse -->

                                                                        </div><!-- /.panel -->
                                                                        <?php
                                                                        $j++;
                                                                }
                                                        }
                                                        ?>





                                                </div><!-- /.panel-group -->

                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marg-top-20">
                                                <h4 class="heading">Filter by Price</h4>
                                                <input type="hidden" id="amount_min" value="<?= $min_amount ?>" />
                                                <input type="hidden" id="categ_min" value="<?= $min_amount ?>" />
                                                <input type="hidden" id="categ_max" value="<?= $max_amount ?>" />
                                                <input type="hidden" id="amount_max"  value="<?= $max_amount ?>"/>
                                                <div id="slider-container"></div>
                                                <p class="slider-values">
                                                    <!--<input type="text" id="amount" />-->

                                                        <span class="min_value" id="min"></span>
                                                        <span class="max_value" id="max"></span>
                                                </p>


                                        </div>


                                </div>
                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 right-section padlft-rit0">

                                <div class="breadcrumb bg-white hidden-xs">
                                        <ol class="path">
                                                <li><a href="index.php">Home</a></li>
                                                <li><a href="#">About Us</a></li>
                                                <li class="active">products</li>
                                        </ol>
                                        <p class="current-page">products</p>
                                </div>

                                <div class="bg-white" style="padding-bottom: 20px;">
                                        <ul class="listOfassignment">
                                                <?=
                                                ListView::widget([
                                                    'dataProvider' => $dataProvider,
                                                    'itemView' => '_view2',
                                                    'pager' => [
                                                        'firstPageLabel' => 'first',
                                                        'lastPageLabel' => 'last',
                                                        'prevPageLabel' => '<',
                                                        'nextPageLabel' => '>',
                                                        'maxButtonCount' => 5,
                                                    ],
                                                ]);
                                                ?>

                                        </ul>

                                        <!--                    <div class="sld-btn text-center col-lg-12">
                                                                <div class="">
                                                                    <button class="btn btn-primary prv" type="submit"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                                                    <ol class="pagenation"></ol>
                                                                    <button class="btn btn-primary pull-right next" type="submit"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>-->
                                </div>

                        </div>
                </div>

        </div>
</div>