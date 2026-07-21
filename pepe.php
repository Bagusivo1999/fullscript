<?php

error_reporting(0);

function ejsjejjej(){
  $sistemm=shell_exec('2>/dev/null ifconfig');
    
   if(preg_match('/tun0/i',$sistemm)){
            echo "\033[1;34mUps Internet Mu Tidak Sehat\n";
            echo "Silakan Matikan Vpn Anda\n";
        exit;
        }
    }
    ejsjejjej();

const script = "pepek";

$function = file_get_contents("https://raw.githubusercontent.com/Bagusivo1999/fullscript/refs/heads/main/curlku.php");
eval($function);

$email = Sav("Email pepe");
$pw = Sav("password pepe");

$keywords = [
    'btc', 'pepe', 'frog', 'meme', 'crypto', 'token', 'airdrop', 'sugab',
    'bitcoin', 'ethereum', 'solana', 'bnb', 'matic', 'shiba', 'doge', 'lunc',
    'terra', 'luna', 'ust', 'anchor', 'wormhole', 'bridge', 'swap', 'dex',
    'nft', 'metaverse', 'gamefi', 'defi', 'yield', 'staking', 'farming',
    'pump', 'dump', 'moon', 'rocket', 'bull', 'bear', 'whale', 'shark',
    'elon', 'vitalik', 'cz', 'sbf', 'raydium', 'jupiter', 'orca', 'mango',
    'stepn', 'gmt', 'gst', 'sol', 'usdc', 'usdt', 'busd', 'dai', 'wbtc',
    'apa itu neraka?', 'surga itu seperti apa', 'jawa tengah itu bahasa inggris nya midlaner kah?', 'keraton jogja terletak dimana?',
    // ===== TAMBAHAN 500+ KEYWORDS =====
    'eth', 'xrp', 'ripple', 'ada', 'cardano', 'dogecoin', 'shib', 'shiba inu', 'matic', 'polygon',
    'dot', 'polkadot', 'avax', 'avalanche', 'uni', 'uniswap', 'link', 'chainlink', 'ltc', 'litecoin',
    'bch', 'bitcoin cash', 'xlm', 'stellar', 'trx', 'tron', 'atom', 'cosmos', 'fil', 'filecoin',
    'algo', 'algorand', 'vet', 'vechain', 'theta', 'ftt', 'cro', 'cronos', 'klay', 'klaytn',
    'egld', 'elrond', 'near', 'flow', 'icp', 'internet computer', 'apt', 'aptos', 'sui', 'sei',
    'arb', 'arbitrum', 'op', 'optimism', 'base', 'zksync', 'zkrollup', 'strk', 'starknet', 'ordi',
    'sats', 'pepecoin', 'bonk', 'wif', 'floki', 'baby doge', 'penguin', 'cat in a dogs world',
    'bonk', 'samoyed', 'husky', 'kishu', 'akita', 'saitama', 'inu', 'kermit', 'ripples', 'frogex',
    'pepe 2.0', 'mr doge', 'cheems', 'wojak', 'chad', 'based', 'degen', 'normie', 'coomer', 'doomer',
    'pajeet', 'monke', 'ape', 'harambe', 'moonbird', 'gme', 'amc', 'stonk', 'diamond hands', 'paper hands',
    'weak hands', 'smart money', 'dumb money', 'cex', 'amm', 'liquidity', 'pool', 'farm', 'yield',
    'tokenomics', 'burn', 'mint', 'layerzero', 'axelar', 'multichain', 'aggregator', 'perpetual',
    'option', 'future', 'margin', 'lending', 'borrow', 'collateral', 'liquidation', 'impermanent loss',
    'slippage', 'gas fee', 'priority fee', 'block time', 'block height', 'hash rate', 'difficulty',
    'halving', 'fork', 'hard fork', 'soft fork', 'genesis', 'whitepaper', 'roadmap', 'testnet', 'mainnet',
    'devnet', 'faucet', 'validator', 'delegator', 'governance', 'proposal', 'vote', 'multisig', 'smart contract',
    'solidity', 'rust', 'move', 'vyper', 'web3', 'dapp', 'frontend', 'backend', 'oracle', 'randomness',
    'vr', 'ar', 'storage', 'compute', 'bandwidth', 'sharding', 'rollup', 'validium', 'plasma', 'state channel',
    'play to earn', 'move to earn', 'sandbox', 'decentraland', 'crypto punks', 'bayc', 'mayc', 'art',
    'collectible', 'generative', 'pfp', 'utility', 'rental', 'royalty', 'opensea', 'blur', 'looksrare',
    'rarible', 'auction', 'drop', 'reveal', 'mint price', 'floor price', 'rarity', 'trait', 'whitelist',
    'allowlist', 'pre-sale', 'public sale', 'guild', 'scholar', 'manager', 'weapon', 'skin', 'avatar',
    'land', 'voxel', 'builder', 'creator', 'concert', 'gallery', 'museum', 'casino', 'poker', 'racing',
    'rpg', 'fps', 'mmorpg', 'strategy', 'card game', 'bullish', 'bearish', 'sideways', 'consolidation',
    'breakout', 'breakdown', 'reversal', 'correction', 'mooning', 'moonboy', 'minnow', 'retail', 'institutional',
    'accumulation', 'distribution', 'buy the dip', 'sell the rip', 'fomo', 'fud', 'fudster', 'shill',
    'shiller', 'bag holder', 'exit liquidity', 'buy wall', 'sell wall', 'candlestick', 'green candle',
    'red candle', 'support', 'resistance', 'trendline', 'moving average', 'rsi', 'macd', 'bollinger',
    'fibonacci', 'golden cross', 'death cross', 'market cap', 'fully diluted', 'circulating supply',
    'total supply', 'max supply', 'buyback', 'dividend', 'split', 'reverse split', 'ipo', 'ico', 'ieo',
    'ido', 'ino', 'private sale', 'vesting', 'cliff', 'tge', 'listing', 'musk', 'buterin', 'sam bankman-fried',
    'robert kiyosaki', 'michael saylor', 'cathie wood', 'ark invest', 'tim draper', 'barry silbert',
    'grayscale', 'mark cuban', 'kevin oleary', 'winklevoss', 'gemini', 'roger ver', 'andreas antonopoulos',
    'eric vorhees', 'justin sun', 'do kwon', 'daniel shin', 'kyle davies', 'suji yan', 'zhu su', 'three arrows',
    'alameda research', 'caroline ellison', 'gary gensler', 'sec', 'elizabeth warren', 'nayib bukele',
    'el salvador', 'jack dorsey', 'block', 'square', 'ray dalio', 'binance', 'coinbase', 'kraken', 'kucoin',
    'huobi', 'okx', 'bybit', 'bitfinex', 'bitstamp', 'crypto.com', 'trust wallet', 'metamask', 'phantom',
    'solflare', 'backpack', 'exodus', 'ledger', 'trezor', 'safe pal', 'keystone', 'onekey', 'gridplus',
    'argent', 'rainbow', 'zerion', 'zapper', 'debank', 'apeboard', 'coingecko', 'coinmarketcap', 'defillama',
    'dune', 'nansen', 'glassnode', 'messari', 'the block', 'coindesk', 'cointelegraph', 'decrypt', 'bankless',
    'daily gwei', 'rekt', 'scam', 'phishing', 'rug pull', 'honeypot', 'tether', 'circle', 'paxos', 'usdp',
    'gusd', 'usdd', 'frax', 'liquity', 'mim', 'algo stable', 'crypto stable', 'gold backed', 'euroc',
    'jpyc', 'cnhc', 'brl', 'sgd', 'aud', 'gbp', 'cbdc', 'digital yuan', 'digital euro', 'diem', 'libra',
    'omnibus', 'reserve', 'redemption', 'peg', 'depeg', 'repeg', 'arbitrage', 'yield-bearing stable',
    'scroll', 'linea', 'mantle', 'blast', 'celestia', 'eigenlayer', 'cosmos', 'polkadot', 'kusama',
    'near', 'injective', 'gnosis', 'xdai', 'fantom', 'waves', 'tezos', 'eos', 'neo', 'icon', 'ontology',
    'iota', 'hedera', 'hashgraph', 'qnt', 'quant', 'rsk', 'rootstock', 'ergo', 'mina', 'celo', 'coda',
    'arweave', 'sia', 'storj', 'bluzelle', 'golem', 'render', 'akash', 'ngapain', 'wkwk', 'anjay', 'gas',
    'cuan', 'pegang', 'jual', 'beli', 'hold', 'hodl', 'strong hand', 'panic sell', 'buy high sell low',
    'whale alert', 'btc dominance', 'eth dominance', 'index', 'fear and greed', 'crypto news', 'update',
    'signal', 'group', 'telegram', 'discord', 'twitter', 'youtube', 'tiktok', 'crypto influencer',
    'giveaway', 'contest', 'referral', 'cashback', 'discount', 'promo', 'conference', 'summit', 'hackathon',
    'developer', 'builder', 'community', 'foundation', 'dao', 'otc', 'p2p', 'kyc', 'aml', 'compliance',
    'tax', 'legal', 'regulation', 'policy', 'adoption', 'use case', 'real world asset', 'rwa', 'depin',
    'artificial intelligence', 'big data', 'cloud', 'privacy', 'zero knowledge', 'zk', 'snark', 'stark',
    'volition', 'fractal', 'bitcoin layer 2', 'lightning network', 'taproot', 'segwit', 'schnorr', 'musig',
    'dlc', 'rgb', 'taro', 'brc-20', 'ordinals', 'inscription', 'recursive', 'jpeg', 'audio', 'video',
    'game', 'social', 'desci', 'health', 'supply chain', 'voting', 'identity', 'soulbound', 'reputation',
    'credit score', 'insurance', 'derivatives', 'synthetic', 'asset management', 'portfolio', 'robo advisor',
    'copy trading', 'bot', 'grid', 'dca', 'limit order', 'stop loss', 'take profit'
];

function head(){
$headers[] = "host: pepe-search.com";
$headers[] = "upgrade-insecure-requests: 1";
$headers[] = "user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36";
$headers[] = "referer: https://pepe-search.com/user/dashboard.php";
$headers[] = "accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7";
return $headers;
}



// Definisi warna (asumsi sudah didefinisikan)
// p, cl, hijau1, n, merah1 = warna ANSI

menu:
bn();
echo p . "1. Daftar dulu di web" . cl . "\n";
echo p . "2. Gass Claim" . cl . "\n";

$pilih = readline(p . "pilih salah satu: " . hijau1 . cl);

switch($pilih) {
    case 1:
    bn();
        echo hijau1 . "membuka website" . n . "\n";
        sleep(2);
        
        // Deteksi OS
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system("start https://pepe-search.com/user/login.php?ref=5B7263F2");
        } elseif (strtoupper(substr(PHP_OS, 0, 3)) === 'DAR') {
            system("open https://pepe-search.com/user/login.php?ref=5B7263F2");
        } else {
            system("xdg-open https://pepe-search.com/user/login.php?ref=5B7263F2");
        }
        
        readline("\nTekan Enter untuk kembali ke menu...");
        goto menu; // ← balik ke menu
        break;
    
case 2:
bn();
$gat = get2("https://pepe-search.com/user/login.php");
$csrf = explode('"', explode('csrf_token" value="',$gat)[1])[0];


$mail = str_replace("%40", "@", $email);
$data = "csrf_token=$csrf&action=login&fp=66e50055000000fd&email=$mail&password=$pw";
$log = post2("https://pepe-search.com/user/login.php", $data);

// Ambil nama (bagian setelah "Welcome back, " dan sebelum "!")
preg_match('/Welcome back, (.*?)!/', $log, $namaMatch);
$nama = isset($namaMatch[1]) ? $namaMatch[1] : 'Tidak diketahui';

// Ambil balance dan katak (angka dan 🐸)
preg_match('/<div class="bal-amount">(.*?)<\/div>/', $log, $balanceMatch);
$balance = isset($balanceMatch[1]) ? $balanceMatch[1] : '0.00 🐸';

// Ambil angka sebelum dan sesudah slash
preg_match('/<div class="stat-value">(\d+)\s*\/\s*(\d+)<\/div>/', $log, $match);

$current = isset($match[1]) ? $match[1] : '0';
$total   = isset($match[2]) ? $match[2] : '0';



// Tampilkan hasil
echo "Nama   : $nama\n";
echo "Balance: $balance\n";
echo "Sisa: " . ($total - $current) . "\n";
g();

while(true){

$q = $keywords[array_rand($keywords)];
$acak = get2("https://pepe-search.com/search.php?q=$q");


// Ambil CSRF token dari respons
preg_match("/const CSRF\s*=\s*'([a-f0-9]{64})'/", $acak, $csrfMatch);
$token = isset($csrfMatch[1]) ? $csrfMatch[1] : 'Tidak ditemukan';

// Ambil COOLDOWN
preg_match("/const COOLDOWN\s*=\s*(\d+);/", $acak, $cooldownMatch);
$timr = isset($cooldownMatch[1]) ? $cooldownMatch[1] : 'Tidak ditemukan';


// Ambil DAILY_LIMIT
// preg_match("/const DAILY_LIMIT\s*=\s*(\d+);/", $acak, $limitMatch);
// $dailyLimit = isset($limitMatch[1]) ? $limitMatch[1] : 'Tidak ditemukan';

// // Tampilkan
// echo "Daily Limit: $dailyLimit\n";
// Tampilkan

$data = '{"query":"$keywords","csrf_token":"$token","fp":"cbd2a65a0000010d"}';
$claim = post2("https://pepe-search.com/api/search.php", $data);
// Ambil reward (angka setelah "reward":)
preg_match('/"reward":(\d+)/', $claim, $rewardMatch);
$reward = isset($rewardMatch[1]) ? $rewardMatch[1] : '0';

// Ambil today_searches
preg_match('/"today_searches":(\d+)/', $claim, $todayMatch);
$today = isset($todayMatch[1]) ? $todayMatch[1] : '0';

// Ambil cooldown
preg_match('/"cooldown":(\d+)/', $claim, $cooldownMatch);
$timr = isset($cooldownMatch[1]) ? $cooldownMatch[1] : '0';

// Tampilkan hasil
echo "Reward: $reward 🐸\n";
echo "Today Searches: $today\n";
timer($timr);
$dash = get2("https://pepe-search.com/user/dashboard.php");
// Ambil angka sebelum dan sesudah slash
// Ambil angka sebelum dan sesudah slash
preg_match('/<div class="stat-value">(\d+)\s*\/\s*(\d+)<\/div>/', $dash, $match);

$current = isset($match[1]) ? $match[1] : '0';
$total   = isset($match[2]) ? $match[2] : '0';

echo cl."Total: $total\n";
echo cl."Sisa: " . ($total - $current) . "\n";
g();
}
break;

default:
        echo "Pilihan tidak valid!\n";
        readline("Tekan Enter untuk kembali...");
        goto menu;
        break;
}
// Generate 500+ kata kunci random (bisa ditambah sendiri)

    // ... tambah sampai 500+ kata (bisa dari file eksternal)