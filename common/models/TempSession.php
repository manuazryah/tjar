<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "temp_session".
 *
 * @property int $id
 * @property string $session_id
 * @property int $user_id
 * @property int $type_id 1=Shipping Address,2=Billing Address,3=Coupon Code
 * @property string $value
 */
class TempSession extends \yii\db\ActiveRecord {

        /**
         * @inheritdoc
         */
        public static function tableName() {
                return 'temp_session';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['user_id', 'type_id'], 'integer'],
                        [['session_id'], 'string', 'max' => 255],
                        [['value'], 'safe'],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'session_id' => 'Session ID',
                    'user_id' => 'User ID',
                    'type_id' => 'Type ID',
                    'value' => 'Value',
                ];
        }

}
