(function() {
	setInterval(refresh, 10000);	// timer. repeatable. every num/1000 seconds.
})();

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function refresh() {
	if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	var url = "getData.php";

	xmlhttp.open("GET",url,true);	// true - async
	xmlhttp.send(null);

	xmlhttp.onload = function (e) {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
            	var text = xmlhttp.responseText;
             	var response = JSON.parse(text);
		
		// check + fill select
		var select_el = document.getElementById('flag');
		

		if(select_el.selectedIndex != -1)
			var selected = select_el.options[select_el.selectedIndex].value;
		var indx = 1;
	
		for (var i = 1; i <= Object.keys(response).length; i++) {
			var flag = false;
			if(response[i]['name'] == selected) indx = i;
			for (var j = 0; j < select_el.options.length; j++) {
				if(select_el.options[j].value == response[i]['name']) flag = true; 
			}
			if(!flag) {
				select_el.options[select_el.options.length] = new Option(response[i]['name'],response[i]['name']);
			}
		}
		


		var first = response[indx];

             	var obj = first['users'];
             	
             	var users_150 = document.getElementById('users_150').getElementsByClassName("val")[0];
				var users_50_150 = document.getElementById('users_50_150').getElementsByClassName("val")[0];
				var users_50 = document.getElementById('users_50').getElementsByClassName("val")[0];
				users_50.innerHTML = obj['too_close'];
				users_50_150.innerHTML = obj['close'];
				users_150.innerHTML = obj['not_close'];

				obj = first['temp'];
				var temprature_log = [];
				var flag = true;
				for (var i in obj) {	// 11 - max size of array
					if(flag) {
						flag = false;
						continue;					
					}
					temprature_log.push([obj[i]['date'], obj[i]['temp'].replace(/\s/g, '')]);
				}
				var temp = document.getElementById('temp').getElementsByClassName("val")[0];
				temp.innerHTML = obj[0]['temp'];				

				var weight = document.getElementById('weight').getElementsByClassName("val")[0];
				weight.innerHTML = first['weight'];

				var loglines = document.getElementsByClassName("logline");
				for (var i = 0; i < temprature_log.length; i++) {
					loglines[i].getElementsByClassName('date_val')[0].innerHTML = temprature_log[i][0];
					loglines[i].getElementsByClassName('temp_val')[0].innerHTML = temprature_log[i][1];
				}


			}
          }
        };

}