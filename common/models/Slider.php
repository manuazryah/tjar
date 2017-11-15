<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string $slider_image
 * @property string $slider_image_arabic
 * @property string $main_tittle
 * @property string $sub_tittle
 * @property string $slider_link
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Slider extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['status', 'CB', 'UB'], 'integer'],
            [['slider_image', 'slider_image_arabic', 'main_tittle', 'canonical_name'], 'required', 'on' => 'create'],
            [['DOC', 'DOU', 'canonical_name'], 'safe'],
            [['slider_image'], 'string', 'max' => 50],
            [['main_tittle', 'slider_link'], 'string', 'max' => 500],
            [['slider_image', 'slider_image_arabic'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'slider_image' => 'Slider Image',
            'slider_image_arabic' => 'Slider Image Arabic',
            'main_tittle' => 'Tittle',
            'canonical_name' => 'Canonical Name',
            'slider_link' => 'Slider Link',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
