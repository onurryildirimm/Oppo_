<?php  
require_once 'mysql/mysqlsorgu.php';
$connect = dbConnect();

$tarih1 = $_POST["baslangic"];
$tarih2 = $_POST["bitis"];
$output = '';
if($tarih1 == "") {
    header('Location: egitim');
}

$output = '';

if(isset($_POST["exportButton"]))
{

$query = " SELECT * FROM egitim WHERE planlanan >=  '$tarih1' AND planlanan<=  '$tarih2' ";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" style="border-collapse: collapse;" border="1"> 
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <tr>  
                <th style="background-color: yellow;"><center>Eğitimin Konusu</center></th>
                <th style="background-color: yellow;"><center>Eğitimi Veren Kişi/Kuruluş</center></th>
                <th style="background-color: yellow;"><center>Eğitim Süresi</center></th>
                <th style="background-color: yellow;"><center>Eğitime Katılacak Gruplar</center></th>
                <th style="background-color: yellow;"><center>Planlanan Tarih</center></th>
                <th style="background-color: yellow;"><center>Gerçekleşen Tarih</center></th>
                
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
         <td style="border: 1px solid black;"><center>'.$row["konu"].'</center></td>  
         <td style="border: 1px solid black;"><center>'.$row["veren"].'</center></td>  
         <td style="border: 1px solid black;"><center>'.$row["sure"].'</center></td>  
         <td style="border: 1px solid black;"><center>'.$row["gruplar"].'</center></td>  
         <td style="border: 1px solid black;"><center>'.($row["planlanan"] ? date('d.m.Y', strtotime($row["planlanan"])) : '').'</center></td>
         <td style="border: 1px solid black;"><center>'.($row["gerceklesen"] ? date('d.m.Y', strtotime($row["gerceklesen"])) : '').'</center></td>
         
       </tr>  
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=egitimlistesi.xls');
  echo $output;
 }
}
?>
