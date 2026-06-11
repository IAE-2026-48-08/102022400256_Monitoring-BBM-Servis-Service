# Monitoring BBM Servis Service

## Teknologi

- Laravel 13.14.0
- SQLite
- Swagger (L5 Swagger)
- GraphQL Lighthouse
- Docker


## Menjalankan Service
Service berjalan pada:
http://localhost:8003

## REST API

### Ambil Semua Data Maintenance
GET /api/v1/maintenance
http://localhost:8003/api/v1/maintenance

### Ambil Data Maintenance Berdasarkan ID
GET /api/v1/maintenance/{id}
http://localhost:8003/api/v1/maintenance/1

### Tambah Data Maintenance
http://localhost:8003/api/v1/maintenance

## API Key
X-IAE-KEY: 102022400256

## Swagger Documentation
http://localhost:8003/api/documentation

## GraphQL
Endpoint:
http://localhost:8003/graphql