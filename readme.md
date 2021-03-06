# Реализация журнала посещаемости Vue + Laravel

## Для запуска проекта необходимо:
 * php >= 7.0
 * node & npm
 * sqlite php driver
 * composer
 
## Запуск проекта:
1. Склонировать проект
```
git clone https://github.com/Oleglacto/journal.git && cd journal/
```
2. Подготовить базу (в качестве базы - sqlite)
```
touch journal.sqlite
```
3. Настроить env (настройки проекта):
```
cp .env.example .env
```
4. Установить зависимости php и сделать миграцию данных
```
composer install && php artisan migrate && php artisan db:seed
```
5. Сгенерировать ключ для приложения
```
php artisan key:generate
```  
6. Установить пакеты JS'a и собрать проект
```
npm i && npm run dev
```
7. Запустить проект
```
php artisan serve
```
8. Перейти по ссылке [localhost](http://127.0.0.1:8000)

p.s. Все в одной команде:
```
git clone https://github.com/Oleglacto/journal.git &&
cd journal/ && touch journal.sqlite &&
cp .env.example .env &&
composer install &&
php artisan migrate && 
php artisan key:generate &&
php artisan db:seed && npm i && npm run dev && php artisan serve
```