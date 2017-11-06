<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "features".
 *
 * @property int $id
 * @property string $filter_tittle
 * @property string $table_name
 * @property string $model_name
 * @property string $tablevalue__name
 * @property string $table_value_id
 * @property int $category
 * @property string $comments
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Features extends \yii\db\ActiveRecord {

        /**
         * @inheritdoc
         */
        public static function tableName() {
                return 'features';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['filter_tittle', 'CB', 'UB'], 'required'],
                        [['category', 'status', 'CB', 'UB'], 'integer'],
                        [['comments'], 'string'],
                        [['DOC', 'DOU'], 'safe'],
                        [['filter_tittle', 'filter_tittle_arabic'], 'string', 'max' => 500],
                        [['table_name', 'model_name', 'tablevalue__name', 'table_value_id'], 'string', 'max' => 100],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'filter_tittle' => 'Filter Tittle',
                    'filter_tittle_arabic' => 'Filter Tittle Arabic',
                    'table_name' => 'Table Name',
                    'model_name' => 'Model Name',
                    'tablevalue__name' => 'Tablevalue  Name',
                    'table_value_id' => 'Table Value ID',
                    'category' => 'Category',
                    'comments' => 'Comments',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
