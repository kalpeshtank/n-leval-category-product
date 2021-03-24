/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    setTimeout(function () {
        initAutocomplete();
    }, 4000);
});
function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 23.0225, lng: 72.5714}, zoom: 13, mapTypeId: 'roadmap'
    });
    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;
    document.getElementById('mapsubmit').addEventListener('click', function () {
        geocodeLatLng(geocoder, map, infowindow);
    });
    // Create the search box and link it to the UI element.
    var input = document.getElementById('google_locations');
    searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });
    markers = [];
    map.addListener('click', function (mapsMouseEvent) {
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];
        var icon = {
            url: "https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png",
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };
        // Create a marker for each place.
        markers.push(new google.maps.Marker({
            map: map,
            icon: icon,
            title: "",
            position: {lat: mapsMouseEvent.latLng.lat(), lng: mapsMouseEvent.latLng.lng()}
        }));
        $('#latitude_input').val(mapsMouseEvent.latLng.lat());
        $('#longitude_input').val(mapsMouseEvent.latLng.lng());
        geocodeLatLng(geocoder, map, infowindow);
    });
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];
        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: {lat: place.geometry.location.lat(), lng: place.geometry.location.lng()}
            }));
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            $('#latitude_input').val(place.geometry.location.lat());
            $('#longitude_input').val(place.geometry.location.lng());
            geocodeLatLng(geocoder, map, infowindow);
        });
        map.fitBounds(bounds);
    });
}
function geocodeLatLng(geocoder, map, infowindow) {
    var latitudeInput = document.getElementById('latitude_input').value;
    var longitudeInput = document.getElementById('longitude_input').value;
    var latlng = {lat: parseFloat(latitudeInput), lng: parseFloat(longitudeInput)};
    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === 'OK') {
            if (results[0]) {
                map.setZoom(11);
                var marker = new google.maps.Marker({position: latlng, map: map});
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}