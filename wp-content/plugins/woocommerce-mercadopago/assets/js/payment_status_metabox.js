window.addEventListener("load", () => {
    const orderDataElement = document.getElementById("woocommerce-order-data");
    const paymentStatusMetaboxElement = document.getElementById("mp-payment-status-metabox");
    const paymentStatusMetaboxTitle = document.querySelector('#mp-payment-status-metabox > div.postbox-header > h2');

    if (orderDataElement && paymentStatusMetaboxElement) {
        orderDataElement.after(paymentStatusMetaboxElement);
        paymentStatusMetaboxTitle.style.fontFamily = "'Lato', sans-serif";
        paymentStatusMetaboxTitle.style.fontSize = "18px";
    }
});
