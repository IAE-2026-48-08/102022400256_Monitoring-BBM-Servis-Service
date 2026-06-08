# PROMPT LOG AI

Nama : Dimas Chairul Anam

NIM : 102022400256

Judul Project : Monitoring BBM Servis Service

AI Tool : ChatGPT

## Prompt 1 – Perancangan REST API
Buatkan REST API sederhana menggunakan Laravel untuk sistem Monitoring BBM dan Servis Kendaraan. Endpoint minimal yang harus tersedia adalah:

* GET /api/v1/maintenance
* GET /api/v1/maintenance/{id}
* POST /api/v1/maintenance

Gunakan SQLite dan format response JSON yang konsisten.

### Hasil Pemanfaatan
Prompt ini digunakan sebagai referensi awal dalam merancang struktur service, model Maintenance, migration database, route API, serta controller yang digunakan untuk mengelola data maintenance kendaraan.


## Prompt 2 – Desain Database
Buatkan struktur tabel maintenance untuk menyimpan data monitoring servis kendaraan yang berisi vehicle_id, fuel_limit, last_service_date, operational_coupon, dan notes.

### Hasil Pemanfaatan
Prompt digunakan sebagai referensi dalam pembuatan migration dan penentuan atribut yang diperlukan untuk menyimpan data monitoring BBM dan servis kendaraan.


## Prompt 3 – Implementasi API Key
Bagaimana cara membuat middleware API Key pada Laravel menggunakan header X-IAE-KEY sehingga setiap endpoint hanya dapat diakses apabila API Key valid

### Hasil Pemanfaatan
Prompt digunakan untuk membuat middleware CheckIAEKey yang bertugas melakukan validasi API Key sesuai ketentuan kontrak integrasi yang diberikan pada tugas.


## Prompt 4 – Standarisasi Response JSON
Buatkan contoh response JSON yang konsisten untuk REST API menggunakan format:

* status
* message
* data
* meta (opsional)

### Hasil Pemanfaatan
Prompt digunakan sebagai referensi agar seluruh endpoint REST API menghasilkan format response yang seragam dan mudah digunakan oleh service lain.


## Prompt 5 – Dokumentasi Swagger
Bagaimana cara mengintegrasikan L5 Swagger ke Laravel dan membuat dokumentasi endpoint GET dan POST menggunakan anotasi OpenAPI.

### Hasil Pemanfaatan
Prompt digunakan sebagai panduan dalam instalasi package L5 Swagger, konfigurasi dokumentasi API, serta penulisan anotasi endpoint pada controller.


## Prompt 6 – Implementasi GraphQL
Bagaimana cara menambahkan GraphQL menggunakan Lighthouse pada Laravel serta membuat query untuk menampilkan seluruh data maintenance dan data maintenance berdasarkan ID.

### Hasil Pemanfaatan
Prompt digunakan sebagai referensi implementasi GraphQL schema dan pengujian query GraphQL terhadap data maintenance yang tersimpan di database.


## Prompt 7 – Pengujian Endpoint
Berikan contoh pengujian REST API menggunakan Thunder Client untuk endpoint GET, POST, dan endpoint yang menggunakan API Key.

### Hasil Pemanfaatan
Prompt digunakan sebagai panduan dalam melakukan pengujian endpoint dan memastikan seluruh fitur berjalan sesuai kebutuhan.


## Prompt 8 – Penyusunan README
Buatkan README.md sederhana untuk project Laravel yang menggunakan REST API, Swagger, GraphQL, SQLite, dan API Key Authentication.

### Hasil Pemanfaatan
Prompt digunakan untuk membantu penyusunan dokumentasi proyek agar mudah dipahami dan dijalankan oleh pengguna lain.


## Prompt 9 – Debugging Error
Bantu analisis dan perbaiki error yang muncul saat konfigurasi Swagger, GraphQL, route API, dan middleware pada Laravel.

### Hasil Pemanfaatan
Prompt digunakan sebagai bantuan troubleshooting selama proses pengembangan hingga seluruh fitur dapat berjalan dengan baik.


## Kesimpulan

Pemanfaatan AI pada proyek ini berfungsi sebagai asisten pembelajaran dan referensi teknis dalam proses pengembangan service. AI digunakan untuk membantu memahami konsep REST API, middleware API Key, Swagger, GraphQL, desain database, dokumentasi, serta proses debugging. Seluruh implementasi, konfigurasi, pengujian, dan validasi akhir tetap dilakukan secara mandiri.
