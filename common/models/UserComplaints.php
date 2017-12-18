<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_complaints".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $vendor_id
 * @property string $product_name
 * @property int $status
 * @property int $complaint
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class UserComplaints extends \yii\db\ActiveRecord {

        /**
         * @inheritdoc
         */
        public static function tableName() {
                return 'user_complaints';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['user_id', 'product_id', 'vendor_id', 'status', 'CB', 'UB', 'complaint_type'], 'integer'],
                        [['user_id', 'product_id', 'vendor_id', 'complaint'], 'required'],
                        [['DOC', 'DOU', 'complaint'], 'safe'],
                        [['product_name'], 'string', 'max' => 500],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'user_id' => 'User ID',
                    'product_id' => 'Product ID',
                    'vendor_id' => 'Vendor ID',
                    'product_name' => 'Product Name',
                    'status' => 'Status',
                    'complaint' => 'complaint',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

        public function getUser() {
                return $this->hasOne(User::className(), ['id' => 'user_id']);
        }

        public function getVendor() {
                return $this->hasOne(Vendors::className(), ['id' => 'vendor_id']);
        }

        public function getProduct() {
                return $this->hasOne(ProductVendor::className(), ['id' => 'product_id']);
        }

}
