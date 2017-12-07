<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "order_history".
 *
 * @property int $id
 * @property int $detail_id
 * @property string $order_id
 * @property int $product_id
 * @property int $status
 * @property string $date
 * @property string $comment
 */
class OrderHistory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'order_history';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['detail_id', 'order_id', 'product_id'], 'required'],
            [['detail_id', 'product_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['order_id'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'detail_id' => 'Detail ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'status' => 'Status',
            'date' => 'Date',
            'comment' => 'Comment',
        ];
    }

    public static function track_content($history, $model) {

        $product_vendor = ProductVendor::findOne($model->product_id);
        $products = Products::findOne($product_vendor->product_id);
        $content = '<div class="panel panel-default">
            <button type="button" class="close" style="padding: 7px 10px;" data-dismiss="modal">&times;</button>
            <div class="panel-heading">
                
                <h3 class="panel-title">' . html::encode($model->order_id . " - " . $products->product_name) . '</h3>


            </div><div class="panel-body"><div class="products-view"><div class="product-vendor-view"><div class="panel panel-default"><div class="panel-body"><div class="panel-body"><div class="col-md-12 col-lg-12 col-sm-12 product-vew-pop"><div class="col-md-12" style="padding-top: 15px;">';

        if (!empty($history)) {
            $content .= '<table class="table"><thead><tr><th>Date</th><th>Status</th><th>Comment</th></tr></thead><tbody>';
            foreach ($history as $hitry) {
                if ($hitry->status == '0')
                    $status = 'Pending';
                if ($hitry->status == '1')
                    $status = 'Placed';
                if ($hitry->status == '2')
                    $status = 'Dispatched';
                if ($hitry->status == '3')
                    $status = 'Delivered';
                $content .= '<tr><td>' . $hitry->date . '</td><td>' . $status . '</td><td>' . $hitry->comment . '</td></tr>';
            }
        }else {
            $content .= '<h4>The Order is in Pending<h4>';
        }
        $content .= '</tbody></table></div></div></div></div></div></div></div></div></div>';
        return $content;
    }

}
