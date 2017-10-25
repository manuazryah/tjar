<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_vendor".
 *
 * @property int $id
 * @property int $product_id
 * @property int $vendor_id
 * @property int $qty
 * @property string $price
 * @property int $sku
 * @property string $offer_note
 * @property int $handling_time
 * @property int $pick_up_location
 * @property int $free_shipping
 * @property int $courier_handover
 * @property string $conditions
 * @property string $offer_price
 * @property int $full_fill
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Products $product
 * @property Vendors $vendor
 */
class ProductVendor extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product_vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['qty', 'handling_time', 'price'], 'required'],
            [['product_id', 'vendor_id', 'qty', 'sku', 'handling_time', 'pick_up_location', 'free_shipping', 'courier_handover', 'full_fill', 'status', 'CB', 'UB'], 'integer'],
            [['price', 'offer_price'], 'number'],
            [['offer_note', 'conditions'], 'string'],
            [['CB', 'UB'], 'required'],
            [['DOC', 'DOU'], 'safe'],
            [['field1', 'field2', 'field3'], 'string', 'max' => 500],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendors::className(), 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'vendor_id' => 'Vendor ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'sku' => 'Sku',
            'offer_note' => 'Offer Note',
            'handling_time' => 'Handling Time',
            'pick_up_location' => 'Pick Up Location',
            'free_shipping' => 'Free Shipping',
            'courier_handover' => 'Courier Handover',
            'conditions' => 'Conditions',
            'offer_price' => 'Offer Price',
            'full_fill' => 'Full Fill',
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
    public function getProduct() {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor() {
        return $this->hasOne(Vendors::className(), ['id' => 'vendor_id']);
    }

}