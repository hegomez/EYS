<?php set_time_limit(0); $bd = new MySQLi("localhost", "root", "", "eys"); if (mysqli_connect_errno()) { printf("Connect failed: %s\n", mysqli_connect_error()); $MysqlCnn=mysqli_connect_error(); exit(); } else {$MysqlCnn="OK";} ?>
<?php
	$serverName = "192.168.1.84,1500";
	$connectionInfo = array( "Database"=>"INFOTEC", "UID"=>"SA", "PWD"=>"Infotec123");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	if( $conn ) {
		 $SQLCnn="ok";
	}else{
     	 die( print_r( sqlsrv_errors(), true));
	}
?>