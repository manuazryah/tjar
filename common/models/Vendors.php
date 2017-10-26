<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vendors".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
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
        public $old_password;
        public $new_password;
        public $repeat_password;

        public static function tableName() {
                return 'vendors';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['status', 'CB', 'UB'], 'integer'],
                        [['DOC', 'DOU'], 'safe'],
                        [['first_name', 'last_name'], 'string', 'max' => 280],
                        [['username', 'password', 'phone_number', 'mobile_number', 'email'], 'string', 'max' => 255],
                        [['bank_account_details'], 'string'],
                        [['email'], 'email'],
                        [['username', 'password'], 'required', 'on' => 'login'],
                        [['password'], 'validatePassword', 'on' => 'login'],
                        [['email'], 'required', 'on' => 'update-email'],
                        [['phone_number', 'mobile_number'], 'required', 'on' => 'update-contact'],
                        [['old_password', 'new_password', 'repeat_password'], 'required', 'on' => 'change-pwd'],
                        ['repeat_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match", 'on' => 'change-pwd'],
                        [['first_name', 'last_name', 'username', 'password', 'phone_number', 'email'], 'required', 'on' => 'create'],
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
                    'first_name' => 'First Name',
                    'last_name' => 'Last Name',
                    'username' => 'Username',
                    'password' => 'Password',
                    'phone_number' => 'Phone Number',
                    'mobile_number' => 'Mobile Number',
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
