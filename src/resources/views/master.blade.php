<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
        <meta name="language" content="English">
        <title>Laravel Colors</title>
        @yield('css')
        <link href='https://fonts.googleapis.com/css?family=Raleway:300' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div id="app" :colors="{{ json_encode($colors) }}" :saves="{{ json_encode($saves)}}">
            <alert></alert>
            @include('laravel-colors::nav')
            <menu :names="names"></menu>
            <div id="draggable" class="wrapper">
                <div class="color" v-for="color in colorScheme">
                    <color :color="color" :name="color.name" :hex="color.hex">
                    </color>
                </div>
            </div>
        </div>
    </body>

    @yield('scripts')
</html>
