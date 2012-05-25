<?
$list = scandir('rrd/', 1) ;
foreach ($list as $file) {
#	echo "$file</br>" ;
	if (preg_match('/^(.+)\.([a-z0-9_]+)(-([a-z0-9_]+))?\.([a-z0-9_-]+)\.rrd$/', $file, $ar)) {
#		echo "$ar[1] - $ar[2] - $ar[4] - $ar[5]<br/>" ;
		$graph[$ar[1]][$ar[2]][$ar[4]] = 1 ;
	}
}
echo "<table border='1'>" ;
foreach ($graph as $ip => $ar) {
	echo "<tr><td>$ip</td>" ;
	foreach ($ar as $type => $arr) {
		if ($type == 'net') {
			echo "<td>" ;
			foreach($arr as $dev => $null) {
				echo "<a href='netb.php?ip=$ip&name=$dev&title=${ip}_bps_$dev&start=-1d&end=-1s&type=AVERAGE' target='_blank'>bps_$dev</a> " ;
				echo "<a href='netp.php?ip=$ip&name=$dev&title=${ip}_pps_$dev&start=-1d&end=-1s&type=AVERAGE' target='_blank'>pps_$dev</a> " ;
			}
			echo "</td>" ;
		}
		if ($type == 'io') {
			echo "<td>" ;
			foreach($arr as $dev => $null) {
				echo "<a href='iops.php?ip=$ip&name=$dev&title=${ip}_iops_$dev&start=-1d&end=-1s&type=AVERAGE' target='_blank'>iops_$dev</a> " ;
				echo "<a href='iosps.php?ip=$ip&name=$dev&title=${ip}_iosps_$dev&start=-1d&end=-1s&type=AVERAGE' target='_blank'>iosps_$dev</a> " ;
				echo "<a href='ioload.php?ip=$ip&name=$dev&title=${ip}_ioload_$dev&start=-1d&end=-1s&type=AVERAGE' target='_blank'>ioload_$dev</a> " ;
			}
			echo "</td>" ;
		}
		if ($type == 'fs') {
			echo "<td>" ;
			foreach($arr as $dev => $null) {
				$devs = str_replace("_", "/", $dev) ;
				echo "<a href='fs.php?ip=$ip&name=$dev&title=${ip}_fs_$devs&start=-1d&end=-1s&type=AVERAGE' target='_blank'>fs_$devs</a> " ;
			}
			echo "</td>" ;
		}
		if ($type === 'mem' ) {
			echo "<td>" ;
			echo "<a href='mem.php?ip=$ip&title=${ip}_memory&start=-1d&end=-1s&type=AVERAGE' target='_blank'>mem</a> " ;
			echo "</td>" ;
		}
		if ($type === 'la' ) {
			echo "<td>" ;
			echo "<a href='la.php?ip=$ip&title=${ip}_load_average&start=-1d&end=-1s&type=AVERAGE' target='_blank'>la</a> " ;
			echo "</td>" ;
		}
		if ($type === 'cpu' ) {
			echo "<td>" ;
			echo "<a href='cpu.php?ip=$ip&title=${ip}_cpu&start=-1d&end=-1s&type=AVERAGE' target='_blank'>cpu</a> " ;
			echo "</td>" ;
		}
	}
	echo "</tr>" ;
}
?>

