<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "RolePermission".
 *
 * @property string $roleName
 * @property string $permissionName
 */
class RolePermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'RolePermission';
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
            [['roleName', 'permissionName'], 'required'],
            [['roleName', 'permissionName'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roleName' => 'Role Name',
            'permissionName' => 'Permission Name',
        ];
    }
}
