import Places from 'places.js';
//import Map from "./js/map";
import 'select2';
import $ from "jquery";
import './js/admin';
import './js/picture';
import './js/slider';
import './js/navbar';

// start the Stimulus application
import 'bootstrap/scss/bootstrap.scss';


import '@glidejs/glide/dist/css/glide.core.min.css';
import '@glidejs/glide/dist/css/glide.theme.min.css';
import '@fortawesome/fontawesome-free/css/all.css';
//import 'boxicons/css/boxicons.min.css';
import 'select2/dist/css/select2.css';
import './css/app.scss';

$(document).ready(function() { $("select").select2(); });

//Map.init();

let inputAddress = document.querySelector('#property_address')
if (inputAddress !== null) {
    let place = Places({
        container: inputAddress
    })
    place.on('change', e => {
        document.querySelector('#property_city').value = e.suggestion.city
        document.querySelector('#property_postal_code').value = e.suggestion.postcode
        document.querySelector('#property_lat').value = e.suggestion.latlng.lat
        document.querySelector('#property_lng').value = e.suggestion.latlng.lng
    })
}

let searchAddress = document.querySelector('#search_address')
if (searchAddress !== null) {
    let place = Places({
        container: searchAddress
    })
    place.on('change', e => {
        document.querySelector('#lat').value = e.suggestion.latlng.lat
        document.querySelector('#lng').value = e.suggestion.latlng.lng
    })
}