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
 * @property int $vendor_status 1=>'pending',2=>'approved',3=>'rejected'
 * @property int $admin_status 1=>'pending',2=>'approved',3=>'rejected'
 * @property string $expiry_date
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

//    public $free_shipping = false;
//    public $courier_handover = true;

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['qty', 'handling_time', 'price'], 'required'],
                        [['sku'], 'unique'],
                        [['product_id', 'vendor_id', 'qty', 'sku', 'handling_time', 'pick_up_location', 'free_shipping', 'courier_handover', 'full_fill', 'vendor_status', 'admin_status', 'CB', 'UB'], 'integer'],
                        [['price', 'offer_price'], 'number'],
                        [['offer_note', 'conditions'], 'string'],
                        [['expiry_date', 'DOC', 'DOU', 'offer'], 'safe'],
                        [['CB', 'UB'], 'required'],
                        [['DOC', 'DOU'], 'safe'],
                        [['field1', 'field2', 'field3', 'warranty'], 'string', 'max' => 500],
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
                    'product_id' => 'Product',
                    'vendor_id' => 'Vendor ID',
                    'qty' => 'Qty',
                    'price' => 'Price',
                    'sku' => 'Sku',
                    'offer_note' => 'Offer Note',
                    'handling_time' => 'Handling Time',
                    'pick_up_location' => 'Pick Up Location',
                    'free_shipping' => ' Free Shipping (You will pay for item shipping)',
                    'courier_handover' => 'Item Pick-Up (Collection)',
                    'conditions' => 'Conditions',
                    'offer_price' => 'Offer Price',
                    'full_fill' => 'Full Fill',
                    'warranty' => 'Warranty',
                    'field1' => 'Field1',
                    'field2' => 'Field2',
                    'field3' => 'Field3',
                    'vendor_status' => 'Vendor Status',
                    'admin_status' => 'Admin Status',
                    'expiry_date' => 'Expiry Date',
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

        public function getProductName() {
                return $this->product->product_name;
        }

}
