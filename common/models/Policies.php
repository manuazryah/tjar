<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "policies".
 *
 * @property int $id
 * @property string $return_policy
 * @property string $terms_of_use
 * @property string $security
 * @property string $privacy
 * @property string $infringement
 * @property string $faq
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Policies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'policies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['return_policy', 'terms_of_use', 'security', 'privacy', 'infringement', 'faq'], 'string'],
            [['status', 'CB', 'UB'], 'integer'],
            [['CB', 'UB'], 'required'],
            [['DOC', 'DOU'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'return_policy' => 'Return Policy',
            'terms_of_use' => 'Terms Of Use',
            'security' => 'Security',
            'privacy' => 'Privacy',
            'infringement' => 'Infringement',
            'faq' => 'Faq',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
