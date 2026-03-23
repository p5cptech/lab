#!/bin/bash

TARGET="mrahmatt74.com"
PROTO="https" # Sesuaikan jika masih menggunakan http

echo "================================================================"
echo "Memulai Simulasi Serangan untuk Testing Wazuh di $TARGET"
echo "================================================================"

# --- Skenario 1: Error Code (4xx & 5xx) ---
echo -e "\n[1] Testing HTTP Error Codes..."
# Rule 31101 (400/404 Error)
curl -I -s "$PROTO://$TARGET/halaman_tidak_ada_404" > /dev/null
# Rule 31151 (Scanning/Multiple 400 Errors)
echo "Menjalankan 20 request cepat untuk memicu deteksi scanning..."
for i in {1..20}; do curl -s -o /dev/null "$PROTO://$TARGET/error_$i"; done

# --- Skenario 2: SQL Injection (SQLi) ---
echo -e "\n[2] Testing SQL Injection..."
# Rule 31103 & 31171 (Basic SQLi)
curl -s -o /dev/null "$PROTO://$TARGET/login.php?user=admin'%20OR%201=1%20--"
curl -s -o /dev/null "$PROTO://$TARGET/product.php?id=1'%20UNION%20SELECT%20null,null%20--"
# Rule 31170 (Time-based SQLi)
curl -s -o /dev/null "$PROTO://$TARGET/page?id=1%2csleep(10)"
# Rule 31164 & 31165 (Encoded SQLi)
curl -s -o /dev/null "$PROTO://$TARGET/search?q=select%2Bfrom%2Bwhere"

# --- Skenario 3: Cross-Site Scripting (XSS) ---
echo -e "\n[3] Testing XSS..."
# Rule 31105 (XSS Attempt)
curl -s -o /dev/null "$PROTO://$TARGET/index.php?name=<script>alert(1)</script>"
curl -s -o /dev/null "$PROTO://$TARGET/profile?id=1%20ONLOAD=alert(1)"

# --- Skenario 4: Directory Traversal ---
echo -e "\n[4] Testing Directory Traversal..."
# Rule 31104
curl -s -o /dev/null "$PROTO://$TARGET/view?file=../../etc/passwd"
curl -s -o /dev/null "$PROTO://$TARGET/winnt/system32/cmd.exe"
curl -s -o /dev/null "$PROTO://$TARGET/cgi-bin/test.sh?exec%20"

# --- Skenario 5: Vulnerability & CGI-Bin ---
echo -e "\n[5] Testing Shellshock & CGI..."
# Rule 31110 (CGI-bin PHP)
curl -s -o /dev/null "$PROTO://$TARGET/cgi-bin/php?-d+allow_url_include=on+-d+auto_prepend_file=php://input"
# Rule 31166 (Shellshock)
curl -s -o /dev/null -A "() { :;}; echo 'Shellshock Test'" "$PROTO://$TARGET/cgi-bin/test.sh"

# --- Skenario 6: URL Too Long ---
echo -e "\n[6] Testing URL Length..."
# Rule 31115 (8000 Karakter)
LONG_URL=$(printf 'A%.0s' {1..8000})
curl -s -o /dev/null "$PROTO://$TARGET/$LONG_URL"

# --- Skenario 7: White Noise / Ignored Rules (Level 0) ---
echo -e "\n[7] Testing Normal Traffic (Should not trigger high alerts)..."
# Rule 31108 (Normal Access)
curl -I -s "$PROTO://$TARGET/index.html" > /dev/null
# Rule 31140 (Googlebot Simulator)
curl -s -o /dev/null -A "Googlebot/2.1 (+http://www.google.com/bot.html)" "$PROTO://$TARGET/halaman_404"

echo -e "\n================================================================"
echo "Simulasi Selesai. Silakan periksa Dashboard Wazuh Anda."
echo "================================================================"
