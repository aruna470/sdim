<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Role".
 *
 * @property string $name
 * @property integer $description
 */
class Role extends \yii\db\ActiveRecord
{
	const SUPERADMIN = 'superadmin';
	const ADMINISTRATOR = 'administrator';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Role';
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
            [['name', 'description'], 'required'],
			[['name'], 'match', 'pattern'=>'/^[a-zA-Z][A-Za-z0-9_.]*$/'],
            [['description'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
}
