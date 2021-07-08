<?php

namespace App\Libraries;

class paymentLib
{
    public function visa()
    {
?>
        <script type="text/javascript" src="https://sandbox-assets.secure.checkout.visa.com/checkout-widget/resources/js/integration/v1/sdk.js">
        </script>
        <img alt="Visa Checkout" class="v-button" role="button" src="https://sandbox.secure.checkout.visa.com/wallet-services-web/xo/button.png" />
        <script type="text/javascript">
            function onVisaCheckoutReady() {
                V.init({
                    apikey: "RSI71R2MBVHPIG06ZZYR21meNR8Kebbfgf1VeE09f8zG8nXgo",
                    encryptionKey: "PNvhZOqsn/$Dr0qp}9QGU7ui625rw8U9y{@lhFXb",
                    paymentRequest: {
                        currencyCode: "USD",
                        subtotal: "11.00"
                    }
                });
                V.on("payment.success", function(payment) {
                    alert(JSON.stringify(payment));
                });
                V.on("payment.cancel", function(payment) {
                    alert(JSON.stringify(payment));
                });
                V.on("payment.error", function(payment, error) {
                    alert(JSON.stringify(error));
                });
            }
        </script>
    <?php
    }

    public function paypal($paypal_client_id, $value, $token)
    {
    ?>
        <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypal_client_id; ?>&currency=HKD">
            // Replace YOUR_SB_CLIENT_ID with your sandbox client ID
        </script>

        <div id="paypal-button-container" class="w-100"></div>

        <!-- Add the checkout buttons, set up the order and approve the order -->
        <script>
            function post(path, params, method = 'post') {

                // The rest of this code assumes you are not using a library.
                // It can be made less wordy if you use one.
                const form = document.createElement('form');
                form.method = method;
                form.action = path;

                for (const key in params) {
                    if (params.hasOwnProperty(key)) {
                        const hiddenField = document.createElement('input');
                        hiddenField.type = 'hidden';
                        hiddenField.name = key;
                        hiddenField.value = params[key];

                        form.appendChild(hiddenField);
                    }
                }

                document.body.appendChild(form);
                form.submit();
            }

            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?php echo $value; ?>'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        post('/package/acceptPayment', {
                            details: JSON.stringify(details),
                            action: '<?php echo $token; ?>',
                        });
                    });
                },
                locale: 'en_US',
                style: {
                    size: 'responsive',
                    color: 'blue',
                    shape: 'pill',
                    label: 'checkout'
                },
            }).render('#paypal-button-container'); // Display payment options on your web page
        </script>
<?php
    }
}
