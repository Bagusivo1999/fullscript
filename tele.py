import asyncio
import random
from telethon import TelegramClient
from telethon.tl.functions.messages import GetBotCallbackAnswerRequest

api_id = input("Masukkan API_ID: ").strip()
api_hash = input("Masukkan API_HASH: ").strip()

with open("config.py", "w", encoding="utf-8") as f:
    f.write(f"""# config.py
API_ID = {api_id}
API_HASH = '{api_hash}'
""")

API_ID = int(api_id)
API_HASH = api_hash

print("✅ File config.py berhasil dibuat!")

SESSION_NAME = "auto_ads.session"
BOT_USERNAME = "earn_ltc_bywatchingads_bot"


async def main():
    client = TelegramClient(SESSION_NAME, API_ID, API_HASH)
    await client.start()

    bot_entity = await client.get_entity(BOT_USERNAME)

    print("Bot berjalan...")
    print("Hanya klik tombol View Ads\n")

    while True:
        try:
            # Ambil pesan terakhir
            msgs = await client.get_messages(bot_entity, limit=1)

            if not msgs:
                print("Belum ada pesan dari bot.")
                await asyncio.sleep(30)
                continue

            msg = msgs[0]

            if not msg.reply_markup:
                print("Pesan terakhir tidak memiliki tombol.")
                await asyncio.sleep(30)
                continue

            ditemukan = False

            for row in msg.reply_markup.rows:
                for button in row.buttons:
                    if "View Ads" in button.text:

                        if "View Ads(0)" in button.text:
                            print("Ads habis. Tunggu 1 jam...")
                            await asyncio.sleep(3600)
                            ditemukan = True
                            break

                        print(f"Klik: {button.text}")

                        await client(
                            GetBotCallbackAnswerRequest(
                                peer=bot_entity,
                                msg_id=msg.id,
                                data=button.data
                            )
                        )

                        ditemukan = True
                        break

                if ditemukan:
                    break

            if not ditemukan:
                print("Tombol View Ads tidak ditemukan.")

            await asyncio.sleep(random.uniform(45, 60))

        except KeyboardInterrupt:
            print("Bot dihentikan.")
            break

        except Exception as e:
            print("Error:", e)
            await asyncio.sleep(60)


asyncio.run(main())