<!DOCTYPE html>
<html lang="en" style="margin: 0; padding: 0; border: 0;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>

</head>

<body
    style="border: 0; background-color: #dddddd; font-size: 16px; max-width: 700px; margin: 0 auto; padding: 2%; color: #000000; font-family: 'Open Sans', sans-serif;">
    <div class="container" style="margin: 0; padding: 0; border: 0; background-color: #ffffff;">
        <div class="logo" style="margin: 0; border: 0; padding: 1%; text-align: center;">
            <img src="{{ asset('logo-dark.png') }}" style="margin: 0; padding: 0; border: 0; max-width: 120px;">
        </div>

        <div class="one-col" style="margin: 0; border: 0; padding: 20px 10px 40px; text-align: center;">
            <h1 style="margin: 0; padding: 0; border: 0; padding-bottom: 15px; letter-spacing: 1px;">Hi,
                {{ $username }}</h1>
            <p style="margin: 0; padding: 0; border: 0; line-height: 28px; padding-bottom: 25px;">{{ $msg }}</p>
            <a href="{{ $link }}"
                style="background-color: #d73644; color: #ffffff; text-decoration: none; font-weight: 700; padding: 10px 15px; border-radius: 10px;">Your
                Orders</a>
            <h1 style="margin: 0; padding: 0; margin-top: 40px; color: #000000;">Order Summary</h1>
            <hr>
            <table style="width: 100%; margin-top: 15px; text-align: left;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid grey; padding: 5px 10px">Product</th>
                        <th style="border-bottom: 1px solid grey; padding: 5px 10px">Price</th>
                        <th style="border-bottom: 1px solid grey; padding: 5px 10px">Quantity</th>
                        <th style="border-bottom: 1px solid grey; text-align: right; padding: 5px 10px">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td style="border-bottom: 1px solid grey; padding: 5px 10px">{{$item->name}}</td>
                            <td style="border-bottom: 1px solid grey; padding: 5px 10px">{{$item->price}}</td>
                            <td style="border-bottom: 1px solid grey; padding: 5px 10px">{{$item->quantity}}</td>
                            <td style="border-bottom: 1px solid grey; text-align: right; padding: 5px 10px">${{$item->total}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <th style="padding: 20px 10px">Grand Total</th>
                        <td style="text-align: right; padding: 20px 10px">${{$grand_total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
