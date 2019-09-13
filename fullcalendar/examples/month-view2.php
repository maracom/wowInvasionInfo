<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<title>격전의 아제로스 습격 시간표</title>
<link href='../packages/core/main.css' rel='stylesheet' />
<link href='../packages/daygrid/main.css' rel='stylesheet' />
<script src='../packages/core/main.js'></script>
<script src='../packages/interaction/main.js'></script>
<script src='../packages/daygrid/main.js'></script>
<?php
/*
순서:
1. 드러스트바 -> 2. 줄다자르 -> 3. 티라가드 -> 4. 나즈미르 -> 5. 스톰송 -> 6. 볼둔
지속시간: 7시간
쿨타임: 12시간
*/
//기본 로테이션 Array
$location = array(
	1 => "드러스트바",
	2 => "줄다자르",
	3 => "티라가드",
	4 => "나즈미르",
	5 => "스톰송",
	6 => "볼둔",
	);
// 기준 시작시간
$seedDateTimeStr = "2019-01-01 17:00:00";
$seedIndex = 1;
$termHours = "7 hours";
$coolTimeHours = $termHours + 12 . " hours";
$currYear = date('Y',strtotime($seedDateTimeStr));
$currMonth = date('m',strtotime($seedDateTimeStr));
$nowYear = date('Y');
$nowMonth = date('m');
$nowDay = date('d');
$week = array("일","월","화","수","목","금","토");
echo "<h1>&quot;격전의 아제로스&quot; &lt;습격&gt; 시간표</h1>";
echo "<h4>7시간 지속, 12시간 후 팝업</h4>";
echo "<h5>1. 드러스트바 -> 2. 줄다자르 -> 3. 티라가드 -> 4. 나즈미르 -> 5. 스톰송 -> 6. 볼둔</h5>";
// 1000 건 루프
for($i = 0; $i < 1000; $i++) {
	if(empty($startDateTime)) {
		$startDateTime = new DateTime($seedDateTimeStr, timezone_open("Asia/Seoul"));
		$endDateTime = new DateTime($seedDateTimeStr, timezone_open("Asia/Seoul"));
		$nextSeedTime = new DateTime($seedDateTimeStr, timezone_open("Asia/Seoul"));
	} else {
		$startDateTime = new DateTime($nextSeedDateTimeStr, timezone_open("Asia/Seoul"));
		$endDateTime = new DateTime($nextSeedDateTimeStr, timezone_open("Asia/Seoul"));
		$nextSeedTime = new DateTime($nextSeedDateTimeStr, timezone_open("Asia/Seoul"));
	}
	if($beforeYear . $beforeMonth != $currYear . $currMonth){
		if($nowYear . $nowMonth != $currYear . $currMonth){
			//echo sprintf("<br /><b>[[ %s년 %s월 ]]</b><br />", $currYear, $currMonth);
		} else {
			//echo sprintf("<br /><b><font style='color:#CD2714'>[[ %s년 %s월 ]]</font></b><br />", $currYear, $currMonth);
		}
	}
	$beforeYear = date('Y',strtotime(date_format($startDateTime, "Y-m-d H:i:s")));
	$beforeMonth = date('m',strtotime(date_format($startDateTime, "Y-m-d H:i:s")));
	$beforeDay = date('d',strtotime(date_format($startDateTime, "Y-m-d H:i:s")));
	$endDateTime->modify("+{$termHours}");
	$startWeek = $week[date('w',strtotime(date_format($startDateTime, "Y-m-d H:i:s")))];
	$endWeek = $week[date('w',strtotime(date_format($endDateTime, "Y-m-d H:i:s")))];
	if($beforeYear . $beforeMonth . $beforeDay != $nowYear . $nowMonth . $nowDay){
		//echo sprintf("%s(%s) ~ %s(%s) [%s]<br />", date_format($startDateTime, "Y-m-d H:i:s"), $startWeek, date_format($endDateTime, "Y-m-d H:i:s"), $endWeek, $location[$seedIndex]);
	} else {
		//echo sprintf("<b><font style='color:#CD2714'>%s(%s) ~ %s(%s) [%s]</font></b><br />", date_format($startDateTime, "Y-m-d H:i:s"), $startWeek, date_format($endDateTime, "Y-m-d H:i:s"), $endWeek, $location[$seedIndex]);
	}
	$calendar_print .= "        {
          title: '".$location[$seedIndex]."',
          start: '".date_format($startDateTime, "Y-m-d")."',
          end: '".date_format($endDateTime, "Y-m-d")."'
        },";

	$seedIndex++;
	if($seedIndex > count($location)) {
		$seedIndex = 1;
	}
	$nextSeedTime->modify("+{$coolTimeHours}");
	$nextSeedDateTimeStr = date_format($nextSeedTime, "Y-m-d H:i:s");
	$currYear = date('Y',strtotime($nextSeedDateTimeStr));
	$currMonth = date('m',strtotime($nextSeedDateTimeStr));
}
?>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid' ],
      defaultDate: '2019-08-12',
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: [
		  <?php
		  echo $calendar_print;
		  ?>
		  /*
        {
          title: 'Long Event',
          start: '2019-08-07',
          end: '2019-08-10'
        },
		*/
      ]
    });

    calendar.render();
  });

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>
