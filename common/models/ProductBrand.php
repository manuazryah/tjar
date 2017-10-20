<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_brand".
 *
 * @property int $id
 * @property int $category
 * @property int $subcategory
 * @property string $brand_name
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductMainCategory $category0
 * @property ProductSubCategory $subcategory0
 */
class ProductBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'brand_name', 'CB', 'UB'], 'required'],
            [['category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['brand_name'], 'string', 'max' => 500],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductMainCategory::className(), 'targetAttribute' => ['category' => 'id']],
            [['subcategory'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSubCategory::className(), 'targetAttribute' => ['subcategory' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
            'brand_name' => 'Brand Name',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(ProductMainCategory::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory0()
    {
        return $this->hasOne(ProductSubCategory::className(), ['id' => 'subcategory']);
    }
}
