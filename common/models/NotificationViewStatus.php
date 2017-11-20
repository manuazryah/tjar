<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification_view_status".
 *
 * @property int $id
 * @property int $reference_id
 * @property int $history_id
 * @property int $user_type 1->Admin,2->Vendor,3->User
 * @property int $user_id
 * @property string $content
 * @property int $view_status 1->seen,0->unseen
 * @property string $date
 *
 * @property History $history
 */
class NotificationViewStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_view_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference_id', 'history_id', 'user_type', 'user_id', 'view_status'], 'integer'],
            [['content'], 'string'],
            [['date'], 'safe'],
            [['history_id'], 'exist', 'skipOnError' => true, 'targetClass' => History::className(), 'targetAttribute' => ['history_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference_id' => 'Reference ID',
            'history_id' => 'History ID',
            'user_type' => 'User Type',
            'user_id' => 'User ID',
            'content' => 'Content',
            'view_status' => 'View Status',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistory()
    {
        return $this->hasOne(History::className(), ['id' => 'history_id']);
    }
}
