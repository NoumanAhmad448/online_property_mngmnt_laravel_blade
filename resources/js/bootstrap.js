window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'

import swal from 'sweetalert';


// import jQuery from './jquery-3.6.0.slim.min';  //deleted later, and installed with NPM
window.Alpine = Alpine;
Alpine.plugin(persist)

Alpine.start();

window.$ = window.jQuery = require('jquery'); //jquery added here after appling npm install --save jquery
import 'flowbite';
