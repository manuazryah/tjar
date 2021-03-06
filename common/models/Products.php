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
 * @property string $reward_points
 * @property string $commisson
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
                        [['product_name', 'canonical_name', 'main_category', 'category', 'brand', 'item_ean', 'main_description', 'CB', 'UB', 'product_name_arabic', 'main_description_arabic', /* 'highlights' */], 'required'],
                        [['main_category', 'category', 'subcategory', 'brand', 'gender', 'status', 'CB', 'UB', 'commisson'], 'integer'],
                        [['main_description', 'meta_description', 'meta_keyword', 'main_description_arabic', 'highlights', 'highlights_arabic', 'important_notes', 'important_notes_arabic'], 'string'],
                        [['DOC', 'DOU'], 'safe'],
                        [['product_name', 'canonical_name', 'item_ean', 'gallery_images', 'meta_title', 'field1', 'field2', 'field3', 'product_name_arabic', 'short_description', 'short_description_arabic'], 'string', 'max' => 500],
                        [['search_tags', 'related_products'], 'safe'],
                        [['reward_points'], 'string', 'max' => 100],
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
                    'short_description' => 'Short Description',
                    'short_description_arabic' => 'Short Description Arabic',
                    'main_description' => 'Main Description',
                    'highlights' => 'Highlights',
                    'highlights_arabic' => 'Highlights Arabic',
                    'important_notes' => 'Important Notes',
                    'important_notes_arabic' => 'Important Notes Arabic',
                    'gallery_images' => 'Gallery Images',
                    'related_products' => 'Related Products',
                    'search_tags' => 'Search Tags',
                    'meta_title' => 'Meta Title',
                    'meta_description' => 'Meta Description',
                    'meta_keyword' => 'Meta Keyword',
                    'reward_points' => 'Reward Points',
                    'commisson' => 'Commisson',
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

        public function getSubCategoryName() {
                return $this->hasOne(ProductSubCategory::className(), ['id' => 'subcategory']);
        }

        public function getBrandName() {
                return $this->hasOne(ProductBrand::className(), ['id' => 'brand']);
        }

        public static function SearchTags($searchtags) {
                if (isset($searchtags) && $searchtags != '') {
                        $searchtags = explode(',', $searchtags);
                        $searchtags_name = '';
                        foreach ($searchtags as $value) {
                                $value_name = SearchTag::findOne($value);
                                if (isset($value_name->tag_name)) {
                                        $searchtags_name .= $value_name->tag_name . ',';
                                }
                        }
                        return $searchtags_name;
                }
        }

}
