<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * This assest register scripts required for event calendar(http://fullcalendar.io)
 */
class CalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'extensions/fullcalendar/fullcalendar.css',
		//'extensions/fullcalendar/fullcalendar.print.css',
    ];

    public $js = [
		'extensions/fullcalendar/lib/moment.min.js',
		'extensions/fullcalendar/fullcalendar.min.js',
    ];
	
	public $depends = [
        'app\assets\AppAsset',        
    ];
	
	public static function registerCss($view)
	{
		$manager = $view->getAssetManager();
		$view->registerCssFile($manager->getAssetUrl($this, 'extensions/fullcalendar/fullcalendar.print.css'), ['media' => 'print']);
	}
}
