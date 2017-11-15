<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "home_management".
 *
 * @property int $id
 * @property int $type
 * @property string $tittle
 * @property string $product_id
 * @property string $image_1
 * @property string $image_1_arabic
 * @property string $link_1
 * @property string $image_2
 * @property string $image_2_arabic
 * @property string $link_2
 * @property string $image_3
 * @property string $image_3_arabic
 * @property string $link_3
 * @property int $sort_order
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class HomeManagement extends \yii\db\ActiveRecord {

    public $category;
    public $subcategory;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'home_management';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type', 'sort_order', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['tittle', 'product_id', 'link_1', 'link_2', 'link_3'], 'safe'],
            [['image_1', 'image_1_arabic', 'image_2', 'image_2_arabic', 'image_3', 'image_3_arabic'], 'string', 'max' => 50],
            [['image_1', 'image_1_arabic', 'image_2', 'image_2_arabic', 'image_3', 'image_3_arabic'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['image_1', 'image_2', 'image_3', 'link_1', 'link_2', 'link_3'], 'required', 'on' => 'create', 'when' => function ($model) {
                    return $model->type == 1;
                }, 'whenClient' => "function (attribute, value) { return $('#id').val() == '1'; }"],
            [['tittle', 'product_id'], 'required', 'on' => 'create', 'when' => function ($model) {
                    return $model->type == 0;
                }, 'whenClient' => "function (attribute, value) { return $('#id').val() == '0'; }"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'tittle' => 'Tittle',
            'product_id' => 'Products',
            'image_1' => 'Image 1',
            'image_1_arabic' => 'Image 1 Arabic',
            'link_1' => 'Link 1',
            'image_2' => 'Image 2',
            'image_2_arabic' => 'Image 2 Arabic',
            'link_2' => 'Link 2',
            'image_3' => 'Image 3',
            'image_3_arabic' => 'Image 3 Arabic',
            'link_3' => 'Link 3',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    public function getProducts($id) {

        $product = explode(',', $id);
        $result = '';
        $i = 0;
        if (!empty($product)) {
            foreach ($product as $val) {

                if ($i != 0) {
                    $result .= ',';
                }
                $product_data = Products::findOne($val);
                $result .= $product_data->product_name;
                $i++;
            }
        }

        return $result;
    }

}
