<?php
namespace app\components;

use Yii;
use app\models\RolePermission;

class WebUser extends \yii\web\User
{
	public function can($permissionName, $params = [], $allowCaching = true)
	{
		if (Yii::$app->user->identity->isSuperadmin) {
			return true;
		}
	
		try {
			$rp = RolePermission::findOne(['roleName' => Yii::$app->user->identity->role, 'permissionName' => $permissionName]);
			if ($rp) {
				return true;
			}
		} catch (Exception $e){}
		
		return false;
	}
	
	public function canList($permissionNames, $params = [], $allowCaching = true)
	{
		foreach ($permissionNames as $permission) {
			if ($this->can($permission)) {
				return true;
			}
		}
		
		return false;
	}
}
?>