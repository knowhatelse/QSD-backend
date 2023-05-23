<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payment Successful</title>
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>
<body>
<h1>Payment Successful</h1>

<p>Dear {{ $order->user->first_name }} {{$order->user->last_name}},</p>

<p>This is just a quick email to say we've received your order ({{ $order->transaction_id }}). In the meantime, if you have any questions, please don't hesitate to contact us at hello@qsd.ba and we'll be happy to assist you.</p>

<h2>Order Details</h2>

<p><strong>Email:</strong> {{ $order->user->email }}</p>
<p><strong>City:</strong> {{ $order->city }}</p>
<p><strong>Address:</strong> {{ $order->address }}</p>
<p><strong>Zip code:</strong> {{ $order->zip_code }}</p>
<p><strong>Phone:</strong> {{ $order->phone }}</p>

<h3>Total Price: ${{ $order->total }}</h3>

<h3>Purchased Products:</h3>

<table>
    <thead>
    <tr>
        <th>Product</th>
        <th>Brand</th>
        <th>Quantity</th>
        <th>Size</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order->orderProductSizes as $orderProductSize)
        <tr>
            <td>{{ $orderProductSize->productSizes->products->name }}</td>
            <td>{{ $orderProductSize->productSizes->products->brands->name }}</td>
            <td>{{ $orderProductSize->quantity }}</td>
            <td>{{ $orderProductSize->productSizes->sizes->size }}</td>
            <td>${{ $orderProductSize->productSizes->products->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p>Thanks for shopping with us!</p>

<p>Regards,<br>QSD Team</p>
</body>
</html>
