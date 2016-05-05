<?php
/**
 * Output class
 * 
 * Author: Yoav Shmaria <yoavshmaria@live.com>
 */

	class Output{

		private 
			$table,
			$output,
			$type;

		public function __construct($table){
			$this->table = $table;
		}

		//Creates an HTML table of 3 cols: Month | Salary day | Bonus day from the $table as given in the constructor
		public function toHTML(){
			$this->type = "html";

			$this->output = "<table><thead><th>Month</th><th>Salary day</th><th>Bonus day</th></thead>";
			$this->output .= "<tbody>";

			foreach($this->table as $month => $payments){
				$this->output .= "<tr>";
				$this->output .= "<td>".$month."</td>";
				$this->output .= "<td>".$payments['Salary']."</td>";
				$this->output .= "<td>".$payments['Bonus']."</td>";
				$this->output .= "</tr>";
			}

			$this->output .= "</tbody>";
			$this->output .= "</table>";
		}

		//Creates a comma delimited table of 3 cols: Month, Salary day, Bonus day \n from the $table as given in the constructor
		public function toCSV(){
			$this->type = "csv";

			$this->output = "Month, Salary day, Bonus day";
			$this->output .= "\n";

			foreach($this->table as $month => $payments){
				$this->output .= $month.",";
				$this->output .= $payments['Salary'].",";
				$this->output .= $payments['Bonus'].",";
				$this->output .= "\n";
			}
		}

		//Set header to force the browser to download the file format [.html or .csv]
		public function download(){
			header('Content-Type: application/'.$this->type);
			header('Content-Disposition: attachment; filename=salaries.'.$this->type);
			header('Pragma: no-cache');
			$this->stdPrint();
		}

		//Simple print of the output to the body
		public function stdPrint(){
			echo $this->output;
		}

	}
?>