├── config/                 # Konfigurasi Database & Global
│   └── db.php              # Koneksi MySQL (Sengaja menggunakan MySQLi/PDO yang tidak aman)
├── core/                   # Logika inti aplikasi
│   ├── auth.php            # Fungsi login/session
│   └── logger.php          # Helper untuk mengirim log custom ke Wazuh
├── public/                 # Folder akses publik
│   ├── assets/             # CSS/JS
│   └── uploads/            # Target untuk File Upload Vulnerability
├── modules/                # MODUL KERENTANAN (Satu folder per kategori)
│   ├── injection/
│   │   ├── sql_i.php       # SQL Injection
│   │   ├── cmd_i.php       # OS Command Injection
│   │   └── ssti.php        # Server Side Template Injection
│   ├── broken_auth/
│   │   ├── jwt_lab.php     # JWT & OAuth Vulnerabilities
│   │   ├── insecure_des.php # Insecure Deserialization
│   │   └── auth_bypass.php # Access Control & Authentication
│   ├── client_side/
│   │   ├── xss_reflected.php
│   │   ├── dom_vulc.php    # DOM-based vulnerabilities
│   │   ├── csrf_lab.php    # Cross-Site Request Forgery
│   │   └── cors_misconfig.php
│   ├── server_side/
│   │   ├── ssrf.php        # Server Side Request Forgery
│   │   ├── xxe.php         # XML External Entity
│   │   ├── path_trav.php   # Path Traversal
│   │   └── host_header.php # Host Header Attacks
│   ├── advanced/
│   │   ├── smuggling.php   # HTTP Request Smuggling
│   │   ├── cache_poison.php # Web Cache Poisoning
│   │   ├── race_cond.php   # Race Conditions
│   │   └── proto_pollute.php # Prototype Pollution (JS context)
│   └── api/
│       └── testing.php     # API Testing & Information Disclosure
├── index.php               # Dashboard Navigasi Lab
└── logs/
    └── pentest_access.log  # File log yang akan di-monitor oleh Wazuh Agent
