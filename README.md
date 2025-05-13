# Real-Time Sales & Recommendation System

A real-time sales insights and recommendation system built with Laravel, Node.js (Socket.IO), and SQLite.  
The system provides real-time updates of sales analytics, integrates with AI for recommendations, and uses weather data to adjust promotions.

---

## Technologies Used

- **Node.js**: v22.14.0
- **PHP**: 8.3.21
- **Laravel**: Framework 12.13.0
- **Database**: SQLite (lightweight setup)
- **Frontend Communication**: Socket.IO (WebSocket)
- **External APIs**:
  - Gemini (Recommendations)
  - OpenWeather (Weather-based promotions)

---

## Features

### Orders Management
- Add a new order to the database using REST API.
- Store order data using **Laravel Query Builder (DB Facade)** — Eloquent ORM intentionally avoided.

### Real-Time Sales Insights
- Calculate and broadcast:
  - Total revenue.
  - Top products by sales (quantity and revenue).
  - Revenue change in the last 1 minute.
  - Orders count in the last 1 minute.

### Real-Time WebSocket Updates (via Socket.IO)
- Frontend can subscribe to:
  - New orders.
  - Live updated analytics.

### AI Recommendations
- Sends recent sales data to Gemini.
- Receives:
  - Product promotion suggestions.
  - Sales strategies based on AI analysis.

### Weather Integration (OpenWeather API)
- Adjusts recommendations dynamically:
  - Promote **cold drinks on hot days**.
  - Promote **hot drinks on cold days**.

---

## Project Practices

- **Database**: Pure `Query Builder` (`DB` facade), no Eloquent ORM.
- **WebSocket**: Custom Node.js `socket.js` server.
- **AI integration**: Clean Laravel service to interact with OpenAI API.
- **Weather Integration**: Uses OpenWeather API via Guzzle HTTP client.

---

## Notes

- **AI Assistance**:
  - AI helped me write and optimize complex **Query Builder queries** because I am primarily experienced with Eloquent ORM and was not confident writing advanced aggregations with Query Builder.
  - AI also supported me in configuring and debugging **Socket.IO server integration with Laravel Broadcasting (Redis + Node.js)**.
  - AI assisted me in integrating **OpenWeather API using Guzzle Client**.

---
