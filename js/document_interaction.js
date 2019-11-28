(function() {
  var signers = document.getElementsByClassName('signer');
  var modal = document.getElementById('myModal');
  var span = document.getElementsByClassName("close")[0];

  span.onclick = function() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
  }

  window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  for (var i = 0; i < signers.length; i++) {
    var signImg = signers[i].getElementsByClassName('link')[0];

    signImg.addEventListener('click', function() {
  	var modal = document.getElementById('myModal');
	if(isSafari()!=true) {
	  modal.style.display = "block";        
	}

	var id = $(this).val();
	var data = document.getElementById('data'+id);
	var doc_hash = data.value;
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
	
	xmlhttp.doc_id = doc_hash;
	var tmp_string = "link.php?user_id="+getCookie("user_id")+"&hash="+getCookie("hash")+"&doc_id="+doc_hash;

	xmlhttp.open("GET",tmp_string,false);
	xmlhttp.send(null);

	if (xmlhttp.status === 200) {
		var iframe = document.getElementById("frame");
		if(isSafari()!=true) {
			iframe.src=xmlhttp.responseText;
		} else {
			var win = window.open(xmlhttp.responseText, '_blank');
  			win.focus();
		}
	}
	});
  }
})();

function writeInDB(id, link) {
    if (id == "") {
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.open("GET","writedb.php?id="+id+"&link="+link,true);
        xmlhttp.onload = function (e) {
          if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200 && xmlhttp.responseText.includes('200')) {
              window.alert('Successfully updated.');
            } else {
              window.alert('Error occured. ' + xmlhttp.responseText);
            }
          }
        };
        xmlhttp.onerror = function (e) {
          console.error(xmlhttp.statusText);
        };
        xmlhttp.send(null);
    }
}


function isSafari() {
var userAgent = window.navigator.userAgent;
if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i)) {
   return true;// iPad or iPhone
}
else {
   return false;// Anything else
}}


function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}


