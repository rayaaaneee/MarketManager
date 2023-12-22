var data = document.getElementById('pie');
data = data.value;
var data = JSON.parse(data);
var labelsPie = Object.keys(data);
var seriesPie = Object.values(data);
// on créer le diagramme en camembert
var options = {
series: seriesPie,
chart: {
width: 450,
type: 'donut'
},
labels: labelsPie,
responsive: [
{
breakpoint: 480,
options: {
chart: {
width: 200
},
legend: {
position: 'bottom'
}
}
}
]
};
// titre du diagramme
options.title = {
text: 'Types of article in your lists',
align: 'center',
margin: 20,
offsetX: 0,
offsetY: 0,
floating: false,
style: {
fontSize: '20px',
fontWeight: 'bold',
fontFamily: undefined,
color: '#263238'
}
};

var chart = new ApexCharts(document.getElementById("piechart"), options);
chart.render();

var stats = document.getElementById('stats');
stats = stats.value;
var stats = JSON.parse(stats);
console.log(stats)
var options = {
series: [
{
data: stats
}
],
chart: {
type: 'bar',
height: 240,
width: 1200

},
plotOptions: {
bar: {
borderRadius: 4,
horizontal: true
}
},
dataLabels: {
enabled: true
},
xaxis: {
categories: ["Lower price article", "Higher price article", "Average price list"]
}
};

options.title = {
text: 'Statistics of your lists',
align: 'center',
margin: 20,
offsetX: 0,
offsetY: 0,
floating: false,
style: {
fontSize: '20px',
fontWeight: 'bold',
fontFamily: undefined,
color: '#263238'
}
};

var chart = new ApexCharts(document.getElementById("barchart"), options);
chart.render();  