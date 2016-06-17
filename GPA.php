<?php
$English = "2.03% 13.56% 28.14% 29.49% 20.34% 4.07% 0.67% 1.36% 0.34% 0.00% 0.00% 0.00%";
$SocialSciences = "1.35% 16.67% 19.82% 22.52% 26.13% 9.01% 2.25% 2.25% 0.00% 0.00% 0.00% 0.00%";
$Math = "12.28% 25.00% 22.37% 15.35% 14.03% 6.14% 2.19% 1.32% 0.88% 0.44% 0.00% 0.00%";
$Science = "7.66% 24.45% 28.47% 16.06% 13.87% 4.39% 2.92% 1.09% 1.09% 0.00% 0.00% 0.00%";
$Hebrew = "12.00% 40.89% 23.56% 12.00% 9.33% 0.89% 0.89% 0.44% 0.00% 0.00% 0.00% 0.00%";
$JudaicStudies = "19.71% 33.01% 22.44% 12.34% 6.25% 3.53% 1.60% 0.32% 0.16% 0.32% 0.00% 0.32%";
$WorldLanguage = "17.78% 37.78% 26.67% 13.33% 1.11% 1.11% 1.11% 1.11% 0.00% 0.00% 0.00% 0.00%";

$GradeDistribution = array($English, $SocialSciences, $Math, $Science, $Hebrew, $JudaicStudies, $WorldLanguage);
?>

<?php
if($_POST){	
	//get classes and grades
	$postedtext = $_POST['text'];
	$postedtext = strstr($postedtext, 'Current Grade');
	$postedtext = substr($postedtext, 14);
	$postedtext = substr($postedtext, 0, strpos($postedtext, "See More"));
	
	$classesraw = explode(", ", $postedtext);

	foreach($classesraw as &$value){
		$editedvalue = substr($value, 0, strpos($value, "("));
		$grade = substr($editedvalue, -7,-1);
		$classname = substr($editedvalue, 0, -7);
		$classes[$classname] = $grade;
		$classsubject[] = substr($value, -8,1);
	}
	
	//cutoff
	for ($i = 1; $i <= $_POST['cutoff']; $i++) {
		array_pop($classes);
	}
	
	//get subject of class using numbers
	array_unshift($classsubject , $postedtext[0]);
	$i=0;
	foreach ($classes as $key => $value) {
		$classsubjectnew[$key] = $classsubject[$i];
		$i++;
	}
	
	//get Change Requests
	foreach ($classes as $key => $value) {
		if ($value >= 96.5){$Changes[$key] = "Not Possoble";}
		if (($value >= 92.5) && ($value <= 96.49)){$Changes[$key] = (96.5 - $value). " A+";}
		if (($value >= 89.5) && ($value <= 92.49)){$Changes[$key] = (92.5 - $value). " A";}
		if (($value >= 86.5) && ($value <= 89.49)){$Changes[$key] = (89.5 - $value). " A-";}
		if (($value >= 82.5) && ($value <= 86.49)){$Changes[$key] = (86.5 - $value). " B+";}
		if (($value >= 79.5) && ($value <= 82.49)){$Changes[$key] = (82.5 - $value). " B";}
		if (($value >= 76.5) && ($value <= 79.49)){$Changes[$key] = (79.5 - $value). " B-";}
		if (($value >= 72.5) && ($value <= 76.49)){$Changes[$key] = (76.5 - $value). " C+";}
		if (($value >= 69.5) && ($value <= 72.49)){$Changes[$key] = (72.5 - $value). " C";}
		if (($value >= 66.5) && ($value <= 69.49)){$Changes[$key] = (69.5 - $value). " C-";}
		if (($value >= 62.5) && ($value <= 66.49)){$Changes[$key] = (66.5 - $value). " D+";}
		if (($value >= 59.5) && ($value <= 62.49)){$Changes[$key] = (62.5 - $value). " D";}
		if ($value <= 59.49){$Changes[$key] = (59.5 - $value). " D-";}
	}
	array_shift($Changes);
	asort($Changes);
	
	
	//get GPA
	array_shift($classes);
	//array_pop($classes);
	foreach ($classes as $key => $value) {
		if($key != "Physical Education	"){
			if ($value >= 96.5){$GPA = $GPA + 4.4;}
			if (($value >= 92.5) && ($value <= 96.49)){$GPA = $GPA + 4;}
			if (($value >= 89.5) && ($value <= 92.49)){$GPA = $GPA + 3.7;}
			if (($value >= 86.5) && ($value <= 89.49)){$GPA = $GPA + 3.3;}
			if (($value >= 82.5) && ($value <= 86.49)){$GPA = $GPA + 3;}
			if (($value >= 79.5) && ($value <= 82.49)){$GPA = $GPA + 2.7;}
			if (($value >= 76.5) && ($value <= 79.49)){$GPA = $GPA + 2.3;}
			if (($value >= 72.5) && ($value <= 76.49)){$GPA = $GPA + 2;}
			if (($value >= 69.5) && ($value <= 72.49)){$GPA = $GPA + 1.7;}
			if (($value >= 66.5) && ($value <= 69.49)){$GPA = $GPA + 1.3;}
			if (($value >= 62.5) && ($value <= 66.49)){$GPA = $GPA + 1;}
			if (($value >= 59.5) && ($value <= 62.49)){$GPA = $GPA + .7;}
			if ($value <= 59.49){$GPA = $GPA + 0;}
		}
		else{
			$gym = "yes";
		}
	}
	if($gym == "yes"){
		$numofclass = count($classes)-1;
	}
	else{
		$numofclass = count($classes);
	}
	$NewGPA = $GPA/$numofclass;
	
}
?>
<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<center>
		<?php 
			if (count($Changes) > 0){
				echo "Your GPA is " . round($NewGPA, 2) . "<br>";
		?>
		<table border="1">
			<tr>
				<th>Class</th>
				<th>Current Grade</th>
				<th>Closest Change in Grade</th>
				<th>Closest New Grade</th>
				<th>New GPA</th>
				<th>Maximum Final Grade</th>
				<th>Minimum Final Grade</th>
				<th>Subject Percentile</th>
			</tr>
			<tbody>
				<?php
					foreach($Changes as $key => $value){
						$pieces = explode(" ", $value);
						$NewGPA = $NewGPA + (.33/$numofclass);
						if($pieces[0]<1){
							echo '<tr style="background-color: green;">';
						}
						elseif($pieces[0]<2.2){
							echo '<tr style="background-color: yellow;">';
						}
						else{
							echo '<tr style="background-color: red;">';
						}
						
						$numgrade = $classes[$key];
						if ($pieces[1] == "Not Possoble"){$gradetoshow = $numgrade. " (A+)";}
						if ($pieces[1] == "A+"){$gradetoshow = $numgrade. " (A)";}
						if ($pieces[1] == "A"){$gradetoshow = $numgrade. " (A-)";}
						if ($pieces[1] == "A-"){$gradetoshow = $numgrade. " (B+)";}
						if ($pieces[1] == "B+"){$gradetoshow = $numgrade. " (B)";}
						if ($pieces[1] == "B"){$gradetoshow = $numgrade. " (B-)";}
						if ($pieces[1] == "B-"){$gradetoshow = $numgrade. " (C+)";}
						if ($pieces[1] == "C+"){$gradetoshow = $numgrade. " (C)";}
						if ($pieces[1] == "C"){$gradetoshow = $numgrade. " (C-)";}
						if ($pieces[1] == "C-"){$gradetoshow = $numgrade. " (D+)";}
						if ($pieces[1] == "D+"){$gradetoshow = $numgrade. " (D)";}
						if ($pieces[1] == "D"){$gradetoshow = $numgrade. " (D-)";}
						if ($pieces[1] == "D-"){$gradetoshow = $numgrade. " (F)";}
						
						//max
						if ($numgrade >= 96.5){$max = "Does Not Exist";}
						if (($numgrade >= 92.5) && ($numgrade <= 96.49)){$max = ((96.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 89.5) && ($numgrade <= 92.49)){$max = ((92.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 86.5) && ($numgrade <= 89.49)){$max = ((89.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 82.5) && ($numgrade <= 86.49)){$max = ((86.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 79.5) && ($numgrade <= 82.49)){$max = ((82.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 76.5) && ($numgrade <= 79.49)){$max = ((79.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 72.5) && ($numgrade <= 76.49)){$max = ((76.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 69.5) && ($numgrade <= 72.49)){$max = ((72.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 66.5) && ($numgrade <= 69.49)){$max = ((69.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 62.5) && ($numgrade <= 66.49)){$max = ((66.5-($numgrade*0.9))/0.1);}
						if (($numgrade >= 59.5) && ($numgrade <= 62.49)){$max = ((62.5-($numgrade*0.9))/0.1);}
						if ($numgrade <= 59.49){$max = ((59.5-($numgrade*0.9))/0.1);}
						
						//min
						if ($numgrade >= 96.5){$min = ((96.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 92.5) && ($numgrade <= 96.49)){$min = ((92.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 89.5) && ($numgrade <= 92.49)){$min = ((89.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 86.5) && ($numgrade <= 89.49)){$min = ((86.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 82.5) && ($numgrade <= 86.49)){$min = ((82.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 79.5) && ($numgrade <= 82.49)){$min = ((79.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 76.5) && ($numgrade <= 79.49)){$min = ((76.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 72.5) && ($numgrade <= 76.49)){$min = ((72.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 69.5) && ($numgrade <= 72.49)){$min = ((69.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 66.5) && ($numgrade <= 69.49)){$min = ((66.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 62.5) && ($numgrade <= 66.49)){$min = ((62.49-($numgrade*0.9))/0.1);}
						if (($numgrade >= 59.5) && ($numgrade <= 62.49)){$min = ((59.49-($numgrade*0.9))/0.1);}
						if ($numgrade <= 59.49){$min = "Does Not Exist";}
						
						$CS = $classsubjectnew[$key];
						$distributionGrades = explode(" ", $GradeDistribution[$CS-1]);
						
						foreach ($distributionGrades as $rank => $value) {
							$number = substr($value, 0, -1);
							$findingPercentile[$rank] = 0;
							for ($i = 1; $i <= round($number); $i++) {
								$findingPercentile[$rank] = $findingPercentile[$rank] + 1;
							}
						}
						
						$percentile = 0;
						if ($pieces[1] == "A+"){for ($i = 1; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "A"){for ($i = 2; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "A-"){for ($i = 3; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "B+"){for ($i = 4; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "B"){for ($i = 5; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "B-"){for ($i = 6; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "C+"){for ($i = 7; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "C"){for ($i = 8; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "C-"){for ($i = 9; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "D+"){for ($i = 10; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "D"){for ($i = 11; $i <= 11; $i++) {$percentile = $percentile + $findingPercentile[$i];}}
						if ($pieces[1] == "F"){$percentile = 0;}
						
						$StudentRank[] = $percentile;
				?>
					<td><?php echo $key; ?></td>
					<td><?php echo $gradetoshow; ?></td>
					<td><?php echo $pieces[0]; ?></td>
					<td><?php echo $pieces[1]; ?></td>
					<td><?php echo round($NewGPA, 2); ?></td>
					<td><?php echo $max; ?></td>
					<td><?php echo $min; ?></td>
					<td><?php echo $percentile; ?>%</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<br>
		<?php asort($StudentRank); echo round($StudentRank[round((count($StudentRank)/2)-2)]);?>% median and <?php echo round(array_sum($StudentRank)/count($StudentRank));?>% average out of whole school.
		<br>
		<br>
		<a href="./">Load Data Again</a>
		<?php 
			}
			else{
		?>
		<br>
		Copy (Control/Command A + Control/Command C) and paste <br>
		your enitre NetClassroom home page in the box below.
		<br>
		<br>
		<form action="./" method="post">
				<textarea name="text" style="width: 500px; height: 500px;"></textarea>
				<br>
				Cutoff <select name="cutoff">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<br>
				<input type="submit" value="Submit">
		</form>
		<?php 
			}
		?>
		</center>
	</body>
</html>
