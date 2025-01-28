import axios from 'axios';
window.axios = axios;
import Toastify from 'toastify-js'
window.Toastify = Toastify;
import * as Chart from 'chart.js'
window.Chart = Chart;
import Highcharts from 'highcharts';
window.Highcharts = Highcharts;
import * as L from 'leaflet';
window.L = L;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
