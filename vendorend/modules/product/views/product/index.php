<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use yii\grid\GridView;
use yii\widgets\ListView;
?>
<style>
    .summary{
        padding-left: 15px;
    }
    .sell-btn{
        opacity: 0;
        position: absolute;
        bottom: 75px;
        left: 30px;
        transition: all 5ms;
        z-index: 2;
        background: #0070CC;
        color: white;
        border: #0070CC;
        padding: 8px 10px;
    }
    .album-image:hover .sell-btn{
        opacity: 2;
        color: white;
    }
</style>
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