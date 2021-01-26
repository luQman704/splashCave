import Vue from 'vue'
require('./bootstrap');
import userList from './components/usersList'
import App from './App'
import axios from 'axios'
Vue.component('userList', require('./components/usersList'));

window.axios = axios

require('./components')

var app = new Vue({
    el: '#app',
    components: {
        'userList': require('./components/usersList.vue'),
    }
});
/*const ELM = '#app'
const mountEl = document.querySelector(ELM);
if (mountEl) {
    new Vue({
        render: createElement => {
            const context = {
                props: { ...mountEl.dataset },
            };
            return createElement(App, context);
        },
    }).$mount(ELM)
}*/
