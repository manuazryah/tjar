<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MenuManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-management-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



                    <?= Html::a('<i class="fa-th-list"></i><span> Create New Menu</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
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
//                                        'id',
                                [
                                    'attribute' => 'type',
                                    'filter' => ['1' => 'Main', '2' => 'Sub', '3' => 'Child'],
                                    'value' => function($data) {
                                        if ($data->type == 1) {
                                            return 'Main';
                                        } elseif ($data->type == 2) {
                                            return 'Sub';
                                        } elseif ($data->type == 3) {
                                            return 'Child';
                                        } else {
                                            return '';
                                        }
                                    }
                                ],
                                'main_menu',
//            'main_menu_arabic',
                                'sub_menu',
                                // 'sub_menu_arabic',
//                                'sub_menu_link',
                                'child_menu',
                                // 'child_menu_arabic',
//                                'child_menu_link',
                                // 'status',
                                // 'CB',
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

<script>
    $(document).ready(function () {
        $(".filters").slideToggle();
        $("#search-option").click(function () {
            $(".filters").slideToggle();
        });
    });
</script>

