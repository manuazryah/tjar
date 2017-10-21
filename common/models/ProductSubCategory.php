<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_sub_category".
 *
 * @property int $id
 * @property int $main_category_id
 * @property int $category_id
 * @property string $subcategory_name
 * @property string $canonical_name
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductBrand[] $productBrands
 * @property ProductMainCategory $mainCategory
 * @property ProductCategory $category
 */
class ProductSubCategory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_sub_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['main_category_id', 'category_id', 'subcategory_name', 'canonical_name', 'CB', 'UB'], 'required'],
            [['main_category_id', 'category_id', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['subcategory_name', 'canonical_name'], 'string', 'max' => 100],
            [['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductMainCategory::className(), 'targetAttribute' => ['main_category_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'main_category_id' => 'Main Category',
            'category_id' => 'Category',
            'subcategory_name' => 'Subcategory Name',
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
        return $this->hasMany(ProductBrand::className(), ['subcategory' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategory() {
        return $this->hasOne(ProductMainCategory::className(), ['id' => 'main_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    public function getSubcatList($cat_id, $subcat_id) {
        $data = ProductSubCategory::find()->where(['main_category_id' => $cat_id, 'category_id' => $subcat_id])
                        ->select(['id', 'subcategory_name AS name'])->asArray()->all();
        return $data;
    }

}
