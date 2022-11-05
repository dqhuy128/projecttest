<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 10:29:55
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-06-18 17:52:16
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Traits;

use App\Modules\Core\Facades\OopsMemory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


trait CallableTrait
{
    public function call($class, $runMethodArguments = [], $extraMethodsToCall = [])
    {
        $class = $this->resolveClass($class);

        $this->setUIIfExist($class);

        $this->callExtraMethods($class, $extraMethodsToCall);

        return $class->run(...$runMethodArguments);
    }

    public function transactionalCall($class, $runMethodArguments = [], $extraMethodsToCall = [])
    {
        return DB::transaction(function() use ($class, $runMethodArguments, $extraMethodsToCall) {
            return $this->call($class, $runMethodArguments, $extraMethodsToCall);
        });
    }

    private function resolveClass($class)
    {
        // in case passing style names such as containerName@classType
        if ($this->needsParsing($class)) {

            $parsedClass = $this->parseClassName($class);

            $containerName = $this->capitalizeFirstLetter($parsedClass[0]);
            $className = $parsedClass[1];

            OopsMemory::verifyContainerExist($containerName);

            $class = $classFullName = OopsMemory::buildClassFullName($containerName, $className);

            OopsMemory::verifyClassExist($classFullName);
        } else {
            Log::debug('It is recommended to use the caller style (containerName@className) for ' . $class);
        }

        return App::make($class);
    }

    private function parseClassName($class, $delimiter = '@')
    {
        return explode($delimiter, $class);
    }

    private function needsParsing($class, $separator = '@')
    {
        return preg_match('/' . $separator . '/', $class);
    }

    private function capitalizeFirstLetter($string)
    {
        return ucfirst($string);
    }

    private function setUIIfExist($class)
    {
        if (method_exists($class, 'setUI') && property_exists($this, 'ui')) {
            $class->setUI($this->ui);
        }
    }

    private function callExtraMethods($class, $extraMethodsToCall)
    {
        // allows calling other methods in the class before calling the main `run` function.
        foreach ($extraMethodsToCall as $methodInfo) {
            // if is array means it method has arguments
            if (is_array($methodInfo)) {
                $this->callWithArguments($class, $methodInfo);
            } else {
                // if is string means it's just the method name without arguments
                $this->callWithoutArguments($class, $methodInfo);
            }
        }
    }

    private function callWithArguments($class, $methodInfo)
    {
        $method = key($methodInfo);
        $arguments = $methodInfo[$method];
        if (method_exists($class, $method)) {
            $class->$method(...$arguments);
        }
    }

    private function callWithoutArguments($class, $methodInfo)
    {
        if (method_exists($class, $methodInfo)) {
            $class->$methodInfo();
        }
    }
}
