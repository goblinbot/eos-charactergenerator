<?php

echo "<b>Regular: (n/2)*(1+n), skip the first. where n = level.</b>";

// (n/2)*(1+n)

// start/skip 1 because math
echo "<br/>Level:&nbsp;1&nbsp;Cost:&nbsp;1<br/>";

// formula
for ($i = 2; $i <= 5; $i++) {
  echo "Level:&nbsp;" . $i . "&nbsp;Cost:&nbsp;" . ($i / 2) * (1 + $i) . "<br/>";
}

echo "<br/><b>Specialist math: (L/2)*(m+n) where L = level, m is first available (6), n is Level (last)</b><br/>";
// level, first possible number, last possible level??
// (L/2)*(m+n)

for ($L = 6; $L <= 10; $L++) {

  $m = 6;
  $n = $L;

  echo "Level: " . $L . " Cost: " . (($L - $m + 1) / 2) * ($m + $n) . "<br/>";
}
