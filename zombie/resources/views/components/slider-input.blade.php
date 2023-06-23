<div class="slider-input-container">
    <div style="width: 40px;" id="value-display-{{ $name }}">{{$initialValue}}%</div>
    <input type="range" id="{{$name}}" name="{{$name}}"
           min="{{$minValue}}" max="{{$maxValue}}" value="{{$initialValue}}" step="1">
    <label for="{{$name}}">{{$label}}</label>
</div>

<script>
    document.getElementById('{{$name}}').oninput =
        function (e) {
            let displayDiv = document.getElementById(`value-display-{{ $name }}`)
            displayDiv.innerHTML = e.target.value + '%'
        }
</script>
