<?php require 'db.php';
session_start();
If(!isset($_SESSION['loged_user'])){
   header('Location: index.php');
}
$pdo = new PDO('mysql:host='.$server_url.';dbname='.$server_db_name.'', $server_user_name, $server_password);

//$count_a = R::count('remont', 'id_publick = ?', [ $id ]);

 //echo $sql;
//$sth = $pdo->prepare($sql);
//$res = $sth->execute(array(':id' => $id));
//$res = $sth->fethAll();
//print_r($sth);
//=============FUNCTION=============//
function generate_id($lnght){
  $random = '';
  for ($i=0; $i < $lnght; $i++) {
    $random .= chr(rand(ord('1'), ord('9')));

  }
  $count_a = R::count('remont', 'id_publick = ?', [ $random ]);
  If($count_a == 0){
  return $random;
  }else{
      while($count_a != 0){
      return $random + 1;
      }
  }

}




//==============PREPARE=============//

$surname = '';
$value_type = 'id_publick';
$id = '0';
$price_shop = '';
$model = '';
$phone_num = '';
$broke = '';
$id_publick = '';
$master = '';
$imei = '';
$notes = '';
$date = '';
$price_shop = '';
$price_master = '';
$check_status_a = '';
$span_status = '';
$s_check = '';
$pn_check = '';



function check($str){
  If($str == 'Null'){
    $str = '';
    return $str;
  }
}
//============ DOWNLOAD==============//
  If(isset($_POST['sub_srch']) or isset($_POST['next'])){

//============DETECTING OF TYPE========//
//$_POST['id_check'];
//$s_check = $_POST['surname_check'] ;
//$pn_check = $_POST['phone_num_check'] ;
 $srch_type = array();
If(isset($_POST['id_check'])){
  $srch_type[] = 'id_publick';
}
If(isset($_POST['surname_check'])){
  $srch_type[] = 'surname';
}
If(isset($_POST['phone_num_check'])){
  $srch_type[] = 'phone_num';
}
$value_type = array_shift($srch_type);
//=====================================//

//================COOKIE==============//


if(isset($_POST['srch'])){
    $id = $_POST['srch'];
    $_SESSION["id"] = $id;
   // echo $_COOKIE["id"];
}
$offset = 0;
If(isset($_POST['next'])){
  $offset = $_POST['next'] - 1;
}
  //echo $_SESSION["id"];
  $res = R::getRow('SELECT * FROM `remont` WHERE '.$value_type.' = "'.$_SESSION["id"].'" LIMIT 1 OFFSET '.$offset.'');
//echo 'SELECT * FROM `remont` WHERE '.$value_type.' = "'.$id.'" LIMIT 1';

//print_r($res);
    $surname = $res['surname'];
    $model = $res['model'];
    $phone_num = $res['phone_num'];
    $broke = $res['broke'];
    $id_publick = $res['id_publick'];
    $master = $res['master'];
    $imei = $res['imei'];
    $notes = $res['notes'];
    $date = $res['date'];
    $price_master = $res['price_master'];
    $price_shop = $res['price_our'];
    $check_status_a = $res['wariaty_status'];
     if(isset($res['date'])){
         $dataDivStr = $res['date'];
     }
    
    If($check_status_a == 'on'){
      $check_status_a = 'checked';
    }else{
      $check_status_a = '';
    }

  }
  
      
 //==================ADD============//



  If(isset($_POST['sub_add'])){
//$time = generate_id(5);
$resL = R::getRow('SELECT * FROM `remont` ORDER BY `id` DESC  LIMIT 1 ');
$time = 100000 + $resL['id'];
    $data = $_POST;
    $new_rmt = R::dispense('remont');
    $new_rmt->surname = $data['surname'];
    $new_rmt->model = $data['model'];
    $new_rmt->phone_num = $data['phone_num'];
    $new_rmt->broke = $data['broke'];
    $new_rmt->id_publick = $time;
    $new_rmt->master = $data['master'];
    $new_rmt->imei = '';
    $new_rmt->notes = '';
    $new_rmt->date = date('d:m:Y');
    $new_rmt->price_master = '';
    $new_rmt->price_our = '';
    $new_rmt->wariaty_status = 'off';
    $id = R::store($new_rmt);
 //============= ADD TO FORM============//

    $id_p = $time;
    $res = R::getAll('SELECT * FROM `remont` WHERE `id_publick` = '.$id_p.' ');

    $surname = $res['0']['surname'];
    $model = $res['0']['model'];
    $phone_num = $res['0']['phone_num'];
    $broke = $res['0']['broke'];
    $id_publick = $res['0']['id_publick'];
    $master = check($res['0']['master']);
    $imei = check($res['0']['imei']);
    $notes = check($res['0']['notes']);
    $date = $res['0']['date'];
    $price_master = check($res['0']['price_master']);
    $price_shop = check($res['0']['price_our']);


  }
  //============UPDATE================//
  If(isset($_POST['sbt_save'])){
    $data = $_POST;
    $sql = 'SELECT `id` FROM `remont` WHERE `id_publick` = '.$data['id_2'].'';
    $res_a = R::getRow($sql);
    $id_a = $res_a['id'];

//---------------Перевірки на пустоту---------//
    If($data['master_2'] == ''){
      $master_a = 'Null';
    }else{
      $master_a = $data['master_2'];
    }
    If($data['imei_2'] == ''){
      $imei_a = 'Null';
    }else{
      $imei_a = $data['imei_2'];
    }
    If($data['adds'] == ''){
        $adds_a = 'Null';
    }else{
      $adds_a = $data['adds'];
    }
    If($data['model_2'] == ''){
      $model_a = 'Null';
    }else{
        $model_a = $data['model_2'];
    }

    If(isset($_POST['wariaty_2'])){
      $bd_war = 'on';
      $input_set = 'checked';

    }else{
      $bd_war = 'off';
    }

    $ind = 4;
//print_r($_POST);
$dateDefault = $_POST['date_2'];
//echo $dateDefault; 
 $dateMassValues =  array();
 $dateMassNotes  = array();
 If(isset($_POST['date_'.$ind.''])){
  while(isset($_POST['date_'.$ind.''])){
     $dateMassValues[] = $_POST['date_'.$ind];
     $dateMassNotes[] = $_POST['notes_'.$ind]; 
     $ind = $ind + 1;
    } 
    $i = 0;
    $valueStr ='';
     while(isset($dateMassValues[$i])){
        $valueStr = $valueStr.'[date.'.$i.'=-'.$dateMassValues[$i].'-],';
        $i += 1;
     }
    $i = 0;
    $notesStr = '';
     while(isset($dateMassNotes[$i])){
        $notesStr = $notesStr.'[notes.'.$i.'=-'.$dateMassNotes[$i].'-],';
        $i += 1;
     }

    
    $dateMassStr = $dateDefault.'/{'.$valueStr.':'.$notesStr.'}';
    //echo $dateMassStr;

 }else{
     $dateMassStr =  $data['date_2'];
 }

   //print_r($id_a);
    $sql = "UPDATE `remont` SET `surname` = '".$data['surname_2']."', model = '".$model_a."', `phone_num` = '".$data['phone_num_2']."', `broke` = '".$data['broke_2']."', `id_publick` = '".$data['id_2']."',
   `master` = '".$master_a."',  imei = '".$imei_a."', notes = '".$adds_a."', date = '".$dateMassStr."', `price_our` = '".$data['price_shop']."', `price_master` = '".$data['price_master']."', `wariaty_status` = '".$bd_war."'
    WHERE `id` = ".$id_a ." ";

//echo $sql;


    $pdo->query($sql);


  }?>
<!DOCTYPE html>
<html lang="ua" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>База Ремонтів</title>

    <link rel="stylesheet" href="style.css">
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap&subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="\php\jquery-ui.css">
    <link rel="shortcut icon" href="86944.png" type="image/x-icon"/>
    <script src="\php\jquery-1.6.4.min.js"></script>
    <script src="\php\jquery-ui.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c4b6311afc.js" crossorigin="anonymous"></script>
    
   
    
    <script type="text/javascript">
    var ind = 4;
    function backToReal(){
      $('#test').hide('slow');
      $('.result').show('slow');
      
    };
   
    $(document).ready(function(){
var a = 1;
/*DATE*/

  //DeCoder ---------------
  
  var strDefault =  $('input[name="date_2"]').val();
if(strDefault != ''){
  
 if(strDefault.split(':').length == 3){
  $('input[name="date_2"]').val(strDefault);
}  else{
var strDefaulStplited = strDefault.split('/');
  var chekStrDate = strDefaulStplited[1].split(":");
  if(chekStrDate.length != 2){
    $('input[name="date_2"]').val(strDefault);
  }else{
    
   var strDate = strDefaulStplited['1'];
     var strMass = strDate.split(':');
     var dateMass1 = strMass[0].split(',');
     var dateMass2 = '';
    var i = 0;  
     while(i != dateMass1.length){
      dateMass2 = dateMass2+dateMass1[i];
      i++;
     }

    dateMass2 = dateMass2.split('-');  
    var dateMassRes = [];
 i=1;
 a=0;
while(i <=  dateMass2.length){
  dateMassRes[a] = dateMass2[i];
  i += 2;
  a++
}


   var notesMass1 = strMass[1].split(',');
     var notesMass2 = '';
    var i = 0;  
     while(i != notesMass1.length){
      notesMass2 = notesMass2+notesMass1[i];
      i++;
     }

    notesMass2 = notesMass2.split('-');  
    var notesMassRes = [];
 i=1;
 a=0;
while(i <=  notesMass2.length){
  notesMassRes[a] = notesMass2[i];
  i += 2;
  a++
}

$('input[name="date_2"]').val(strDefaulStplited[0]);
//alert(dateMassRes.length);
var length = 0;
var a_len = 0;
while(length != dateMassRes.length-1){
 a_len = length + 4;

 
 $('.datediv').append('<span>Дата: </span><input type="text" name="date_'+a_len+'" placeholder="Type something..." value="'+dateMassRes[length]+'" style="margin-left: 37px;"><input type="text" placeholder="Нотаток..."  style="margin-left:12px;" name="notes_'+a_len+'" value="'+notesMassRes[length]+'"><br>');
 length++; 
}

}
  
  }
}




//--------------------
 
 
     //alert(notesMassRes);
     //alert(dateMassRes);


/*DATE END*/


    $('#viber').click(function () {
    $('#span_rs').show("slow");
    var surnameV = $('input[name="surname_2"]').val();
    var modelV = $('input[name="model_2"]').val();
    var dataV = $('input[name="date_2"]').val();
    var dataPriceArrV = dataV.split(":");
      dataV = dataPriceArrV[0]+":"+dataPriceArrV[1];
    var brokeV = $('input[name="broke_2"]').val();
      $('#result_pr').html(surnameV+"<br>"+modelV+"<br>"+dataV+"<br>"+brokeV);
  })


       ind = a + 3;
      $('#add_data').click(function(){
        //code
        var dateTodey;
        $('.datediv').append('<span>Дата: </span><input type="text" name="date_'+ind+'" placeholder="00.00.0000"  style="margin-left: 37px;" value="<?php echo date("d.m.Y")?>"><input type="text" placeholder="Нотаток..."  style="margin-left:12px;" name="notes_'+ind+'"><br>')
        ind += 1;
      })


       $.ajax({
  url: 'date.php',
  success: function (html) {
    dateTodey = html;    
  }
 })
        $('#last').click(function () {
       $.ajax({
         url: "last.php",
         success: function (html) {
           $('#srch').val(html);
         }
       })
     })
        $('a[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
$('input[name="id_check"]').change(function(){
       if($('input[name="id_check"]').is(":checked")){
         $('input[name="surname_check"]').removeAttr("checked");
         $('input[name="phone_num_check"]').removeAttr("checked");
       }
})

$('input[name="surname_check"]').change(function(){
       if($('input[name="surname_check"]').is(":checked")){
         $('input[name="id_check"]').removeAttr("checked");
         $('input[name="phone_num_check"]').removeAttr("checked");
       }
})

$('input[name="phone_num_check"]').change(function(){
       if($('input[name="phone_num_check"]').is(":checked")){
         $('input[name="surname_check"]').removeAttr("checked");
         $('input[name="id_check"]').removeAttr("checked");
       }
})
     

$('input[name="srch"]').change(function () {
  // body...
   var strSrch =  $(this).val();
      if(strSrch[0] == 0 || strSrch[0] == '+' || strSrch[0] == 38){
        $('input[name="phone_num_check"]').attr("checked", " ");
        $('input[name="surname_check"]').removeAttr("checked");
         $('input[name="id_check"]').removeAttr("checked");
      }
      if(strSrch[0] != 1 & strSrch[0] != 0 & strSrch[0] != '+' & strSrch[0] != ""){
        
        $('input[name="surname_check"]').attr("checked", " ");
        $('input[name="id_check"]').removeAttr("checked");
         $('input[name="phone_num_check"]').removeAttr("checked");
      }
var i=1;
      while(i != 10){
          if(strSrch[0] == i){
            $('input[name="id_check"]').attr("checked", " ");
          $('input[name="surname_check"]').removeAttr("checked");
         $('input[name="phone_num_check"]').removeAttr("checked");
        i++;    
          }
        i++;
      }
})

        $('#kvit').click(function(){
      var surname = $('input[name="surname_2"]').val();
      var phone_num = $('input[name="phone_num_2"]').val();
      var broke = $('input[name="broke_2"').val();
      var id = $('input[name="id_2"').val();
      var date = $('input[name="date_2"').val();
        var model = $('input[name="model_2"').val();
        var imei = $('input[name="imei_2"').val();
        if (imei == 'Null') {
          imei = '';
        }
        if (id == '') {
          var check  = false;
          //alert('1');
        }
      var str_k = '1';
        str_k = "Ремонт мобільних пристроїв (МП)\nМагазин «Техномережа F5» (4)\nтел.+380996515161,+380969115995\nдата прийому "+date+" дата видачі________\nПІП: "+surname+"_____________________________________________\n Модель, сер-й номер: "+model+" _____________________________________________\nЗаявлена несправність,примітки: "+broke+" _____________________________________________\nhttp://f5remont.beget.tech/client.php?id="+id+"\n Виконані роботи,ціна ремонту,гарантія, примітка: "+imei+' '+id+"\n-Не залишайте в МП  СІМ-картки і картки пам’яті\n-При значних механічних чи хімічних пошкодженнях МП може не вмикатись чи втратити деякі функції  після ремонту, особисті дані можуть бути втрачені.  \n-Ціну ремонту, необхідність збереження особистих даних клієнт погоджує при здачі телефону чи в процесі ремонту (при необхідності)\n-після ремонту пристрій зберігається до 3 місяців після чого може бути використаний для компенсації витрат на ремонт і зберігання\n- видача пристрою без талону коштує 20грн – здійснюється після перевірки особистих даних \nЗ правилами ремонту згідний(а)___________________\n\n";
  if(check != false){
    swal({
  title: "Квитанція",
  text: str_k,
  icon: "success",
  button: "OK",
});

  }else{
    swal({
title: "Помилка",
  text: "Не має квитанції!",
  icon: "error",
  button: "OK",
      });
  }

    })
    $('#span_rs').hide();
    $('#test').hide();
    $('#print').click(function(){
      $('#body').hide();
        var surname = $('input[name="surname_2"]').val();
         var phone_num = $('input[name="phone_num_2"]').val();
           var broke = $('input[name="broke_2"').val();
              var id = $('input[name="id_2"').val();
                var date = $('input[name="date_2"').val();
                  var model = $('input[name="model_2"').val();
                     var imei = $('input[name="imei_2"').val();
        if (imei == 'Null') {
          imei = '';
        }
        if (id == '') {
          var check  = false;
          //alert('1');
        }
      var str_k = '1';
        //str_k ="<center><b>Ремонт мобільних пристроїв (МП)\n<br>Магазин «Техномережа F5» (4) тел.+380996515161,+380969115995\<hr> <h1>код:"+id+"</h1>\n<hr></b></center><b><br>дата прийому "+date+" дата видачі________\n<br>ПІП: "+surname+"____________________________________________________________________________________\n<br> Модель, сер-й номер: "+model+" __________________________________________________________________\n<br> Заявлена несправність,примітки: "+broke+" _________________________________________________________\n<br> Виконані роботи,ціна ремонту,гарантія, примітка: "+imei+"\n<br><hr>\nhttp://f5remont.beget.tech/client.php?id="+id+"\n<hr>-Не залишайте в МП  СІМ-картки і картки пам’яті\n<br>-При значних механічних чи хімічних пошкодженнях МП може не вмикатись чи втратити деякі функції  після ремонту, особисті дані можуть бути втрачені.  \n<br>-Ціну ремонту, необхідність збереження особистих даних клієнт погоджує при здачі телефону чи в процесі ремонту (при необхідності)\n<br>-після ремонту пристрій зберігається до 3 місяців після чого може бути використаний для компенсації витрат на ремонт і зберігання\n<br>- видача пристрою без талону коштує 20грн – здійснюється після перевірки особистих даних \n<br>З правилами ремонту згідний(а)___________________\n<br>\n<br><b>";
       str_k = "<center><b>Ремонт мобільних пристроїв (МП)\n<br>Магазин «Техномережа F5» (4) тел.+380996515161,+380969115995\<hr> <h1>код:"+id+"</h1>\n<hr></b></center><b><br>дата прийому "+date+" дата видачі________\n<br>ПІП: "+surname+"____________________________________________________________________________________\n<br> Модель, сер-й номер: "+model+" __________________________________________________________________\n<br> Заявлена несправність,примітки: "+broke+" _________________________________________________________\n<br> Виконані роботи,ціна ремонту,гарантія, примітка: "+imei+"\n<br><hr>\nhttp://f5remont.beget.tech/client.php?id="+id+"\n@F5Remontsbot - наш телеграм бот!\n<hr><div style='float: left;display: flex;align-items: center;justify-content: center; width: 100%;'><div style='width:70%; font-size: 14px;height:70%;'>-Не залишайте в МП  СІМ-картки і картки пам’яті\n<br>-При значних механічних чи хімічних пошкодженнях МП може не вмикатись чи втратити деякі функції  після ремонту, особисті дані можуть бути втрачені.  \n<br>-Ціну ремонту, необхідність збереження особистих даних клієнт погоджує при здачі телефону чи в процесі ремонту (при необхідності)\n<br>-після ремонту пристрій зберігається до 3 місяців після чого може бути використаний для компенсації витрат на ремонт і зберігання\n<br>- видача пристрою без талону коштує 20грн – здійснюється після перевірки особистих даних \n<br>З правилами ремонту згідний(а)___________________\n<br>\n<br></div><center><div style='width:50%;' id='output'></div></center><b>";
       $('#print_div').html(str_k);
      let qrcode = new QRCode("output", {
            text: "http://f5remont.beget.tech/client.php?id="+id,
            width: 177,
            height: 177,
            colorDark : "#222",
            colorLight : "#f3f3f3",
            correctLevel : QRCode.CorrectLevel.H
        });
      
      window.print();
        $('#print_div').html(' ');
        $('#body').show();  
      
         
    })
    $('#combinate, #clip_2').click(function (){
      var surname = $('input[name="surname_2"]').val();
      var phone_num = $('input[name="phone_num_2"]').val();
      var broke = $('input[name="broke_2"').val();
      var master = $('input[name="master_2"').val();
       if(master == "Міша"){
        master = 'M';
       }
       if(master == "Саша М" || master == "Саша"){
        master = 'СM';
       }
       if(master == "Саша Пасевич" || master == "Саша П"){
        master = 'СП';
       }
       if(master == "Стасік" || master == "Стасік"){
        master = 'Ст';
       }
       if(master == "Ультра"){
        master = 'Ул';
       }
       if(master == "ДисконтМобайл"){
        master = 'ДМ';
       }
       if(master == "ЮгКонтракт"){
        master = 'ЮГ';
       }
       if(master == "РадіоЛайн"){
        master = 'РЛ';
       }
       if(master == "ЦифроТех" || master == "Цифро Тех"){
        master = 'ЦТ';
       }
       if(master == "Now nothing"){
        master = ' ';
       }
      var id = $('input[name="id_2"').val();
      var data = $('input[name="date_2"').val();
      var dataPriceArr = data.split(":");
      data = dataPriceArr[0]+":"+dataPriceArr[1];
      var result = surname+'   '+data+'<br> '+ phone_num+" "+"<span style='border: 1px solid #000;'>"+master+'</span> <br>'+ broke+'<br> '+id; 
      $('#span_rs').show("slow");
      $('#result_pr').html(result);
    })
    var count_s = 0;
    $('#hide_pr').click(function(){
      $('#span_rs').hide("slow");
      
      count_s++;
      if(count_s == 3){
        var check_s = $('input[name="surname_2"]').val();
    if(check_s =="i love potato"){
      swal("Easter Egg!!");
      swall("1 John 4:16 NIV -- 4");
      count_s = 4;
    }
       
       }

    })
    var type = $('.becup').text();
    $('input[name="type"]').val(type);

    var surname_3 = $('#surnameA').val();
    $('input[name="surname_3"]').val(surname_3);

    var id_3 = $('#id_2').val();
    $('input[name="id_3"]').val(id_3)

    var phone_num_3 = $('#phone_num_2').val();
    $('input[name="phone_num_3"]').val(phone_num_3);


    $('.table_form').submit(function(){

      var str = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "table.php",
        data: str,
        success: function(html) {
          $('#test').html(html);
          $('.result').hide("slow");
          $('#test').show("slow");
        }
      });
    if(count_s == 4){
      if(check_s == "know"){
        swall("How you do it?!");
        count_s = 0;
      }
    }

      return false;
    })
    $('#submitOffsetInput').click(function () {
      var limit = $('#offsetInput').val();
      var offset = $('#offsetInputSecond').val();
      $.ajax({
        url: 'loadLast.php',
        type: 'POST',
        data: 'limit='+limit+"&offset="+offset,
        success: function (html) {
          $('#test').html(html);
          $('.result').hide("slow");
          $('#test').show("slow");
        }
      })
      
    })
      
$(function() {    $( "#btn_set").datepicker({});  });
var date_val = $('#btn_set').val();
function check(date_val) {
  if( date_val != ''){
       $.ajax({
         url: "load.php",
         type: "POST",
         data: "date="+date_val,
         success: function (html) {
           $('#test').html(html);
          $('.result').hide("slow");
          $('#test').show("slow");
         }
       })
  }
}
    
    $("#btn_set").change(function(){
date_val = $('#btn_set').val();
check(date_val);
    })
    $('#addVisualKey').click(function () {
      let id = $('#id_2').val();
      //alert("http://f5remont.beget.tech/passwords/?id="+id);
      window.location.href = "http://f5remont.beget.tech/passwords/?id="+id;
    })
     })
    </script>

    <style media="screen">
      table{
        border-collapse: collapse;
         width: 100%;
      }
      th,td{
        padding: 7px;
      }
    tr:nth-child(2n){
      background-color: #bdd1de;
    }
     tr:first-child{
       background-color: #76838c;
     }
     #kvit{
      margin: 3px;
  border: 1px solid black;
  padding: 3px;
  box-shadow: 0 0 5px rgba(0,0,0,0.5);
  border-radius: 4px;
  background-color: #ffaa80;
  width: 175px;
  margin-left: 8px;
  font-weight: bold;
  color: #fff;
  font-size: 21px;
  cursor: pointer;
    }
    #btn_set, #ubdate_date, #print{
        margin: 7px;
  border: 1px solid black;
  padding: 3px;
  box-shadow: 0 0 5px rgba(0,0,0,0.5);
  border-radius: 4px;
  background-color: #ffaa80;
  width: 175px;
  margin-left: 8px;
  font-weight: bold;
  color: #fff;
  font-size: 15px;
  cursor: pointer;

    }
     #ubdate_date,#print{
 height: 37px;
    }
    input[type="checkbox"]{
      margin-right: 21px;
      height: 20px;
  width: 20px;
  background-color: #eee;
    }
    #print_div{
      text-align: center;
      font-weight: bold;
    }
    #last{
        margin: 7px;
  border: 1px solid black;
  padding: 3px;
  box-shadow: 0 0 5px rgba(0,0,0,0.5);
  border-radius: 4px;
  ;
  width: 175px;
  margin-left: 8px;
  font-weight: bold;
 
  font-size: 15px;
  cursor: pointer;
    }
    #offsetInput{
      width: 40px;
    }
    #offsetInputSecond{
      width: 40px;
    }
    #addVisualKey{
      position: absolute;
      margin-top: 170px;
      margin-left: 6px;
      border: none;
      width: 399px;
      color: #000;
      background-color: #c9c9c9;
      transition: 0.5s;
    }
    #addVisualKey:hover{
      background-color: #232323;
      color: #fff; 
    }


    </style>
  </head>
  <body>
    <div id="body">
    <header>
      <div class="head">
        <a id="logo" >F5 Base</a>
        <span>Designed by <a href="https://www.instagram.com/andriypol68/" style = "
        text-decoration: none;
        color:black;">@andrijpol68</a></span>
      </div>
    </header>
    <!-- CONTENT -->
    <div class="content">
      <div class="searh">
        <form class="srch_req" method="post">
<input type="text" name="srch"  placeholder="Введіть пошуковий запит..." style="width: 300px;" id="srch" >
<button type="submit" name="sub_srch" id="search" class="btn btn-warning"><i class="fa fa-search"></i></button>
  <span id="check">
      <span   style="display:none;">
          <span>ID:</span>
<input type="checkbox" checked name="id_check">
<span>Прізвищу:</span>
<input type="checkbox" name = "surname_check">
<span>Номеру телефону:</span>
<input type="checkbox" name="phone_num_check">
      </span>

<input type="text" name="date_set" id="btn_set" placeholder="Дата..." autocomplete="off">
 <span/>
 <button type="button" name="button" id="last" >Останій</button>
 <button class="btn btn-success" type="button" id="submitOffsetInput">Завантажити</button>
 <input type="text" id="offsetInput">
 <label>Зміщення <input type="text" value="0" id="offsetInputSecond"></label>
        </form>
        
      </div>
      <div class="add_form">
        <form class="add"  method="post">
<input type="text" name="surname" placeholder="Прізвище...">
<input type="text" name="model" placeholder="Модель...">
<input type="text" name="phone_num" placeholder="Номер...">
<input type="text" name="broke" placeholder="Поломка...">
<input type="text" style="display:none;" name="master" placeholder="Мастер...">

<input type="submit" name="sub_add" value="ВПЕРЕД">

        </form>
      </div>
      <div id="span_rs" style="
float: right;
margin-right: 40px;
margin-top: 40px;
      ">
        <span>На цінник</span><br><b>
        <div id="result_pr" style="
font-family: 'Roboto', sans-serif;
border: 2px solid black;
padding: 4px
background-color: #ffffff;
border-radius: 4px;
font-size:10px;

        "></div></b>
        <button type="button" id="hide_pr" style="
border-radius: 1px;
  background-color: white;
  border: none;
  border: 3px solid #2ECC71  ;
  padding: 5px;
  border-radius: 5px;
  font-weight: bold;
  color: #1D8348;
  font-size: 14px;
  cursor: pointer;
  margin-left: 9px;
        ">Сховати</button>
        <button id="clip"type="button" name="button" data-clipboard-target="#result_pr" style="border-radius: 1px;
          background-color: white;
          border: none;
          border: 3px solid #2ECC71  ;
          padding: 5px;
          border-radius: 5px;
          font-weight: bold;
          color: #1D8348;
          font-size: 14px;
          cursor: pointer;
          margin-left: 9px;">Копіювати</button>

      </div>
      <div class="result">
        <div class="becup" style="display: none">
          <?php echo $value_type ?>
        </div>
<form method="POST" >


        <ul>
          <li>
<span>Прізвище: </span><input id = "surnameA"type="text" name="surname_2" placeholder="Type something..." value="<?php echo $surname;?>">
          </li>

            <li>
<span>Модель: </span><input type="text" name="model_2" placeholder="Type something..." value="<?php echo $model;?>" style = "margin-left: 18px;">
          </li>
          <li>
<span>Телефон: </span><input id="phone_num_2" type="text" name="phone_num_2" placeholder="Type something..." value="<?php echo $phone_num;?>" style = "margin-left: 9px;">
<a type="button" href="tel: <?php echo $phone_num;?>"  class="btn btn-primary"><i class="fa fa-phone"></i></a>
          </li>
          <li>
<span>Поломка: </span><input type="text" name="broke_2" placeholder="Type something..." value="<?php echo $broke;?>" style="margin-left: 9px;">
          </li>
          <li>
<span>Майстер: </span><input type="text" name="master_2" placeholder="Type something..." value="<?php echo $master;?>" style="margin-left: 9px;">
<button type="button" id="viber" data-clipboard-target="#viber_res" class="btn btn-primary"><i class="fa fa-copy"></i></button>
          </li>
          <li>
<span>Імей: </span><input type="text" name="imei_2" placeholder="Type something..." value="<?php echo $imei;?>" style="margin-left: 37px;">
          </li>
          <li>
            <div class="datediv panel panel-info">
              <span>Дата: </span><input type="text" name="date_2" placeholder="Type something..." value="<?php echo $date;?>" style="margin-left: 37px;">
              <button type="button"class="btn btn-primary" id="add_data">+</button><br>
            </div>

          </li>
          <li>
<span>Ціна: </span>
     <p><span style="margin-left: 8px;">Ціна майстра: </span><input type="text" name="price_master" placeholder="Type something..." style="margin-left: 37px;" value=<?php echo $price_master; ?>><p/>
     <p><span style="margin-left: 8px;">Ціна магазина: </span><input type="text" name="price_shop" placeholder="Type something..." style="margin-left: 27px;" value=<?php echo $price_shop; ?>><p/>
          </li>
          <li>
<span <?php echo $span_status; ?>>Гарантiйний: </span><input type="checkbox" name="wariaty_2" placeholder="Type something..." <?php echo $check_status_a?>  style="margin-left: 10px; ">
          </li>
          <li>
<span>Унікальний індифікатор(ID): </span><input id = "id_2"type="text" name="id_2" style = "color: red;" placeholder="Type something..." value="<?php echo $id_publick?>">
          </li>
          <li>
<span>Примітки: </span>
          </li>
<button id="addVisualKey" type="button">Добавити пароль</button>
<textarea name="adds" rows="8" cols="80" placeholder="Type something..." value=""><?php echo $notes?></textarea>
        </ul>
        <input type="submit" name="sbt_save" value="Зберегти" id="sbt" style="width: 121px;"><button type="button" id="combinate" style="

        border-radius: 1px;
  background-color: white;
  border: none;
  border: 3px solid #2ECC71  ;
  padding: 5px;
  border-radius: 5px;
  font-weight: bold;
  color: #1D8348;
  font-size: 14px;
  cursor: pointer;
  margin-left: 7px;
  width: 121px;
  ">Зкомпілювати</button>

  <button id="clip_2"type="button" name="button"   data-clipboard-target="#result_pr" style="border-radius: 1px;
          background-color: white;
          border: none;
          border: 3px solid #2ECC71  ;
          padding: 5px;
          border-radius: 5px;
          font-weight: bold;
          color: #1D8348;
          font-size: 14px;
          cursor: pointer;
          width: 121px;
            ">Копіювати</button>
</form><form class="table_form"  method="post" style="margin-left: 6px;">
  <input type="text" name="type" value="" style="display:none;">
  <input type="text" name="surname_3" value="" style="display:none;">
  <input type="text" name="phone_num_3" value="" style="display:none;">
  <input type="text" name="id_3" value="" style="display:none;">
  <input id="go" type="submit" name="table_go" value="Перетворити в таблицю" style="width: 375px;">
</form>
<button id="kvit" type="submit"  >Квитанція</button>  <button id="print">Друк</button> 
      </div>
    </div>
    <div id="test">

    </div>
    <footer>
<div class="footer">
  <hr>
  F5 Service ----- Remont BASE
</div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
    <script type="text/javascript">
      new ClipboardJS("#clip");
      new ClipboardJS("#clip_2");
    </script>
  </div>  
  <div id="print_div">

  </div>
<div id="viber_res" >
  
</div>
  <div id="dateDivJS"> 



  </div>
   <script src="qrcode.min.js"></script>
  </body>
    
  
</html>
