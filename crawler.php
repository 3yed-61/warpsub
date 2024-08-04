<?php

$getList = file_get_contents('https://raw.githubusercontent.com/3yed82/warp-lP/main/warp.json?v1.' . time());
$strings = explode("\n", $getList);

$warp = "//profile-title: base64:8J+XvcKzxrPOnvCdkp/wk4SC8JOGgw==\n";
$warp .= "//profile-update-interval: 1\n";
$warp .= "//subscription-userinfo: upload=0; download=0; total=10737418240000000; expire=0;\n";
$warp .= "//support-url: https://github.com/3yed-61\n";

$warp .= "warp://@auto4/?ifp=1-3&ifpm=m4#Local&&detour=warp://@auto4/?ifp=1-3&ifpm=m6#WoW";

$i = 1;
$pattern = '/^warp:\/\/.*$/';
$first_ip = '';
$second_ip = '';

foreach ($strings as $val) {
    if ($i > 2) {
        break;
    }

    if (preg_match($pattern, $val) && !str_contains($val, '&&detour=')) {
        if ($i == 1) {
            $first_ip = $val;
        } elseif ($i == 2) {
            $second_ip = $val;
        }

        $i++;
    }
}

$warp .= "\n" . $first_ip . '#Warp 🇮🇷 IP&&detour=' . $second_ip . '#Warp 🇩🇪 IP';

file_put_contents("export/warp", $warp);
?>
