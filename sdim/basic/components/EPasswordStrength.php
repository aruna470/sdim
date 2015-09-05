<?php
namespace app\components;
use Yii;
/**
 *
 * EPasswordStrength class
 *
 * Validate if password is strong enought
 *
 * The validator check if password has at least min characters,
 * and if password contain at least one lower case letter, at least one upper case letter,
 * and at least one number
 *
 *
 *
 *
 * @see      http://www.yiiframework.com
 * @version  1.0
 * @access   public
 * @author   ivica Nedeljkovic (ivica.nedeljkovic@gmail.com)
 */
class EPasswordStrength extends Validator {

	// Minimum password length
	public $min = 7;
	// Allow password empty
	public $allowEmpty = true;

	/**
	 * (non-PHPdoc)
	 * @see CValidator::validateAttribute()
	 */
	protected function validateAttribute($object, $attribute) {
		if (!$this->checkPasswordStrength($object->$attribute)) {
			$message = $this->message !== null ? $this->message : Yii::t("app", "{attribute} is weak. {attribute} must contain at least {min} characters, at least one letter, at least one number and at least one symbol(-@_#&.).", array('{min}'=>$this->min));
			$this->addError($object, $attribute, $message);
		}
	}

	/**
	 * Check if password is strong enought
	 * @param string $password
	 * @return boolean
	 */
	protected function checkPasswordStrength($password) {
		if ($this->allowEmpty && '' == $password) {
			return true;
		} else {
			if (preg_match("/^.*(?=.{".$this->min.",})(?=.*\d)(?=.*[a-zA-Z])(?=.*[-@_#&.]).*$/", $password)) {
				return true;
			} else {
				return false;
			}
		}
	}

}
