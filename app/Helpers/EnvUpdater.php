<?php

namespace App\Helpers;

class EnvUpdater
{
    public static function updateEnv(array $data)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $env = file_get_contents($path);

            foreach ($data as $key => $value) {
                $pattern = "/^" . preg_quote($key) . "=.*/m";  // Regular expression to find the key

                if (preg_match($pattern, $env)) {
                    $env = preg_replace($pattern, "$key=$value", $env);
                } else {
                    $env .= "\n$key=$value";
                }
            }
            file_put_contents($path, $env);
        }
    }
}
