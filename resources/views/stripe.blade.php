<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   {{-- {{ dd($activePayment) }} --}}
   @if($activePayment)
        <div class="alert alert-info">
            <h5><i class="fas fa-info-circle"></i> You Already Have Active Access</h5>
            <p>Your premium subscription is active until {{ $activePayment->expires_at->format('d M Y, H:i') }}</p>
            <p>{{ $activePayment->daysRemaining() }} days remaining</p>
            <a href="/profile" class="btn btn-primary">Go to Profile</a>
        </div>
   @else
        <div class="container-sm">
            <h1>Payment Page</h1>
            <form action="{{ route('stripe.payment') }}" method="POST" id="stripe-form">
                @csrf
                <input type="hidden" name="price" id="" value="1.99">
                <input type="hidden" name="stripeToken" id="stripe-token">
                <div id='card-element' class="form-control"></div>
                <button onclick="createToken()" type="button" class="btn btn-primary mt-3">submit</button>
            </form>
        </div>
   @endif

    <script src="https://js.stripe.com/basil/stripe.js"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ config('stripe.stripe_key') }}');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');
        function createToken(){
            stripe.createToken(cardElement).then(function(result) {
                console.log(result)
                if(result.token){
                    document.getElementById('stripe-token').value = result.token.id;
                    document.getElementById('stripe-form').submit();
                }
            });
         }
    </script>
</body>
</html>