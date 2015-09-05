<?php

use yii\helpers\Html;
use yii\web\View;
use app\assets\CalendarAsset;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->pageTitle = Yii::t('app', 'My Cases');
$this->pageTitleDescription = Yii::t('app', 'Casses assigned to you.');
$this->params['breadcrumbs'][] = Yii::t('app', 'My Cases');
CalendarAsset::register($this);
?>

<?php
$sampleUrl = Yii::$app->urlManager->createUrl(['site/tab-sample']);
$this->registerJs("
$(document).ready(function() {
var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  
  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    editable: true,
    events: [
      {
        title: 'Case 1',
        start: new Date(y, m, d+1, 19, 0),
        end: new Date(y, m, d+1, 22, 30),
        allDay: false,
		url: '{$sampleUrl}'
      },
      {
        title: 'Case 2',
        start: new Date(y, m, 28),
        end: new Date(y, m, 29),
        url: '{$sampleUrl}'
      }
    ]
  });
})
", View::POS_END, 'calendar');
?>

<div style="margin-top:25px" id='calendar'></div>