<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $product_name
 * @property string $canonical_name
 * @property int $main_category
 * @property int $category
 * @property int $subcategory
 * @property int $brand
 * @property string $item_ean
 * @property int $gender
 * @property string $main_description
 * @property string $gallery_images
 * @property string $related_products
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name', 'canonical_name', 'main_category', 'category', 'brand', 'item_ean', 'gender', 'main_description', 'CB', 'UB'], 'required'],
            [['main_category', 'category', 'subcategory', 'brand', 'gender', 'status', 'CB', 'UB'], 'integer'],
            [['main_description'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['product_name', 'canonical_name', 'item_ean', 'gallery_images', 'related_products'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'canonical_name' => 'Canonical Name',
            'main_category' => 'Main Category',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
            'brand' => 'Brand',
            'item_ean' => 'Item Ean',
            'gender' => 'Gender',
            'main_description' => 'Main Description',
            'gallery_images' => 'Gallery Images',
            'related_products' => 'Related Products',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
