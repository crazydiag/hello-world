<?php

$start=$_GET['start'];
$end=$_GET['end'];
$ip=$_GET['ip'];
$title=$_GET['title'];
$name=$_GET['name'];
$type=$_GET['type'];

$rrdcmd="rrdtool graph - ";
$rrdcmd.="-s \"$start\" -e \"$end\" ";
$rrdcmd.="-a PNG --width 500 --height 80 --title $title -l 0 --slope-mode ";

$rrdcmd.="DEF:inb=/var/www/stats/rrd/$ip.net-$name.rxb.rrd:val:$type ";
$rrdcmd.="DEF:outb=/var/www/stats/rrd/$ip.net-$name.txb.rrd:val:$type ";

$rrdcmd.="CDEF:in=inb,8,* ";
$rrdcmd.="CDEF:out=outb,8,* ";

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

