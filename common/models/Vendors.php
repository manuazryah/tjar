<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vendors".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $address
 * @property string $city
 * @property integer $post_code
 * @property string $phone_number
 * @property string $mobile_number
 * @property string $email
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 */
class Vendors extends ActiveRecord implements IdentityInterface {

        /**
         * @inheritdoc
         */
        private $_user;
        public $rememberMe = true;
        public $created_at;
        public $updated_at;
        public $confirm_pasword;

        public static function tableName() {
                return 'vendors';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['post_code', 'status', 'CB', 'UB'], 'integer'],
                        [['DOC', 'DOU'], 'safe'],
                        [['name'], 'string', 'max' => 280],
                        [['username', 'password', 'address', 'city', 'phone_number', 'mobile_number', 'email'], 'string', 'max' => 255],
                        [['bank_account_details'], 'string'],
                        [['email'], 'email'],
                        [['username', 'password'], 'required', 'on' => 'login'],
                        [['password'], 'validatePassword', 'on' => 'login'],
                ];
        }

        public function validatePassword($attribute, $params) {

                if (!$this->hasErrors()) {

                        $user = $this->getUser();
                        if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
                                $this->addError($attribute, 'Incorrect username or password.');
                        }
                }
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'name' => 'Name',
                    'username' => 'Username',
                    'password' => 'Password',
                    'address' => 'Address',
                    'city' => 'City',
                    'post_code' => 'Post Code',
                    'phone_number' => 'Phone Number',
                    'mobile_number' => 'Alternate Number',
                    'email' => 'Email',
                    'bank_account_details' => 'Account Details',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

        public function login() {

                if ($this->validate()) {
                        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
                } else {
                        return false;
                }
        }

        protected function getUser() {
                if ($this->_user === null) {

                        $this->_user = static::find()->where('username = :uname and status = :stat', ['uname' => $this->username, 'stat' => '1'])->one();
                }

                return $this->_user;
        }

        public function validatedata($data) {
                if ($data == '') {
                        $this->addError('password', 'Incorrect username or password');
                        return true;
                }
        }

        /**
         * Finds user by username
         *
         * @param string $username
         * @return static|null
         */
        public static function findByUsername($username) {
                return static::findOne(['username' => $username, 'status' => 1]);
        }

        /**
         * @inheritdoc
         */
        public static function findIdentity($id) {
                return static::findOne(['id' => $id, 'status' => 1]);
        }

        /**
         * @inheritdoc
         */
        public static function findIdentityByAccessToken($token, $type = null) {
                throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }

        public function getId() {
                return $this->getPrimaryKey();
        }

        /**
         * @inheritdoc
         */
        public function getAuthKey() {
                return $this->auth_key;
        }

        /**
         * @inheritdoc
         */
        public function validateAuthKey($authKey) {
                return $this->getAuthKey() === $authKey;
        }

}
