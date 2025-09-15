<!DOCTYPE html>
<html>
<head>
    <title>Stripe Checkout</title>
</head>
<body>
<h1>Stripe Checkout Demo</h1>
<form action="{{ route('stripe.checkout') }}" method="GET">
    <button type="submit">Pay with Stripe</button>
</form>
</body>
</html>
