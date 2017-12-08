<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zpm_processor".
 *
 * @property int $id
 * @property int $main_category
 * @property int $category
 * @property int $subcategory
 * @property string $value
 * @property string $canonical_name
 * @property string $value_arabic
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductCategory $category0
 * @property ProductMainCategory $mainCategory
 * @property ProductSubCategory $subcategory0
 */
class ZpmProcessor extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'zpm_processor';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['main_category', 'category', 'subcategory', 'value', 'value_arabic'], 'required'],
			[['main_category', 'category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
			[['DOC', 'DOU'], 'safe'],
			[['value', 'value_arabic', 'canonical_name'], 'string', 'max' => 250],
//            [['field1', 'field2', 'field3'], 'string', 'max' => 500],
		    [['category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category' => 'id']],
			[['main_category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductMainCategory::className(), 'targetAttribute' => ['main_category' => 'id']],
			[['subcategory'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSubCategory::className(), 'targetAttribute' => ['subcategory' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
		    'id' => 'ID',
		    'main_category' => 'Main Category',
		    'category' => 'Category',
		    'subcategory' => 'Subcategory',
		    'value' => 'Value',
		    'canonical_name' => 'Canonical Name',
		    'value_arabic' => 'Value Arabic',
		    'field1' => 'Field1',
		    'field2' => 'Field2',
		    'field3' => 'Field3',
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
	public function getMainCategory() {
		return $this->hasOne(ProductMainCategory::className(), ['id' => 'main_category']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSubcategory0() {
		return $this->hasOne(ProductSubCategory::className(), ['id' => 'subcategory']);
	}

}
