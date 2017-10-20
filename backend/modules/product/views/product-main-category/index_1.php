<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductMainCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Main Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-main-category-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <?=
                        $this->render('_form', [
                            'model' => $model,
                        ])
                        ?>
                    </div>
                    <div class="col-md-8">

                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                        <?php // Html::a('<i class="fa-th-list"></i><span> Create New</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>

                        <div class="table-responsive" style="border: none">
                            <button class="btn btn-white" id="search-option" style="float: right;">
                                <i class="linecons-search"></i>
                                <span>Search</span>
                            </button>
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
//                                'id',
                                    'name',
                                    'canonical_name',
                                    'status',
//                                'CB',
                                    // 'UB',
                                    // 'DOC',
                                    // 'DOU',
                                    ['class' => 'yii\grid\ActionColumn'],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>

