
// any CSS you import will output into a single css file (app.css in this case)

import './js/admin';
import './js/picture'

// start the Stimulus application
import noUSlider from 'nouislider';
import 'nouislider/dist/nouislider.css'
import './css/app.css';
import './bootstrap';

import 'bootstrap/dist/css/bootstrap.css';

const slider = document.getElementById('price-slider');

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
        console.log(values, handleNumber)
    })
}
