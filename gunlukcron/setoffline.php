<?php

	try{//hata varmı diye kontrol mekanizması.

		$baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur");//bağlantı yaptık

	    $sonuc = $baglanti->exec("UPDATE user SET status='Offline'");
	}catch (PDOException $h) {

		$hata=$h->getMessage();

		

	}
	
	?>