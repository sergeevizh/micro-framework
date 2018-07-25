{
	"status": "<?php echo $status; ?>",
	"result": [
	<?
		if(is_array($json)){
			$c=0;
			foreach($json as $json_line){
				$c++;
				if($c>1) echo ",";
				echo "{
		";
				$j=0;
				foreach($json_line as $key => $value){
					$j++;
					if($j>1) echo ",
			";
					echo '"'.$key.'": "'.$value.'"';
				}
				echo "}";
			}
		}
	?>
	]
}