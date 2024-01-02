@extends('layouts.app')

@section('contents')
<div class="form-container">
    <form action="{{ route('execute-code') }}" method="post">
        @csrf
        <label for="code">Enter your code:</label><br>
        <textarea name="code" rows="20" cols="80" required maxlength="10000"></textarea>
        <br>
        <label for="runtime">Choose runtime:</label>
        <select name="runtime" required>
            <option value="python">Python</option>
            <option value="php">PHP</option>
            <option value="c">C</option>
            <option value="cpp">C++</option>
        </select>
        <br>
        <button type="submit">Execute Code</button>
    </form>

    @if(session('executionStatus'))
        <h3>Status: {{ session('executionStatus') }}</h3>
    @endif

    @if(session('executionResult'))
        <h3>Execution Result:</h3>
        <pre>{{ session('executionResult')['result'] }}</pre>
        @if(session('executionResult')['output'])
            <h3>Execution Output:</h3>
            <pre>{{ session('executionResult')['output'] }}</pre>
        @endif
    @endif
</div>
@endsection
