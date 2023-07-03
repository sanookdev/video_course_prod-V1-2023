<?defined('BASEPATH') or exit('No direct script access allowed');?>

<!DOCTYPE html>
<html>
<head>
    <title>Video Player</title>
</head>
<body>
    <video controls>
        <source src="<?php echo $video_url; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</body>
</html>
