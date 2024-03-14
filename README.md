<div align="center">
    <img src="https://user-images.githubusercontent.com/49023326/157672798-bc59f465-4dc2-40d5-bd46-3de39d16cf2a.png" width=300px>

</div>
<hr>
<h3>System Requirements</h3>
<b><font color="red">Perhatian!: Aplikasi ini belum dioptimasi untuk PHP 8 keatas, jika dipaksakan maka akan muncul error</font></b>

1. PHP min versi 7.4 dan < 8 with extensions: 
    - BCMath PHP Extension
    - Ctype PHP Extension
    - Fileinfo PHP extension
    - JSON PHP Extension
    - Mbstring PHP Extension
    - OpenSSL PHP Extension
    - PDO PHP Extension
    - Tokenizer PHP Extension
    - XML PHP Extension
    - PHP cURL extension
2. MySQL Database
3. Composer minimum versi 2
4. RAM minimum 512MB recommended >= 1 GB
5. CPU Minimum 1 Core recommended >= 2 core
6. Penyimpanan bebas Minimum 1 GB (untuk menyimpan log aplikasi, file pengguna, session,cache, dll)
7. Inodes minimal 35.000 jika menggunakan unlimited hosting

<h3>Cara Install</h3>

1. Clone dari master  ``git clone https://github.com/indihealth-2022/indihealth-monitoring-v3``

2. Buka folder projek (jika di linux gunakan perintah ``cd lokasi-projek``) tersebut lalu buka cmd

3. Jalankan perintah ``composer install``

4. jalankan perintah ``copy .env.example .env``

5. buka file ``.env`` lakukan konfigurasi username, password, dan database sesuai dengan pengaturan database anda

6. jalankan perintah ``php artisan key:generate``  pada terminal

7. jalankan perintah ``php artisan migrate``

8. jalankan perintah ``php artisan db:seed --class=RolesSeed``

9. jalankan perintah ``php artisan db:seed --class=JabatanSeed``

10. jalankan perintah ``php artisan db:seed --class=SuperAdminSeeder``

11. jalankan perintah ``php artisan serve`` **(Lewati langkah ini jika diinstalasi pada server production)**
12. Jika anda di server / Hosting arahkan domain ke directory ``project_name/public``

12. buka browser lalu buka http://localhost:8000 (khusus Local dev)

13. Login menggunakan akun 
    ``Email : superadmin@indihealth.com``
    ``Kata Sandi : idhMonitoring@123#``
14. Setelah login anda akan diminta oleh aplikasi untuk mengubah kata sandi.


**Note**: Untuk server production mohon untuk mengubah data di file .env ini<br>
``APP_NAME=Laravel menjadi APP_NAME=Nama Perusahaan``<br>
``APP_ENV=local menjadi APP_ENV=production``<br>
``APP_DEBUG=true menjadi APP_DEBUG=false``

    <hr>
    https://github.com/irfaardy
    Irfa Ardiansyah (irfa.backend@protonmail.com)


