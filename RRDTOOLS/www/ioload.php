<?php

$start=$_GET['start'];
$end=$_GET['end'];
$ip=$_GET['ip'];
$title=$_GET['title'];
$name=$_GET['name'];
$type=$_GET['type'];


$rrdcmd="rrdtool graph - ";
$rrdcmd.="-s $start -e $end ";
$rrdcmd.="-a PNG --width 500 --height 80 --title $title -l 0 --slope-mode -u 100 ";

$rrdcmd.="DEF:load1=/var/www/stats/rrd/$ip.io-$name.iotime.rrd:val:$type ";

$rrdcmd.="CDEF:load=load1,100,/ ";

$rrdcmd.="AREA:load#00FF00:load ";
$rrdcmd.="GPRINT:load:LAST:%.2lf\\\\n ";

$rrdcmd=preg_replace("/['`|;\n]/","",$rrdcmd) ;

header('Cache-Control: max-age=40');
header('Pragma: privade'); 
header('Content-type: image/png');
passthru("LANG=ru_RU.UTF-8 " .$rrdcmd);

?>

