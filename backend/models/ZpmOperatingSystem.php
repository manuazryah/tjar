<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zpm_operating_system".
 *
 * @property int $id
 * @property int $main_category
 * @property int $category
 * @property int $subcategory
 * @property string $operating_system
 * @property string $operating_system_1
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class ZpmOperatingSystem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zpm_operating_system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['main_category', 'category', 'operating_system', 'operating_system_1', 'CB', 'UB'], 'required'],
            [['main_category', 'category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['operating_system', 'operating_system_1'], 'string', 'max' => 250],
            [['field1', 'field2', 'field3'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_category' => 'Main Category',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
            'operating_system' => 'Operating System',
            'operating_system_1' => 'Operating System 1',
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
}
