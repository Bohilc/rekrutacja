<!doctype html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Warszawa</title>

        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <!-- <script src="{{ url('js/app.js') }}"></script> -->

        <!-- custom style -->
        <link href="{{ url('css/custom.css') }}" rel="stylesheet">
        <!-- angularjs -->
        <!-- <script src="{{ url('js/angularjs/angular.min.js') }}"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="{{ url('js/angularjs/controllers/mainController.js') }}"></script>
        <!-- icons -->
        <!-- <script src="{{ url('js/feather.min.js') }}"></script> -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <!-- jQuery -->
        <script src="{{ url('js/jquery.min.js') }}"></script>
        <!-- chartist.js -->
        <!-- <link rel="stylesheet" href="{{ url('css/chartist.min.css') }}"> -->
        <link rel="stylesheet" href="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
        <script src="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
        <!-- <script src="{{ url('js/chartist.min.js') }}"></script> -->
    </head>
    
    <body ng-app="app" ng-cloak>
   
        <div ng-controller="appCtrl" class="content">
            <div class="content__page">
                <div class="grid content__page__weather__container" style="width: 90%">
                    <!-- 1 section -->
                    <div>
                        <i data-feather="map-pin" color="#00FFFF"></i>
                        <h1 class="content__page__title--white"><b>warszawa</b></h1>
                        <div>
                            <i ng-if="dateString !== todayDate" class="icon--arrow" ng-click="previousDay()" data-feather="arrow-left"></i>
                                <h2 class="title title--white title--change">{$ dateString $}</h2>
                            <i ng-if="end !== true" class="icon--arrow" ng-click="nexDay()" data-feather="arrow-right"></i>
                        </div>  
                        <div class="content__page__weather__container content__page__weather__container--marginBottomZero" style="width: 90%">
                            <div style="margin: auto">
                                <div class="content__page__weather__container--box">
                                    <h3 class="title title--degree title--white">Max: <b>{$ (todayMaxDegree).toFixed() $}<span class="icon--cyan">°C</span></b></h3>
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <h3 class="title title--degree title--white">Min: <b>{$ (todayMinDegree).toFixed() $}<span class="icon--cyan">°C</span></b></h3>
                                </div>
                            </div>
                        </div>
                        <br>
                        
                        
                        <!-- weather icon -->
                        <img ng-if="dateString == todayDate" class="weather__img" src="http://openweathermap.org/img/w/{$ currentWeather[0].weather[0].icon $}.png"  alt="">
                        <img ng-if="dateString !== todayDate && currentWeather[4] !== undefined" class="weather__img" src="http://openweathermap.org/img/w/{$ currentWeather[4].weather[0].icon $}.png"  alt="">
                        <img ng-if="dateString !== todayDate && currentWeather[4] == undefined" class="weather__img" src="http://openweathermap.org/img/w/{$ currentWeather[currentWeather.length-1].weather[0].icon $}.png"  alt="">

                        <!-- weather description -->
                        <h2 ng-if="dateString == todayDate" class="title title--white">{$ currentWeather[0].weather[0].description $}</h2>
                        <h2 ng-if="dateString !== todayDate && currentWeather[4] !== undefined" class="title title--white">{$ currentWeather[4].weather[0].description $}</h2>
                        <h2 ng-if="dateString !== todayDate && currentWeather[4] == undefined" class="title title--white">{$ currentWeather[currentWeather.length-1].weather[0].description $}</h2>
                    </div>

                    <!-- 2 section -->
                    <div style="margin: auto">
                        <!-- 1 column -->
                        <div class="content__page__weather__container__column">
                            <div class="content__page__weather__container--box">
                                    <h2 class="title title--white">
                                        <b >~ {$ time $}</b> 
                                        <!-- <b ng-if="dateString !== todayDate">{$ currentWeather[4].dt_txt $}</b>  -->
                                    </h2>
                                </div>
                                <div class="content__page__weather__container--box">
                                <h2 ng-if="dateString == todayDate" class="title title--white">
                                    Teraz: <b>{$ (currentWeather[0].main.temp).toFixed() $}<span class="icon--cyan">°C</span> </b> 
                                </h2>

                                    <h2 ng-if="dateString !== todayDate" class="title title--white">
                                        <span ng-if="currentWeather[4]">Po południu: <b>{$ (currentWeather[4].main.temp).toFixed() $}<span class="icon--cyan">°C</span></b></span>
                                        <span ng-if="!currentWeather[4]">Rano: <b>{$ (currentWeather[currentWeather.length-1].main.temp).toFixed() $}<span class="icon--cyan">°C</span></b></span>
                                    </h2>
                                </div>
                            
                            <div class="content__page__weather__container--box">
                                <h2 class="title title--white">
                                Wilgotność: 
                                    <b ng-if="dateString == todayDate && currentWeather[4] == undefined">{$ currentWeather[0].main.humidity $} <span class="icon--cyan">%</span></b> 
                                    <b ng-if="dateString == todayDate && currentWeather[4] !== undefined">{$ currentWeather[0].main.humidity $} <span class="icon--cyan">%</span></b> 

                                    <b ng-if="dateString !== todayDate && currentWeather[4] !== undefined">{$ currentWeather[4].main.humidity $} <span class="icon--cyan">%</span></b> 
                                    <b ng-if="dateString !== todayDate && currentWeather[4] == undefined">{$ currentWeather[currentWeather.length-1].main.humidity $} <span class="icon--cyan">%</span></b> 
                                    <i data-feather="droplet" class="icon--cyan--1"></i>
                                </h2>
                            </div>
                        </div>

                        <!-- 2 column -->
                        <div class="content__page__weather__container__column">
                            <div class="content__page__weather__container--box">
                                <h2 class="title title--white">
                                        Pochmurność: 
                                            <b ng-if="dateString == todayDate && currentWeather[4] == undefined">{$ currentWeather[0].clouds.all $}<span class="icon--cyan">%</span></b> 
                                            <b ng-if="dateString == todayDate && currentWeather[4] !== undefined">{$ currentWeather[0].clouds.all $}<span class="icon--cyan">%</span></b>

                                            <b ng-if="dateString !== todayDate && currentWeather[4] !== undefined">{$ currentWeather[4].clouds.all $}<span class="icon--cyan">%</span></b>
                                            <b ng-if="dateString !== todayDate && currentWeather[4] == undefined">{$ currentWeather[currentWeather.length-1].clouds.all $}<span class="icon--cyan">%</span></b>
                                            <i data-feather="cloud" class="icon--cyan--1"></i>
                                    
                                    </h2>
                            </div>
                            <div class="content__page__weather__container--box">
                                <h2 class="title title--white">
                                    Wiatr: 
                                    <b class="title--white" ng-if="dateString == todayDate && currentWeather[4] == undefined">{$ currentWeather[0].wind.speed $} <span class="icon--cyan">m/s</span></b>
                                    <b class="title--white" ng-if="dateString == todayDate && currentWeather[4] !== undefined">{$ currentWeather[0].wind.speed $} <span class="icon--cyan">m/s</span></b>

                                    <b class="title--white" ng-if="dateString !== todayDate && currentWeather[4] !== undefined">{$ currentWeather[4].wind.speed $} <span class="icon--cyan">m/s</span></b>
                                    <b class="title--white" ng-if="dateString !== todayDate && currentWeather[4] == undefined">{$ currentWeather[currentWeather.length-1].wind.speed $} <span class="icon--cyan">m/s</span></b>
                                </h2>
                                <i data-feather="wind" class="icon--cyan--1"></i>
                            </div>
                            <div class="content__page__weather__container--box">
                                <h2 class="title title--white">
                                    Ciśnienie : 
                                    <b ng-if="dateString == todayDate && currentWeather[4] == undefined">{$ currentWeather[0].main.pressure $} <span class="icon--cyan">hPa</span></b> 
                                    <b ng-if="dateString == todayDate && currentWeather[4] !== undefined">{$ currentWeather[0].main.pressure $} <span class="icon--cyan">hPa</span></b> 

                                    <b ng-if="dateString !== todayDate && currentWeather[4] !== undefined">{$ currentWeather[4].main.pressure $} <span class="icon--cyan">hPa</span></b> 
                                    <b ng-if="dateString !== todayDate && currentWeather[4] == undefined">{$ currentWeather[currentWeather.length-1].main.pressure $} <span class="icon--cyan">hPa</span></b> 
                                </h2>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <!-- chart -->
                <div class="content__page__weather--chart">
                    <div class="ct-chart content__page__weather__container"></div>
                </div>
            </div>

        </div>
        <style>
            .ct-chart .ct-line,
            .ct-chart .ct-point {
                stroke: white;
                /* stroke-width: 4px; */
                
                color: white;

            }
            .ct-series-a .ct-area {
                fill: #00FFFF;
            }
            
            .ct-label {
                font-size: 15px;
                color: #00FFFF;
            }

            @media only screen and (max-width: 576px) {
                .ct-label{
                    font-size: 10px;
                }
            }

           .bold-grid {
                stroke: #fff;
                stroke-dasharray: 3px;
                stroke-width: .5px;
            }

            .ct-series-b .ct-line,
            .ct-series-b .ct-point {
                stroke: white;
            }
        </style>
        <script>
            feather.replace(); 
        </script>
    </body>
</html>
