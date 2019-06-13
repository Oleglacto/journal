<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Test</title>
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div id="app">
            <header>
                <router-link to="/" class="is-size-1">Journal</router-link>
            </header>
            <main class="columns" style="padding: 20px">
                <aside class="column is-2">
                    <ul class="menu-list">
                        <li><router-link to="/lessons">Дисцплины</router-link></li>
                        <li><router-link to="/schedule">Расписание</router-link></li>
                        <li><router-link to="/users">Пользователи</router-link></li>
                    </ul>
                </aside>

                <div class="column is-10">
                    <router-view></router-view>
                </div>
            </main>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>