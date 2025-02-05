document.addEventListener('DOMContentLoaded', function () {
    var mapOptions = {
        center: { lat: parseFloat(gmpData.latitude), lng: parseFloat(gmpData.longitude) },
        zoom: 15,
    };
    var map = new google.maps.Map(document.getElementById('gmp-map'), mapOptions);

    var marker = new google.maps.Marker({
        position: { lat: parseFloat(gmpData.latitude), lng: parseFloat(gmpData.longitude) },
        map: map,
    });
});
