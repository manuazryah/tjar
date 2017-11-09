<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_post".
 *
 * @property int $id
 * @property string $post_name
 * @property int $admin
 * @property int $product_reviews
 * @property int $order
 * @property int $vendor
 * @property int $users
 * @property int $promotions
 * @property int $masters
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property AdminUsers[] $adminUsers
 */
class AdminPost extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admin_post';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['post_name', 'admin', 'product_reviews', 'order', 'vendor', 'users', 'promotions', 'masters'], 'required'],
            [['admin', 'product_reviews', 'order', 'vendor', 'users', 'promotions', 'masters', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['post_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'post_name' => 'Post Name',
            'admin' => 'Admin',
            'product_reviews' => 'Product & Reviews',
            'order' => 'Order',
            'vendor' => 'Vendor',
            'users' => 'Users',
            'promotions' => 'Promotions',
            'masters' => 'Masters',
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
    public function getAdminUsers() {
        return $this->hasMany(AdminUsers::className(), ['post_id' => 'id']);
    }

}
