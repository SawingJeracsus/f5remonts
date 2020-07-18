<?php
    require '../db/db.php';
    $sql = 'SELECT `model`, COUNT(*) FROM `remonts` GROUP BY `model` ORDER BY COUNT(*) DESC LIMIT 5';
    $res = R::getAll($sql);

    $retutn = [
        'labels' => [],
        'data'   => []
    ];
    foreach ($res as $key => $value) {
        if($value['model'] == ''){
          $res[$key]['model'] = 'Без імені'; 
          $return['labels'][] = 'Без імені'; 
        }else{
            $return['labels'][] = $value['model']; 
        }
        $return['data'][] = $value['COUNT(*)']; 
    }


    print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
?>