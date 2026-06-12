# Analisis Tugas 3 – Monitoring BBM Servis Service

## Identitas Layanan

* Nama Service : Monitoring BBM Servis Service
* NIM : 102022400256
* Teknologi : Laravel 11
* Database : SQLite
* Integrasi : SSO Dosen, SOAP XML Audit, RabbitMQ Publisher


# 1. Justifikasi Transaksi Kritis

Transaksi yang dipilih sebagai transaksi kritis adalah proses **penambahan data maintenance kendaraan** melalui endpoint:

```http
POST /api/v1/maintenance
```

Transaksi ini dipilih karena mengubah data operasional kendaraan yang berkaitan dengan batas penggunaan BBM, riwayat servis, serta kupon operasional. Perubahan data tersebut dapat mempengaruhi proses monitoring kendaraan dan pengambilan keputusan operasional.

Karena transaksi ini bersifat **state-changing**, maka setiap perubahan harus:

1. Diautentikasi menggunakan sistem keamanan terpusat (SSO).
2. Dicatat ke sistem audit legacy menggunakan SOAP/XML.
3. Disebarkan ke sistem lain menggunakan RabbitMQ agar sistem lain dapat menerima informasi secara real-time.

Dengan demikian transaksi create maintenance memenuhi kriteria sebagai transaksi kritis yang wajib diaudit dan dipublikasikan.


# 2. Implementasi Federated SSO

Pada implementasi ini aplikasi menggunakan token M2M (Machine to Machine) yang diperoleh dari Cloud Dosen.

Token JWT digunakan untuk:

* Mengakses layanan SOAP Audit.
* Mengakses layanan RabbitMQ Publisher.
* Membuktikan bahwa request berasal dari aplikasi yang terdaftar pada sistem pusat.

Payload JWT yang diterima berisi informasi identitas aplikasi seperti:

* Client ID
* Team
* Nama aplikasi
* Expired time token

Token tersebut digunakan sebagai Bearer Token pada seluruh komunikasi dengan layanan terpusat.


# 3. Implementasi SOAP XML Client

Setelah data maintenance berhasil disimpan ke database, aplikasi akan melakukan transformasi data maintenance ke dalam format XML SOAP Envelope.

Informasi yang dikirim meliputi:

* Team ID
* Activity Name
* Vehicle ID
* Fuel Limit
* Last Service Date

SOAP Audit digunakan untuk mencatat aktivitas bisnis ke sistem audit terpusat yang masih menggunakan protokol SOAP/XML.

Hasil pengujian menunjukkan bahwa aplikasi berhasil mengirim request SOAP Audit dan menerima respons sukses dari server dengan status **SUCCESS** beserta **Receipt Number** sebagai bukti pencatatan audit.



# 4. Implementasi RabbitMQ Publisher

Setelah proses audit berhasil dijalankan, aplikasi melakukan publish event ke RabbitMQ.

Event yang dipublikasikan antara lain:

```json
{
  "event_name": "maintenance.created",
  "service_name": "Monitoring BBM Servis",
  "team": "TEAM-07",
  "vehicle_id": "K005",
  "fuel_limit": 10000
}
```

Tujuan pengiriman event ini adalah agar sistem lain dapat mengetahui adanya penambahan data maintenance secara asynchronous tanpa harus melakukan request langsung ke service.

Hasil implementasi menunjukkan bahwa event berhasil diterima oleh RabbitMQ Server dengan status HTTP 200 dan tampil pada Message Board Cloud Dosen.


# 5. Sequence Diagram

User
 |
 | POST /api/v1/maintenance
 v
Monitoring BBM API
 |
 | Simpan data maintenance
 v
Database
 |
 | Data berhasil disimpan
 v
Monitoring BBM API
 |
 | SOAP Audit Request
 v
SOAP Audit Service
 |
 | SOAP Success
 v
Monitoring BBM API
 |
 | Publish maintenance.created
 v
RabbitMQ Server
 |
 | Publish Success
 v
Monitoring BBM API


# 6. Hasil Implementasi

Implementasi Tugas 3 berhasil memenuhi kebutuhan integrasi yang ditentukan pada layanan Monitoring BBM Servis Service.

Capaian yang berhasil diselesaikan:

* Federated SSO menggunakan JWT dari Cloud Dosen.
* Integrasi SOAP XML Client untuk audit transaksi maintenance.
* Integrasi RabbitMQ Publisher untuk event notification.
* Implementasi transaksi kritis pada endpoint POST /api/v1/maintenance.
* Pengiriman SOAP Audit dilakukan otomatis setelah data maintenance berhasil dibuat.
* Publish event RabbitMQ dilakukan otomatis setelah proses audit selesai.
* SOAP Audit berhasil memperoleh status SUCCESS dari server pusat.
* Event maintenance.created berhasil diterima oleh RabbitMQ Message Board.

Dengan demikian layanan Monitoring BBM Servis Service telah berhasil terintegrasi dengan infrastruktur terpusat yang disediakan.