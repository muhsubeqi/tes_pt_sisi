<h2>Cara Menggunakan</h2>

clone terlebih dahulu

```bash
$ git clone https://github.com/muhsubeqi/tes_pt_sisi.git
```

lalu setting .env sesuai nama database, username, password

```bash
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

<h3>Buka terminal</h3>
ketik kan perintah dibawah ini di terminal

```bash
composer update
```

```bash
php artisan key:generate
```

```bash
php artisan migrate --seed
```

jika sudah dilakukan semua langkah terakhir yaitu jalankan dengan ketik perintah berikut

```bash
php artisan service
```

note: jika anda menggunakan xampp, aktifkan terlebih dahulu APACHE dan MySQL

<hr>

<h4>AKSES</h4>

Username : admin@gmail.com

Password : admin123
