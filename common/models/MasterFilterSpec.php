<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_filter_spec".
 *
 * @property int $id
 * @property string $filter_tittle
 * @property string $table_name
 * @property string $model_name
 * @property string $tablevalue__name
 * @property string $table_value_id
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class MasterFilterSpec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_filter_spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filter_tittle', 'table_name', 'model_name', 'tablevalue__name', 'table_value_id', 'CB', 'UB'], 'required'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['filter_tittle'], 'string', 'max' => 500],
            [['table_name', 'model_name', 'tablevalue__name', 'table_value_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filter_tittle' => 'Filter Tittle',
            'table_name' => 'Table Name',
            'model_name' => 'Model Name',
            'tablevalue__name' => 'Tablevalue  Name',
            'table_value_id' => 'Table Value ID',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
