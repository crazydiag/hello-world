<?php

$start=$_GET['start'];
$end=$_GET['end'];
$ip=$_GET['ip'];
$title=$_GET['title'];
$type=$_GET['type'];

$rrdcmd="rrdtool graph - ";
$rrdcmd.="-s $start -e $end ";
$rrdcmd.="-a PNG --width 500 --height 80 --title $title -l 0 --slope-mode ";

$rrdcmd.="DEF:idle=/var/www/stats/rrd/$ip.cpu.idle.rrd:val:$type ";
$rrdcmd.="DEF:irq=/var/www/stats/rrd/$ip.cpu.irq.rrd:val:$type ";
$rrdcmd.="DEF:nice=/var/www/stats/rrd/$ip.cpu.nice.rrd:val:$type ";
$rrdcmd.="DEF:softirq=/var/www/stats/rrd/$ip.cpu.softirq.rrd:val:$type ";
$rrdcmd.="DEF:sys=/var/www/stats/rrd/$ip.cpu.sys.rrd:val:$type ";
$rrdcmd.="DEF:user=/var/www/stats/rrd/$ip.cpu.user.rrd:val:$type ";
$rrdcmd.="DEF:wait=/var/www/stats/rrd/$ip.cpu.wait.rrd:val:$type ";

$rrdcmd.="AREA:irq#FFAAAA:irq ";
$rrdcmd.="GPRINT:irq:LAST:%.2lf\\\\n ";

$rrdcmd.="AREA:softirq#FFAAFF:softirq:STACK ";
$rrdcmd.="GPRINT:softirq:LAST:%.2lf\\\\n ";

$rrdcmd.="AREA:user#00FF00:user:STACK ";
$rrdcmd.="GPRINT:user:LAST:%.2lf\\\\n ";

$rrdcmd.="AREA:nice#0000FF:nice:STACK ";
$rrdcmd.="GPRINT:nice:LAST:%.2lf\\\\n ";

$rrdcmd.="AREA:sys#00FFFF:sys:STACK ";
$rrdcmd.="GPRINT:sys:LAST:%.2lf\\\\n ";

$rrdcmd.="AREA:wait#FF0000:wait:STACK ";
$rrdcmd.="GPRINT:wait:LAST:%.2lf\\\\n ";

$rrdcmd.="AREA:idle#FFFFAA:idle:STACK ";
$rrdcmd.="GPRINT:idle:LAST:%.2lf\\\\n ";

$rrdcmd=preg_replace("/['`|;\n]/","",$rrdcmd) ;

header('Cache-Control: max-age=40');
header('Pragma: privade'); 
header('Content-type: image/png');
passthru("LANG=ru_RU.UTF-8 " .$rrdcmd);

?>

