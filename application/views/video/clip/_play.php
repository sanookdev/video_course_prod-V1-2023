<!DOCTYPE html>
<html>

<head>
    <link href="https://vjs.zencdn.net/7.15.0/video-js.css" rel="stylesheet">
</head>

<body>
    <video id="videoPlayer" class="video-js vjs-default-skin" controls preload="auto">
        <source src="<?php echo $videoPath; ?>" type="video/mp4">
    </video>

    <script src="https://vjs.zencdn.net/7.15.0/video.js"></script>
    <script>
    // Initialize Video.js player
    videojs("videoPlayer", {}, function() {
        // Player ready
    });
    </script>
</body>

</html>