<?php

function getArr($name, $toName = false) {
    $arr = json_decode(file_get_contents(config_path() . "/admin/" . $name . ".json"), true);

    if($toName) return $arr;
    $arrNew = [];

    foreach ($arr as $v) {
        $arrNew[$v['name']] = $v;
    }

    return $arrNew;
}

return [
    'module' => getArr("module", true),
    'plugins' => getArr("plugins"),
];
