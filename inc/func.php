<?php 
	function Locate($url) { header("Location: $url"); exit(); }
	function prepare($theValue, $theType,$bd) 
	{
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}
	
		$theValue = $bd->real_escape_string($theValue);
	
		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "''";
			break;
			case "sql":
				$theValue = ($theValue != "") ? $theValue : "''";
			break;    
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "0";
			break;
			case "double":
				$theValue = ($theValue != "") ? doubleval($theValue) : "0";
			break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : " ";
			break;
		}
		return $theValue;
	}

/////////////////////////////////////////NUEVAS FUNCIONES ////////////////////////////////////////
	function DelGall()
	{
		if(isset($_COOKIE['user'])){unset($_COOKIE['user']);}
		if(isset($_COOKIE['pass'])){unset($_COOKIE['pass']);}
		if(isset($_COOKIE['name'])){unset($_COOKIE['name']);}
		if(isset($_COOKIE['t_doc'])){unset($_COOKIE['t_doc']);}
		if(isset($_COOKIE['n_doc'])){unset($_COOKIE['n_doc']);}
		if(isset($_COOKIE['reg'])){unset($_COOKIE['reg']);}
		if(isset($_COOKIE['GO'])){unset($_COOKIE['GO']);}
	}

	function ctrl($icon,$id,$pla='',$val='',$ext='',$type='text')
	{
		echo '<div class="input-group">
		<div class="input-group-addon">'.$icon.'</div>
		<input type="'.$type.'" value="'.$val.'" '.$ext.' class="form-control" id="'.$id.'" name="'.$id.'" placeholder="'.$pla.'">
		</div>';
	}
	function select($icon,$id,$DATA,$Sel,$Pla,$ext='')
	{
		echo'<div class="input-group">
		<div class="input-group-addon">'.$icon.'</div>
		<select class="form-control" id="'.$id.'" name="'.$id.'" '.$ext.' >
		<option value="-1" disabled>'.$Pla.'</option>';
		foreach($DATA as $ID=>$VAL)
		{
			$S = $ID==$Sel ? 'selected' : '' ;
			echo '<option '.$S.' value="'.$ID.'">'.$VAL.'</option>';
		}
		echo'</select></div>';
	}
	
?>
