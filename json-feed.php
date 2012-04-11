<?php

$product = '';

if (isset($_GET['product'])) {
    switch ($_GET['product'])  {
        case 'firefox':
            $file_minor = file_get_contents('http://www.mozilla.com/includes/product-details/json/firefox_history_stability_releases.json');
            $file_major = file_get_contents('http://www.mozilla.com/includes/product-details/json/firefox_history_major_releases.json');
            $product = 'Mozilla Firefox';  
            break;
        case 'thunderbird':
            $file_minor = file_get_contents('http://www.mozilla.com/includes/product-details/json/thunderbird_history_stability_releases.json');
            $file_major = file_get_contents('http://www.mozilla.com/includes/product-details/json/thunderbird_history_major_releases.json');
            $product = 'Mozilla Thunderbird';          
            break;
    }
}
else //die();
phpinfo();

/*$array  = json_decode($file_minor, true);
$array  = array_merge(json_decode($file_major, true), $array);*/

if ($_GET['product'] == 'all') {
    $firefox = '';
}

$arr1 = convertToItems(json_decode($file_minor, true), $product, 'minor');
$arr2 = convertToItems(json_decode($file_major, true), $product, 'major');

//$array = array_merge(convertToItems(json_decode($file_major, true), $product, 'major'), $array);


$array = array_merge_recursive ($arr1, $arr2);
print (json_encode($array));

  
//print_r ($array);



  
//$json['types']      = array();
//$json['types']['test']['pluralLabel'] = 'tests';
function convertToItems($arr, $product = '', $stab = '') {
    foreach ($arr as $release=>$date) {
        $item['label']= $product .' '. $release;
        $item['stab'] = $stab;
        $item['version'] = $release;
        $item['date'] = $date;
        
        $json['items'][] = $item;
    //    $json['items'][$release]=$date;
    }
    //print_r($json);
    
    return $json;
}

function print_json($file, $product='', $type='') {
    $arr = convertToItems(json_decode($file, true), $product, $type);
    return $arr;
}
