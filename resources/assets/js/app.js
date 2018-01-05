require('./bootstrap');

window.Vue = require('vue');
import Buefy from 'buefy';

Vue.use(Buefy, {
  defaultIconPack: 'fa'
});

// Vue.component('example', require('./components/Example.vue'));

var app = new Vue({
  el: '#app',
  data: {}
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




jQuery(document).ready(function($) {


  function showSnackbar(){
    setTimeout(function(){
      $('.snackbar').addClass('opened');
    }, 500);
    setTimeout(function(){
      $('.snackbar').css('opacity', 0);
    }, 4500);
    setTimeout(function(){
      $('.snackbar').remove();
    }, 5000);
    $('.snackbar a').click(function(e) {
      e.preventDefault();
      $(this).parent().css('opacity', 0);
      setTimeout(function(){
        $(this).parent().remove();
      }, 500);
    });
  }

  showSnackbar();



  $('.form-delete-clinic .button').click(function(e){
    e.preventDefault();
    swal("¿Seguro que quieres eliminar esta clínica?", {
      dangerMode: true,
      buttons: ['Cancelar', "Eliminar"],
    })
    .then((willDelete) => {
      if (willDelete) {
        $(this).closest('form').submit();
      }
    });
  });

  $('.form-delete-invoice .button').click(function(e){
    e.preventDefault();
    swal("¿Seguro que quieres eliminar esta factura?", {
      dangerMode: true,
      buttons: ['Cancelar', "Eliminar"],
    })
    .then((willDelete) => {
      if (willDelete) {
        $(this).closest('form').submit();
      }
    });
  });

  $('.invoice-clinic-id-fake').change(function(e) {
    e.preventDefault();

    $('.invoice-clinic-id').val($(this).val());

    var clinic = $(this).find(':selected');
    var table = this.closest('table');

    if($(clinic).val()==0){
      $(table).find('.clinic-email').text('');
      $(table).find('.clinic-nif').text('');
      $(table).find('.clinic-address').text('');
      $(table).find('.clinic-address-2').text('');
      $(table).find('.clinic-phone-fax').text('');
      return;
    }

    $(table).find('.clinic-email').text($(clinic).data('email') || '');
    $(table).find('.clinic-nif').text($(clinic).data('nif') || '');
    $(table).find('.clinic-address').text($(clinic).data('address') || '');
    $(table).find('.clinic-address-2').text($(clinic).data('post_code')+' '+$(clinic).data('locality')+' ('+$(clinic).data('province')+')' || '');
    $(table).find('.clinic-phone-fax').text($(clinic).data('phone')+' / '+$(clinic).data('fax') || '');

  });

  //Remove danger input classes on keydown
  $('input, textarea, select').on('keydown change', function(e) {
    if($(this).hasClass('is-danger')){
      $(this).removeClass('is-danger').addClass('is-primary');
      $(this).parent().next('.help.is-danger').remove();
      $(this).parent().parent().removeClass('has-error');
    }
  });

  //Change invoice_date input value when changes invoice_date_fake value
  $('.invoice-date-fake').change(function(e) {
    $('.invoice-date').val($(this).val());
  });

  //Invoice remove invoice lines
  $('.remove-invoice-line').click(function(e) {
    e.preventDefault();
    $(this).closest('tr').remove();
    calculateInvoiceTotal();
  });

  //Invoice add invoice lines
  $('.add-invoice-line').click(function(e) {
    createNewInvoiceLine();
  });

  $('.invoice-quantity, .invoice-unit-price').on('keyup change', function(){
    if($(this).val() == '') $(this).val(1);
    var $_invoice_line = $(this).closest('tr');
    calculateLineTotal($_invoice_line);
  })

  function createNewInvoiceLine(statusClass = 'is-primary'){
    var lastDataId = $('.invoice-details-table tbody tr').last().data('id') || 0;
    var newDataId = lastDataId+1;

    var tr = document.createElement('tr');
        tr.className = 'invoice-line';
        tr.dataset.id = newDataId;
    var tdDescription = document.createElement('td');
        tdDescription.className = 'has-input-field';
    var inputDescription = document.createElement('input');
        inputDescription.className = 'invoice-description input '+statusClass;
        inputDescription.name = 'invoiceline['+newDataId+'][description]';
        inputDescription.required = 'required';
    var tdQuantity = document.createElement('td');
        tdQuantity.className = 'has-input-field w-100';
    var inputQuantity = document.createElement('input');
        inputQuantity.className = 'invoice-quantity input is-primary';
        inputQuantity.name = 'invoiceline['+newDataId+'][quantity]';
        inputQuantity.type = 'number';
        inputQuantity.value = 1;
        inputQuantity.min = 1;
        inputQuantity.required = 'required';
        inputQuantity.addEventListener('change', function(e){
          if($(this).val() == '') $(this).val(1);
          var $_invoice_line = $(this).closest('tr');
          calculateLineTotal($_invoice_line);
        });
    var tdUnitPrice = document.createElement('td');
        tdUnitPrice.className = 'has-input-field w-150';
    var inputUnitPrice = document.createElement('input');
        inputUnitPrice.className = 'invoice-unit-price input is-primary';
        inputUnitPrice.name = 'invoiceline['+newDataId+'][unit_price]';
        inputUnitPrice.type = 'number';
        inputUnitPrice.value = 1;
        inputUnitPrice.min = 1;
        inputUnitPrice.required = 'required';
        inputUnitPrice.addEventListener('change', function(e){
          if($(this).val() == '') $(this).val(1);
          var $_invoice_line = $(this).closest('tr');
          calculateLineTotal($_invoice_line);
        });
    var tdTotal = document.createElement('td');
        tdTotal.className = 'has-text-right w-150';
    var spanTotal = document.createElement('span');
        spanTotal.className = 'invoice-line-total';
        spanTotal.innerHTML = '1€';
    var tdRemove = document.createElement('td');
        tdRemove.className = 'is-empty has-input-field w-10';
    var spanRemove = document.createElement('span');
        spanRemove.className = 'remove-invoice-line has-text-danger';
        spanRemove.title = 'Eliminar línea';
        spanRemove.innerHTML = '&times;';
        spanRemove.addEventListener('click', function(e){
          e.preventDefault();
          $(this).closest('tr').remove();
          calculateInvoiceTotal();
        });

        tdRemove.appendChild(spanRemove);
        tdTotal.appendChild(spanTotal);
        tdUnitPrice.appendChild(inputUnitPrice);
        tdQuantity.appendChild(inputQuantity);
        tdDescription.appendChild(inputDescription);

        tr.appendChild(tdDescription);
        tr.appendChild(tdQuantity);
        tr.appendChild(tdUnitPrice);
        tr.appendChild(tdTotal);
        tr.appendChild(tdRemove);

        $('.invoice-details-table tbody').append(tr);
        calculateInvoiceTotal();
  }

  function calculateLineTotal(invoiceLine){
    var _quantity = parseFloat(invoiceLine.find('.invoice-quantity').val());
    var _unit_price = parseFloat(invoiceLine.find('.invoice-unit-price').val());
    var _total = _quantity * _unit_price;
        _total = numberFormat(_total,2,',','.');
        _total = _total.replace(',00', '');

    invoiceLine.find('.invoice-line-total').html(_total+'€');
    calculateInvoiceTotal();
  }

  function calculateInvoiceTotal(){
    var _invoice_subtotal = 0;
    var _invoice_retention = parseFloat($('.invoice-retention').text());
    var _invoice_retention_total = 0;
    var _invoice_total = 0;

    $('.invoice-line').each(function(index, invoiceLine) {
      var _invoice_line_total = $(invoiceLine).find('.invoice-line-total').html();
          _invoice_line_total = parseFloat(_invoice_line_total.replace('.','').replace(',', '.'));

      _invoice_subtotal += _invoice_line_total;
    });

    _invoice_retention_total = _invoice_subtotal * _invoice_retention / 100;
    _invoice_total = _invoice_subtotal - _invoice_retention_total;

    _invoice_subtotal = numberFormat(_invoice_subtotal,2,',','.');
    _invoice_subtotal = _invoice_subtotal.replace(',00', '')+'€';
    $('.create-invoice-form').find('.invoice-subtotal').html(_invoice_subtotal);

    _invoice_retention_total = numberFormat(_invoice_retention_total,2,',','.');
    _invoice_retention_total = _invoice_retention_total.replace(',00', '')+'€';
    $('.create-invoice-form').find('.invoice-retention-total').html(_invoice_retention_total);

    _invoice_total = numberFormat(_invoice_total,2,',','.');
    _invoice_total = _invoice_total.replace(',00', '')+'€';
    $('.create-invoice-form').find('.invoice-total').html(_invoice_total);
  }

  function numberFormat(number, decimals, dec_point, thousands_sep) {
      var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          toFixedFix = function (n, prec) {
              // Fix for IE parseFloat(0.55).toFixed(0) = 0;
              var k = Math.pow(10, prec);
              return Math.round(n * k) / k;
          },
          s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
      if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
  }

  $('.create-invoice-form').submit(function(e) {
    var $_invoice_lines = $(this).find('.invoice-line');
    if(!$_invoice_lines.length){
      createNewInvoiceLine('is-danger');
      e.preventDefault();
      return;
    }
  });

  $('.submit-invoice').click(function(e) {
    e.preventDefault();

    var _errors = false;
    var $_invoiceLines = {};
    var $_form = $(this).closest('form');
    var _clinicId = $('.invoice-clinic-id').val();
    var _invoiceDate = $('.invoice-date').val();

    if(_clinicId == '' || _clinicId == 0 || _clinicId == null){
      _errors = true;
      $('.invoice-clinic-id-fake').removeClass('is-primary').addClass('is-danger');
    }else{
      $('.invoice-clinic-id-fake').removeClass('is-danger').addClass('is-primary');
    }

    if(_invoiceDate == '' || _invoiceDate == 0 || _invoiceDate == null){
      _errors = true;
      $('.invoice-date-fake').removeClass('is-primary').addClass('is-danger');
    }else{
      $('.invoice-date-fake').removeClass('is-danger').addClass('is-primary');
    }

    $('.invoice-line').each(function(index, line) {
      var _id = $(line).data('id');
      var _description = $(line).find('.invoice-description');
      var _quantity = $(line).find('.invoice-quantity');
      var _unit_price = $(line).find('.invoice-unit-price');


      if(_description.val() == ''){
        _errors = true;
        _description.removeClass('is-primary').addClass('is-danger');
      }else{
        _description.removeClass('is-danger').addClass('is-primary');
      }

      if(_quantity.val() == ''){
        _errors = true;
        _quantity.removeClass('is-primary').addClass('is-danger');
      }else{
        _quantity.removeClass('is-danger').addClass('is-primary');
      }

      if(_unit_price.val() == ''){
        _errors = true;
        _unit_price.removeClass('is-primary').addClass('is-danger');
      }else{
        _unit_price.removeClass('is-danger').addClass('is-primary');
      }

      $_invoiceLines[_id] = {
        'description': _description.val(),
        'quantity': _quantity.val(),
        'unit_price': _unit_price.val(),
        'errors': {
          'description': _description.val() == '',
          'quantity': _quantity.val() == '',
          'unit_price': _unit_price.val() == '',
        }
      };
    });

    if(_errors) return;
    else $_form.submit();

    // var form = $('.create-invoice-form');
    // var _url = form.attr('action');
    // var _token = form.find('input[name="_token"]').val();
    // var _invoiceDate = $('.invoice-date').val();
    // var _invoiceNo = $('.invoice-no').data('invoiceno');

    // $.ajax({
    //   url: _url,
    //   method: 'post',
    //   data: {
    //     _token: _token,
    //     invoice_no: _invoiceNo,
    //     invoice_date: _invoiceDate,
    //     invoice_lines: $_invoiceLines,
    //   },
    // })
    // .done(function(response) {
    //   console.log(response);
    //   console.log("success");
    // })
    // .fail(function() {
    //   console.log("error");
    // })
    // .always(function() {
    //   console.log("complete");
    // });
  });



});






















