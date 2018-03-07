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

  function createSnackbar(message){
    var div = document.createElement('div');
        div.className = 'snackbar';
        div.innerText = message;
    var a = document.createElement('a');
        a.href = '#';
        a.innerText = 'OK';

    div.appendChild(a);
    $('body').append(div);
    showSnackbar();
  }

  showSnackbar();

  $('.dropdown-label').click(function(e) {
    e.preventDefault();
    $(this).parent().toggleClass('is-opened');
  });

  $(document).on('click', '.show-pdf-button', function(e) {
    $('.loader-wrapper').addClass('opened');
  });

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

  $('.invoice-state-switcher').click(function(e) {
    var that = $(this);
    var checkbox = $('#invoice-state-input');
    var checked = checkbox.is(":checked");
    checkbox.prop('checked', !checked);
    that.toggleClass('paid unpaid');
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
      $(this).removeClass('is-danger');
      $(this).parent().next('.help.is-danger').remove();
      $(this).parent().parent().removeClass('has-error');
    }
  });

  //Invoice remove invoice lines
  // $('.remove-invoice-line').click(function(e) {
  //   e.preventDefault();
  //   $(this).closest('tr').remove();
  //   calculateInvoiceTotal();
  // });

  $(document).on('click', '.remove-invoice-line', function(e) {
    e.preventDefault();
    $(this).closest('tr').remove();
    calculateInvoiceTotal();
  });

  //Invoice add invoice lines
  $('.add-invoice-line').click(function(e) {
    createNewInvoiceLine();
  });

  // $('.invoice-quantity, .invoice-unit-price').on('keyup change', function(e){
  //   // if($(this).val() == '') $(this).val(1);
  //   var $_invoice_line = $(this).closest('tr');
  //   calculateLineTotal($_invoice_line);
  // });

  // $('.invoice-retention').on('keyup change', function(e) {
  //   calculateInvoiceTotal();
  // });

  // $('.invoice-unit-price').on('keyup change', function(e) {
  //   calculateInvoiceTotal();
  // });

  // Recalculate invoice line total and grand total
  $(document).on('keyup change', '.invoice-quantity, .invoice-unit-price', function(e) {
    var $_invoice_line = $(this).closest('tr');
    calculateLineTotal($_invoice_line);
  });

  // Recalculate invoice grand total
  $(document).on('keyup change', '.invoice-dentist-percentage, .invoice-retention', function(e) {
    calculateInvoiceTotal();
  });

  function createNewInvoiceLine(statusClass = ''){
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
        inputQuantity.className = 'invoice-quantity input';
        inputQuantity.name = 'invoiceline['+newDataId+'][quantity]';
        inputQuantity.type = 'number';
        inputQuantity.value = 1;
        inputQuantity.min = 1;
        inputQuantity.required = 'required';
        // inputQuantity.addEventListener('keyup', function(e){
        //   if($(this).val() == '') $(this).val(1);
        //   var $_invoice_line = $(this).closest('tr');
        //   calculateLineTotal($_invoice_line);
        // });
        // inputQuantity.addEventListener('change', function(e){
        //   if($(this).val() == '') $(this).val(1);
        //   var $_invoice_line = $(this).closest('tr');
        //   calculateLineTotal($_invoice_line);
        // });
    var tdUnitPrice = document.createElement('td');
        tdUnitPrice.className = 'has-input-field w-150';
    var inputUnitPrice = document.createElement('input');
        inputUnitPrice.className = 'invoice-unit-price input';
        inputUnitPrice.name = 'invoiceline['+newDataId+'][unit_price]';
        inputUnitPrice.type = 'number';
        inputUnitPrice.value = 1;
        inputUnitPrice.min = 1;
        inputUnitPrice.required = 'required';
        // inputUnitPrice.addEventListener('keyup', function(e){
        //   if($(this).val() == '') $(this).val(1);
        //   var $_invoice_line = $(this).closest('tr');
        //   calculateLineTotal($_invoice_line);
        // });
        // inputUnitPrice.addEventListener('change', function(e){
        //   if($(this).val() == '') $(this).val(1);
        //   var $_invoice_line = $(this).closest('tr');
        //   calculateLineTotal($_invoice_line);
        // });
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
        // spanRemove.addEventListener('click', function(e){
        //   e.preventDefault();
        //   $(this).closest('tr').remove();
        //   calculateInvoiceTotal();
        // });

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
        $('.create-invoice-form').find('.invoice-description').last().focus();
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
    var _invoice_dentist_percent = parseFloat($('.invoice-dentist-percentage').val());
    var _invoice_dentist_sub_total = 0;
    var _invoice_retention = parseFloat($('.invoice-retention').val());
    var _invoice_retention_total = 0;
    var _invoice_total = 0;

    $('.invoice-line').each(function(index, invoiceLine) {
      var _invoice_line_total = $(invoiceLine).find('.invoice-line-total').html();
          _invoice_line_total = parseFloat(_invoice_line_total.replace('.','').replace(',', '.'));

      _invoice_subtotal += _invoice_line_total;
    });

    _invoice_dentist_sub_total = _invoice_subtotal * _invoice_dentist_percent / 100;
    _invoice_retention_total = _invoice_dentist_sub_total * _invoice_retention / 100;
    _invoice_total = _invoice_dentist_sub_total - _invoice_retention_total;

    _invoice_subtotal = numberFormat(_invoice_subtotal,2,',','.', true);
    _invoice_subtotal = _invoice_subtotal.replace(',00', '')+'€';
    $('.create-invoice-form').find('.invoice-subtotal').html(_invoice_subtotal);

    _invoice_dentist_sub_total = numberFormat(_invoice_dentist_sub_total,2,',','.', true);
    _invoice_dentist_sub_total = _invoice_dentist_sub_total.replace(',00', '')+'€';
    $('.create-invoice-form').find('.invoice-dentist-percentage-total span').html(_invoice_dentist_sub_total);

    _invoice_retention_total = numberFormat(_invoice_retention_total,2,',','.', false);
    _invoice_retention_total = _invoice_retention_total.replace(',00', '')+'€';
    $('.create-invoice-form').find('.invoice-retention-total').html(_invoice_retention_total);

    _invoice_total = numberFormat(_invoice_total,2,',','.', true);
    _invoice_total = _invoice_total.replace(',00', '')+'€';
    $('.create-invoice-form').find('.invoice-total').html(_invoice_total);
  }

  function numberFormat(number, decimals, dec_point, thousands_sep, up = false) {
      var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          toFixedFix = function (n, prec) {
              // Fix for IE parseFloat(0.55).toFixed(0) = 0;
              var k = Math.pow(10, prec);
              if(up){
                return Math.ceil(n * k) / k;
              }else{
                return Math.floor(n * k) / k;
              }
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
      $('.invoice-clinic-id-fake').removeClass('is-danger');
    }

    if(_invoiceDate == '' || _invoiceDate == 0 || _invoiceDate == null){
      _errors = true;
      $('.invoice-date-fake').removeClass('is-primary').addClass('is-danger');
    }else{
      $('.invoice-date-fake').removeClass('is-danger');
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
        _description.removeClass('is-danger');
      }

      if(_quantity.val() == ''){
        _errors = true;
        _quantity.removeClass('is-primary').addClass('is-danger');
      }else{
        _quantity.removeClass('is-danger');
      }

      if(_unit_price.val() == ''){
        _errors = true;
        _unit_price.removeClass('is-primary').addClass('is-danger');
      }else{
        _unit_price.removeClass('is-danger');
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


jQuery(document).ready(function($) {

  generateFloatingTooths();
  generateParticles();

	$(window).on('load scroll', function(e) {
		showAppearElements();

    if($('#footer .heart').visible()){
      setTimeout(function(){
        $('#footer .heart').addClass('visible');
      }, 700);
    }
	});

  // Menú actions
  $('.side-menu-icons').click(function(e) {
    $('#app').toggleClass('side-menu-opened');
  });

  // User Settings Page
  $('#custom-logo-file-input').hover(function() {
    $(this).prev('.select-file-fake-button').addClass('is-hovered');
  }, function() {
    $(this).prev('.select-file-fake-button').removeClass('is-hovered');
  });

  $('#custom-logo-file-input').change(function(e) {
    e.preventDefault();

    var file = null;
    var filename = "Ningún archivo seleccionado";
    var size = 0;
    var width = 0;
    var height = 0;
    var logourl = null;

    if(this.files.length){
      file = this.files.item(0);
      filename = file.name;
      size = file.size;
    }

    $('#custom-logo-upload').find('.filename').text(filename);

    if(file === null){
      logourl = $('#default-logo-file-input').val();
    }else{
      logourl = window.URL.createObjectURL(file);
    }

    // Remove previous image & create image tag and append to form for previsualize it
    $('#logo-previewer').remove();

    var imgFake = document.createElement('img');
        imgFake.id = 'logo-previewer';
        imgFake.width = 225;
        imgFake.addEventListener('load', function(){
          width  = imgFake.naturalWidth  || imgFake.width;
          height = imgFake.naturalHeight || imgFake.height;
        });
    imgFake.src = window.URL.createObjectURL(file);
    width = imgFake.naturalWidth;
    height = imgFake.naturalHeight;
    $('#logo-previewer-container').prepend(imgFake);
    $('#remove-custom-logo-input').val(0);
    $('.btn-set-default-logo').addClass('visible');
  });

  $('.btn-set-default-logo').click(function(e) {
    var removeCustomLogo = $('#remove-custom-logo-input').val();

    if(removeCustomLogo == 0){
      var custom_logo_src = $('#logo-previewer-container').data('defaultlogo');
      $('#logo-previewer').attr('src', custom_logo_src);
      $('#custom-logo-file-input').val('');
      $('#custom-logo-upload .filename').text('Ningún archivo seleccionado');
      $('#remove-custom-logo-input').val(1);
      $(this).removeClass('visible');
    }
  });

});

function showAppearElements() {
  var hasAppear = $('.appear').length;
  var hasAppearParents = $('.appear-parent').length;

  if(hasAppear){
  	$('.appear').each(function() {
          if ( $(this).visible(true) ){
          	$(this).addClass('visible');
          }
  	});
  }

  if(hasAppearParents){
  	$('.appear-parent').each(function() {
          if ( $(this).visible(true) ){
  			var reverse = $(this).hasClass('areverse');
          	var children = (reverse) ? $(this).find('.appear-child').reverse() : $(this).find('.appear-child');
          	revealChilds(children);
          }
  	});
  }
}

function generateFloatingTooths(){
  for(i = 0; i < 20; i++) {
    $('.floating-tooth-background').append('<span class="icon floating-tooth"><i class="mdi mdi-tooth"></i></span>');
  }
}

function generateParticles(){
  for(i = 0; i < 80; i++) {
    $('.particles-content').append('<span class="particle"></span>');
  }
}

function reveal(selector){
	var elems = $(selector+':not(.reveal)');
	var i = 0;

	setInterval(function(){
		if ( i >= elems.length ) return false;
		var el = elems[i];
		$(el).addClass('reveal');
		i ++;
	}, 200);
}

function revealChilds(children){
	var i = 0;

	setInterval(function(){
		if ( i >= children.length ) return false;
		var el = children[i];
		$(el).addClass('visible');
		i ++;
	}, 100);
}

$.fn.reverse = [].reverse;

$.fn.scrollTo = function (speed) {
  if (typeof(speed) === 'undefined') speed = 1000;

  $('html, body').animate({
      scrollTop: parseInt($(this).offset().top)
  }, speed);
};

$.fn.visible = function(partial) {
    var $t            = $(this),
        $w            = $(window),
        viewTop       = $w.scrollTop(),
        viewBottom    = viewTop + $w.height(),
        _top          = $t.offset().top,
        _bottom       = _top + $t.height(),
        compareTop    = partial === true ? _bottom : _top,
        compareBottom = partial === true ? _top : _bottom;

  return ((compareBottom <= viewBottom) && (compareTop >= viewTop));
}

$.fn.visibleBottom = function(partial) {
    var $t            = $(this),
        $w            = $(window),
        viewTop       = $w.scrollTop(),
        viewBottom    = viewTop + $w.height(),
        _top          = $t.offset().top,
        _bottom       = _top + $t.height();

  return viewBottom >= _bottom && viewTop <= _bottom;
}

$.fn.bottomPosition = function(partial) {
    var $t            = $(this),
        $w            = $(window),
        viewTop       = $w.scrollTop(),
        viewBottom    = viewTop + $w.height(),
        _top          = $t.offset().top,
        _bottom       = _top + $t.height();

  // return 'vt=' + viewTop + '\nvb=' + viewBottom + '\nbt=' + (_bottom - viewTop);
  return (_bottom - viewTop) * 100 / (viewTop - viewBottom) * -1;
}

  $.fn.translateX = function(val, measure) {
  	measure = measure || "px";
  	$(this).css({
        '-webkit-transform': 'translateX(' + val + measure + ')',
        '-moz-transform': 'translateX(' + val + measure + ')',
        '-ms-transform': 'translateX(' + val + measure + ')',
        '-o-transform': 'translateX(' + val + measure + ')',
        'transform': 'translateX(' + val + measure + ')'
    });
  }
  $.fn.translateY = function(val, measure) {
  	measure = measure || "px";
  	$(this).css({
        '-webkit-transform': 'translateY(' + val + measure + ')',
        '-moz-transform': 'translateY(' + val + measure + ')',
        '-ms-transform': 'translateY(' + val + measure + ')',
        '-o-transform': 'translateY(' + val + measure + ')',
        'transform': 'translateY(' + val + measure + ')'
    });
  }
  $.fn.translate3d = function(valx, valy, valz, measure) {
  	measure = measure || "px";
  	$(this).css({
        '-webkit-transform': 'translate3d(' + valx + measure + ', ' + valy + measure + ', ' + valz + measure + ')',
        '-moz-transform': 'translate3d(' + valx + measure + ', ' + valy + measure + ', ' + valz + measure + ')',
        '-ms-transform': 'translate3d(' + valx + measure + ', ' + valy + measure + ', ' + valz + measure + ')',
        '-o-transform': 'translate3d(' + valx + measure + ', ' + valy + measure + ', ' + valz + measure + ')',
        'transform': 'translate3d(' + valx + measure + ', ' + valy + measure + ', ' + valz + measure + ')'
    });
  }

  $.fn.rotate = function(deg) {
  	$(this).css({
        '-webkit-transform': 'rotate(' + deg + 'deg)',
        '-moz-transform': 'rotate(' + deg + 'deg)',
        '-ms-transform': 'rotate(' + deg + 'deg)',
        '-o-transform': 'rotate(' + deg + 'deg)',
        'transform': 'rotate(' + deg + 'deg)'
    });
  }

  $.fn.displayFlex = function() {
  	$(this).css({
        'display': '-webkit-flex',
      'display': '-moz-flex',
      'display': '-ms-flex',
      'display': '-o-flex',
      'display': 'flex'
    });
  }

  $.fn.backgroundImage = function(imgUrl) {
  	$(this).css('background-image', 'url('+imgUrl+')');
  }
