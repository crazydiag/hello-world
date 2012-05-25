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

$rrdcmd.="DEF:read=/var/www/stats/rrd/$ip.io-$name.readsec.rrd:val:$type ";
$rrdcmd.="DEF:write=/var/www/stats/rrd/$ip.io-$name.writesec.rrd:val:$type ";

$rrdcmd.="AREA:read#00FF00:readsec ";
$rrdcmd.="GPRINT:read:LAST:%.2lf\\\\n ";
$rrdcmd.="LINE2:write#FF0000:writesec ";
$rrdcmd.="GPRINT:write:LAST:%.2lf\\\\n ";

$rrdcmd=preg_replace("/['`|;\n]/","",$rrdcmd) ;

header('Cache-Control: max-age=40');
header('Pragma: privade'); 
header('Content-type: image/png');
passthru("LANG=ru_RU.UTF-8 " .$rrdcmd);

?>

