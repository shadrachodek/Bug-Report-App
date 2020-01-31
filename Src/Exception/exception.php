<?php
set_exception_handler([ new \App\Exception\ExceptionHandler(), 'convertWarningsNoticesToException']);
set_exception_handler([ new \App\Exception\ExceptionHandler(), 'handle']);