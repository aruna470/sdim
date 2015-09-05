<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SampleForm extends Model
{
    public $lastName;
    public $firstName;
    public $dateOfBirth;
    public $middleName;
    public $age;
	public $maritalStatus;
	
	public $unitNo;
	public $streetNo;
	public $streetName;
	public $suburb;
	public $postCode;
	public $state;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }
}
