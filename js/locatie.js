getLocation();
var x = document.getElementById("x-coord");
var y = document.getElementById("y-coord");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocatia nu este suportata de browserul dvs.";}
    }
    
    function showPosition(position) {
        x.innerHTML="X: " + position.coords.latitude.toFixed(3);
        y.innerHTML="Y: " + position.coords.longitude.toFixed(3);
    }

