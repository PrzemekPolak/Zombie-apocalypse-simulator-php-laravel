<html>
<head>
    <title>Symulacja apokalipsy zombie</title>
</head>
<body>
<div class="content">
    <h1>{{$title}}</h1>
    {{ $slot }}
</div>
</body>
</html>

<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    h1 {
        text-align: center;
    }

    .content {
        background-color: #e5e7eb;
        border: solid 1px #9ca3af;
        border-radius: 10px;
        padding: 16px;
        min-width: 600px;
    }
</style>
