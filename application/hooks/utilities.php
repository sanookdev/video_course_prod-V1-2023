<?
 function MyTrimer(){
    if(count($_POST) > 0 ){
      foreach($_POST as $k => $v){
        if(!is_array($_POST[$k])){ 
          $_POST[$k]=trim($_POST[$k]);
        }   
      }   
    }
  }
?>