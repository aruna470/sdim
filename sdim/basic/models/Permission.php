<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Permission".
 *
 * @property string $name
 * @property string $description
 * @property string $category
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Permission';
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
            [['name', 'description', 'category'], 'required'],
			[['name'], 'match', 'pattern'=>'/^[a-zA-Z][A-Za-z0-9_.]*$/'],
            [['name', 'category'], 'string', 'max' => 25],
            [['description'], 'string', 'max' => 64]
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
            'category' => 'Category',
        ];
    }
}
