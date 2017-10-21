<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "search_tag".
 *
 * @property int $id
 * @property int $category
 * @property int $subcategory
 * @property string $tag_name
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductCategory $category0
 * @property ProductSubCategory $subcategory0
 */
class SearchTag extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'search_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category', 'tag_name', 'CB', 'UB'], 'required'],
            [['category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['tag_name'], 'string', 'max' => 500],
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
            'tag_name' => 'Tag Name',
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

}
