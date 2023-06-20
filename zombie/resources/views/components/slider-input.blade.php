<div class="slider-container">
    <div id="value-display">z db</div>
    <input type="range" id="{{$name}}" name="{{$name}}"
           min="0" max="100" value="90" step="1" oninput="updateValueDisplay(this.value)">
    <label for="{{$name}}">{{$label}}</label>
</div>

<script>
    const updateValueDisplay = (value) => {
        let displayDiv = document.getElementById('value-display')
        displayDiv.innerHTML = value + '%'
    }
</script>

<style>
    .slider-container {
        display: flex;
        gap: 8px;
    }

    #value-display {
        width: 40px;
    }
</style>
