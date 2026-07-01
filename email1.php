<?php
/**
 * PROJECT     : Tmailor Tempmail + Auto OTP (Full Content)
 * AUTHOR      : BINTANG
 * CREATOR     : BINTANG
 * DESCRIPTION : Generate email, read full message, extract OTP/verification link
 * USAGE       : php email1.php
 */

define('API_URL', 'tmailor.com');
define('API_PATH', '/api');
define('MAX_WAIT', 120);

$currentToken = null;

function generateEmail() {
    $domains = getAllDomains();
    
    $priorityDomains = ['freeimagehosts.org', 'etubemail.com', 'tokmail.net'];
    usort($domains, function($a, $b) use ($priorityDomains) {
        $aPriority = in_array($a['domain_name'], $priorityDomains) ? 0 : 1;
        $bPriority = in_array($b['domain_name'], $priorityDomains) ? 0 : 1;
        return $aPriority - $bPriority;
    });
    
    foreach ($domains as $domain) {
        try {
            $emailData = createEmail($domain['token']);
            $token = $emailData['accesstoken'];
            $email = $emailData['email'];
            
            return [
                'success' => true,
                'data' => [
                    'email' => $email,
                    'access_token' => $token,
                    'created_at' => $emailData['create'],
                    'permission' => $emailData['permission_desc'],
                    'domain' => $domain['domain_name']
                ]
            ];
        } catch (Exception $e) {
            continue;
        }
    }
    
    throw new Exception('Semua domain gagal. Coba lagi nanti.');
}

function checkInbox($email, $token) {
    if (!$email || !$token) {
        throw new Exception('Email dan token diperlukan.');
    }

    $listToken = [];
    $listToken[$email] = $token;

    $payload = [
        'action' => 'listinbox',
        'listToken' => $listToken,
        'fbToken' => null
    ];

    $response = makeRequest($payload);
    
    $messages = [];
    if (isset($response['data'][$email]['data']) && is_array($response['data'][$email]['data'])) {
        $inboxData = $response['data'][$email]['data'];
        foreach ($inboxData as $key => $msg) {
            // Ambil body message jika ada
            $body = '';
            if (isset($msg['body'])) {
                $body = $msg['body'];
            } elseif (isset($msg['text'])) {
                $body = $msg['text'];
            } elseif (isset($msg['html'])) {
                $body = strip_tags($msg['html']);
            }
            
            $messages[] = [
                'id' => $msg['id'],
                'uuid' => $msg['uuid'],
                'subject' => $msg['subject'],
                'sender_name' => $msg['sender_name'],
                'sender_email' => $msg['sender_email'],
                'body' => $body,
                'read' => $msg['read'] == 1,
                'receive_time' => $msg['receive_time'],
                'sort' => $msg['sort']
            ];
        }
    }

    return [
        'success' => true,
        'data' => [
            'email' => $email,
            'total_messages' => count($messages),
            'messages' => $messages
        ]
    ];
}

function getFullMessage($email, $token, $uuid) {
    $listToken = [];
    $listToken[$email] = $token;

    $payload = [
        'action' => 'getmessage',
        'listToken' => $listToken,
        'uuid' => $uuid,
        'fbToken' => null
    ];

    $response = makeRequest($payload);
    
    if (isset($response['data'][$email])) {
        $msg = $response['data'][$email];
        return [
            'subject' => $msg['subject'] ?? '',
            'sender_name' => $msg['sender_name'] ?? '',
            'sender_email' => $msg['sender_email'] ?? '',
            'body' => $msg['body'] ?? $msg['text'] ?? '',
            'html' => $msg['html'] ?? '',
            'received_at' => $msg['receive_time'] ?? ''
        ];
    }
    
    return null;
}

function getAllDomains() {
    $payload = [
        'action' => 'newemail',
        'list_domain' => 1,
        'fbToken' => null,
        'curentToken' => getCurrentToken()
    ];

    $response = makeRequest($payload);
    
    if ($response['msg'] === 'choose_domain' && isset($response['data']) && count($response['data']) > 0) {
        return $response['data'];
    }
    
    throw new Exception('Gagal mendapatkan domain list');
}

function createEmail($domainToken) {
    $payload = [
        'action' => 'newemail',
        'curentToken' => getCurrentToken(),
        'choose_domain' => $domainToken,
        'cf_turnstile_response' => '',
        'fbToken' => null
    ];

    $response = makeRequest($payload);
    
    if ($response['msg'] === 'ok' && isset($response['email'])) {
        return $response;
    }
    
    throw new Exception($response['msg'] ?? 'erroremail');
}

function getCurrentToken() {
    global $currentToken;
    
    if ($currentToken) {
        return $currentToken;
    }
    
    $payload = [
        'action' => 'newemail',
        'list_domain' => 1,
        'fbToken' => null
    ];

    $response = makeRequest($payload);
    
    if ($response['msg'] === 'choose_domain' && isset($response['data'][0]['token'])) {
        $currentToken = $response['data'][0]['token'];
        return $currentToken;
    }
    
    throw new Exception('Gagal mendapatkan current token');
}

function makeRequest($payload) {
    $jsonPayload = json_encode($payload);
    
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Accept: application/json, text/plain, */*',
                'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Origin: https://tmailor.com',
                'Referer: https://tmailor.com/',
                'Cookie: PHPSESSID=' . uniqid() . '; tmailor_session=' . md5(time()),
                'Content-Length: ' . strlen($jsonPayload)
            ],
            'content' => $jsonPayload,
            'timeout' => 30,
            'ignore_errors' => true
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ];
    
    $context = stream_context_create($options);
    $response = @file_get_contents('https://' . API_URL . API_PATH, false, $context);
    
    if ($response === false) {
        throw new Exception('Gagal konek ke server.');
    }
    
    $data = json_decode($response, true);
    if ($data === null) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }
    
    return $data;
}

function extractOTP($text) {
    // Cari berbagai format OTP
    $patterns = [
        '/\b(\d{4,6})\b/',  // 4-6 digit angka
        '/code[:\s]*(\d{4,6})/i',
        '/otp[:\s]*(\d{4,6})/i',
        '/kode[:\s]*(\d{4,6})/i',
        '/verifikasi[:\s]*(\d{4,6})/i',
        '/verification code[:\s]*(\d{4,6})/i',
        '/pin[:\s]*(\d{4,6})/i'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $text, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function extractVerificationLink($text) {
    // Cari link verifikasi
    $patterns = [
        '/https?:\/\/[^\s]+verify[^\s]*/i',
        '/https?:\/\/[^\s]+confirmation[^\s]*/i',
        '/https?:\/\/[^\s]+verification[^\s]*/i',
        '/https?:\/\/[^\s]+activate[^\s]*/i'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $text, $matches)) {
            return $matches[0];
        }
    }
    return null;
}

function displayEmailContent($email, $token, $message) {
    echo "\n";
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║                    📩 DETAIL EMAIL                         ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n";
    echo "📧 Email: {$email}\n";
    echo "📌 Subject: {$message['subject']}\n";
    echo "👤 From: {$message['sender_name']} <{$message['sender_email']}>\n";
    echo "🕐 Time: " . date('Y-m-d H:i:s', $message['receive_time']) . "\n";
    echo "──────────────────────────────────────────────────────────────\n";
    
    // Tampilkan body
    $body = $message['body'];
    if (empty($body)) {
        // Coba ambil full message
        $fullMsg = getFullMessage($email, $token, $message['uuid']);
        if ($fullMsg) {
            $body = $fullMsg['body'];
            if (!empty($fullMsg['html'])) {
                $body .= "\n\n[HTML Content tersedia]";
            }
        }
    }
    
    if (!empty($body)) {
        echo "📝 Isi Email:\n";
        echo "──────────────────────────────────────────────────────────────\n";
        echo $body . "\n";
        echo "──────────────────────────────────────────────────────────────\n";
        
        // Extract OTP
        $otp = extractOTP($body);
        if ($otp) {
            echo "\n✅ KODE OTP DITEMUKAN!\n";
            echo "╔════════════════════════════════════════════════════════════╗\n";
            echo "║  🔑 KODE OTP: {$otp}                                       ║\n";
            echo "╚════════════════════════════════════════════════════════════╝\n";
        }
        
        // Extract verification link
        $link = extractVerificationLink($body);
        if ($link) {
            echo "\n🔗 LINK VERIFIKASI DITEMUKAN!\n";
            echo "──────────────────────────────────────────────────────────────\n";
            echo $link . "\n";
            echo "──────────────────────────────────────────────────────────────\n";
        }
    } else {
        echo "⚠️  Tidak ada isi email (mungkin HTML-only).\n";
    }
    
    echo "\n";
}

function waitForOTP($email, $token, $maxWait = MAX_WAIT) {
    $startTime = time();
    $lastCount = 0;
    $checkedUUIDs = [];
    
    echo "\n⏳ Menunggu email masuk... (maksimal {$maxWait} detik)\n";
    echo "📧 Email: {$email}\n";
    echo "🔄 Cek setiap 5 detik. Press Ctrl+C untuk batal.\n\n";
    
    while (time() - $startTime < $maxWait) {
        $remaining = $maxWait - (time() - $startTime);
        echo "\r⏱️  Sisa waktu: {$remaining} detik  ";
        
        try {
            $result = checkInbox($email, $token);
            
            if ($result['success'] && $result['data']['total_messages'] > 0) {
                $messages = $result['data']['messages'];
                
                // Cek email baru
                foreach ($messages as $msg) {
                    if (!in_array($msg['uuid'], $checkedUUIDs)) {
                        $checkedUUIDs[] = $msg['uuid'];
                        
                        echo "\n\n📩 Email baru masuk!\n";
                        displayEmailContent($email, $token, $msg);
                        
                        // Cek OTP
                        $otp = extractOTP($msg['body'] . ' ' . ($msg['subject'] ?? ''));
                        if ($otp) {
                            return [
                                'otp' => $otp,
                                'message' => $msg
                            ];
                        }
                        
                        // Cek link
                        $link = extractVerificationLink($msg['body'] . ' ' . ($msg['subject'] ?? ''));
                        if ($link) {
                            return [
                                'link' => $link,
                                'message' => $msg
                            ];
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // Skip error
        }
        
        sleep(5);
    }
    
    echo "\n\n⏰ Waktu habis! Tidak ada email masuk dalam {$maxWait} detik.\n";
    return null;
}

function main() {
    echo "\n";
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║     TMAILOR AUTO OTP & VERIFICATION LINK GENERATOR        ║\n";
    echo "║     Author: BINTANG                                       ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n\n";
    
    $running = true;
    $counter = 1;
    
    while ($running) {
        try {
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo "📌 Generate email ke-{$counter}\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            
            $result = generateEmail();
            
            if (!$result['success']) {
                echo "❌ Gagal generate email!\n";
                break;
            }
            
            $email = $result['data']['email'];
            $token = $result['data']['access_token'];
            
            echo "✅ Email berhasil dibuat!\n";
            echo "📧 Email: {$email}\n";
            echo "🔑 Token: " . substr($token, 0, 30) . "...\n";
            
            // Tunggu email
            $result = waitForOTP($email, $token);
            
            if ($result) {
                if (isset($result['otp'])) {
                    echo "\n🎯 GUNAKAN KODE INI UNTUK VERIFIKASI:\n";
                    echo "╔════════════════════════════════════════════════════════════╗\n";
                    echo "║  🔑 {$result['otp']}                                         ║\n";
                    echo "╚════════════════════════════════════════════════════════════╝\n";
                }
                
                if (isset($result['link'])) {
                    echo "\n🔗 ATAU BUKA LINK INI:\n";
                    echo "──────────────────────────────────────────────────────────────\n";
                    echo $result['link'] . "\n";
                    echo "──────────────────────────────────────────────────────────────\n";
                }
            }
            
            $counter++;
            
            // Tanya mau lanjut atau stop
            echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo "❓ Generate email lagi? (y/n): ";
            $input = trim(fgets(STDIN));
            
            if (strtolower($input) !== 'y' && strtolower($input) !== 'yes') {
                $running = false;
                echo "\n👋 Terima kasih telah menggunakan Tmailor!\n";
                echo "   Total email digenerate: " . ($counter - 1) . "\n\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
            echo "   Coba lagi...\n\n";
            sleep(2);
        }
    }
}

if (php_sapi_name() === 'cli') {
    main();
}
?>