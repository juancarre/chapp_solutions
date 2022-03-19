

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/theme.scss';
import './styles/home.scss'
import './styles/reservation.scss'


// loads the Bootstrap jQuery plugins
import 'bootstrap-sass/assets/javascripts/bootstrap/transition.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/alert.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/collapse.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/dropdown.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/modal.js';
import 'bootstrap-datepicker/js/bootstrap-datepicker.js'
import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.es'
import 'jquery';

//Pages js
import './js/base.js';
import './js/request.js'
import './js/reservation/new.js'


// start the Stimulus application
import './bootstrap';
