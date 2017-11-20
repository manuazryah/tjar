<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $reference_id
 * @property int $history_type
 * @property int $product_id
 * @property string $content
 * @property string $date
 * @property int $CB
 *
 * @property MasterHistoryType $historyType
 * @property NotificationViewStatus[] $notificationViewStatuses
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference_id', 'history_type', 'product_id', 'CB'], 'integer'],
            [['content'], 'string'],
            [['date'], 'safe'],
            [['history_type'], 'exist', 'skipOnError' => true, 'targetClass' => MasterHistoryType::className(), 'targetAttribute' => ['history_type' => 'id']],
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
            'history_type' => 'History Type',
            'product_id' => 'Product ID',
            'content' => 'Content',
            'date' => 'Date',
            'CB' => 'Cb',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryType()
    {
        return $this->hasOne(MasterHistoryType::className(), ['id' => 'history_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationViewStatuses()
    {
        return $this->hasMany(NotificationViewStatus::className(), ['history_id' => 'id']);
    }
}
