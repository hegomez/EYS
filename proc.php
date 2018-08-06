<?php include("inc/conn.php") ?>
<?php include("inc/func.php") ?>
<?php if(!isset($_COOKIE['GO'])){Locate('index.php?3R');} ?>
<?php
	if(isset($_GET['jsoncallback']) && !empty($_GET['jsoncallback']))
	{
		$array=array();

		if(isset($_GET['FindData']))
		{
			if($_GET['FindData']=='URG')
			{$Q="SELECT historia,cod_admin,codigo,fecha_ing AS fecha FROM urgencia012018 where historia=".$_GET['ADM'];}
			else
			{$Q="SELECT historia,cod_admin,codigo,fecha FROM hospitalizacion01 where historia=".$_GET['ADM'];}
			$params = array(1, "some data");
			$stmt = sqlsrv_query( $conn, $Q, $params);
			if( $stmt === false ) {
				 die( print_r( sqlsrv_errors(), true));
			}
			else
			{
				$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
				$cod=$row['cod_admin'];
				$RS=$bd->query("SELECT eps FROM eps WHERE cod='$cod'");
				$RW=$RS->fetch_assoc();
				$array['EPS']=$RW['eps'];
				$Query="SELECT tipo_c, ppellido, sapellido, nombre, snombre FROM paciente where codigo='".$row['codigo']."'";
				$params = array(1, "some data");
				$res = sqlsrv_query( $conn, $Query, $params);
				if( $res === false ) {
					 die( print_r( sqlsrv_errors(), true));
				}
				$sRW = sqlsrv_fetch_array( $res, SQLSRV_FETCH_ASSOC);
				$array['NOM']=trim($sRW['nombre'])." ".trim($sRW['ppellido'])." ".trim($sRW['sapellido']);
				$array['NOM']=strtoupper(trim($array['NOM']));
				$array['IDN']=$sRW['tipo_c']."-".$row['codigo'];
				$array['IDN']=trim($array['IDN']);
				$array['FCH']=$row['fecha']->format('Y-m-d');
			}
		}
		if(isset($_GET['TEMPOCC']))
		{
			$CUPS=$_GET["CUPS"];
			$CIRJ=$_GET["CIRJ"];
			$ANES=$_GET["ANES"];
			$AYUD=$_GET["AYUD"];
			$SALA=$_GET["SALA"];
			$MATE=$_GET["MATE"];
			if($_GET['TEMPOCC']=='ADD')
			{
				$bd->query("INSERT INTO `tmp_cc` VALUES($CUPS,$CIRJ,$ANES,$AYUD,$SALA,$MATE)");
			}
			else
			{
				$bd->query("DELETE FROM `tmp_cc` WHERE cod=$CUPS and ciru=$CIRJ and anes=$ANES and ayud=$AYUD and sala=$SALA and mate=$MATE LIMIT 1");
			}
		}
		if(isset($_GET['CUPS'])&&!isset($_GET['TEMPOCC']))
		{
			$CODIGO=prepare($_GET['CUPS'],'double',$bd);
			$RS=$bd->query("SELECT * FROM `cups_iss2001` WHERE `CODIGO`=$CODIGO");
			if($RS->num_rows>=1)
			{
				$array['RTA']='OK';
				$RW=$RS->fetch_assoc();
				$array['NOM'] = strlen($RW['DESCRIPCION'])>=40 ? utf8_encode(substr($RW['DESCRIPCION'],0,37)) . "..." : utf8_encode($RW['DESCRIPCION']) ;
				
				$array['UVR']=$RW['UVR'];
			}
			else
			{
				$array['RTA']='NO';
			}
		}
		echo $_GET['jsoncallback'].'('.json_encode($array).')';
	}
?>