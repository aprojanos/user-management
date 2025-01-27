import axios from 'axios';
window.axios = axios;
import Toastify from 'toastify-js';
window.Toastify = Toastify;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
