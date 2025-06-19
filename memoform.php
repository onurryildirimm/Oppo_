<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memorandum Sayfası</title>
  <style>
    /* CSS stil kurallarını burada tanımlayabilirsiniz */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }
     h1 {
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }
    
     table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      border: 2px solid #333;
      border-radius: 10px;
    }

    .header {
      text-align: right;
      margin-bottom: 20px;
    }

    .content {
      display: flex;
    }

    .content-left {
      flex: 1;
    }

    .content-right {
      flex: 1;
      text-align: right;
    }

    .field {
      margin-bottom: 10px;
    }

    .field-label {
      font-weight: bold;
    }
    
    .field2 {
      margin-bottom: 10px;
      text-align: center;
    }
    
    @media print {
      @page {
        margin: 5mm; /* Kenar boşluğu ayarını burada yapabilirsiniz */
      }
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="container">
      <center><h3><?php echo $_POST['id']; ?> No'lu Memorandum</h3></center>
    </div>
    <div class="header">
      <div>Tarih: <?php 
      $tarih = $_POST['tarih'];
      $tarihformat = date('d/m/Y', strtotime($tarih));
      echo $tarih; ?></div>
      <div>Geçerlilik Tarihi: <?php 
      $gecerlilikTarihi = $_POST['gecerliliktarihi'];
      $gecerlilikTarihiFormatted = date('d/m/Y', strtotime($gecerlilikTarihi));
      echo $gecerlilikTarihi; ?></div>
    </div>
    <div class="content">
      <div class="content-left">
        <div class="field">
          <div class="field-label">Tesis:</div>
          <div><?php echo $_POST['tesis']; ?></div>
          <br>
        </div>
        <div class="field">
          <div class="field-label">Kimden:</div>
          <div><?php echo $_POST['kimden']; ?></div>
        </div>
        <br>
        <div class="field">
          <div class="field-label">Kime:</div>
          <div><?php echo $_POST['kime']; ?></div>
        </div>
        <br>
        <div class="field">
          <div class="field-label">Konu:</div>
          <div><?php echo $_POST['konu']; ?></div>
        </div>
      </div>
      <div class="content-right">
        <button class="no-print" onclick="window.print()">Yazdır</button>
      </div>
    </div>
   <div class="field2">
  <div class="field-label">Bilgi:</div>
  <div><?php echo nl2br($_POST['bilgi']); ?></div>
</div>
  </div>
</body>

</html>
