<?php

namespace app\models;

use Yii;

/**
 * This is the model class for "User".
 *
 * @property mixed $id
 * @property mixed $firstName
 * @property mixed $lastName
 * @property mixed $username
 * @property mixed $password
 * @property mixed $role
 */
class User extends \yii\db\ActiveRecord
{	
	// User statuses
	const ACTIVE = 1;
	const INACTIVE = 2;
	
	public $confPassword;
	public $captcha;
	public $oldPassword;
	public $newPassword;
	public $curOldPassword;

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }
	
	public function behaviors()
    {
        return [
            'sammaye\audittrail\LoggableBehavior'
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName', 'email', 'lastName', 'password', 'role', 
			  'confPassword', 'captcha', 'oldPassword', 'newPassword'], 'safe'],
			
			// Common
			[['email'], 'email'],
			[['email', 'username'], 'unique'],
			
			// System user create
			[['firstName', 'email', 'password', 'confPassword', 'role', 'timeZone', 'username'], 'required', 'on' => 'create'],
			[['password'], 'checkPasswordStrength', 'on' => 'create', 'params' => ['min' => 7, 'allowEmpty' => false]],
			[['confPassword'], 'compare', 'on' => 'create', 'compareAttribute' => 'password', 'operator' => '=='],
			
			// System user update
			[['firstName', 'email', 'role', 'timeZone', 'username'], 'required', 'on' => 'update'],
			[['password'], 'checkPasswordStrength', 'on' => 'update', 'params' => ['min' => 7, 'allowEmpty' => true]],
			[['confPassword'], 'compare', 'on' => 'update', 'compareAttribute' => 'password', 'operator' => '=='],
			
			// My Account
			[['firstName', 'lastName', 'email', 'companyName', 'companyAddress', 'contactNumber', 
			  'role', 'timeZone', 'username'], 'required', 'on' => 'myAccount'],
			[['firstName', 'email', 'contactNumber', 'role', 'timeZone'], 'required', 'on' => 'myAccountSysUser'],
			
			// Change Password
			[['oldPassword', 'newPassword', 'confPassword'], 'required', 'on' => 'changePassword'],
			[['oldPassword'], 'compare', 'compareValue' => $this->curOldPassword, 'operator' => '==', 'type' => 'string', 'on' => 'changePassword'],
			[['newPassword'], 'checkPasswordStrength', 'on' => 'changePassword', 'params' => ['min' => 7, 'allowEmpty' => false]],
			[['confPassword'], 'compare', 'compareAttribute' => 'newPassword', 'operator' => '==', 'type' => 'string', 'on' => 'changePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstName' => Yii::t('app', 'First Name'),
            'lastName' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
			'confPassword' => Yii::t('app', 'Confirm Password'),
			'oldPassword' => Yii::t('app', 'Old Password'),
			'newPassword' => Yii::t('app', 'New Password'),
			'role' => Yii::t('app', 'Role'),
        ];
    }
	
	/**
     * Encrypt password
	 * @return string crypt encrypted password.
     */
	public function encryptPassword($password = '')
	{
		$pw = $password == '' ? $this->password : $password;
		return crypt($pw, Yii::$app->params['salt']);
	}
	
	
	/**
     * Check password strength
	 * @param string $attribute Attribute name
	 * @params array $params Extra prameters to be passed to validation function
     */
	public function checkPasswordStrength($attribute, $params) 
	{
		if ($params['allowEmpty'] && '' == $this->$attribute) {
			return true;
		} else {
			if (preg_match("/^.*(?=.{" . $params['min'] . ",})(?=.*\d)(?=.*[a-zA-Z])(?=.*[-@_#&.]).*$/", $this->$attribute)) {
				return true;
			} else {
				$this->addError($attribute, Yii::t("app", "{attribute} is weak. {attribute} must contain at least {min} characters, at least one letter, at least one number and at least one symbol(-@_#&.).", ['min' => $params['min'], 'attribute' => $attribute]));
			}
		}
	}
	
   /**
	* Generate new password for reset, according to password plicy
	* @return string $password Random password. ex:abcd123.@
	*/
	public function getNewPassword()
	{
		$letters = 'bcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';
		$numbers = '0123456789';
		$symbols = '-@_#&.';
	
		$password  = substr(str_shuffle($letters),0,4);
		$password .= substr(str_shuffle($numbers),0,2);
		$password .= substr(str_shuffle($symbols),0,2);
	
		return $password;
	}
	
   /**
	* Get any of user attribute by its id
	* @parm string $attribute Attribute name
	*/
	public function getAttributeValueById($id, $attribute)
	{
		$model = User::findOne($id);
		if (!empty($model))
			return $model->$attribute;
		else
			return '';
	}
}
