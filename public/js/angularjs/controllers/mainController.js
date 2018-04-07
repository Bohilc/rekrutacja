(function(){
    var app = angular.module('app', []);

    app.config(function ($interpolateProvider) {

    $interpolateProvider.startSymbol('{$');
    $interpolateProvider.endSymbol('$}');

    });

    app.controller('appCtrl', ['$scope', '$http', function($scope, $http) {
        // get data from API
        var weatherAPI;
        $http.get('http://api.openweathermap.org/data/2.5/forecast?lat=52.23547&lon=21.04191&units=metric&lang=pl&appid=08dc4bcda6ba5d7a76b2e2e6f189db81')
            .then(function(response) {
                
                weatherAPI = response.data;
                drawChart(weatherAPI);
            }).catch (function(err) {
                weatherAPI = "Error";
        });

        var day = 0;
        // get current date
        var currentData = new Date();

        $scope.dateString = currentData.getFullYear() + '-'
            + ('0' + (currentData.getMonth()+1)).slice(-2) + '-'
            + ('0' + (currentData.getDate())).slice(-2);

        $scope.todayDate = currentData.getFullYear() + '-'
            + ('0' + (currentData.getMonth()+1)).slice(-2) + '-'
            + ('0' + (currentData.getDate())).slice(-2);

        // nex day
        $scope.nexDay = function (){
            
            var listLength = weatherAPI.list.length-1;
            var splitYearMonthDay = (weatherAPI.list[listLength].dt_txt).split(" ");
            // check max admissible day
            if(splitYearMonthDay[0] > $scope.dateString){
                day++;
            };
            
            if(day >=0 ){
                $scope.dateString = currentData.getFullYear() + '-'
                + ('0' + (currentData.getMonth()+1)).slice(-2) + '-'
                + ('0' + (currentData.getDate()+day)).slice(-2);
                console.log($scope.dateString);
                drawChart(weatherAPI, day, true);
            };
        };


        // previous Day
        $scope.previousDay = function (){
            // check min admissible day
            if(day > 0){
                day--;
                $scope.end = false;
            };

            if(day >=0 ){

                $scope.dateString = currentData.getFullYear() + '-'
                    + ('0' + (currentData.getMonth()+1)).slice(-2) + '-'
                    + ('0' + (currentData.getDate()+day)).slice(-2);
                    console.log($scope.dateString);
    
                drawChart(weatherAPI, day);
            };              
        };

        function drawChart(weatherAPI, day = 0, nexDay = false){
            // get current date from weather API
            $scope.currentWeather = [];
            var labelsTime = [];
            var labelsData = [];
            var todayMaxDegree = [];
            var todayMinDegree = [];

            for(var i = 0; i <= (weatherAPI.list.length-1); i++){
                var weatherData = weatherAPI.list[i];
                var splitYearMonthDay = (weatherData.dt_txt).split(" ");
                labelsData.push(splitYearMonthDay[0]);
                
                if(splitYearMonthDay[0] == $scope.dateString){
                    $scope.currentWeather.push(weatherAPI.list[i]);
                    labelsTime.push(splitYearMonthDay[1]);
                   
                    todayMaxDegree.push(weatherData.main.temp_max)
                    todayMinDegree.push(weatherData.main.temp_min)
                };
            };

            if(nexDay == true){
                if( (labelsData[labelsData.length-1]) == $scope.dateString) {
                    $scope.end = true;
                }
            }

            // get o'clock
            if(day == 0){
                var time = ($scope.currentWeather[0].dt_txt).split(" ");
                $scope.time = time[1];
            } else if( $scope.currentWeather[4] == undefined ){
                // console.log(($scope.currentWeather[$scope.currentWeather.length-1].dt_txt).split(" "));
                var time = ($scope.currentWeather[$scope.currentWeather.length-1].dt_txt).split(" ");
                $scope.time = time[1];
                
            } else {
                var time = ($scope.currentWeather[4].dt_txt).split(" ");
                $scope.time = time[1];
            }
            
            // max degree
            $scope.todayMaxDegree = Math.max.apply(null, todayMaxDegree);
            // min degree
            $scope.todayMinDegree = Math.min.apply(null, todayMinDegree);
            
            
            // dynamic create background color
            if( $scope.currentWeather[0] && day==0 ){
                // if today
                var weather = $scope.currentWeather[0].weather[0].main;
                dynamicBackgroundColor(weather);
                
            } else if( $scope.currentWeather[4] !== undefined && day > 0 ) {
                // if another day (not today) show weather at 12:00 o'clock
                var weather = $scope.currentWeather[4].weather[0].main;
                dynamicBackgroundColor(weather);

            } else if($scope.currentWeather[4] == undefined){
                // if south not find
                var weather = $scope.currentWeather[$scope.currentWeather.length-1].weather[0].main;
                dynamicBackgroundColor(weather);
            } else {
                // color standard
                dynamicBackgroundColor();
            };

            function dynamicBackgroundColor(weather = 0){
                if(weather == 'Clear'){
                    document.documentElement.style.setProperty('--bg-color-from', 'rgb(46,49,146)');
                    document.documentElement.style.setProperty('--bg-color-to', 'rgb(251,176,59)');
                } else if(weather == 'Clouds'){
                    document.documentElement.style.setProperty('--bg-color-from', 'rgb(128,128,128)');
                    document.documentElement.style.setProperty('--bg-color-to', 'rgb(230,230,230)');
                } else if(weather == 'Rain'){
                    document.documentElement.style.setProperty('--bg-color-from', 'rgb(58,56,151)');
                    document.documentElement.style.setProperty('--bg-color-to', 'rgb(163,161,255)');
                } else {
                    document.documentElement.style.setProperty('--bg-color-from', 'rgb(46,49,146)');
                    document.documentElement.style.setProperty('--bg-color-to', 'rgb(251,176,59)');
                }
            };
            
            // get degrees from $scope.currentWeather
            var units = $scope.currentWeather.map(function(value){
                console.log(value)
                return value.main.temp;
            });

            // settings chart
            var data = {
                labels: labelsTime,
                series: [
                  {
                    data: units
                  }
                ]
              };

              var options = {
                
                stretch: true,
                fullWidth: false,
                // low: 0,
                showArea: true,
                
                width: '100%',
                height: 'auto',
              };
              
              /* Now we can specify multiple responsive settings that will override the base settings based on order and if the media queries match. In this example we are changing the visibility of dots and lines as well as use different label interpolations for space reasons. */
              var responsiveOptions = [
                ['screen and (min-width: 1024px)', {
                    axisX: {
                        labelInterpolationFnc: function(value) {
                          // Will return Mon, Tue, Wed etc. on medium screens
                          return value.slice(0, 5);
                        }
                      }
                }],
                ['screen and (min-width: 641px) and (max-width: 1024px)', {
                  showPoint: true,
                  axisX: {
                    labelInterpolationFnc: function(value) {
                      // Will return Mon, Tue, Wed etc. on medium screens
                      return value.slice(0, 5);
                    }
                  }
            
                 
                }],
                ['screen and (max-width: 640px)', {
                  showLine: true,
                  width: '100%',
                  axisX: {
                    labelInterpolationFnc: function(value) {
                      // Will return Mon, Tue, Wed etc. on medium screens
                      return value.slice(0, 5);
                    }
                  }
                 
                }]
              ];
              
              /* Initialize the chart with the above settings */
              var chart = new Chartist.Line('.ct-chart', data, options, responsiveOptions);
              chart.on('draw', function(data) {
                if(data.type === 'grid' ) {
                  data.element.attr({"class": data.element.attr('class')+" bold-grid"});
                }
              });
        }
    }]);

}())