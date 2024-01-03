<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeExecutionController extends Controller
{
    public function showForm()
    {
        return view('code_execution.index', [
            'executionResult' => null ,
            'selectedLanguage' => null,
            'code' => null,
            'runtime' => null,
        ]);
    }
    public function executeCode(Request $request)
    {
        $selectedLanguage = $request->input('runtime');
        $code = $request->input('code');
        $executionResult = CodeExecutionService::executeCodeByLanguage($selectedLanguage, $code);  
        return view('code_execution.index')->with([
            'executionResult' => $executionResult,
            'selectedLanguage' => $selectedLanguage,
            'code' => $code,
            'runtime' => $selectedLanguage,
        ]);
    }
    public function showExecutions()
    {
        return view('executions');
    }
}
