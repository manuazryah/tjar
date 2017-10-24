<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_specifications".
 *
 * @property int $id
 * @property int $product_id
 * @property int $product_feature_id
 * @property string $product_feature_value
 * @property string $Product_feature_text
 * @property string $comments
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductFeatures $productFeature
 * @property Products $product
 */
class ProductSpecifications extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'product_specifications';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['product_id'], 'required'],
			[['product_id', 'product_feature_id', 'status', 'CB', 'UB'], 'integer'],
			[['comments'], 'string'],
			[['DOC', 'DOU'], 'safe'],
			[['product_feature_value', 'Product_feature_text'], 'string', 'max' => 500],
			[['product_feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductFeatures::className(), 'targetAttribute' => ['product_feature_id' => 'id']],
			[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
		    'id' => 'ID',
		    'product_id' => 'Product ID',
		    'product_feature_id' => 'Product Feature ID',
		    'product_feature_value' => 'Product Feature Value',
		    'Product_feature_text' => 'Product Feature Text',
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
	public function getProductFeature() {
		return $this->hasOne(ProductFeatures::className(), ['id' => 'product_feature_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProduct() {
		return $this->hasOne(Products::className(), ['id' => 'product_id']);
	}

}
