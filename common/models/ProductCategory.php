<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property int $category_id
 * @property string $category_name
 * @property string $canonical_name
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductBrand[] $productBrands
 * @property ProductMainCategory $category
 * @property ProductSubCategory[] $productSubCategories
 */
class ProductCategory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'category_name', 'canonical_name', 'CB', 'UB'], 'required'],
            [['category_id', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['category_name', 'canonical_name'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductMainCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'canonical_name' => 'Canonical Name',
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
        return $this->hasMany(ProductBrand::className(), ['category' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(ProductMainCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSubCategories() {
        return $this->hasMany(ProductSubCategory::className(), ['category_id' => 'id']);
    }

    public function getCatList($cat_id) {
        $data = ProductCategory::find()->where(['category_id' => $cat_id])
                        ->select(['id', 'category_name AS name'])->asArray()->all();
        return $data;
    }

}
