<?php
/*
  LAB REMOTE FILE INCLUSION (RFI)
  WARNING: VULNERABLE CODE – FOR LAB ONLY
*/

$page = $_GET['page'];

include($page); // ❌ VULNERABLE RFI
?>
