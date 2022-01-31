/*jshint multistr: true */

window.addEventListener('load', function() {
  //remove link breadcrumb, header and save button
  document.querySelector('.wc-admin-breadcrumb').style.display = 'none';
  if (document.querySelector('.mp-header-logo') !== null){
    document.querySelector('.mp-header-logo').style.display = 'none';
  } else {
    var pElement = document.querySelectorAll('#mainform > p');
    pElement[0] !== undefined ? pElement[0].style.display = 'none' : null;
  }
  document.querySelector('p.submit').style.display = 'none';

  var h2s = document.querySelectorAll('h2');
  h2s[4] !== undefined ? h2s[4].style.display = 'none' : null;

  var descriptionInput = document.querySelectorAll('p.description');
  for (var i = 0; i < descriptionInput.length; i++) {
    descriptionInput[i].style.width = '420px';
  }

  //update form_fields label
  var label = document.querySelectorAll('th.titledesc');
  for (var j = 0; j < label.length; j++) {
    label[j].id = 'mp_field_text';
    if (label[j] && label[j].children[0] && label[j].children[0].children[0]) {
      label[j].children[0].children[0].style.position = 'relative';
      label[j].children[0].children[0].style.fontSize = '22px';
    }
  }

  //collpase ajustes avanzados
  var table = document.querySelectorAll('.form-table');
  for (var k = 0; k < table.length; k++) {
    table[k].id = 'mp_table_' + k;
  }

  // Add max length to title input

  let titleInput = this.document.querySelectorAll('.limit-title-max-length');

  titleInput.forEach(
    (element) => {
      element.setAttribute('maxlength', '85');
    }
  );

  // Remove title and description row if necessary.
  
  document.querySelectorAll('.hidden-field-mp-title').forEach(
    (element) => {
      element.closest('tr').style.display = 'none';
    }
  );

  document.querySelectorAll('.hidden-field-mp-desc').forEach(
    (element) => {
      element.closest('tr').style.display = 'none';
    }
  );

  //clone save button
  var cloneSaveButton = document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_btn_save');
  if (document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_homolog_title') !== null || document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_credential_description_test') !== null) {
    document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_mode_alert').append(document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_btn_save'));
  }

  if ((document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_homolog_title') !== null || document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_pix_options_title') !== null) && document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_steps_pix') === null ) {
    document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_pix_options_title').nextElementSibling.append(cloneSaveButton.cloneNode(true));
    document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_advanced_settings').nextElementSibling.append(cloneSaveButton.cloneNode(true));
    document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_pix_payments_description').nextElementSibling.append(cloneSaveButton.cloneNode(true));
    document.getElementById('woocommerce_woo-mercado-pago-pix_checkout_payments_advanced_description').nextElementSibling.append(cloneSaveButton.cloneNode(true));

    var collapse_title = document.querySelector('#woocommerce_woo-mercado-pago-pix_checkout_advanced_settings');
    var collapse_table = collapse_title.nextElementSibling;
    collapse_table.style.display = 'none';
    collapse_title.style.cursor = 'pointer';

    collapse_title.innerHTML += '<span class="mp-btn-collapsible" id="header_plus" style="display:block">+</span>\
      <span class="mp-btn-collapsible" id="header_less" style="display:none">-</span>';

		var header_plus = document.querySelector('#header_plus');
		var header_less = document.querySelector('#header_less');

		collapse_title.onclick = function () {
			if (collapse_table.style.display === 'none') {
				collapse_table.style.display = 'block';
				header_less.style.display = 'block';
				header_plus.style.display = 'none';
			} else {
				collapse_table.style.display = 'none';
				header_less.style.display = 'none';
				header_plus.style.display = 'block';
			}
		};

		//collpase Configuración Avanzada
		var collapse_title_2 = document.querySelector('#woocommerce_woo-mercado-pago-pix_checkout_pix_payments_advanced_title');
		var collapse_table_2 = document.querySelector('#woocommerce_woo-mercado-pago-pix_checkout_payments_advanced_description').nextElementSibling;
		var collapse_description_2 = document.querySelector('#woocommerce_woo-mercado-pago-pix_checkout_payments_advanced_description');
		collapse_table_2.style.display = 'none';
		collapse_description_2.style.display = 'none';
		collapse_title_2.style.cursor = 'pointer';

		collapse_title_2.innerHTML += '<span class="mp-btn-collapsible" id="header_plus_2" style="display:block">+</span>\
      <span class="mp-btn-collapsible" id="header_less_2" style="display:none">-</span>';

		var header_plus_2 = document.querySelector('#header_plus_2');
		var header_less_2 = document.querySelector('#header_less_2');

		collapse_title_2.onclick = function () {
			if (collapse_table_2.style.display === 'none') {
				collapse_table_2.style.display = 'block';
				collapse_description_2.style.display = 'block';
				header_less_2.style.display = 'block';
				header_plus_2.style.display = 'none';
			} else {
				collapse_table_2.style.display = 'none';
				collapse_description_2.style.display = 'none';
				header_less_2.style.display = 'none';
				header_plus_2.style.display = 'block';
			}
		};

		//payment methods
		var tablePayments = document.querySelector('#woocommerce_woo-mercado-pago-pix_checkout_pix_payments_description').nextElementSibling.getAttribute('class');
		var mp_input_payments = document.querySelectorAll('.' + tablePayments + ' td.forminp label');
		for (var ip = 0; ip < mp_input_payments.length; ip++) {
			mp_input_payments[ip].id = 'mp_input_payments_mt';
		}

		//offline payments configuration form
		var offline_payment_translate = '';
		var offlineChecked = '';
		var countOfflineChecked = 0;
		var offlineInputs = document.querySelectorAll('.pix_payment_method_select');
		for (var ioff = 0; ioff < offlineInputs.length; ioff++) {
			offline_payment_translate = offlineInputs[ioff].getAttribute('data-translate');
			if (offlineInputs[ioff].checked === true) {
				countOfflineChecked += 1;
			}
		}

		if (countOfflineChecked === offlineInputs.length) {
			offlineChecked = 'checked';
		}

		for (var offi = 0; offi < offlineInputs.length; offi++) {
			if (offi === 0) {
				var checkbox_offline_prepend = '<div class="all_checkbox">\
          <label for="checkmeoff" id="mp_input_payments" style="margin-bottom: 37px !important;">\
            <input type="checkbox" name="checkmeoff" id="checkmeoff" ' + offlineChecked + ' onclick="completeOfflineCheckbox()">\
            ' + offline_payment_translate + '\
          </label>\
        </div>';
				offlineInputs[offi].parentElement.insertAdjacentHTML('beforebegin', checkbox_offline_prepend);
				break;
			}
		}

	}

	var saveButtonElements = document.querySelectorAll('.mp-save-button');
	if (saveButtonElements.length !== 0) {
		Array.from(saveButtonElements).forEach(function (button) {
			button.addEventListener('click', function () {
				var saveButtonEvent = document.querySelector('.woocommerce-save-button');
				saveButtonEvent.click();
			});
		});
	}


	//Offline payments
	window.completeOfflineCheckbox = function () {
		var offlineCheck = document.getElementById('checkmeoff').checked;
		var offlineInputs = document.querySelectorAll('.pix_payment_method_select');
		for (var i = 0; i < offlineInputs.length; i++) {
			if (offlineCheck === true) {
				offlineInputs[i].checked = true;
			} else {
				offlineInputs[i].checked = false;
			}
		}
	};

});
