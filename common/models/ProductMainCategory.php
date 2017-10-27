<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_main_category".
 *
 * @property int $id
 * @property string $name
 * @property string $canonical_name
 * @property string $name_arabic
 * @property string $comments
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductBrand[] $productBrands
 * @property ProductCategory[] $productCategories
 * @property ProductSubCategory[] $productSubCategories
 */
class ProductMainCategory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_main_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'canonical_name', 'name_arabic', 'CB', 'UB'], 'required'],
            [['comments'], 'string'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['name', 'canonical_name', 'name_arabic'], 'string', 'max' => 100],
            [['canonical_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'canonical_name' => 'Canonical Name',
            'name_arabic' => 'Name Arabic',
            'comments' => 'Comments',
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
    public function getProductBrands() {
        return $this->hasMany(ProductBrand::className(), ['main_category' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories() {
        return $this->hasMany(ProductCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSubCategories() {
        return $this->hasMany(ProductSubCategory::className(), ['main_category_id' => 'id']);
    }

}
