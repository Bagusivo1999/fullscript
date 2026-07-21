<?php
/*
 ============================================================
   🔐 SECRET KEY GENERATOR v2.0
   Generate berbagai jenis secret key untuk keamanan
 ============================================================
*/

// ==================== KONFIGURASI ====================
define('VERSION', '2.0');
define('AUTHOR', 'Security System');

// ==================== FUNGSI GENERATOR ====================

/**
 * Mode 1: Generate Manual (Custom)
 * User menentukan key sendiri
 */
function generateManual($custom_key = null) {
    if ($custom_key === null) {
        // Jika tidak ada input, generate otomatis
        return generateRandom(64);
    }
    
    // Validasi panjang minimal 32 karakter
    if (strlen($custom_key) < 32) {
        return [
            'error' => true,
            'message' => 'Key harus minimal 32 karakter!'
        ];
    }
    
    return [
        'mode' => 'Manual',
        'key' => $custom_key,
        'length' => strlen($custom_key),
        'strength' => checkKeyStrength($custom_key)
    ];
}

/**
 * Mode 2: Generate Otomatis (Random Bytes)
 * Menggunakan random_bytes() untuk keamanan tinggi
 */
function generateRandom($length = 32) {
    try {
        $bytes = random_bytes($length);
        $key = bin2hex($bytes);
        
        return [
            'mode' => 'Random Bytes (bin2hex)',
            'key' => $key,
            'length' => strlen($key),
            'entropy' => 'High (Cryptographically Secure)',
            'timestamp' => date('Y-m-d H:i:s')
        ];
    } catch (Exception $e) {
        // Fallback jika random_bytes tidak tersedia
        return generateFallback($length);
    }
}

/**
 * Mode 3: Generate dari Hash
 * Menggunakan hash dari string custom
 */
function generateHash($input_string = null, $algo = 'sha256') {
    if ($input_string === null) {
        $input_string = 'aplikasi_saya_' . date('Ymd') . '_' . uniqid();
    }
    
    // Tambahkan salt untuk keamanan
    $salt = 's4lt_k3aman4n_' . date('Y');
    $hashed = hash($algo, $input_string . $salt);
    
    return [
        'mode' => 'Hash (' . strtoupper($algo) . ')',
        'input' => $input_string,
        'key' => $hashed,
        'length' => strlen($hashed),
        'algorithm' => $algo
    ];
}

/**
 * Mode 4: Generate Base64
 * Menggunakan base64 encoding untuk key yang readable
 */
function generateBase64($length = 32) {
    try {
        $bytes = random_bytes($length);
        $key = base64_encode($bytes);
        // Hapus karakter yang tidak perlu
        $key = str_replace(['+', '/', '='], ['-', '_', ''], $key);
        
        return [
            'mode' => 'Base64 URL Safe',
            'key' => $key,
            'length' => strlen($key),
            'original_length' => $length
        ];
    } catch (Exception $e) {
        return generateFallback($length);
    }
}

/**
 * Mode 5: Generate Multi-layer
 * Kombinasi beberapa metode untuk keamanan ekstra
 */
function generateMultiLayer() {
    $part1 = bin2hex(random_bytes(16));
    $part2 = hash('sha256', uniqid() . microtime(true) . random_bytes(16));
    $part3 = base64_encode(random_bytes(24));
    $part3 = str_replace(['+', '/', '='], ['-', '_', ''], $part3);
    
    $key = substr($part1, 0, 16) . substr($part2, 8, 16) . substr($part3, 4, 16);
    $key = str_shuffle($key);
    
    return [
        'mode' => 'Multi-layer Combination',
        'key' => $key,
        'length' => strlen($key),
        'components' => [
            'part1' => $part1,
            'part2' => $part2,
            'part3' => $part3
        ]
    ];
}

/**
 * Mode 6: Generate dengan Timestamp
 * Key yang mengandung timestamp untuk rotasi
 */
function generateTimestampKey() {
    $timestamp = time();
    $date = date('YmdHis');
    $random = bin2hex(random_bytes(16));
    $hash = hash('sha256', $timestamp . $random . SECRET_SALT);
    
    $key = substr($hash, 0, 20) . $date . substr($hash, -12);
    
    return [
        'mode' => 'Timestamp-based',
        'key' => $key,
        'timestamp' => $date,
        'expiry' => date('Y-m-d H:i:s', $timestamp + 86400), // 24 jam
        'length' => strlen($key)
    ];
}

/**
 * Mode 7: Generate untuk Android
 * Key khusus untuk validasi aplikasi Android
 */
function generateAndroidKey($package_name = 'com.example.app') {
    $base = $package_name . date('Ymd') . SECRET_SALT;
    $key = hash('sha256', $base);
    $key = substr($key, 0, 16) . '-' . substr($key, 16, 16) . '-' . substr($key, 32, 16);
    $key = strtoupper($key);
    
    return [
        'mode' => 'Android App Key',
        'package' => $package_name,
        'key' => $key,
        'format' => 'XXXX-XXXX-XXXX-XXXX',
        'length' => strlen($key)
    ];
}

/**
 * Mode 8: Generate API Key
 * Key khusus untuk API dengan prefix
 */
function generateAPIKey($prefix = 'API') {
    $random = bin2hex(random_bytes(24));
    $timestamp = dechex(time());
    $hash = hash('sha256', $random . $timestamp . SECRET_SALT);
    
    $key = $prefix . '_' . substr($hash, 0, 16) . '_' . $timestamp . '_' . substr($random, 0, 16);
    
    return [
        'mode' => 'API Key',
        'prefix' => $prefix,
        'key' => $key,
        'format' => 'PREFIX_HASH_TIMESTAMP_RANDOM',
        'length' => strlen($key)
    ];
}

/**
 * Mode 9: Generate Encrypted Key
 * Key yang dienkripsi untuk penyimpanan aman
 */
function generateEncryptedKey($plain_key = null) {
    if ($plain_key === null) {
        $plain_key = bin2hex(random_bytes(32));
    }
    
    $encryption_key = SECRET_SALT;
    $iv = random_bytes(16);
    $encrypted = openssl_encrypt(
        $plain_key,
        'AES-256-CBC',
        $encryption_key,
        0,
        $iv
    );
    
    return [
        'mode' => 'Encrypted Key',
        'plain_key' => $plain_key,
        'encrypted' => base64_encode($iv . $encrypted),
        'algorithm' => 'AES-256-CBC',
        'length' => strlen($plain_key)
    ];
}

/**
 * Mode 10: Generate JWT Secret
 * Key khusus untuk JWT (JSON Web Token)
 */
function generateJWTSecret($length = 64) {
    $key = bin2hex(random_bytes($length));
    $base64_key = base64_encode(random_bytes($length));
    
    return [
        'mode' => 'JWT Secret',
        'hex_key' => $key,
        'base64_key' => $base64_key,
        'recommended' => 'HS256: Minimal 32 karakter',
        'length' => strlen($key)
    ];
}

// ==================== FUNGSI BANTUAN ====================

// Salt global untuk semua generator
if (!defined('SECRET_SALT')) {
    define('SECRET_SALT', 's4lt_gl0bal_k3aman4n_' . date('Y'));
}

/**
 * Cek kekuatan key
 */
function checkKeyStrength($key) {
    $score = 0;
    
    // Panjang
    if (strlen($key) >= 32) $score += 25;
    else if (strlen($key) >= 16) $score += 15;
    
    // Huruf besar
    if (preg_match('/[A-Z]/', $key)) $score += 20;
    
    // Huruf kecil
    if (preg_match('/[a-z]/', $key)) $score += 20;
    
    // Angka
    if (preg_match('/[0-9]/', $key)) $score += 20;
    
    // Simbol khusus
    if (preg_match('/[^a-zA-Z0-9]/', $key)) $score += 15;
    
    // Entropy
    $entropy = strlen($key) * log(strlen($key), 2);
    if ($entropy > 128) $score += 10;
    else if ($entropy > 64) $score += 5;
    
    // Rating
    if ($score >= 90) return 'Strong 🔒';
    else if ($score >= 70) return 'Medium 🔐';
    else return 'Weak ⚠️';
}

/**
 * Fallback jika random_bytes tidak tersedia
 */
function generateFallback($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    
    return [
        'mode' => 'Fallback (mt_rand)',
        'key' => $key,
        'length' => strlen($key),
        'warning' => 'Tidak cryptographically secure! Gunakan untuk development saja.'
    ];
}

// ==================== FUNGSI UTAMA ====================

function generateAllKeys() {
    echo "\n";
    echo "═══════════════════════════════════════════════════════════════\n";
    echo "  🔐 SECRET KEY GENERATOR v" . VERSION . " - " . date('Y-m-d H:i:s') . "\n";
    echo "═══════════════════════════════════════════════════════════════\n\n";
    
    // 1. Manual Key
    echo "1️⃣ MANUAL KEY (Custom)\n";
    $manual = generateManual('xK9mP2nQ5rS8tU1vW4yZ7bC3eF6gH9jL');
    if (isset($manual['error'])) {
        echo "   ❌ " . $manual['message'] . "\n";
    } else {
        echo "   🔑 " . $manual['key'] . "\n";
        echo "   📏 Length: " . $manual['length'] . " | Strength: " . $manual['strength'] . "\n";
    }
    echo "\n";
    
    // 2. Random Key
    echo "2️⃣ RANDOM KEY (Cryptographically Secure)\n";
    $random = generateRandom(32);
    echo "   🔑 " . $random['key'] . "\n";
    echo "   📏 Length: " . $random['length'] . " | Entropy: " . $random['entropy'] . "\n";
    echo "\n";
    
    // 3. Hash Key
    echo "3️⃣ HASH KEY\n";
    $hash = generateHash('aplikasi_saya_2026_rahasia');
    echo "   🔑 " . $hash['key'] . "\n";
    echo "   📏 Length: " . $hash['length'] . " | Algorithm: " . $hash['algorithm'] . "\n";
    echo "   📝 Input: " . $hash['input'] . "\n";
    echo "\n";
    
    // 4. Base64 Key
    echo "4️⃣ BASE64 URL-SAFE KEY\n";
    $base64 = generateBase64(32);
    echo "   🔑 " . $base64['key'] . "\n";
    echo "   📏 Length: " . $base64['length'] . " (Original: " . $base64['original_length'] . " bytes)\n";
    echo "\n";
    
    // 5. Multi-layer Key
    echo "5️⃣ MULTI-LAYER KEY\n";
    $multi = generateMultiLayer();
    echo "   🔑 " . $multi['key'] . "\n";
    echo "   📏 Length: " . $multi['length'] . " | Mode: " . $multi['mode'] . "\n";
    echo "\n";
    
    // 6. Timestamp Key
    echo "6️⃣ TIMESTAMP-BASED KEY\n";
    $timestamp = generateTimestampKey();
    echo "   🔑 " . $timestamp['key'] . "\n";
    echo "   📏 Length: " . $timestamp['length'] . " | Expiry: " . $timestamp['expiry'] . "\n";
    echo "\n";
    
    // 7. Android Key
    echo "7️⃣ ANDROID APP KEY\n";
    $android = generateAndroidKey('com.example.app');
    echo "   🔑 " . $android['key'] . "\n";
    echo "   📦 Package: " . $android['package'] . " | Format: " . $android['format'] . "\n";
    echo "\n";
    
    // 8. API Key
    echo "8️⃣ API KEY\n";
    $api = generateAPIKey('PROD');
    echo "   🔑 " . $api['key'] . "\n";
    echo "   📏 Length: " . $api['length'] . " | Format: " . $api['format'] . "\n";
    echo "\n";
    
    // 9. Encrypted Key
    echo "9️⃣ ENCRYPTED KEY\n";
    $encrypted = generateEncryptedKey();
    echo "   🔑 Plain: " . $encrypted['plain_key'] . "\n";
    echo "   🔒 Encrypted: " . substr($encrypted['encrypted'], 0, 50) . "...\n";
    echo "   🔐 Algorithm: " . $encrypted['algorithm'] . "\n";
    echo "\n";
    
    // 10. JWT Secret
    echo "🔟 JWT SECRET\n";
    $jwt = generateJWTSecret(32);
    echo "   🔑 Hex: " . $jwt['hex_key'] . "\n";
    echo "   🔑 Base64: " . $jwt['base64_key'] . "\n";
    echo "   📏 Length: " . $jwt['length'] . " | Recommended: " . $jwt['recommended'] . "\n";
    
    echo "\n";
    echo "═══════════════════════════════════════════════════════════════\n";
    echo "  ⚠️  SIMPAN KEY DI TEMPAT AMAN! JANGAN PERNAH DISHARE!\n";
    echo "═══════════════════════════════════════════════════════════════\n\n";
}

// ==================== GENERATE UNTUK KONFIGURASI ====================

function generateConfigFile() {
    $keys = [
        'SECRET_KEY' => generateRandom(64)['key'],
        'API_SECRET' => generateRandom(48)['key'],
        'ENCRYPT_KEY' => generateRandom(32)['key'],
        'JWT_SECRET' => generateJWTSecret(32)['hex_key'],
        'ANDROID_SIGNATURE' => strtoupper(generateRandom(32)['key'])
    ];
    
    $config = "<?php\n";
    $config .= "// ==========================================\n";
    $config .= "// KONFIGURASI KEAMANAN\n";
    $config .= "// Generated: " . date('Y-m-d H:i:s') . "\n";
    $config .= "// ==========================================\n\n";
    
    foreach ($keys as $name => $value) {
        $config .= "define('" . $name . "', '" . $value . "');\n";
    }
    
    $config .= "\n// JANGAN MODIFIKASI TANPA IZIN!\n";
    $config .= "// Simpan file ini di tempat aman.\n";
    $config .= "?>";
    
    return [
        'keys' => $keys,
        'config' => $config
    ];
}

// ==================== EKSEKUSI ====================

// Cek mode dari parameter
$mode = $_GET['mode'] ?? 'all';

switch ($mode) {
    case 'config':
        $result = generateConfigFile();
        echo "✅ Config file generated!\n\n";
        echo "Keys:\n";
        foreach ($result['keys'] as $name => $value) {
            echo "  - " . $name . ": " . substr($value, 0, 20) . "...\n";
        }
        echo "\n📝 Save this to config.php:\n\n";
        echo $result['config'];
        break;
        
    case 'single':
        $type = $_GET['type'] ?? 'random';
        $length = intval($_GET['length'] ?? 32);
        
        switch ($type) {
            case 'random':
                $result = generateRandom($length);
                break;
            case 'base64':
                $result = generateBase64($length);
                break;
            case 'hash':
                $input = $_GET['input'] ?? 'default_string';
                $result = generateHash($input);
                break;
            case 'api':
                $prefix = $_GET['prefix'] ?? 'API';
                $result = generateAPIKey($prefix);
                break;
            default:
                $result = generateRandom($length);
        }
        
        echo "🔑 " . $result['key'] . "\n";
        break;
        
    default:
        // Tampilkan semua mode
        generateAllKeys();
        
        // Tambahan: generate config
        echo "\n📄 INGIN GENERATE CONFIG FILE?\n";
        echo "   Jalankan: ?mode=config\n";
        echo "   Untuk single key: ?mode=single&type=random&length=64\n\n";
        
        // Tampilkan opsi cepat
        echo "⚡ QUICK GENERATE:\n";
        $quick = generateRandom(32);
        echo "   Random 32: " . $quick['key'] . "\n";
        $quick = generateBase64(24);
        echo "   Base64 24: " . $quick['key'] . "\n";
        $quick = generateAPIKey('DEV');
        echo "   API Key: " . $quick['key'] . "\n";
}
?>