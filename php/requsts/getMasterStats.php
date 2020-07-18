<?php
    require '../db/db.php';
    $sql = 'SELECT `master`, COUNT(*) FROM `remonts` GROUP BY `master` ORDER BY COUNT(*) DESC LIMIT 5';
    $res = R::getAll($sql);

    $retutn = [
        'labels' => [],
        'data'   => []
    ];
    foreach ($res as $key => $value) {
        if($value['master'] == '' || $value['master'] == 'Null'){
          $res[$key]['master'] = 'Без імені'; 
          $return['labels'][] = 'Без імені'; 
        }else{
            $return['labels'][] = $value['master']; 
        }
        $return['data'][] = $value['COUNT(*)']; 
    }


    print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
?>