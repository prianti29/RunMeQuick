<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
// CodeExecutionService.php

class CodeExecutionService
{
    public static function executeCodeByLanguage($language, $code)
    {
        switch ($language) {
            case 'php':
                return self::executePhpCode($code);
            case 'python':
                return self::executePythonCode($code);
            case 'cpp':
                return self::executeCPPCode($code);
            case 'c':
                return self::executeCCode($code);
            default:
                throw new \InvalidArgumentException("Unsupported language: $language");
        }
    }

    private static function executePHPCode($code)
    {
        ob_start();
        try {
            eval($code);
            $output = ob_get_clean();
            return [
                'result' => $output,
                'error' => null,
            ];
        } catch (Exception $e) {
            $error = ob_get_clean();
            return [
                'result' => null,
                'error' => $error,
            ];
        }
    }
    private static function executePythonCode($code)
    {
        $descriptors = [
            0 => ['pipe', 'r'], 
            1 => ['pipe', 'w'], 
            2 => ['pipe', 'w'], 
        ];
        $process = proc_open('python', $descriptors, $pipes);
        if (is_resource($process)) {
            fwrite($pipes[0], $code);
            fclose($pipes[0]);
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
           
            $error = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            $resultCode = proc_close($process);
            if ($resultCode === 0) {
                dd($output);
                return [
                    'result' => $output,
                    'error' => null,
                ];
            } else {
                return [
                    'result' => null,
                    'error' => $error,
                ];
            }
        } else {
            return [
                'result' => null,
                'error' => 'Failed to open process.',
            ];
        }
    }
    private static function executeCppCode($code)
    {
        $cppFile = tempnam(sys_get_temp_dir(), 'cpp_code');
        file_put_contents($cppFile . '.cpp', $code);
        $compileCommand = "g++ -o {$cppFile}.out {$cppFile}.cpp 2>&1";
        $runCommand = "{$cppFile}.out 2>&1";
        exec($compileCommand, $compileOutput, $compileStatus);
        if ($compileStatus === 0) {
            $output = shell_exec($runCommand);
            unlink("{$cppFile}.out");
            unlink("{$cppFile}.cpp");
            dd($output);
            return [
                'result' => $output,
                'error' => null,
            ];
        } else {
            unlink("{$cppFile}.cpp");
            return [
                'result' => null,
                'error' => implode("\n", $compileOutput),
            ];
        }
    }
    private static function executeCCode($code)
    {
        $cFile = tempnam(sys_get_temp_dir(), 'c_code');
        file_put_contents($cFile . '.c', $code);
        $compileCommand = "gcc -o {$cFile}.out {$cFile}.c 2>&1";
        $runCommand = "{$cFile}.out 2>&1";
        exec($compileCommand, $compileOutput, $compileStatus);
        if ($compileStatus === 0) {
            $output = shell_exec($runCommand);
            unlink("{$cFile}.out");
            unlink("{$cFile}.c");
            dd($output);
            return [
                'result' => $output,
                'error' => null,
            ];
        } else {
            unlink("{$cFile}.c");
            return [
                'result' => null,
                'error' => implode("\n", $compileOutput), 
            ];
        }
    }   
}

