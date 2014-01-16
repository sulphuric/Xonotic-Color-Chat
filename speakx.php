
<?php
//color chat script support for Xonotic
//created by NARKASUR aka H2SO4 on 2014/01/16
header('Content-type: text/plain');

if(empty($_GET ["say"]) || empty($_GET ["visibility"]))
	return;

$say = $_GET["say"];

$chat_type = -1; // random or what
$chat_type = $_GET ["type"];


/*$possible_null_char = substr($say, 0,6);
if(strcmp($possible_null_char, "--NULL") == 0)
{
	print "cprint ^1 No input; echo ^1 No input";
	return;
}*/

$visibility = $_GET["visibility"];

if($visibility == 1)
	echo "say ";
elseif($visibility == 2)
	echo "say_team ";
else
	echo "echo ";
	
$color_count = 1;

//place your color codes here, if you change the number of colors in each set then adjust the cases in colorify also
$color_set = array(
	 array('000', '222', '555', '777', '888', 'AAA', 'BBB', 'CCC', 'EEE'),//gray gradiant
	 array('700', 'A10', 'E20', 'F21', 'F33', 'F76', 'F77', 'FAA', 'FEE'), //red gradiant
	 array('020', '070', '0b0', '1f4', '3f6', '6f9', '8fa', 'bfd', 'dfe'), //green gradiant
	 array('220', '450', '8a0', 'ae0', 'ef3', 'df5', 'df9', 'efb', 'dfd'), // yellow gradiant
	 array('001', '108', '10c', '22f', '55f', '88f', 'bbf', 'ccf', 'eef'), //indigo gradiant
	 array('011', '055', '0AB', '0DE', '1EF', '5EF', '7DF', 'ACF', 'EFF'), //cyan gradiant
	 array('305', 'A0A', 'D0D', 'F2F', 'F4F', 'F7F', 'F9F', 'FBF', 'FEF'), //magenta - pink
	 array('50F', '209', '05E', '080', 'EE0', 'B40', 'E10', '080', 'EE0'), //rainbow 
	 array('210', '840', 'C60', 'E70', 'FA4', 'FD6', 'FE9', 'FEA', 'FFD'), //brownish gradiant
	 array('000', '222', '555', '777', '888', 'AAA', 'BBB', 'CCC', 'EEE'), //gray gradiant
);

$color_code = ($chat_type < 0) ? $color_set[rand(0, count($color_set) - 1)]: $color_set[$chat_type];


$chat_container = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19);

$wordcount = 0;
$possible_word_break_pos = 0;
$word_break_is_set = 0;
$tok = strtok($say, " \n\t");
	while ($tok !== false) {
	$temp_char = substr($tok,1, strlen($tok) );
	if($word_break_is_set == 0 && is_numeric($temp_char) && $wordcount + 1 == $temp_char)
	{
		$possible_word_break_pos = $wordcount;
		$word_break_is_set = 1;
	}
    $chat_container[$wordcount++] =  $tok ;
		if($word_break_is_set == 1){
			break;}
	
    $tok = strtok(" \n\t");
}

$break_pos = FindBreakPosition($possible_word_break_pos, $chat_container);

for($i = 0; $i < $break_pos; ++$i)
{
	$trimmed_string = 'fine';
	$trimmed_string = TrimAlreadyExistingColorCodes($chat_container[$i]);
	$j = 0;
	for($j = 0; $j < strlen($trimmed_string); ++$j)
	{
		echo("$trimmed_string[$j]");
		$color_count = colorify($color_count);
	}
}

function colorify($color_count) 
{
		global $color_code;
		switch ($color_count){
			case 1 :
				echo("^x$color_code[0]");
				++$color_count;
				break;
			case 2 :
				echo("^x$color_code[1]");
				++$color_count;
				break;
			case 3 :
				echo("^x$color_code[2]");
				++$color_count;
				break;
			case 4 :
				echo("^x$color_code[3]");
				++$color_count;
				break;
			case 5 :
				echo("^x$color_code[4]");
				++$color_count;
				break;
			case 6 :
				echo("^x$color_code[5]");
				++$color_count;
				break;
			case 7 :
				echo("^x$color_code[6]");
				++$color_count;
				break;
			case 8 :
				echo("^x$color_code[7]");
				++$color_count;
				break;
			case 9 :
				echo("^x$color_code[8]");
				++$color_count;
				break;
			#reverse color
			case 10 :#same as 8
				echo("^x$color_code[7]");
				++$color_count;
				break;
			case 11 :#same as 7
				echo("^x$color_code[6]");
				++$color_count;
				break;
			case 12 :#same as 6
				echo("^x$color_code[5]");
				++$color_count;
				break;
			case 13 :#same as 5
				echo("^x$color_code[4]");
				++$color_count;
				break;
			case 14 :#same as 4
				echo("^x$color_code[3]");
				++$color_count;
				break;
			case 15 :#same as 3
				echo("^x$color_code[2]");
				++$color_count;
				break;
			case 16 :#same as 2
				echo("^x$color_code[1]");
				$color_count = 1;
				break;
			default:
				break;
		}
		return $color_count;
}

function FindBreakPosition($possible_word_break_pos, $chat_container)
{
	//$position = $possible_word_break_pos;
	//for($i = $position; $i < strlen($chat_container); ++$i)
	//{
			//todo - some serious check
	//}
	return $possible_word_break_pos;//temporary
}

function TrimAlreadyExistingColorCodes($input_string){
	$trimmed_char = " ";
	$color_code_position = 0;
	$stringlength = strlen($input_string);
	$position_B = $stringlength;  # A........B..A............B
	$position_A = 0;  # A........^1.A............^xCF0.A......
	$position_B_memory = $position_B; #need to reset if color code verification fails
	for($j = 0; $j <$stringlength; ++$j)
	{
		$temp_char = substr($input_string, $j,1);
		
		if(strcmp ($temp_char, "^") == 0)
		{
			$color_code_position  = 1 ;
		}
		elseif($color_code_position == 1 )
		{
		
			if($temp_char <= 9 && $temp_char >=0 && is_numeric($temp_char))
			{
				#add1;
				$position_B = $j - 1 ;
				
				if($position_B - $position_A > 0)
				{
					$trimmed_char = $trimmed_char.substr($input_string, $position_A, $position_B - $position_A);
				}
			
				$position_A = $position_B + 2;
				$position_B = $stringlength;
				$color_code_position = 0;
				
			}
			elseif (strcmp ( $temp_char , "x")==0)
			{
				$color_code_position  = 2;
			}
			else
			{
				$color_code_position = 0;
			#	$position_B = $position_B_memory; # color code verification failed; something like ...^a..
			}
			
		}
		elseif($color_code_position == 2 || $color_code_position == 3 || $color_code_position == 4 || $color_code_position == 5)
		{
		
			if( (0 <= $temp_char && $temp_char <= 9 && is_numeric($temp_char)) || strcmp ( $temp_char , "A" ) == 0||
			strcmp ( $temp_char , "B") == 0 || strcmp( $temp_char, "C") == 0|| strcmp ( $temp_char , "D") == 0|| strcmp ( $temp_char , "E") == 0|| strcmp ( $temp_char , "F") == 0
			|| strcmp ( $temp_char , "a") == 0 || strcmp ( $temp_char , "b") == 0 || strcmp ( $temp_char , "c") == 0|| strcmp ( $temp_char , "d"|| strcmp ( $temp_char , "e") == 0|| strcmp ( $temp_char , "f") == 0))
			{
				++$color_code_position;
			}
			else
			{
				$color_code_position = 0;
				#???
			}
			
			if($color_code_position == 4)
			{
				#add2;
				
				$position_B = $j - 3;
				if($position_B - $position_A > 0)
				{
					$trimmed_char = $trimmed_char.substr($input_string, $position_A, $position_B- $position_A );
				}
			
				$position_A = $position_B + 5;
				$position_B = $stringlength;
				$color_code_position = 0;
			}
				
		}
	}
	
	$trimmed_char = $trimmed_char.substr($input_string, $position_A, $position_B - $position_A);
	return $trimmed_char;
}


?>
