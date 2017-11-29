<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
?>
<style>
        .summary{
                padding-left: 15px;
        }
        .sell-btn-div{
                opacity: 0;
                position: absolute;
                bottom: -52px;
                /* left: 30px; */
                right: 0px;
                transition: all 5ms;
                z-index: 5;
                background: #ffffff;
                color: white;
                border: #ffffff;
                padding: 18px 10px;
                background-color: white;
                margin: 0 auto;
                left: 0px;
                right: 0px;
                text-align: center;
        }
        .sell-btn{
                background: #2196F3;
                padding: 10px 60px;
                font-weight: 600;
                color: white;
        }
        .sell-btn:hover{
                color: white;
        }
        .product-div:hover .sell-btn-div{
                opacity: 2;
                color: white;
        }
</style>
<style>
        .view_detail{
                opacity: 0;
                position: absolute;
                bottom: 180px;
                transition: all 5ms;
                z-index: 2;
                background: #0070CC;
                color: white;
                border: #0070CC;
                padding: 8px 10px;
                margin-left: 31px;
                left: 0;
                right: 0;
                margin: 0 auto;
                width: 30%;
                cursor:pointer;
        }
        .album-image:hover .view_detail{
                opacity: 2;
                color: white;
        }
        .album-image{
                min-height: 437px;
        }
        .album-image:hover .thumb{
                background: rgba(0,0,0,.44);
        }
</style>

<?php
Modal::begin([
    'header' => '',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id = 'modalContent'></div>";
Modal::end();
?>
<section class="gallery-env">

        <div class="row">

                <!-- Gallery Album Optipns and Images -->
                <div class="col-sm-9 gallery-right">

                        <!-- Album Header -->
                        <div class="album-header">
                                <h2>General</h2>
                        </div>

                        <!-- Sorting Information -->
                        <div class="album-sorting-info">
                                <div class="album-sorting-info-inner clearfix">
                                        <a href="#" class="btn btn-secondary btn-xs btn-single btn-icon btn-icon-standalone pull-right" data-action="sort">
                                                <i class="fa-save"></i>
                                                <span>Save Current Order</span>
                                        </a>

                                        <i class="fa-arrows-alt"></i>
                                        Drag images to sort them
                                </div>
                        </div>

                        <!-- Album Images -->
                        <div class="album-images row">
                                <?=
                                $dataProvider->totalcount > 0 ? ListView::widget([
                                            'dataProvider' => $dataProvider,
                                            'itemView' => '_view2',
                                            'pager' => [
                                                'firstPageLabel' => 'first',
                                                'lastPageLabel' => 'last',
                                                'prevPageLabel' => '<',
                                                'nextPageLabel' => '>',
                                                'maxButtonCount' => 5,
                                            ],
                                        ]) : $this->render('no_product');
                                ?>
                                <!-- Album Image -->
                        </div>
                </div>

                <!-- Gallery Sidebar -->
                <div class="col-sm-3 gallery-left">

                        <div class="gallery-sidebar">

                                <a href="#" class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right">
                                        <i class="fa fa-filter"></i>
                                        <span>Filter By</span>
                                </a>

                                <ul class="list-unstyled">
                                        <li class="active">
                                                <a href="#">
                                                        <i class="fa-folder-open-o"></i>
                                                        <span>General</span>
                                                </a>
                                        </li>
                                        <li>
                                                <a href="#">
                                                        <i class="fa-folder-o"></i>
                                                        <span>Office</span>
                                                </a>
                                        </li>
                                        <li>
                                                <a href="#">
                                                        <i class="fa-folder-o"></i>
                                                        <span>Las Vegas</span>
                                                </a>
                                        </li>
                                        <li>
                                                <a href="#">
                                                        <i class="fa-folder-o"></i>
                                                        <span>Thailand</span>
                                                </a>
                                        </li>
                                        <li>
                                                <a href="#">
                                                        <i class="fa-folder-o"></i>
                                                        <span>Nature</span>
                                                </a>
                                        </li>
                                </ul>

                        </div>

                </div>

        </div>

</section>