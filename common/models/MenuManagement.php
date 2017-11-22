<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu_management".
 *
 * @property int $id
 * @property int $type 1->Main,2->Sub,3->child
 * @property int $main_menu_id
 * @property string $main_menu
 * @property string $main_menu_arabic
 * @property int $sub_menu_id
 * @property string $sub_menu
 * @property string $sub_menu_arabic
 * @property string $sub_menu_link
 * @property string $child_menu
 * @property string $child_menu_arabic
 * @property string $child_menu_link
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class MenuManagement extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'menu_management';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type'], 'required'],
            [['type', 'main_menu_id', 'sub_menu_id', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['main_menu', 'main_menu_arabic', 'sub_menu', 'sub_menu_arabic', 'child_menu', 'child_menu_arabic'], 'string', 'max' => 500],
            [['sub_menu_link', 'child_menu_link'], 'string', 'max' => 1000],
            [['main_menu', 'main_menu_arabic'], 'required', 'when' => function ($model) {
                    return $model->type == 1;
                }, 'whenClient' => "function (attribute, value) { return $('#id').val() == '0'; }"],
            [['main_menu_id', 'sub_menu', 'sub_menu_arabic', 'sub_menu_link'], 'required', 'when' => function ($model) {
                    return $model->type == 2;
                }, 'whenClient' => "function (attribute, value) { return $('#id').val() == '0'; }"],
            [['main_menu_id', 'sub_menu_id', 'child_menu', 'child_menu_arabic', 'child_menu_link'], 'required', 'when' => function ($model) {
                    return $model->type == 3;
                }, 'whenClient' => "function (attribute, value) { return $('#id').val() == '0'; }"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'main_menu_id' => 'Main Menu',
            'main_menu' => 'Main Menu',
            'main_menu_arabic' => 'Main Menu Arabic',
            'sub_menu_id' => 'Sub Menu',
            'sub_menu' => 'Sub Menu',
            'sub_menu_arabic' => 'Sub Menu Arabic',
            'sub_menu_link' => 'Sub Menu Link',
            'child_menu' => 'Child Menu',
            'child_menu_arabic' => 'Child Menu Arabic',
            'child_menu_link' => 'Child Menu Link',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
