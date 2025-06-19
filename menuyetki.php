<?php
require_once "mysql/mysqlsorgu.php";
// Veritabanına bağlan
$connection = dbConnect();

// Kullanıcıları ve menü öğelerini alalım
$users = $connection->query("SELECT id, username FROM user");
$menuItems = $connection->query("SELECT id, name FROM menu_items");
?>

<form method="post" action="yetkilendirme.php">
    <label for="user">Kullanıcı Seç:</label>
    <select name="user_id">
        <?php while($user = $users->fetch_assoc()) { ?>
            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
        <?php } ?>
    </select>

    <h3>Menü Yetkilerini Seç:</h3>
    <?php while($menuItem = $menuItems->fetch_assoc()) { ?>
        <input type="checkbox" name="menu_items[]" value="<?php echo $menuItem['id']; ?>">
        <?php echo $menuItem['name']; ?><br>
    <?php } ?>

    <button type="submit">Yetkilendir</button>
</form>
