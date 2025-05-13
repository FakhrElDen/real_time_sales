// socket.js (ES Module)
import { createServer } from 'http';
import { Server } from 'socket.io';
import Redis from 'ioredis';

// Create HTTP server
const server = createServer();

// Initialize Socket.io
const io = new Server(server, {
    cors: {
        origin: '*',
    },
});

// Connect to Redis
const redis = new Redis(6379, '127.0.0.1');

io.on('connection', (socket) => {
    console.log(`Client connected: ${socket.id}`);
});

// Subscribe to Laravel Redis broadcasts (note channel name should be 'orders-updates')
redis.subscribe('orders-updates', (error, analytic) => {
    if (error) {
        console.error('Error subscribing to Redis channel:', error);
        return;
    }
    console.log(`Subscribed to ${analytic} channel(s)`);
});

redis.on('message', (channel, message) => {
    console.log(`Message from ${channel}:`, message);
    try {
        const payload = JSON.parse(message);
        io.emit('orders-updates', payload);
    } catch (error) {
        console.error('Invalid message format', error);
    }
});

// Start server
server.listen(3000, () => {
    console.log('Socket.IO server running on port 3000');
});
