

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY, // Sử dụng biến môi trường để lấy giá trị key từ file .env
    cluster: process.env.MIX_PUSHER_APP_CLUSTER, // Sử dụng biến môi trường để lấy giá trị cluster từ file .env
    encrypted: true, // Sử dụng kết nối mã hóa
});