<html>
    <p>Hello, this is the report:</p>
    
    @foreach ($teams as $team)
        {{ $team->name }}, {{ $team->abbr}}
        <br>
    @endforeach
</html>