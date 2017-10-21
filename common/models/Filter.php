<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "filter".
 *
 * @property int $id
 * @property int $category
 * @property int $subcategory
 * @property string $filters
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property ProductCategory $category0
 * @property ProductSubCategory $subcategory0
 */
class Filter extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'filter';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category', 'filters', 'CB', 'UB'], 'required'],
            [['category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU', 'filters'], 'safe'],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['category' => 'id']],
            [['subcategory'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSubCategory::className(), 'targetAttribute' => ['subcategory' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'subcategory' => 'Subcategory',
            'filters' => 'Filters',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0() {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory0() {
        return $this->hasOne(ProductSubCategory::className(), ['id' => 'subcategory']);
    }

    public static function getFilters($id) {

        $filters = explode(',', $id);
        $result = '';
        $i = 0;
        if (!empty($filters)) {
            foreach ($filters as $val) {

                if ($i != 0) {
                    $result .= ',';
                }
                $filter_data = MasterFilterSpec::findOne($val);
                $result .= $filter_data->filter_tittle;
                $i++;
            }
        }

        return $result;
    }

}
