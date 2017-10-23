<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_features".
 *
 * @property int $id
 * @property int $category
 * @property int $subcategory
 * @property int $specification
 * @property int $specification_type
 * @property string $comments
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductCategory $category0
 * @property Features $specification0
 * @property ProductSubCategory $subcategory0
 */
class ProductFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'specification', 'specification_type', 'CB', 'UB'], 'required'],
            [['category', 'subcategory', 'specification', 'specification_type', 'status', 'CB', 'UB'], 'integer'],
            [['comments'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category' => 'id']],
            [['specification'], 'exist', 'skipOnError' => true, 'targetClass' => Features::className(), 'targetAttribute' => ['specification' => 'id']],
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
            'specification' => 'Specification',
            'specification_type' => 'Specification Type',
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
    public function getCategory0()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecification0()
    {
        return $this->hasOne(Features::className(), ['id' => 'specification']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory0()
    {
        return $this->hasOne(ProductSubCategory::className(), ['id' => 'subcategory']);
    }
}
