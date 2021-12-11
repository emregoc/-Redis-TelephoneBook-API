<h1><p align="center">Laravel 8, Redis, Laravel Passport, Swagger </p></h1>


## Proje Clone işlemi ve Gerekli paketlerin kurulumu

Projeyi reposunu git ile kendi localinize klonladıktan sonra;

- composer install ile paketler yüklenmeli.
- Authentication işlemleri için Laravel passport paketi kurulmalı
- https://hackthedeveloper.com/how-to-install-redis-on-windows-10/ adresinden redis kurulmali
- https://laravel.com/docs/8.x/redis adresinden Laravel icin redis kurulumlari yapilmali
- Swagger ile API dökümantasyonu kurulumu için https://github.com/DarkaOnLine/L5-Swagger adresinden yararlanabilirsiniz.
- Swagger dökümantasyonunu aktif etmek için php artisan l5-swagger:generate komutu calıstırılmalı
- Swagger dökümantasyonuna ulaşmak için php artisan serve yazıldıktan sonra http://localhost:8000/api/documentation adresinden ulasilabilir.


## Projede ki API'lerin testi için

- Register ile post istegi gönderip kayıt işlemi tamamlanmalı.
- Kayıt olunan Mail ve şifreyle giriş yapılmalı. Dönen response verisindeki token kopyalanmalı ve Authorize'a eklenmeli.
- Auth işlemi tamamlandıktan sonra diğer istekleri kullanabilirsiniz.

## Projenin Endpointleri

    Projede yazılan endpointler Repository Pattern kullanılarak yazılmıştır.
    Projede Event Listener kullanılmıştır.

- User Register API (POST): http://localhost:8000/api/register
- User Login API (POST): http://localhost:8000/api/login
- User Logout API (GET): http://localhost:8000/api/logout
- Tüm Verilein API'si (GET): http://localhost:8000/api/data
- Güncelleme için API (PUT): http://localhost:8000/api/personel-update/{id}
- Silme için API (DELETE): http://localhost:8000/api/personel-delete/{id}
- Rehbere kişi Ekleme için API (POST): http://localhost:8000/api/add-person
- Alfabetik Sıralama için API (GET): http://localhost:8000/api/person-filter
- Kişi arama için API (POST): http://localhost:8000/api/person-search

### Pojenin Ekran Çıktıları
<details>
<summary>Swagger</summary>
<img src="https://user-images.githubusercontent.com/56219956/145681715-4fb52279-2e50-468b-ad2d-3aee09522886.png" width="500">
</details>
<details>
<summary>Log</summary>
<img src="https://user-images.githubusercontent.com/56219956/145681662-70a56507-48bc-49ed-974e-b8e15a173008.png" width="500">
</details>
<details>
<summary>Mail</summary>
<img src="https://user-images.githubusercontent.com/56219956/145681659-0cda087c-de9a-431b-9835-30fed458938a.png" width="500">
</details>
<details>
<summary>Redis-server</summary>
<img src="https://user-images.githubusercontent.com/56219956/145681676-610c49c2-7a59-46d5-9dfb-6b6b04b45b99.png" width="500">
</details>
<details>
<summary>Redis-client</summary>
<img src="https://user-images.githubusercontent.com/56219956/145681679-a9a6b1f2-2a4e-4879-b286-a593f960f45f.png" width="500">
</details>
