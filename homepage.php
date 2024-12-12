<?php
session_start();
include("connect.php");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #controls {
            margin-top: 20px;
            background:grey;
    color: white;
    width:450px;
    padding:1.5rem;
    margin:50px auto;
    border-radius:10px;
    display: flex;
    justify-content: space-around;
        }
        button {
            margin-right: 10px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .cam {
    background:#A0153E;
    color: white;
    width:450px;
    padding:1.5rem;
    margin:50px auto;
    border-radius:10px;
    display: flex;
    justify-content: space-around;
}
    </style>
</head>

<body>
    <div class="head">
        <p style="font-size:50px; font-weight:bold;">
            Welcome, <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
                while ($row = mysqli_fetch_array($query)) {
                    echo $row['firstName'] . ' ' . $row['lastName'];
                }
            }
            ?></p>
    </div>
    <div id="controls">
    <button id="startBtn">Turn On</button>
    <button id="stopBtn" disabled>Turn Off</button>
    </div>
    </div>

    <div class="cam">
    <video id="webcam" autoplay playsinline width="320" height="240"></video>
    <script>
        const videoElement = document.getElementById('webcam');
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        let stream = null;
        function startWebcam() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((mediaStream) => {
                    stream = mediaStream;
                    videoElement.srcObject = stream;
                    startBtn.disabled = true;
                    stopBtn.disabled = false;
                })
                .catch((error) => {
                    console.error("Error accessing webcam: ", error);
                });
        }
        function stopWebcam() {
            if (stream) {
                let tracks = stream.getTracks();
                tracks.forEach(track => track.stop()); 
                videoElement.srcObject = null; 
                stream = null;
                startBtn.disabled = false;
                stopBtn.disabled = true;
            }
        }


        startBtn.addEventListener('click', startWebcam);
        stopBtn.addEventListener('click', stopWebcam);
    </script>

    </div>


    <div class="foot"><a href="logout.php">
            <p>Logout</p>
        </a></div>
</body>

</html>
