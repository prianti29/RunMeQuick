@extends('layouts.app')

@section('contents')
<div class="form-container">
    <form action="{{ route('execute-code') }}" method="post">
        @csrf
        <label for="code">Enter your code:</label><br>
        <textarea name="code" rows="20" cols="80" required maxlength="10000">{{ isset($code) ? $code : '' }}</textarea>
        <br>
        <label for="runtime">Choose runtime:</label>
        <select name="runtime" required>
            <option value="python" {{ $runtime == 'python' ? 'selected' : '' }}>Python</option>
            <option value="php" {{ $runtime == 'php' ? 'selected' : '' }}>PHP</option>
            <option value="c" {{ $runtime == 'c' ? 'selected' : '' }}>C</option>
            <option value="cpp" {{ $runtime == 'cpp' ? 'selected' : '' }}>C++</option>
        </select>
        <br> <br>
        <button type="submit" class="btn btn-success">Execute Code</button>
    </form>

    {{-- @if(session('executionResult'))
        <h3>Execution Result:</h3>
        <pre>{{ session('executionResult')['result'] }}</pre>
        @if(session('executionResult')['output'])
            <h3>Execution Output:</h3>
            <pre>{{ session('executionResult')['output'] }}</pre>
        @endif
    @endif --}}
    <div class="result" style="width: 66%">
        @if($executionResult)
            <h3>Execution Result:</h3>
            <pre>{{ $executionResult['result'] }}</pre>
                @if($executionResult['output'])
                    <h3>Execution Output:</h3>
                    <pre>{{ $executionResult['output'] }}</pre>
                @endif
        @endif
    </div>
</div>
@endsection
