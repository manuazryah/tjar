<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_mapping".
 *
 * @property int $id
 * @property int $category
 * @property int $subcategory
 * @property string $product_id
 * @property string $variants
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductCategory $category0
 * @property ProductSubCategory $subcategory0
 */
class ProductMapping extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_mapping';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU', 'product_id', 'variants'], 'safe'],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category' => 'id']],
            [['subcategory'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSubCategory::className(), 'targetAttribute' => ['subcategory' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
            'product_id' => 'Product',
            'variants' => 'Variants ( Maximum : 2 )',
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
    public function getCategory0() {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory0() {
        return $this->hasOne(ProductSubCategory::className(), ['id' => 'subcategory']);
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

    public function getVariants($id) {
        $variants = explode(',', $id);
        $result = '';
        $i = 0;
        if (!empty($variants)) {
            foreach ($variants as $val) {

                if ($i != 0) {
                    $result .= ',';
                }
                $variants_data = Features::findOne($val);
                $result .= $variants_data->filter_tittle;
                $i++;
            }
        }

        return $result;
    }

}
