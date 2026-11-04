<?php

return [
    'engine' => env('ANALYTICS_ENGINE', 'php'),
    // A local portable runtime is convenient on Windows; hosting can set an absolute path.
    'python_binary' => env('ANALYTICS_PYTHON_BINARY', is_file(base_path('.runtime/python/python.exe'))
        ? base_path('.runtime/python/python.exe')
        : (PHP_OS_FAMILY === 'Windows' ? 'python' : 'python3')),
    'timeout' => 20,
];
