<?php

if (! isset($_POST["keyword"]))
{ exit("Access Denied"); }

// $ -> \$
$dict = array("feliz (a) happy | 幸福的",
              "infeliz (a) unhappy | 不幸福的");

$keyword = $_POST["keyword"];
$mode = $_POST["mode"];
$length = strlen($keyword);
if ($length > 20)
{ exit("Your keyword is invalid."); }
$result = "";
$total = 0;

// $line = finlandes^finlandês [*] (a, m) Finnish, Finn | 芬兰的，芬兰人，芬兰语
// $po = finlandes^finlandês
// $en = Finnish, Finn
// $ch = 芬兰的，芬兰人，芬兰语
// $poench = finlandes^finlandês|Finnish|Finn|芬兰的|芬兰人|芬兰语

foreach ($dict as $line)
{ if (stripos($line, " [") > 0)
    $pos1 = stripos($line, " [");
  else
    $pos1 = stripos($line, " (");
  $pos2 = stripos($line, ") ");
  $pos3 = stripos($line, " | ");

  $po = substr($line, 0, $pos1);
  $en = substr($line, $pos2 + 2, $pos3 - $pos2 - 2);
  $ch = substr($line, $pos3 + 3);

  $poench = $po . "|" . $en . "|" . $ch;
  // $poench = str_ireplace(", ", "|", $poench);
  // $poench = str_ireplace("，", "|", $poench);
  $poench = str_ireplace("①", "", $poench);
  // $poench = str_ireplace(" ②", "|", $poench);
  // $poench = str_ireplace(" ③", "|", $poench);
  // $poench = str_ireplace(" ④", "|", $poench);
  // $poench = str_ireplace(" ⑤", "|", $poench);
  // $poench = strtolower($poench);

  $list = explode("|", $poench);
  $lastdata = "";

  if ($mode == "smode")
  { foreach ($list as $word)
      if (strncasecmp($word, $keyword, $length) == 0)
      { $pos4 = stripos($line, "^");
        if ($pos4 > 0)
          $line = substr($line, $pos4 + 1);
        $data = "<li>" . $line . "</li>";
        if ($data != $lastdata)
        { $result .= $data;
          $lastdata = $data;
          $total++; } } }
  else
  { foreach ($list as $word)
      if (stripos($word, $keyword) > 0)
      { $pos4 = stripos($line, "^");
        if ($pos4 > 0)
          $line = substr($line, $pos4 + 1);
        $data = "<li>" . $line . "</li>";
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