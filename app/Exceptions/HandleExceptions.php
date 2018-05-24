<?php

namespace App\Exceptions;

use Log;
use Exception;
use ErrorException;

class HandleExceptions
{

    /**
     * Bootstrap the given application.
     */
    public function bootstrap()
    {
        error_reporting(-1);
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    /**
     * Convert a PHP error to an ErrorException.
     * @param  int  $level
     * @param  string  $message
     * @param  string  $file
     * @param  int  $line
     * @param  array  $context
     * @return void
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle an uncaught exception from the application.
     * Note: Most exceptions can be handled via the try / catch block in
     * the HTTP and Console kernels. But, fatal error exceptions must
     * be handled differently since they are not normal exceptions.
     * @param  \Throwable  $e
     * @return voidfile
     */
    public function handleException($e)
    {
        if ($e instanceof ServiceException) {
            Log::info('【EXCEPTION】', ['code'=>$e->getCode(), 'massage'=>$e->getMessage()]);
            return \Response::setData(['code' => $e->getCode(), 'msg' => $e->getMessage(), 'data' => new \stdClass()])->send();
        } else {
            Log::warning('【EXCEPTION】', ['code'=>$e->getCode(), 'massage'=>$e->getMessage()]);
            return \Response::setData(['code' => -1, 'msg' => '系统异常', 'data' => new \stdClass()])->send();
        }
    }


    /**
     * Handle the PHP shutdown event.
     *
     * @return void
     */
    public function handleShutdown()
    {
        if (! is_null($error = error_get_last()) && $this->isFatal($error['type'])) {
            $this->handleException(new \Exception('error', -1));
        }
    }

    /**
     * Determine if the error type is fatal.
     * @param  int  $type
     * @return bool
     */
    protected function isFatal($type)
    {
        return $type & (E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR | E_PARSE);
    }
}
