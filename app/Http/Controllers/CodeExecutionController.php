<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeExecutionController extends Controller
{
    public function showForm()
    {
        return view('code_execution.index');
    }
    public function executeCode(Request $request)
    {
    $selectedLanguage = $request->input('runtime');
    $executionResult = CodeExecutionService::executeCodeByLanguage($selectedLanguage, $request->input('code'));
    return redirect()->route('code-execution.form')->with([
        'executionStatus' => 'Queued',
        'executionResult' => null, 
        'selectedLanguage' => $selectedLanguage, 
    ]);
    }
    public function showExecutions()
    {
        return view('executions');
    }
}
