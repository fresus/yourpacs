<style>
* {
	font-size: 25px;
}

td {
	border-collapse: collapse;
	border: 1px solid blue;
	text-align: center;
	height: 50px;
}
</style>

<?php
/** GENERADOR DE CARTONES DE BINGO **/

$filas   = 3;
$celdas  = 9;
$numeros = 5;
$maxnum  = 90;

// $nums  = getNums($filas, $numeros, $celdas, $maxnum);
// echo "<pre>";
// print_r($nums);
// exit();

for ($x = 0; $x < 5; $x++)
{
	?>
	<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 8px;">
	<tr>
		<td width="50%" style="padding-right: 10px; border: 0px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr><td colspan="9" style="font-size: 12px; height: 22px; background-color: rgb(240,240,240); font-weight: bold;">¡¡BINGO JULIÁN!!</td></tr>
			<tr>
			<?php
			$nums = getNums($filas, $numeros, $celdas, $maxnum);
			foreach ($nums as $num)
			{
				if ($counter++ > 8) {
					echo "</tr><tr>\n";
					$counter = 1;
				}

				echo "<td width='11%' " . ($num >= 1 ? "style='background-color: rgb(240,240,240)'" : null) . ">" . ($num >= 1 ? $num : "*" ) . "</td>\n";
			}
			?>
			</tr>
			</table>
		</td>
		<td style="padding-left: 10px; border: 0px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr><td colspan="9" style="font-size: 12px; height: 22px; background-color: rgb(240,240,240); font-weight: bold;">¡¡BINGO JULIÁN!!</td></tr>
			<tr>
			<?php
			$nums = getNums($filas, $numeros, $celdas, $maxnum);
			foreach ($nums as $num)
			{
				if ($counter++ > 8) {
					echo "</tr><tr>\n";
					$counter = 1;
				}

				echo "<td width='11%' " . ($num >= 1 ? "style='background-color: rgb(240,240,240)'" : null) . ">" . ($num >= 1 ? $num : "*" ) . "</td>\n";
			}
			?>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<?php
}


function getNums($filas, $numeros, $celdas, $maxnum)
{
	$listnums   = array();
	$listspaces = array();

	# Obtenemos los numeros aleatorios unicos
	for ($i = 0; $i < ($filas * $numeros); $i++)
	{
		$rand = rand(1, $maxnum);

		if (!in_array($rand, $listnums)) {
			$listnums[] = $rand;
		}
		else {
			$i = $i - 1;
		}
	}
	sort($listnums);


	# Random de espacios en blanco
	$spaces = ($celdas * $filas) - ($filas * $numeros);

	for ($i = 0; $i < $spaces; $i++)
	{
		$newNums = array();
		$rand    = rand(0, ($celdas * $filas));

		if (!in_array($rand, $listspaces))
		{
			if ($listnums[$rand])
			{
				foreach ($listnums as $num)
				{
					if ($listnums[$rand] == $num) {
						$newNums[] = "";
					}
					$newNums[] = $num;
				}

				$listnums = $newNums;
			}
			else {
				$i = $i - 1;
			}
		}
		else {
			$i = $i - 1;
		}
	}

	return $listnums;
}




?>