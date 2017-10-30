<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property int $country_id
 * @property int $city_id
 * @property int $street_id
 * @property string $address
 * @property string $landmark
 * @property int $default_address
 * @property int $pincode
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property City $city
 * @property Country $country
 * @property Street $street
 * @property User $user
 */
class UserAddress extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'country_id', 'city_id', 'street_id', 'default_address', 'pincode', 'status', 'CB', 'UB'], 'integer'],
            [['address', 'landmark'], 'string'],
            [['CB', 'UB'], 'required'],
            [['DOC', 'DOU'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['street_id'], 'exist', 'skipOnError' => true, 'targetClass' => Street::className(), 'targetAttribute' => ['street_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'country_id' => 'Country',
            'city_id' => 'City',
            'street_id' => 'Street',
            'address' => 'Address',
            'landmark' => 'Landmark',
            'default_address' => 'Default Address',
            'pincode' => 'Pincode',
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
     * @return \yii\db\ActiveQuery
     */
    public function getStreet() {
        return $this->hasOne(Street::className(), ['id' => 'street_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
