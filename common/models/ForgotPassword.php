<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "forgot_password".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $type
 * @property string $date_time
 */
class ForgotPassword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forgot_password';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'integer'],
            [['date_time'], 'safe'],
            [['token'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'type' => 'Type',
            'date_time' => 'Date Time',
        ];
    }
}
