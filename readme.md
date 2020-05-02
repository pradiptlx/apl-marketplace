1. Aplikasi ini dibangun mengunakan Phalcon 3.4.5, dan Mysql.
2. Install Phalcon https://phalcon.io/en-us
3. Run database.sql
4. Konfigurasi web server, telah disediakan file conf nginx idy.conf, ubah root folder dan server_name sesuai kebutuhan, konfigurasi /etc/hosts sesuai kebutuhan jika menggunakan local dns
4. copy .env.example ke .env dan isi parameter sesuai kebutuhan. use case rate idea akan mengirim email, gunakan maltrap.io untuk development dan lengkapi parameter smtp pada .env.
5. run composer install
6. buka uri pada web browser. project ini menggunakan uri http://idy.local

APL 2020
