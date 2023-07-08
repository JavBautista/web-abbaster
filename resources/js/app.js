
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('admin-courses', require('./components/AdminCourses.vue'));
Vue.component('admin-course-videos', require('./components/AdminCourseVideos.vue'));
Vue.component('admin-messages-customer', require('./components/AdminMessagesCustomer.vue'));
Vue.component('admin-products', require('./components/AdminProducts.vue'));
Vue.component('admin-projects', require('./components/AdminProjects.vue'));
Vue.component('admin-po-products', require('./components/AdminPurchaseOrderProducts.vue'));
Vue.component('admin-po-products-surtir', require('./components/AdminPurchaseOrderProductsSurtir.vue'));
Vue.component('admin-sale-chat', require('./components/AdminSaleChat.vue'));
Vue.component('admin-services', require('./components/AdminServices.vue'));
Vue.component('admin-testimonios', require('./components/AdminTestimonios.vue'));
Vue.component('admin-users', require('./components/AdminUsers.vue'));
Vue.component('operation-recepcion', require('./components/CedisOperationRecepcion.vue'));
Vue.component('confirm-payment', require('./components/ConfirmPayment.vue'));
Vue.component('customer-course-video', require('./components/CustomerCourseVideos.vue'));
Vue.component('customer-information', require('./components/CustomerInformation.vue'));
Vue.component('customer-messages', require('./components/CustomerMessages.vue'));
Vue.component('customer-register', require('./components/CustomerRegister.vue'));
Vue.component('destacados-abbaster', require('./components/DestacadosAbbaster.vue'));
Vue.component('directorio-clientes', require('./components/DirectorioClientes.vue'));
Vue.component('directorio-clientes-shop', require('./components/DirectorioClientesShop.vue'));
Vue.component('dollar-price', require('./components/DollarPrice.vue'));
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('charts', require('./components/MetricasCharts.vue'));
Vue.component('visitas-categorias', require('./components/MetricasVisitasCategorias.vue'));
Vue.component('visitas-productos', require('./components/MetricasVisitasProductos.vue'));
Vue.component('visitas-web', require('./components/MetricasVisitasWeb.vue'));
Vue.component('visitas-web-range', require('./components/MetricasVisitasWebRange.vue'));
Vue.component('visitas-web-mes', require('./components/MetricasVisitasWebMes.vue'));
Vue.component('payment', require('./components/Payment.vue'));
Vue.component('product-comentarios', require('./components/ProductComentarios.vue'));
Vue.component('questions-products', require('./components/QuestionsProducts.vue'));
Vue.component('section-price-cripto', require('./components/SectionPriceCripto.vue'));
Vue.component('shopping-cart', require('./components/ShoppingCart.vue'));
Vue.component('testvideo-component', require('./components/TestVideoComponent.vue'));
Vue.component('warehouse-component', require('./components/Warehouse.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

//console.log('Mensaje desde app.js');

$(document).ready(function() {
  $('#summernote').summernote();
});

/*   script que guarda temporalmente el pago */
window.mercadoPago  = function (cart_id, url_redirect, cart_title) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var url = '/payment/mercadopago/preorder';
    axios.post
    (url, {cart_id: cart_id, cart_title: cart_title})
        .then(function (response) {
            var status = response.data.status;
            console.log(url_redirect);

            if(status == 200){
                window.location = url_redirect
                ;
            }
        })
        .catch(function (error) {

        })
        .then(function () {
        });
}

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';


/* $( "#datepicker" ).datepicker(); */
$('.datepicker').datepicker({
    altFormat: "YYYY-MM-DD"
});





jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'far fa-trash-alt',
      close: 'far fa-times-circle'
    }
});

