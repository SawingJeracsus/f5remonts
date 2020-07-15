<?php 
require '../php/db/db.php';
echo "<pre>";

// print_r($allOld);
$allOld = R::getAll('SELECT * FROM `remont`');


foreach ($allOld as $remont) {
	$remontOld = R::dispense('result');
	$remontOld->id_publick = $remont['id_publick'].'с';
	$remontOld->surname = $remont['surname'];
	$remontOld->model = $remont['model'];
	$remontOld->phone_num = $remont['phone_num'];
	$remontOld->broke = $remont['broke'];
	$remontOld->master = $remont['master'];
	$remontOld->imei = $remont['imei'];

	if(count(explode('/', $remont["date"])) > 1){
		$data = explode('/', $remont["date"]);
		$mainData = $data[0];

		$data = explode(':', $data[1]);

		$datesArray = explode(",", $data[0]);
		$dateDone = [];
		foreach ($datesArray as $date) {
		 	if(trim($date) != ''){
		 		$dateDone[] = explode('-', explode('=', $date)[1])[1];
		 	}
		 }

		$notesArray = explode(",", $data[1]);
		$noteDone = [];
		foreach ($notesArray as $note) {
		 	if(trim($note) != '' && !is_null(explode('-', explode('=', $note)[1])[1])){
		 		$noteDone[] = explode('-', explode('=', $note)[1])[1];
		 	}
		 } 

		 $history = [];
		foreach ($dateDone as $key => $value) {
			$history[$key] = [
				'date' => $value,
				'note' => $noteDone[$key]
			];
		}
		$history = json_encode($history, JSON_UNESCAPED_UNICODE);

	$remontOld->date = $mainData;
	$remontOld->history = $history;

	}else{
			$remontOld->date = $remont['date'];
			$remontOld->history = '';
	}
	$remontOld->price_master = $remont['price_master'];
	$remontOld->price_our = $remont['price_our'];
	$remontOld->wariaty = $remont['wariaty_status'] == 'off'? 0 : 1;
	$remontOld->savedby = 'F5';


	R::store($remontOld);
	echo "Success saving Old remont!<br>";
}

$allNew = R::getAll('SELECT * FROM `remonts` ');

foreach ($allNew as $remontNew) {
	$remontNewSave = R::dispense('result');
	foreach ($remontNew as $key => $value) {
		if($key != 'id'){
			$remontNewSave->$key = $value;
		} 
	}
	$remontNewSave->savedby = 'F5';
	R::store($remontNewSave);

	echo "Success saving New remont!<br>";

 }

echo "</pre>";
 ?>
 