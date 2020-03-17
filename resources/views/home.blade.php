<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Погода</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            background-color: #498CEC;
            color: #ffffff;
            font-family: sans-serif;
        }

        h1 {
            text-align: center;
        }

        form {
            display: inherit;
        }

        input {
            border: 0;
            padding: 10px;
            border-radius: 4px 0 0 4px;
        }

        input[type="submit"] {
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            color: #1086FF;
            font-weight: bold;
        }

        label {
            font-family: monospace;
            font-size: 16px;
            cursor: pointer;
            padding: 8px;
            opacity: 0.6;
        }

        input[type="radio"]:checked + label {
            opacity: 1;
            cursor: default;
        }

        input[type="radio"] {
            display: none;
        }

        .units-switcher {
            display: inline;
            border: white 2px solid;
            border-radius: 4px;
            padding: 6px 0;
            margin-left: 10px;
        }

        .header {
            height: 20vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .weather, .error, .greetings {
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        .weather-main h1 {
            margin: 0;
        }

        .temp-block {
            display: flex;
            align-items: center;
            justify-content: center
        }

        .description {
            margin: 0;
            text-align: center;
            font-family: monospace;
            font-size: 16px;
        }

        .temp {
            font-family: sans-serif;
            font-size: 85px;
            font-weight: normal;
        }

        .details {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .title {
            font-weight: normal;
        }

        .value {
            font-family: monospace;
            font-size: 24px;
        }

        .error {
            align-items: center;
        }

        .error-message {
            width: 300px;
            padding: 10px;
            font-weight: bold;
            font-size: 24px;
            text-align: center;
            border: 2px solid red;
        }
    </style>
</head>
<body>
<div class="header">
    <form method="post" action="/">
        @csrf
        <input type="text" name="q" placeholder="Введите город" value="{{ $_POST['q'] ?? '' }}"><input type="submit"
                                                                                                       value="OK">
        <div class="units-switcher">
            <input type="radio" name="units" id="metric" value="metric" checked>
            <label for="metric">°C</label>
            <input type="radio" name="units" id="imperial" value="imperial">
            <label for="imperial">°F</label>
        </div>
    </form>
</div>
@if (isset($weather) && $weather['cod'] < 399)
    <div class="weather">
        <div class="weather-main">
            <h1>{{$weather['city']}}</h1>
            <div class="temp-block">
                <img src="http://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png">
                <span class="temp">{{ $weather['temp'] }}°</span>
            </div>
            <p class="description">{{ $weather['description'] }}</p>
        </div>
        <div class="details">
            <div class="details-block">
                <p class="title">Ощущается как</p>
                <p class="value">
                    {{$weather['feelsTemp']}}°
                </p>
            </div>
            <div class="details-block">
                <p class="title">Ветер</p>
                <p class="value">
                    {{ $weather['windSpeed'] }} м/с, {{$weather['windDirection']}}
                </p>
            </div>
            <div class="details-block">
                <p class="title">Давление</>
                <p class="value">
                    {{ $weather['pressure'] }} мм рт. ст.
                </p>
            </div>
            <div class="details-block">
                <p class="title">Влажность</p>
                <p class="value">
                    {{ $weather['humidity'] }}%
                </p>
            </div>
        </div>
    </div>
@elseif(isset($weather) && $weather['cod'] >= 400)
    <div class="error">
        <span class="error-message">
            {{$weather['message']}}
        </span>
    </div>
@else
    <div class="greetings">
        <h1>Главней всего погода в доме</h1>
    </div>
@endif
</body>
</html>
