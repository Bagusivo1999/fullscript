import asyncio
import re
import random
from config import API_ID, API_HASH
from telethon import TelegramClient
from telethon.tl.functions.messages import GetBotCallbackAnswerRequest
from telethon.errors import TimeoutError, MessageIdInvalidError

SESSION_NAME = 'auto_ads.session'
BOT_USERNAME = 'earn_ltc_bywatchingads_bot'

async def sleep_timer(seconds, label="Jeda"):
    """Versi sleep doang, gak pake animasi"""
    mins, secs = divmod(int(seconds), 60)
    print(f"{label}: {mins:02d}:{secs:02d} - tidur dulu zzz")
    await asyncio.sleep(seconds)

async def click_with_retry(client, bot_entity, msg, button):
    for i in range(3):
        try:
            await client(GetBotCallbackAnswerRequest(
                peer=bot_entity,
                msg_id=msg.id,
                data=button.data
            ), timeout=25)
            return True, 0
        except TimeoutError:
            print(f" Timeout ke-{i+1}/3...")
            await asyncio.sleep(random.uniform(4, 7))
        except MessageIdInvalidError:
            print(" Msg ID kadaluarsa")
            return False, 0
    return False, 3

async def main():
    client = TelegramClient(SESSION_NAME, API_ID, API_HASH)
    await client.start()
    bot_entity = await client.get_entity(BOT_USERNAME)

    timeout_count = 0
    ads_claimed = 0

    print("Mode Human ON - Versi Sleep\nCtrl+C buat stop\n")

    while True:
        try:
            if timeout_count >= 3:
                print("\n!!! 3x Timeout berturut-turut")
                print("Bot lagi marah. Cooldown 10 menit...")
                await sleep_timer(600, "Cooldown")
                timeout_count = 0
                print("Lanjut lagi...\n")

            sleep_before = random.uniform(38, 52)
            await sleep_timer(sleep_before, "Sebelum /start")

            await client.send_message(bot_entity, '/start')
            await asyncio.sleep(random.uniform(3.5, 6.5))

            msg = await client.get_messages(bot_entity, limit=1)
            if not msg or not msg[0].reply_markup:
                await asyncio.sleep(40)
                continue
            msg = msg[0]

            clicked = False
            for row in msg.reply_markup.rows:
                for button in row.buttons:
                    if 'View Ads' in button.text:
                        if 'View Ads(0)' in button.text:
                            print("Ads habis. Tidur 1 jam...")
                            await sleep_timer(3600, "Tunggu reset")
                            break

                        print(f"Klik: {button.text}")
                        success, timeouts = await click_with_retry(client, bot_entity, msg, button)

                        if success:
                            timeout_count = 0
                            ads_claimed += 1
                            clicked = True
                        else:
                            timeout_count = timeouts
                            print(f"Timeout streak: {timeout_count}/3")
                        break
                if clicked or timeout_count >= 3:
                    break

            await asyncio.sleep(random.uniform(5, 8))
            new_msgs = await client.get_messages(bot_entity, limit=2, min_id=msg.id)
            for m in new_msgs:
                if m.text and "You've got" in m.text:
                    got = re.search(r"You've got ([\d.]+) LTC", m.text)
                    bal = re.search(r"Balance:\s*([\d.]+) LTC", m.text)
                    if got: print(f"✅ You got {got.group(1)} LTC")
                    if bal: print(f"💰 Balance: {bal.group(1)} LTC")
                    print(f"Total klaim: {ads_claimed}")
                    print("-" * 30)

            sleep_after = random.uniform(42, 58)
            await sleep_timer(sleep_after, "Sebelum loop")

        except KeyboardInterrupt:
            print("\nStop manual. Bye!")
            break
        except Exception as e:
            print("Error:", e)
            await asyncio.sleep(60)

asyncio.run(main())