import Places from 'places.js'
import Filter from "./js/filter";
import 'select2';
import $ from "jquery";
import './js/admin';
import './js/picture';

new Filter(document.querySelector('.js-filter'))

// start the Stimulus application
import noUSlider from 'nouislider';
import 'nouislider/dist/nouislider.css'
import 'select2/dist/css/select2.css'
import './css/app.css';
import './bootstrap';

import 'bootstrap/dist/css/bootstrap.css';

const slider = document.getElementById('price-slider');

/**
 * The price filter
 *
 * This system will allow the user to change the minimum and maximum price by simple drag and drop.
 */
if (slider) {
    const min = document.getElementById('min')
    const max = document.getElementById('max')
    const minValue = Math.floor(parseInt(slider.dataset.min, 10) / 10) * 10
    const maxValue = Math.ceil(parseInt(slider.dataset.max, 10) / 10) * 10
    const range = noUSlider.create(slider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        step: 10,
        range: {
            'min': minValue,
            'max': maxValue
        }
    })
    range.on('slide', function (values,handleNumber) {
        if (handleNumber === 0 ) {
            min.value = Math.round(values[0])
        }
        if (handleNumber === 1) {
            max.value = Math.round(values[1])
        }
    })
    range.on('end', function (values,handleNumber){
        min.dispatchEvent(new Event('change'))
    })
}

$(document).ready(function() { $("select").select2(); });


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