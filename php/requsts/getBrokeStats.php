<?php
    require '../db/db.php';
    $sql = 'SELECT `broke`, COUNT(*) FROM `remonts` GROUP BY `broke` ORDER BY COUNT(*) DESC LIMIT 5';
    $res = R::getAll($sql);

    $retutn = [
        'labels' => [],
        'data'   => []
    ];
    foreach ($res as $key => $value) {
        if($value['broke'] == ''){
          $res[$key]['broke'] = 'Без імені'; 
          $return['labels'][] = 'Без імені'; 
        }else{
            $return['labels'][] = $value['broke']; 
        }
        $return['data'][] = $value['COUNT(*)']; 
    }


    print_r(json_encode($return, JSON_UNESCAPED_UNICODE));
?>