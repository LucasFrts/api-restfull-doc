<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel
<h2>Iniciar Projeto:</h2>
<strong>Executar:</strong>
<p>php artisan key:generate</p>
<p>php artisan jwt:secret</p>
<p>php artisan migrate --seed</p>
<small><strong>OBS:</strong>Crie ou vincule um banco de dados ao seu .env, assegure-se de seu banco de dados não possuir uma tabela chamada "users"</small>
<p>php artisan optimize</p>
<p>php artisan serve</p>
<h2>Testar o projeto</h2>
<p>Podemos testar a partir dos testes de integração:</p>
<p>php artisan test<p>
<p>Também podemos utilizar o curl, segue um exemplo de requisição</p>
<pre>
http://127.0.0.1:8000/api/users   -H 'Authorization: Bearer {token}'
</pre>
<small>
<strong>OBS:</strong>
Substitue {token} pelo seu código JWT localizado no JWT_SECRET do seu .env
</small>