<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use Illuminate\Http\Request;
use ParseError;

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
                'output' => $output,
                'result' => 'Code executed successfully',
            ];
        } catch (ParseError $parseError) {
            $error = ob_get_clean();
            return [
                'output' => null,
                'result' => 'Parse error: ' . $parseError->getMessage(),
            ];
        } catch (Error $error) {
            $error = ob_get_clean();
            return [
                'output' => null,
                'result' => 'Runtime error: ' . $error->getMessage(),
            ];
        } catch (Exception $e) {
            $error = ob_get_clean();
            return [
                'output' => null,
                'result' => 'Exception: ' . $e->getMessage(),
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
               // dd($output);
                return [
                    'output' => $output,
                    'result' => 'Code executed successfully',
                ];
            } else {
                return [
                    'output' => null,
                    'result' => $error,
                ];
            }
        } else {
            return [
                'output' => null,
                'result' => 'Failed to open process.',
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
            return [
                'output' => $output,
                'result' => "Code executed successfully",
            ];
        } else {
            unlink("{$cppFile}.cpp");
            return [
                'output' => null,
                'result' => implode("\n", $compileOutput),
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
            return [
                'output' => $output,
                'result' => 'Code executed successfully',
            ];
        } else {
            unlink("{$cFile}.c");
            return [
                'output' => null,
                'result' => implode("\n", $compileOutput), 
            ];
        }
    }   
}

