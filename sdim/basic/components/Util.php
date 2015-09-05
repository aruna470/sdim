<?php

namespace app\components;

use Yii;
use yii\base\Component;
use \DateTime;
use \DateTimeZone;

class Util extends Component
{
	/**
     * Retrieve UTC date time
	 * @param string $format Date Time format
	 * @return string UTC date time
     */
	public function getUtcDateTime($dateTime = null, $sourceTz = null, $format = "Y-m-d H:i:s")
	{
		if (null != $dateTime) {
			$date = new DateTime($dateTime, new DateTimeZone($sourceTz));
			$date->setTimezone(new DateTimeZone('UTC'));
			return $date->format($format);
		} else {
			return gmdate("Y-m-d H:i:s");
		}
	}
	
	/**
     * Retrieve UTC date
	 * @param string $format Date Time format
	 * @return string UTC date
     */
	public function getUtcDate($format = 'Y-m-d')
	{
		return gmdate($format);
	}
	
	/**
     * Convert specific date time to another date time based on Timezone
	 * @param string $dateTime Stored datetime
	 * @param string $destinationTz Date time will be converted to this timezone
	 * @param string $sourceTz Currently date time stored timezone
	 * @param string $format Date Time format 
	 * @return string converted date time
     */
	public function getLocalDateTime($dateTime, $destinationTz, $sourceTz = 'UTC', $format = "Y-m-d H:i:s")
	{
		if ('' != $dateTime) {
			$date = new DateTime($dateTime, new DateTimeZone($sourceTz));
			$date->setTimezone(new DateTimeZone($destinationTz));
			return $date->format($format);
		}
		
		return '';
	}
	
	/**
     * Returns available timezone list
     */
	public function getTimeZoneList()
	{
		$tz = timezone_identifiers_list();
		
		return array_combine($tz, $tz);
	}
	
	/**
     * Prepare bootstrap lable segments to be diaplayed
	 * @param string $type Label type
	 * @param string $text Lable text
     */
	public function getBootLabel($type, $text)
	{
		return "<span class='label label-{$type}'>{$text}</span>";
	}
	
	/**
     * Restart streaming process when new keyword get added.
     */
	public function restartStreamingService()
	{
		$pid = Yii::$app->cache->get('STREAM_PID');
		
		if ($pid != '') {
			$command = "kill -9 {$pid}";
			exec($command, $output);
			Yii::$app->appLog->writeLog("Killing streaming process.", ['output' => $output, 'pid' => $pid]);
		}
		
		$command =  "php " . Yii::$app->params['consoleCmdPath'] . " stream/stream";
		$pid = shell_exec(sprintf('%s > /dev/null 2>&1 & echo $!', $command));
		$pid = str_replace("\n", '', $pid);
		
		Yii::$app->cache->set('STREAM_PID', $pid, 0);
		Yii::$app->appLog->writeLog("Streaming process started.", ['pid' => $pid]);
	}
	
	/**
	 * Handle popup window close.
	 * @param string $parentRedirectUrl Parent page redirect URL on popup close
	 * @param boolean $parentRefresh Whether to refresh parent page on popup close
	 */
	public function closePopupWindow($parentRedirectUrl = null, $parentRefresh = false)
	{
		if ($parentRefresh) {
			$script = "window.opener.location.reload();window.close();";
		} else if (null == $parentRedirectUrl && !$parentRefresh) {
			$script = "window.close();";
		} else {
			$script = "window.opener.location.href = '{$parentRedirectUrl}';window.close();";
		}
		//echo $script;
		echo "<script>{$script}</script>";
	}
}

?>