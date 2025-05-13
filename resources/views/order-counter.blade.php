<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Counter Test</title>
</head>
<body>
    <h1>Order Counter</h1>
    <div id="order-count">Waiting for updates...</div>
    <div id="total-revenue"></div>
    <div id="top-products"></div>
    <div id="revenue-last-minute"></div>
    <div id="order-count-last-minute"></div>

    <!-- Include Socket.IO client -->
    <script src="https://cdn.socket.io/4.6.1/socket.io.min.js"></script>

    <script>
        // Connect to your custom Socket.IO server (replace localhost with server IP if needed)
        const socket = io('http://localhost:3000', {
            transports: ['websocket'],
        });

        socket.on('connect', () => {
            console.log('Connected to Socket.IO server', socket.id);
        });

        // Listen to the channel the Laravel event is sending to Redis pub/sub
        socket.on('orders-updates', (data) => {
            console.log('Order update received:', data);
            console.log(data.data);
            document.getElementById('order-count').innerText = 'Updated Count: ' + data.data.analytics.orders_count;
            document.getElementById('total-revenue').innerText = 'Updated Total Revenue: ' + data.data.analytics.total_revenue;
            document.getElementById('top-products').innerText = 'Updated Top Product ID: ' + data.data.analytics.top_products[0].product_id;
            document.getElementById('revenue-last-minute').innerText = 'Updated Revenue Last Minute: ' + data.data.analytics.revenue_last_minute;
            document.getElementById('order-count-last-minute').innerText = 'Updated Order Count Last Minute: ' + data.data.analytics.order_count_last_minute;
        });

        socket.on('disconnect', () => {
            console.log('Disconnected from server');
        });
    </script>
</body>
</html>
