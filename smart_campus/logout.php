<?php
session_start();
session_unset();
session_destroy(); // Menghapus seluruh data session login

header("Location: index.php");
exit();
?>