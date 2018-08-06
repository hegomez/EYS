<?php include("inc/conn.php") ?>
<?php include("inc/func.php") ?>
<?php
	if(isset($_POST['user']) && isset($_POST['pass']))
	{
		$u=strtolower($_POST['user']);
		$p=sha1(strtolower($_POST['pass']));
		$user=prepare($u,'text',$bd);
		$pass=prepare($p,'text',$bd);
		$RS=$bd->query("SELECT name,t_doc,n_doc,reg FROM `users` where `user`=$user AND `pass`=$pass");
		if($RS->num_rows>=1)
		{
			$RW=$RS->fetch_assoc();
			$day = 60 * 60 * 24 + time();
			foreach ($RW as $key => $value)
			{
				setcookie($key,$value,$day);
			}
			setcookie("GO","GO",$day);
			Locate('main.php');
		}
		else
		{
			Locate('index.php?3R');
		}
	}
?>