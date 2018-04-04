
<!DOCTYPE html>
<html>
<head>
    <link href="http://vjs.zencdn.net/5.10.2/video-js.css" rel="stylesheet">
    <link http-equiv="x-pjax-version" href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>VideoJS</title>
</head>
<body>
<div class="container">
    <video  id="my-video"
            class="video-js vjs-big-play-centered"
            controls
            poster=""
            data-setup="{}"
    >
        <source src="http://resource.dingdone.com/141C015B281BB231538F547A8CA3A012.mp4" type="video/mp4">

        {{--<p class="vjs-no-js">--}}
        {{--To view this video please enable JavaScript, and consider upgrading--}}
        {{--to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>--}}
        {{--</p>--}}
    </video>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="http://vjs.zencdn.net/5.10.2/video.js"></script>
<script src="//cdn.sc.gl/videojs-hotkeys/0.2/videojs.hotkeys.min.js"></script>
<script src="/js/main.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>