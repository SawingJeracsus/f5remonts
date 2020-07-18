<?php
    require '../db/db.php';
    if(isset($_POST['val'])){
        // $sql = 'SELECT `model`, COUNT(*) FROM `remonts` GROUP BY `model` ORDER BY COUNT(*) DESC LIMIT 5';
        $sql = 'SELECT `broke`, COUNT(*) FROM `remonts` WHERE `master` = "'.$_POST['val'].'" GROUP BY `broke` ORDER BY COUNT(*) DESC LIMIT 5'; 
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
    
        die;
    }
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