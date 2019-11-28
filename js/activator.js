(function() {
	var elements = document.getElementsByClassName('hidden');
	for(var i=0; i < elements.length; i++) {
		elements[i].style.display = "none";
	}
})();

function activator() {
  var x = document.getElementsByClassName("hidden")[0];
  if (x.style.display === "none") {
    x.style.display = "block";
    document.getElementById('arrow-img').src = "img/arrow-top.png";
  } else {
    x.style.display = "none";
    document.getElementById('arrow-img').src = "img/arrow-down.png";
  }
}