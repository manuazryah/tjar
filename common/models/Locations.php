<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $first_name
 * @property string $last_name
 * @property int $country
 * @property int $city
 * @property int $street
 * @property string $building_no
 * @property int $mobile_no
 * @property int $landline
 * @property string $postbox_no
 * @property int $dafault_address
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Vendors $vendor
 */
class Locations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'locations';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['vendor_id', 'country', 'city', 'street', 'mobile_no', 'landline', 'dafault_address', 'status', 'CB', 'UB'], 'integer'],
            [['city', 'mobile_no', 'street', 'building_no'], 'required'],
            [['DOC', 'DOU'], 'safe'],
            [['first_name', 'last_name', 'postbox_no'], 'string', 'max' => 100],
            [['building_no'], 'string', 'max' => 300],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendors::className(), 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'vendor_id' => 'Vendor ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'country' => 'Country',
            'city' => 'City',
            'street' => 'Street',
            'building_no' => 'Building No',
            'mobile_no' => 'Mobile No',
            'landline' => 'Landline',
            'postbox_no' => 'Postbox No',
            'dafault_address' => 'Set as Primary',
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
    public function getVendor() {
        return $this->hasOne(Vendors::className(), ['id' => 'vendor_id']);
    }

}
