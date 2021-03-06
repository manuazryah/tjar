<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_reviews".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $title
 * @property string $description
 * @property string $review_date
 * @property int $status
 *
 * @property ProductVendor $product
 * @property User $user
 */
class CustomerReviews extends \yii\db\ActiveRecord {

        /**
         * @inheritdoc
         */
        public static function tableName() {
                return 'customer_reviews';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['user_id', 'product_id'], 'required'],
                        [['user_id', 'product_id', 'status', 'rating', 'order_id'], 'integer'],
                        [['title', 'description'], 'string'],
                        [['review_date'], 'safe'],
                        [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductVendor::className(), 'targetAttribute' => ['product_id' => 'id']],
                        [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'order_id' => 'Order Id',
                    'user_id' => 'User',
                    'product_id' => 'Product',
                    'title' => 'Title',
                    'description' => 'Description',
                    'review_date' => 'Review Date',
                    'status' => 'Status',
                    'rating' => 'Rating',
                ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProduct() {
                return $this->hasOne(ProductVendor::className(), ['id' => 'product_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getUser() {
                return $this->hasOne(User::className(), ['id' => 'user_id']);
        }

}
