var dps_t = [];
var dps_a = [];
var chart_a;
var chart_t;
var flag;
var p = [];

//var pline;
//var p;

function onMozilla(){
  var time_from = document.getElementById('from-t');
  var time_to = document.getElementById('to-t');
  var from = document.getElementById('from-date');
  var to = document.getElementById('to-date');

  from.removeChild(time_from);
  to.removeChild(time_to);

  from.innerHTML += "<timepicker id=\"from-t\" value=\"00:00\"/>";
  from.innerHTML += "<timepicker id=\"to-t\"/>";
}

window.onload = function () {
  if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
    onMozilla();
  }



  flag = document.getElementById('flag');
  
  p = [];

  chart_t = new CanvasJS.Chart("chart_temp", {
  animationEnabled: true,  
  title:{
    text: "Графік температури"
  },
  axisY: {
    title: "Температура",
    valueFormatString: "#0.",
    suffix: "°C",
    stripLines: [{
    }]
  },
  data: [{
    yValueFormatString: "#.0 °C",
    xValueFormatString: "HH:mm:ss",
    type: "spline", 
    dataPoints: dps_t
  }]
});

chart_a = new CanvasJS.Chart("chart_number", {
  animationEnabled: true,
  zoomEnabled: true,
  exportEnabled: true,
  title: {
    text: "Графік кількості товару"
  },
  subtitles: [],
  axisX: {
    interval: 1,
    valueFormatString: "HH:mm:ss"
  },
  axisY: {
    includeZero: false,
    prefix: "",
    minimum: 0,
    title: "Кількість"
  },
  toolTip: {
    content: "Час: {x}<br /><strong>Кількість:</strong><br />Початок: {y[0]}, Кінець: {y[3]}<br />Макс: {y[2]}, Мін: {y[1]}"
  },
  data: [{
    type: "candlestick",
    yValueFormatString: "##0 шт",
    dataPoints: dps_a,
    risingColor: "green",
    fallingColor: "red"
  }]
});

chart_p = new CanvasJS.Chart("chart_people", {
  animationEnabled: true,  
  title:{
    text: "Графік кількості людей"
  },
  axisY: {
    title: "Кількість людей",
    valueFormatString: "#0.",
    suffix: "",
    minimum: 0,
    stripLines: [{
    }]
  },
  toolTip: {
    content: "<strong>Кількість по зонах:</strong><br />Час: {x}<br />Зона 1: {data[0]}<br />Зона 2: {data[1]}<br />Зона 3: {data[2]}<br />Сума: {y}"
  },
  data: [{
    yValueFormatString: "#",
    xValueFormatString: "HH:mm:ss",
    type: "column", 
    dataPoints: p
  }]
});

  var devices = document.getElementById('devices');
  var first = devices.getElementsByClassName('my-green')[0];

  if(first == null)
    var first = devices.getElementsByClassName('device-button')[0];
  switchSensor(first.value);

  var sec = 60;
  setInterval(refreshCharts, sec*1000)
  setInterval(refreshTime,1000);
}

function refreshTime(){
  var today = new Date();
  var time = today.getHours() + ":" + today.getMinutes() + ":" + addZero(today.getSeconds());
  document.getElementById('curr_timeS').innerHTML = time;
  document.getElementById('curr_time').innerHTML = time;
}

function addZero(i){
  if(i<10){
    i = "0"+i;
  }
  return i;
}


function toggleDataSeries(e){
  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    e.dataSeries.visible = false;
  }
  else{
    e.dataSeries.visible = true;
  }
  chart.render();
}


function refreshCharts(){
  if(flag.innerHTML == 1) {
    var sname = document.getElementById('name').innerHTML.replace('"','').replace('"','');
    var buttons = document.getElementsByClassName('device-button');

    var current;

    for (var i = 0; i < buttons.length; i++) {
      //alert(buttons[i] + "  " + sname);
      if(buttons[i].innerHTML.includes(sname)){
        current = buttons[i];
        break;
      } 
    }

    if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
      } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

    var from_d = document.getElementById('from-d').value;
    var from_t = document.getElementById('from-t').value;
    var to_d = document.getElementById('to-d').value;
    var to_t = document.getElementById('to-t').value;

    var url = "sensorData.php?id="+current.value+"&from="+from_d+"T"+from_t+"&to=";
    if(to_d!="")
      url+=to_d+"T"+to_t;
    
    xmlhttp.open("GET",url,true); // true - async
    xmlhttp.send();


    xmlhttp.onload = function (e) {
      if (xmlhttp.readyState === 4) {
        if (xmlhttp.status === 200) {
          var text = xmlhttp.responseText;
          var response = JSON.parse(text);
          var cur = 0;
          if(to_d=="")
            cur = 1;
          fillWithData(response, 0, cur);
        }
      }
    }
  }
}

function renderNewChart(){
  flag.innerHTML = 0;
  var sname = document.getElementById('name').innerHTML.replace('"','').replace('"','');
  var buttons = document.getElementsByClassName('device-button');

  var current;

  for (var i = 0; i < buttons.length; i++) {
    //alert(buttons[i] + "  " + sname);
    if(buttons[i].innerHTML.includes(sname)){
      current = buttons[i];
      break;
    }
  }
  switchSensor(current.value);
}

function switchSensor(value) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var from_d = document.getElementById('from-d').value;
    var from_t = document.getElementById('from-t').value;
    var to_d = document.getElementById('to-d').value;
    var to_t = document.getElementById('to-t').value;

    var url = "sensorData.php?id="+value+"&from="+from_d+"T"+from_t+"&to=";
    if(to_d!="")
      url+=to_d+"T"+to_t;
  
  xmlhttp.open("GET",url,true); // true - async
  xmlhttp.send();


  xmlhttp.onload = function (e) {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
              var text = xmlhttp.responseText;
              var response = JSON.parse(text);
              var cur = 0;
              if(to_d=="")
                cur = 1;
              fillWithData(response, 1, cur);
            }
          }
        }
}

function fillWithData(response, is_new, current){
  var name = document.getElementById('name');
  var temp = document.getElementById('temp');
  var number = document.getElementById('number');
  var sold = document.getElementById('sold');
  var time_r = document.getElementById('renev_time');
  var people = document.getElementById('people');
  var project = document.getElementById('project');

  name.innerHTML = response['name'];
  temp.innerHTML = 'Температура: ' + response['temp']+'°C';
  number.innerHTML = 'Кількість продукції на полиці: ' + response['number'];
  sold.innerHTML = 'Продано за вказаний час: ' + response['sold'];
  time_r.innerHTML = 'Останнє поповнення: '+ response['last_in'].replace("-",':').replace('-',':');
  people.innerHTML = 'Людей біля полиці за вказаний час: ' + response['people'];
  project.innerHTML = response['project'];

  var unit_ws = response['unit'];
  var all_hist = response['all_hist'];
              
  prepareData(all_hist, unit_ws, is_new, current);
  renderCharts();
}


function prepareData(data, unit, is_new, current){
  if(is_new == 1) {
    while (dps_a.length > 0) { 
      p.pop();
      dps_a.pop(); 
      dps_t.pop(); 
    }
  }
  try {
    var databits = data[0].split(';');
    var fdate = new Date(databits[0]);
    fdate.setMinutes(fdate.getMinutes()-5);
    today_m = new Date();
    today_m.setMinutes(0);
    today_m.setHours(0); 
    if(fdate> today_m && current == 1){
      p.push({x: today_m}); 
      dps_t.push({x: today_m});
      dps_a.push({x: today_m});
    }

    var iter = 0;
    var z1 = 0;
    var z2 = 0;
    var z3 = 0;
    var t = 0.0;

    var i = dps_a.length;
    var start_time;
    if(current == 1){
      start_time = new Date();
      start_time.setMinutes(0);
      start_time.setHours(0);
      start_time.setSeconds(0); 
    } else {
      var databits = data[0].split(';');
      start_time = new Date(databits[0]);
    }
    var tmp_date = start_time;
    while(i < Object.keys(data).length) {
      var databits = data[i].split(';');

      dps_a.push({x: new Date(databits[0]), y: [
        parseInt(databits[5]),
        parseInt(databits[6]),
        parseInt(databits[7]),
        parseInt(databits[8])
      ]
      });

      //alert(databits[0] + "\n" + tmp_date);

      if(new Date(databits[0]) < tmp_date && i <= Object.keys(data).length-1){
        z1 += parseInt(databits[2]);
        z2 += parseInt(databits[3]);
        z3 += parseInt(databits[4]);
        t += parseFloat(databits[1]);
        iter++;
        i++;
      } else {
        iter++;
        z1 += parseInt(databits[2]);
        z2 += parseInt(databits[3]);
        z3 += parseInt(databits[4]);
        t += parseFloat(databits[1]);
        if(t == 0)
          dps_t.push({x: new Date(tmp_date+"")});
        else 
          dps_t.push({x: new Date(tmp_date+""), y: t/iter});
        if(z1+z2+z3 == 0)
          p.push({x: new Date(tmp_date+"")});
        else
          p.push({x: new Date(tmp_date+""), y: z1+z2+z3, data: [z1,z2,z3]});
        iter = 0;
        z1 = 0;
        z2 = 0;
        z3 = 0;
        t = 0.0;
        tmp_date.setMinutes(tmp_date.getMinutes() + 10);
      }
    }

  /*
  for (var i = dps_a.length; i < Object.keys(data).length; i++) {
    var databits = data[i].split(';');
    dps_a.push({x: new Date(databits[0]), y: [
      parseInt(databits[5]),
      parseInt(databits[6]),
      parseInt(databits[7]),
      parseInt(databits[8])
      ]
    });

    if(iter != 1 && i != Object.keys(data).length-1){
      z1 += parseInt(databits[2]);
      z2 += parseInt(databits[3]);
      z3 += parseInt(databits[4]);
      t += parseFloat(databits[1]);
      iter++;
    } else {
      iter++;
      z1 += parseInt(databits[2]);
      z2 += parseInt(databits[3]);
      z3 += parseInt(databits[4]);
      t += parseFloat(databits[1]);
      dps_t.push({x: new Date(databits[0]), y: t/iter});
      p.push({x: new Date(databits[0]), y: z1+z2+z3, data: [z1,z2,z3]});
      iter = 0;
      z1 = 0;
      z2 = 0;
      z3 = 0;
      t = 0.0;
    }
  }
  */
    
  var databits = data[Object.keys(data).length-1].split(';');
  var fdate = new Date(databits[0]);
  fdate.setMinutes(fdate.getMinutes()+2);
  if(fdate<new Date() && current == 1){
    p.push({x: new Date(), label: "zone1: "+0+", zone2: "+0+", zone3: "+0+", sum"}); 
    dps_t.push({x: new Date()});
    dps_a.push({x: new Date()});
  }
  if(current == 1) {
    fdate.setMinutes(0);
    fdate.setHours(24);
    p.push({x:fdate});
    dps_t.push({x:fdate});
    dps_a.push({x:fdate});
  }
  } catch(e) {}
}

function renderCharts(){
  chart_a.render();
  chart_t.render();
  chart_p.render();
}

function resetSearch(){

}


function getFile(){
  var sname = document.getElementById('name').innerHTML.replace('"','').replace('"','');
  var buttons = document.getElementsByClassName('device-button');

  var current;

  for (var i = 0; i < buttons.length; i++) {
    if(buttons[i].innerHTML.includes(sname)){
      current = buttons[i];
      break;
    } 
  }

  var from_d = document.getElementById('from-d').value;
  var from_t = document.getElementById('from-t').value;
  var to_d = document.getElementById('to-d').value;
  var to_t = document.getElementById('to-t').value;

  var url = "https://c.advin.in.ua/fileRout.php?id="+current.value+"&from="+from_d+"T"+from_t+"&to=";
  if(to_d!="")
    url+=to_d+"T"+to_t;

  window.open(url);
}

