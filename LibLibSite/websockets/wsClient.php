<html>
<body>
    <h1>Websocket Testing</h1>
    <div id="root"></div>
    <script>
        var host = 'ws://localhost:8000/wsServer.php';
        var socket = new WebSocket(host);
        socket.onmessage = function(e) {
            document.getElementById('root').innerHTML = e.data;
        };
    </script>
</body>
</html>
