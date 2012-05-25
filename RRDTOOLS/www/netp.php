<?php

$start=$_GET['start'];
$end=$_GET['end'];
$ip=$_GET['ip'];
$title=$_GET['title'];
$name=$_GET['name'];
$type=$_GET['type'];

$rrdcmd="rrdtool graph - ";
$rrdcmd.="-s $start -e $end ";
$rrdcmd.="-a PNG --width 500 --height 80 --title $title -l 0 --slope-mode ";

$rrdcmd.="DEF:in=/var/www/stats/rrd/$ip.net-$name.rx.rrd:val:$type ";
$rrdcmd.="DEF:out=/var/www/stats/rrd/$ip.net-$name.tx.rrd:val:$type ";

$rrdcmd.="AREA:in#00FF00:in ";
$rrdcmd.="GPRINT:in:LAST:%.2lf%s\\\\n ";
$rrdcmd.="LINE2:out#FF0000:out ";
$rrdcmd.="GPRINT:out:LAST:%.2lf%s\\\\n ";

$rrdcmd=preg_replace("/['`|;\n]/","",$rrdcmd) ;

header('Cache-Control: max-age=40');
header('Pragma: privade'); 
header('Content-type: image/png');
passthru("LANG=ru_RU.UTF-8 " .$rrdcmd);

?>

