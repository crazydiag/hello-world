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

$rrdcmd.="DEF:total=/var/www/stats/rrd/$ip.mem.swaptotal.rrd:val:$type ";
$rrdcmd.="DEF:free=/var/www/stats/rrd/$ip.mem.swapfree.rrd:val:$type ";

$rrdcmd.="CDEF:used=total,free,- ";

$rrdcmd.="AREA:used#00FF00:used ";
$rrdcmd.="GPRINT:used:LAST:%.2lf%s\\\\n ";
$rrdcmd.="LINE2:total#FF0000:total ";
$rrdcmd.="GPRINT:total:LAST:%.2lf%s\\\\n ";

$rrdcmd=preg_replace("/['`|;\n]/","",$rrdcmd) ;

header('Cache-Control: max-age=40');
header('Pragma: privade'); 
header('Content-type: image/png');
passthru("LANG=ru_RU.UTF-8 " .$rrdcmd);

?>

