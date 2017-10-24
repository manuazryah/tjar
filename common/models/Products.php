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
 * @property string $search_tags
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Products extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'products';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['product_name', 'canonical_name', 'main_category', 'category', 'brand', 'item_ean', 'main_description', 'CB', 'UB', 'product_name_arabic', 'main_description_arabic'], 'required'],
			[['main_category', 'category', 'subcategory', 'brand', 'gender', 'status', 'CB', 'UB'], 'integer'],
			[['main_description', 'meta_description', 'meta_keyword', 'main_description_arabic'], 'string'],
			[['DOC', 'DOU'], 'safe'],
			[['product_name', 'canonical_name', 'item_ean', 'gallery_images', 'related_products', 'search_tags', 'meta_title', 'field1', 'field2', 'field3', 'product_name_arabic', 'search_tags_arabic'], 'string', 'max' => 500],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
		    'id' => 'ID',
		    'product_name' => 'Product Name',
		    'product_name_arabic' => 'Product Arabic Name',
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
		    'search_tags' => 'Search Tags',
		    'meta_title' => 'Meta Title',
		    'meta_description' => 'Meta Description',
		    'meta_keyword' => 'Meta Keyword',
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

	public function getMainCategory() {
		return $this->hasOne(ProductMainCategory::className(), ['id' => 'main_category']);
	}

	public function getCategoryName() {
		return $this->hasOne(ProductCategory::className(), ['id' => 'category']);
	}

}
