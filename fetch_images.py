import urllib.request
import json
import re
import os
import sys
import mysql.connector

# Connect to database
try:
    conn = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="siswamart"
    )
    cursor = conn.cursor(dictionary=True)
except Exception as e:
    print(f"Error connecting to database: {e}")
    sys.exit(1)

products = [
    {"id": 4, "query": "spicy chips snack", "slug": "keripik-tempe-balado"},
    {"id": 5, "query": "fried banana chocolate", "slug": "pisang-coklat-crispy"},
    {"id": 6, "query": "iced tea glass", "slug": "es-teh-manis-jumbo"},
    {"id": 7, "query": "avocado smoothie green", "slug": "jus-alpukat-susu"},
    {"id": 8, "query": "chocolate pudding dessert", "slug": "puding-coklat-oreo"},
    {"id": 9, "query": "homemade ice cream bowl", "slug": "es-krim-homemade"},
    {"id": 10, "query": "matcha bubble tea boba", "slug": "boba-matcha-susu"}
]

base_dir = "c:/laragon/www/siswamart/storage/app/public/produk"
os.makedirs(base_dir, exist_ok=True)

import ssl
ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

for p in products:
    print(f"Searching for {p['query']}...")
    url = f"https://unsplash.com/napi/search/photos?query={urllib.parse.quote(p['query'])}&per_page=1"
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        response = urllib.request.urlopen(req, context=ctx)
        data = json.loads(response.read().decode('utf-8'))
        if data['results']:
            photo_url = data['results'][0]['urls']['regular']
            print(f"Found image: {photo_url}")
            
            # Download image
            img_filename = f"{p['slug']}.jpg"
            img_path = os.path.join(base_dir, img_filename)
            print(f"Downloading to {img_path}...")
            
            img_req = urllib.request.Request(photo_url, headers={'User-Agent': 'Mozilla/5.0'})
            img_res = urllib.request.urlopen(img_req, context=ctx)
            with open(img_path, 'wb') as f:
                f.write(img_res.read())
            
            # Update DB
            db_path = f"produk/{img_filename}"
            cursor.execute("UPDATE produk SET foto_utama = %s WHERE id = %s", (db_path, p['id']))
            conn.commit()
            print(f"Updated DB for ID {p['id']}")
        else:
            print(f"No results found for {p['query']}")
    except Exception as e:
        print(f"Error fetching/downloading for {p['query']}: {e}")

cursor.close()
conn.close()
print("Done!")
