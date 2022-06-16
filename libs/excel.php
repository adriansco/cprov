<?PHP
  namespace Chirp;

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  $test = 'Yoli';

  $data = array(
    array("ID Agentis" => $test, "Nombre" => "Johnson", "Correo" => 25, "Teléfono" => "777 362 15 98", "Doc1" => "2", "Doc2" => "2", "Doc3" => "2", "Doc4" => "2", "Doc5" => "2", "Doc6" => "2", "Doc7" => "2", "Doc8" => "2", "Doc9" => "2", "Doc10" => "2"),
    array("ID Agentis" => "Amanda", "Nombre" => "Miller", "Correo" => 18, "Teléfono" => "777 362 15 98", "Doc1" => "2", "Doc2" => "2", "Doc3" => "2", "Doc4" => "2", "Doc5" => "2", "Doc6" => "2", "Doc7" => "2", "Doc8" => "2", "Doc9" => "2", "Doc10" => "2"),
    array("ID Agentis" => "James", "Nombre" => "Brown", "Correo" => 31, "Teléfono" => "777 362 15 98", "Doc1" => "2", "Doc2" => "2", "Doc3" => "2", "Doc4" => "2", "Doc5" => "2", "Doc6" => "2", "Doc7" => "2", "Doc8" => "2", "Doc9" => "2", "Doc10" => "2"),
    array("ID Agentis" => "Patricia", "Nombre" => "Williams", "Correo" => 7, "Teléfono" => "777 362 15 98", "Doc1" => "2", "Doc2" => "2", "Doc3" => "2", "Doc4" => "2", "Doc5" => "2", "Doc6" => "2", "Doc7" => "2", "Doc8" => "2", "Doc9" => "2", "Doc10" => "2"),
    array("ID Agentis" => "Michael", "Nombre" => "Davis", "Correo" => 43, "Teléfono" => "777 362 15 98", "Doc1" => "2", "Doc2" => "2", "Doc3" => "2", "Doc4" => "2", "Doc5" => "2", "Doc6" => "2", "Doc7" => "2", "Doc8" => "2", "Doc9" => "2", "Doc10" => "2"),
    array("ID Agentis" => "Sarah", "Nombre" => "Miller", "Correo" => 24, "Teléfono" => "777 362 15 98", "Doc1" => "2", "Doc2" => "2", "Doc3" => "2", "Doc4" => "2", "Doc5" => "2", "Doc6" => "2", "Doc7" => "2", "Doc8" => "2", "Doc9" => "2", "Doc10" => "2"),
    array("ID Agentis" => "Patrick", "Nombre" => "Miller", "Correo" => 27, "Teléfono" => "777 362 15 98", "Doc1" => "2", "Doc2" => "2", "Doc3" => "2", "Doc4" => "2", "Doc5" => "2", "Doc6" => "2", "Doc7" => "2", "Doc8" => "2", "Doc9" => "2", "Doc10" => "2")
  );

  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // file name for download
  $filename = "website_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\n";
  }

  exit;
?>
