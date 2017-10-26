<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "street".
 *
 * @property int $id
 * @property int $country_id
 * @property int $city_id
 * @property string $street_name
 * @property string $street_name_arabic
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property City $city
 * @property Country $country
 */
class Street extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'street';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['country_id', 'city_id', 'status', 'CB', 'UB'], 'integer'],
            [['city_id', 'street_name', 'street_name_arabic'], 'required'],
            [['DOC', 'DOU'], 'safe'],
            [['street_name', 'street_name_arabic'], 'string', 'max' => 100],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'country_id' => 'Country',
            'city_id' => 'City',
            'street_name' => 'Street Name',
            'street_name_arabic' => 'Street Name Arabic',
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
    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * Get main street list
     */
    public function getStreetList($city_id) {
        $data = Street::find()->where(['city_id' => $city_id])
                        ->select(['id', 'street_name AS name'])->asArray()->all();
        return $data;
    }

}
