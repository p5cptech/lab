<?php
echo "<h2>Document Viewer</h2>";
$file = $_GET['file'];

// VULNERABLE: Tidak ada pengecekan path (.. atau /)
// Serangan: ?file=../../../../etc/passwd
if (isset($file)) {
    echo "<h3>Viewing: " . htmlspecialchars($file) . "</h3>";
    echo "<pre>";
    include($file); 
    echo "</pre>";
} else {
    echo "Pilih file untuk dilihat (contoh: ?file=readme.txt)";
}
?>
