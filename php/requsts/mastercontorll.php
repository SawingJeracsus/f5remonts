<?php 
    require '../db/db.php';
    if(!isset($_POST['id'])){

        try {
            $count = R::getRow("SELECT COUNT(`id`) FROM `masters` WHERE `name` = '".$_POST['name']."'")['COUNT(`id`)'];
        } catch (\Throwable $th) {
            $count = 0;
        }
        // print_r("SELECT COUNT(`id`) FROM `masters` WHERE `name` '".$_POST['name']."'");
        // die;
        if($count == 0){
            $master = R::dispense('masters');
            $master->name = $_POST['name'];
            R::store($master);
        }else{
            print_r(json_encode([
                'type' => 'error',
                'message' => 'master with this name is already exist!'
            ], JSON_UNESCAPED_UNICODE));
            die;
        }
    
        $masters = R::getAll('SELECT * FROM `masters`');
        foreach ($masters as $master) {
            echo '
            <li class="master">
                <div class="name">
                 '.$master['name'].'
                </div>
                <button class="btn danger remove" data-id = "'.$master['id'].'">-</button>
            </li>
            ';
        }
    }else{
        R::exec('DELETE FROM `masters` WHERE `id` = '.$_POST['id']);

        $masters = R::getAll('SELECT * FROM `masters`');
        foreach ($masters as $master) {
            echo '
            <li class="master">
                <div class="name">
                 '.$master['name'].'
                </div>
                <button class="btn danger remove" data-id = "'.$master['id'].'">-</button>
            </li>
            ';
        }
    }
?>