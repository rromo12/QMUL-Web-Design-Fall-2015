<?PHP
  include 'ChromePhp.php';
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');  
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  header('Access-Control-Allow-Headers: Authorization');
  
  /*$user_name = "rgr30";
  $pass_word = "JMvRAKbOpcObx";
  $database = "rgr30";
  $server = "dbprojects.eecs.qmul.ac.uk";
*/
  $user_name = "root";
  $pass_word = "";
  $database = "rgr30";
  $server = "127.0.0.1";

function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
};

ChromePhp::log('Included');

  
?>
