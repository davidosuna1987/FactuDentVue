require('./bootstrap');
require('./main.js');

window.Vue = require('vue');
import Buefy from 'buefy';

Vue.use(Buefy, {
  defaultIconPack: 'mdi',
  defaultDateFormatter: (date) => date.toLocaleString("es", { day: "numeric" }) + ' de ' +
                                  date.toLocaleString("es", { month: "long"  }) + ' de ' +
                                  date.toLocaleString("es", { year: "numeric"})
});

Vue.component('invoices', require("./components/Invoices.vue"))
Vue.component('clinics', require("./components/Clinics.vue"))

const app = new Vue({
  el: '#app',
  data() {
    return {
      monthNames: ["Enero", "Febrero", "Marzo", "Abril", "May0", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      dayNames: ["D", "L", "M", "X", "J", "V", "S"],
      invoiceDateExpedition: null, //Para la creación y edición de facturas
      customLogo: null, //Para editar el logo en los PDF de las facturas
    }
  },
  methods: {
    invoiceDateFormatter(date) {
      return date = date.toLocaleString("es", { day: "2-digit" }) + '/' +
             date.toLocaleString("es", { month: "2-digit"  }) + '/' +
             date.toLocaleString("es", { year: "numeric"})
    }
  },
  created: function () {
    var invoice_date = $('input.invoice-date');
    if(invoice_date.length){
      if(invoice_date.val()){
        this.invoiceDateExpedition = new Date(invoice_date.val());
      }
    }
  }
});

// BULMA responsive menú open and close
document.addEventListener('DOMContentLoaded', function () {

  // Get all "navbar-burger" elements
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach(function ($el) {
      $el.addEventListener('click', function () {

        // Get the target from the "data-target" attribute
        var target = $el.dataset.target;
        var $target = document.getElementById(target);

        // Toggle the class on both the "navbar-burger" and the "navbar-menu"
        $el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }
});
