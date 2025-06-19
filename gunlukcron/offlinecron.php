<?php
require_once '/../mysql/mysqlsorgu.php';

	try{//hata varmı diye kontrol mekanizması.

		$baglanti=getPDOConnection();

	    $sonuc = $baglanti->exec("UPDATE user SET status='Offline'");
	}catch (PDOException $h) {

		$hata=$h->getMessage();

		

	}
	
	?>