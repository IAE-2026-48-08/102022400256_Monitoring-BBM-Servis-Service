# Prompt Log AI – Tugas 3 Integrasi Aplikasi Enterprise

## Informasi Mahasiswa

* Nama Service : Monitoring BBM Servis Service
* NIM : 102022400256
* Mata Kuliah : Integrasi Aplikasi Enterprise
* Tugas : Tugas 3 – SOAP XML Audit dan RabbitMQ Publisher

## Prompt 1 – Implementasi Federated SSO

### Prompt

Bagaimana cara mendapatkan token M2M dari Cloud Dosen menggunakan API Key yang diberikan?

### Hasil

Berhasil memperoleh JWT Token menggunakan API Key yang diberikan dosen dan memahami penggunaan token sebagai Bearer Authentication pada layanan SOAP dan RabbitMQ.


## Prompt 2 – Integrasi SOAP XML Client

### Prompt

Bagaimana cara mengirim SOAP XML menggunakan Laravel Http Client dan membuat XML Envelope yang sesuai dengan format yang diminta server?

### Hasil

Berhasil membuat SOAP Envelope XML dan mengirimkan Audit Request ke layanan SOAP Cloud Dosen menggunakan Laravel Http Client.


## Prompt 3 – Debugging SOAP Audit

### Prompt
Mengapa SOAP Audit menghasilkan status 400 dan bagaimana cara memperbaiki struktur XML yang dikirim?

### Hasil
Berhasil mengidentifikasi kesalahan pada struktur XML, memperbaiki field yang diperlukan, dan memperoleh response SUCCESS dari server SOAP.


## Prompt 4 – Integrasi RabbitMQ Publisher

### Prompt
Bagaimana cara mengirim event maintenance.created ke RabbitMQ menggunakan Laravel Http Client?

### Hasil
Berhasil melakukan publish event maintenance.created ke RabbitMQ Cloud Dosen menggunakan format JSON yang sesuai.


## Prompt 5 – Verifikasi RabbitMQ

### Prompt
Bagaimana cara memverifikasi bahwa event RabbitMQ berhasil dikirim dan diterima oleh Cloud Dosen?

### Hasil
Berhasil melakukan pengecekan melalui Message Board dan memastikan event maintenance.created diterima dengan status sukses.


## Prompt 6 – Penyusunan Sequence Diagram

### Prompt
Buatkan sequence diagram untuk proses POST /api/v1/maintenance yang terhubung dengan Database, SOAP Audit Service, dan RabbitMQ Server.

### Hasil
Berhasil menyusun sequence diagram yang menggambarkan alur transaksi kritis dari pengguna hingga proses audit dan publish event.


## Kesimpulan
AI digunakan sebagai alat bantu untuk memahami requirement tugas, membantu proses implementasi integrasi SOAP dan RabbitMQ, melakukan debugging error, serta membantu penyusunan dokumentasi teknis. Seluruh implementasi, pengujian, dan validasi hasil tetap dilakukan secara mandiri pada layanan Monitoring BBM Servis Service.