<h1>Laravel Chart using <b>larapex charts Library</b></h1>

## About

"php": "^7.4|^8.0"<br>
"laravel": "9"<br>
Library<br>
"name": "arielmejiadev/larapex-charts"<br>
"version": "5.2.0"<br>

## Steps

1- Add larapex charts using composer to your project<br><br>
&nbsp;&nbsp;composer require arielmejiadev/larapex-charts<br><br>
2- In terminal execute this command:<br><br>
&nbsp;&nbsp;    php artisan vendor:publish --tag=larapex-charts-config<br><br>
3- Create a chart<br><br>
&nbsp;&nbsp;    php artisan make:chart MonthlyUsersChart<br><br>
4- Then select a chart type:<br><br>
 &nbsp;&nbsp;   - [x] Pie Chart<br>
 &nbsp;&nbsp;   - [ ] Donut Chart<br>
 &nbsp;&nbsp;   - [ ] Radial Bar Chart<br>
 &nbsp;&nbsp;   - [ ] Polar Area Chart<br>
 &nbsp;&nbsp;   - [ ] Line Chart<br>
 &nbsp;&nbsp;   - [ ] Area Chart<br>
 &nbsp;&nbsp;   - [ ] Bar Chart<br>
 &nbsp;&nbsp;  - [ ] Horizontal Bar Chart<br>
 &nbsp;&nbsp;   - [ ] HeatMap Chart<br>
&nbsp;&nbsp;    - [ ] Radar Chart<br><br>
 5- Now you are able to see the chart file in app/Charts/MonthlyUsersChart.php<br><br>
 &nbsp;&nbsp;   https://larapex-charts.netlify.app/2-simple-example/<br><br>
6- Create a controller<br><br>
&nbsp;&nbsp;    php artisan make:controller UserController -r<br><br>
7- On app/Http/Controllers/UserController.php inject the chart object:<br><br>
&nbsp;&nbsp;    https://larapex-charts.netlify.app/2-simple-example/<br><br>
8- Add this route on routes/web.php<br><br>
 &nbsp;&nbsp;   https://larapex-charts.netlify.app/2-simple-example/<br><br>
9- Add the chart to a view<br><br>
  &nbsp;&nbsp;  Copy and paste this layout, it is using tailwindcss, but you can use any css styles.<br>
 &nbsp;&nbsp;   It adds $chart->container(), $chart->cdn() and $chart->script() methods, to render a chart.<br>
  &nbsp;&nbsp;  https://larapex-charts.netlify.app/2-simple-example/<br><br>
    
 <b>These are the steps.If you want to make different charts in your project select your respective option while making chart.</b>



