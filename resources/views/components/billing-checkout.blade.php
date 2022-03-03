<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Stripe</title>
</head>

<body>
    {{ __('Please wait...') }}

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (() => {
            Stripe('{{ $stripeKey }}').redirectToCheckout({
                sessionId: '{{ $checkout->id }}'
            }).then(function(result) {
                if (result.error) {
                    window.href = '{{ $checkout->cancel_url }}';
                }
            });
        })();
    </script>
</body>

</html>
