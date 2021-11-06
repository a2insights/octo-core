<?php

if (!function_exists('octo_route')) {
    /**
     * Return the octo_route
     *
     * @param string $name
     * @param array $params
     * @return \Octo\Route
     */
    function octo_route(string $name, array $params = []) {
        return new \Octo\Route([
            'name' => $name,
            'params' => $params
        ]);
    }
}

if (!function_exists('replaceInFile')) {
    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
