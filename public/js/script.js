paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '<?= $totalPriceFormatted ?>'
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            window.location.href = "payment_success.php?orderID=" + data.orderID;
        });
    },
    onError: function (err) {
        console.error('PayPal onError:', err);
        alert('An error prevented the PayPal payment screen from loading.');
    }
}).render('#paypal-button-container');
