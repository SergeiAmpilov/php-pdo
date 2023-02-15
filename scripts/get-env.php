<?

function getEnvParam(string $name) {
  if ($envData = file_get_contents(__DIR__ . '/../.env')) {
    $envData = str_replace("\r\n", '', $envData);
    $strings = explode(';', $envData);

    $formatedStrings = array_map(function ($element) {
      return explode("=", $element);
    }, $strings);

    $arFiltered = array_filter($formatedStrings, function ($element) use ($name) {
      return $element[0] == $name;
    });


    if ($arFiltered && count($arFiltered)) {
      return current($arFiltered)[1];
    } else {
      return false;
    }    
    
  } else {
    return false;
  }


}