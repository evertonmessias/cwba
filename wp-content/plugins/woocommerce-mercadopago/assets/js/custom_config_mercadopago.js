/*jshint multistr: true */

const payment_mercado_pago_custom = {
  initScreen: function () {
    if (!this.hasConfigurations()) {
      this.removeElements();
      return;
    }
    this.setInputMaxLength();
    this.setTitleDescriptionStyle();
    this.setHide();
    this.makeCollapsibleAdvancedConfig();
  },
  hasConfigurations: function () {
    const settings_table = document.querySelector("table.form-table");
    return settings_table.hasChildNodes();
  },
  removeElements: function () {
    const settings_table = document.querySelector("table.form-table");
    settings_table.previousElementSibling.remove();
    settings_table.previousElementSibling.remove();
    settings_table.nextElementSibling.remove();
  },
  setHide: function () {
    document.querySelector(".wc-admin-breadcrumb").style.display = "none";
    if (document.querySelector(".mp-header-logo") !== null) {
      document.querySelector(".mp-header-logo").style.display = "none";
    } else {
      var pElement = document.querySelectorAll("#mainform > p");
      pElement[0] !== undefined ? (pElement[0].style.display = "none") : null;
    }

    var h2s = document.querySelectorAll("h2");
    h2s[4] !== undefined ? (h2s[4].style.display = "none") : null;

    document.querySelectorAll(".hidden-field-mp-title").forEach((element) => {
      element.closest("tr").style.display = "none";
    });

    document.querySelectorAll(".hidden-field-mp-desc").forEach((element) => {
      element.closest("tr").style.display = "none";
    });
  },
  setInputMaxLength: function () {
    let titleInput = document.querySelectorAll(".limit-title-max-length");

    titleInput.forEach((element) => {
      element.setAttribute("maxlength", "85");
    });
  },
  setTitleDescriptionStyle: function () {
    //update form_fields label
    var label = document.querySelectorAll("th.titledesc");
    for (var j = 0; j < label.length; j++) {
      label[j].id = "mp_field_text";
      if (
        label[j] &&
        label[j].children[0] &&
        label[j].children[0].children[0]
      ) {
        label[j].children[0].children[0].style.position = "relative";
        label[j].children[0].children[0].style.fontSize = "22px";
      }
    }
  },
  makeCollapsibleAdvancedConfig: function () {
    //collpase Configuración Avanzada
    document.querySelector(
      "#woocommerce_woo-mercado-pago-custom_checkout_payments_advanced_description"
    ).nextElementSibling.style.display = "none";

    var collapse_title_2 = document.querySelector(
      "#woocommerce_woo-mercado-pago-custom_checkout_custom_payments_advanced_title"
    );
    var collapse_table_2 = document.querySelector(
      "#woocommerce_woo-mercado-pago-custom_checkout_payments_advanced_description"
    ).nextElementSibling;
    var collapse_description_2 = document.querySelector(
      "#woocommerce_woo-mercado-pago-custom_checkout_payments_advanced_description"
    );
    collapse_table_2.style.display = "none";
    collapse_description_2.style.display = "none";
    collapse_title_2.style.cursor = "pointer";

    collapse_title_2.innerHTML +=
      '<span class="mp-btn-collapsible" id="header_plus_2" style="display:block">+</span>\
            <span class="mp-btn-collapsible" id="header_less_2" style="display:none">-</span>';

    var header_plus_2 = document.querySelector("#header_plus_2");
    var header_less_2 = document.querySelector("#header_less_2");

    collapse_title_2.onclick = function () {
      if (collapse_table_2.style.display === "none") {
        collapse_table_2.style.display = "block";
        header_less_2.style.display = "block";
        collapse_description_2.style.display = "block";
        header_plus_2.style.display = "none";
      } else {
        collapse_table_2.style.display = "none";
        header_less_2.style.display = "none";
        collapse_description_2.style.display = "none";
        header_plus_2.style.display = "block";
      }
    };
  },
};

window.addEventListener("load", function () {
  payment_mercado_pago_custom.initScreen();
});
