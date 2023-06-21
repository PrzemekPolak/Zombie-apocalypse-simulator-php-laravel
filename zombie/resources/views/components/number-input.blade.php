<div>
    <input class="number-input" id="{{ $name }}-input" type="number" name="{{$name}}"
           min="1" max="{{$maxValue}}" step="1" value="{{$initialValue}}"/>
    <label for="{{$name}}">{{$label}} [1-{{$maxValue}}]</label>
</div>

<script>
    document.getElementById(`{{ $name }}-input`).onkeydown =
        function (e) {
            if (isNaN(parseInt(e.key)) && e.key !== "ArrowLeft" && e.key !== "ArrowRight"
                && e.key !== 'Backspace' && e.key !== "Delete") {
                return false;
            } else {
                return true;
            }
        }

    document.getElementById(`{{ $name }}-input`).onblur =
        function (e) {
            let maxValue = parseInt('{{$maxValue}}')
            if (e.target.value > maxValue) {
                e.target.value = maxValue
            } else if (e.target.value < 1) {
                e.target.value = 1
            }
        }
</script>

