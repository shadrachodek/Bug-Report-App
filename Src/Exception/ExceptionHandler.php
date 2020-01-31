<?php
declare(strict_types = 1);

namespace App\Exception;


use App\Helpers\App;
use ErrorException;
use Throwable;

class ExceptionHandler
{
    public function handle(Throwable $exception) : void {
        $app = new App;

        if ($app->isDebugMode()) {
            var_dump($exception);
        } else {
            echo "This should not have happened, please try again";
        }
        exit;
    }

    public function convertWarningsNoticesToException($severity, $message, $file, $line) {
        throw new ErrorException($message, $severity, $severity, $file, $line);
    }
}