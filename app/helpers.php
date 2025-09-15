<?php
function generateStrongPassword($length = 10)
{
    $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialCharacters = '!@#$%^&*()-_=+[]{}|;:,.<>?';
    $password = '';
    $password .= $upperCase[rand(0, strlen($upperCase) - 1)];
    $password .= $lowerCase[rand(0, strlen($lowerCase) - 1)];
    $password .= $numbers[rand(0, strlen($numbers) - 1)];
    $password .= $specialCharacters[rand(0, strlen($specialCharacters) - 1)];
    $allCharacters = $upperCase . $lowerCase . $numbers . $specialCharacters;

    for ($i = 4; $i < $length; $i++) {
        $password .= $allCharacters[rand(0, strlen($allCharacters) - 1)];
    }
    // Shuffle the password to ensure random order
    return str_shuffle($password);
}

function generateToc($content)
{
    // Use regex to find headers in the content
    $content = preg_replace('/<h([1-2])[^>]*?>/', '<h$1>', $content);
    $content = preg_replace('/<\/h([1-2])>/', '</h$1>', $content);
    preg_match_all('/<h([1-2])>(.*?)<\/h[1-2]>/', $content, $matches, PREG_SET_ORDER);

    $toc = '<ul>';
//    dd($matches);
    foreach ($matches as $header) {

        $level = $header[1];
        $text = $header[2];
        $id = str_replace(' ', '-', strtolower($text));
        $content = str_replace($header[0], "<h$level id=\"$id\">$text <a href=\"#$id\"> #</a></h$level> ", $content);
        $toc .= "<li class=\"toc-level-$level\"><a href=\"#$id\">$text</a></li>";
    }
    $toc .= '</ul>';
//    dd($toc);

    return ['toc' => $toc, 'content' => $content];
}

function menuSubmenu($menu, $submenu)
{
    $request = request();
    $request->session()->forget(['lsbm', 'lsbsm']);
    $request->session()->put(['lsbm' => $menu, 'lsbsm' => $submenu]);
    return true;
}

function getDateTime($date){
    $timezone = isset($_COOKIE['timezone']) ? $_COOKIE['timezone'] : config('app.timezone');
    return \Carbon\Carbon::parse($date)->timezone($timezone);
}
