<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_brand".
 *
 * @property int $id
 * @property int $main_category
 * @property int $category
 * @property int $subcategory
 * @property string $brand_name
 * @property string $brand_name_arabic
 * @property string $comments
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductMainCategory $mainCategory
 * @property ProductSubCategory $subcategory0
 * @property ProductCategory $category0
 */
class ProductBrand extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'product_brand';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['main_category', 'category', 'brand_name', 'brand_name_arabic', 'CB', 'UB'], 'required'],
			[['main_category', 'category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
			[['comments'], 'string'],
			[['DOC', 'DOU'], 'safe'],
			[['brand_name', 'brand_name_arabic', 'canonical_name'], 'string', 'max' => 500],
			[['main_category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductMainCategory::className(), 'targetAttribute' => ['main_category' => 'id']],
			[['subcategory'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSubCategory::className(), 'targetAttribute' => ['subcategory' => 'id']],
			[['category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category' => 'id']],
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
		    'brand_name' => 'Brand Name',
		    'brand_name_arabic' => 'Brand Name Arabic',
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
	public function getMainCategory() {
		return $this->hasOne(ProductMainCategory::className(), ['id' => 'main_category']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSubcategory0() {
		return $this->hasOne(ProductSubCategory::className(), ['id' => 'subcategory']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategory0() {
		return $this->hasOne(ProductCategory::className(), ['id' => 'category']);
	}

	public function getBrandList($cat_id, $subcat_id) {

		$data = ProductBrand::find()->where(['category' => $cat_id])->orWhere(['subcategory' => $subcat_id])
				->select(['id', 'brand_name AS name'])->asArray()->all();

		return $data;
	}

}
