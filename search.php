<?php

if (! isset($_POST["keyword"]))
{ exit("Access Denied"); }

// $ -> \$
$dict = array();

$keyword = $_POST["keyword"];
$mode = $_POST["mode"];
$length = strlen($keyword);
if ($length > 20)
{ exit("Your keyword is invalid."); }
$result = "";
$total = 0;

// $line = finlandês [fĩlãd'es] (a, m) Finnish, Finn | 芬兰的，芬兰人，芬兰语
// $po = finlandês
// $en = Finnish, Finn
// $ch = 芬兰的，芬兰人，芬兰语
// $pec = finlandês|Finnish|Finn|芬兰的|芬兰人|芬兰语

foreach ($dict as $line)
{ $pos1 = stripos($line, " [");
  $pos2 = stripos($line, ") ");
  $pos3 = stripos($line, " | ");
  $po = substr($line, 0, $pos1);
  $en = substr($line, $pos2 + 2, $pos3 - $pos2 - 2);
  $ch = substr($line, $pos3 + 3);
  $poench = $po . "|" . $en . "|" . $ch;

  $poench = strtolower($poench);
  $poench = str_ireplace("à", "a", $poench);
  $poench = str_ireplace("á", "a", $poench);
  $poench = str_ireplace("â", "a", $poench);
  $poench = str_ireplace("ã", "a", $poench);
  $poench = str_ireplace("ç", "c", $poench);
  $poench = str_ireplace("é", "e", $poench);
  $poench = str_ireplace("ê", "e", $poench);
  $poench = str_ireplace("í", "i", $poench);
  $poench = str_ireplace("ó", "o", $poench);
  $poench = str_ireplace("ô", "o", $poench);
  $poench = str_ireplace("õ", "o", $poench);
  $poench = str_ireplace("ú", "u", $poench);
  $poench = str_ireplace("ü", "u", $poench);
  $poench = str_ireplace(", ", "|", $poench);
  $poench = str_ireplace("，", "|", $poench);

  $list = explode("|", $poench);
  $lastdata = "";

  if ($mode == "smode")
  { foreach ($list as $word)
      if (strncasecmp($word, $keyword, $length) == 0)
      { $data = "<li>" . $line;
        if ($data != $lastdata)
        { $result .= $data;
          $lastdata = $data;
          $total++; } } }
  else
  { foreach ($list as $word)
      if (stripos($word, $keyword) != false)
      { $data = "<li>" . $line;
        if ($data != $lastdata)
        { $result .= $data;
          $lastdata = $data;
          $total++; } } } }

if ($result != "")
{ echo $result;
  echo $total == 1 ? "<p>1 word found</p>" : "<p>$total words found</p>"; }
else
{ echo "<p>No word found</p>"; }

?>