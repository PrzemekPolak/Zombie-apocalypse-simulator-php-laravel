<div class="slider-input-container">
    <div class="value-display-for-slider" id="value-display-{{ $name }}">{{$initialValue}}%</div>
    <input type="range" id="{{$name}}" name="{{$name}}"
           min="0" max="100" value="{{$initialValue}}" step="1">
    <label for="{{$name}}">{{$label}}</label>
</div>

<script>
    document.getElementById('{{$name}}').oninput =
        function (e) {
            let displayDiv = document.getElementById(`value-display-{{ $name }}`)
            displayDiv.innerHTML = e.target.value + '%'
        }
</script>
