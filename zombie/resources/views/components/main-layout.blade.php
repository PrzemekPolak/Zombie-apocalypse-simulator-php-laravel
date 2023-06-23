<html>
<head>
    <title>Symulacja apokalipsy zombie</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='{{asset('app.css')}}' type="text/css" rel="stylesheet"/>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="main-layout-content">
    <h1>{{$title}}</h1>
    @if($showSettingsButton)
        <a class="settings-button" href="{{  route ('settings')}}">
            <button><img src="{{asset('images/gear-solid.svg')}}"></button>
        </a>
    @endif
    {{ $slot }}
</div>

<script>
    function loadingNow(state) {
        if (state) {
            document.querySelectorAll('button').forEach((el) => el.disabled = true)
        } else {
            document.querySelectorAll('button').forEach((el) => el.disabled = false)
        }
    }
</script>
</body>
</html>
