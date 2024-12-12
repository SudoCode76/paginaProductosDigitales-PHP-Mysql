<?php
session_start();
session_destroy();
header("Location: http://localhost/paginaProductosDigitales/public/index.php");
exit();
?>
