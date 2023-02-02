# REST_API

## Запуск проекта на докер командой

Командой make: 
```sh
$ sudo make init
```

или docker-compose
```sh
	$ sudo docker-compose run rest-node-cli npm update
```
```sh
	$ sudo docker-compose run rest-composer composer install
```
```sh
	$ sudo cp .env.example .env
```
```sh
	$ sudo docker-compose up -d
```
```sh
	$ sudo docker-compose run rest-php-fpm php artisan migrate
```
```sh
	$ sudo chmod -R 777 .
```
```sh
	$ sudo docker-compose run rest-node-cli npm run build
```

## Структура проекта

App\Http\Controllers
- EquipmentController -- ресурс контроллер для оборудования
- EquipmentTypeController -- контроллер для типа оборудования

App\Http\Requests;
- EquipmentRequest -- Вализация данных

App\Http\Resources
- EquipmentResource -- Ресурсы оборудования
- EquipmentTypeResource -- Ресурсы типа оборудования

App\Models
- Equipment -- модель оборудования
- EquipmentType -- модель типа оборудования

 App\Services
- \Base\BaseServiceApi -- родительский класс для всех сервисов работающих с бд
- EquipmentService -- сервис для оборудования

App\Traits
- RulesEquipmentRequestTrait -- кастомные проерки для Requests
- SearchableTrait -- Добавление поиска по полям в сервис

