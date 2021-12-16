<?php 
?>

<html>
<body>
    <div id="root"></div>
    <script>
        var host = 'ws://localhost:8000/websockets/wsServer.php';
        var socket = new WebSocket(host);
        socket.onmessage = function(e) {
            document.getElementById('root').innerHTML = e.data;
        };
    </script>
</body>
</html>