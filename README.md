Az adatbázis tervezés: két különböző adattáblát készítettem
1: A projectek tárolása gyakorlatilag csak a project_name oszlop van benne.
2: A projectekhez tartozó idősávok és commentek tárolása, itt van egy a project_id egy project_start és egy project_end oszlop plusz a project_comment.

A működési elv kezdő oldalon elég egyszerű, egyből megjelenik egy input mező ami ha nem üres akkor a beírt szöveget enter megnyomásával menti a projectek közé. (Project_name)
Alatta listázza az összes projectet pagination-el, (ha lenne authetikáció akkor természetesen egy user_id ellenőrzést bevezetnénk de most tesztjelleg miatt nincs ilyen.

Az adott projectre kattintva fejlön a project modal ablaka ami tartalmazza az adott project idősávjához tartozó számlálót HH:MM:SS formátumban, alatta egy comment multiline mezővel és start/stop gombokkal.

Működési elv:
Amikor megnyitjuk ezt a project modal-t az azonnal létrehoz egy idősáv rekordot az adott projecthez, ekkor az adatbázisban még minden oszlop null értékű kivéve a project_id-t és vissza adja a kliensnek a létrehozott idősáv rekord primary id-jét.
Amikor a start gombot megnyomjuk akkor patch metódussal updateli a start időpontot akkor ha a számláló 0 (ha ez nem lenne akkor minden alkalommal felül irná a start időpontot ami nem jó).
Amikor a stop gombot megnyomjuk akkor szintén updatel csak ilyenkor a project_end et fogja abban az esetben ha a számláló éppen folyamatban volt, ha már áll a számláló akkor nem updatel a stop gomb hiszen az megint csak hibás működés lenne.
A modal ablak X azaz bezárás gombja szintén updateli a project_end oszlopot amennyiben a számláló nem volt megállítva, ha meg volt már állítva akkor nem csinál semmit.
A comment mező csak akkor updateli a project_commentet amikor elveszti a fókuszt vagy a start gomb lenyomásakor. Ez különállóan tud updatelni a start és stop gomboktól.

Azért volt szükség erre a logikára mert a tesztfeladat leírása szerint minden idősáv rekordhoz saját comment szekció kell. És különálló mentési logika.

Az export gombról nehéz ódákat irni, a controllerben látott logika alapján lekéri az adatokat és megjeleníti azokat egy modal ablakban.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
