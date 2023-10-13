<?php
require_once('functions.php');
if(!isset($_SESSION['email'])) die('This is a private area, you are not allowed here');
?>
<h1>Private</h1>
<?= $_SESSION['email'] ?><br />
<?= $_SESSION['ID'] ?><br />