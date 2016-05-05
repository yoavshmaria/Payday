<?php
/**
 * Salaries class
 * 
 * Author: Yoav Shmaria <yoavshmaria@live.com>
 */

	class Salaries{

		private 
			$start_date,
		 	$end_date,
		 	$table;

		/**
		 * Date const - STRINGS MUST BE IN strtotime FORMAT <http://php.net/manual/en/function.strtotime.php>
		 * Define the forbidden pay days as a comma delimited string
		 * Define the alternatyive pay day for salary and bonus
		 * Define the default date limit for the constructor
		 */
		const 
			FORBIDDEN_DAYS 			= "Friday,Saturday",
			ALTERNATIVE_SALARY_DAY 	= "Thursday last week",
			ALTERNATIVE_BONUS_DAY 	= "Wednesday next week",
			DEFAULT_DATE_LIMIT 		= "+12 month";


		/**
		 * Constructor
		 * ==========
		 * Params
		 *		$date_range = array of 2 cells: <string>start_date & <string>end_date - strtotime format
		 */
		public function __construct($date_range = []){
			//By default - sets the date range from this month to the date limit
			if(empty($date_range)){			
				$date_range = [date("Y-m"),date("Y-m",strtotime(self::DEFAULT_DATE_LIMIT))];
			}

			$this->start_date 	= new DateTime($date_range[0]);
			$this->end_date 	= new DateTime($date_range[1]);			
			$this->_getSalariesDays();
			$this->_getBonusesDate();			
		}

		public function getTable(){
			return $this->table;
		}


		//The following function runs through the date range and set each month salary pay day in $table
		private function _getSalariesDays(){
			$interval 	= DateInterval::createFromDateString('1 month');
			$period 	= new DatePeriod($this->start_date, $interval, $this->end_date);

			foreach ($period as $date){
				$year 		= $date->format("Y");
				$month 		= $date->format("m");
				$day 		= $date->format("t");

				if($this->isDayForbidden(date("l",strtotime("$year-$month-$day")))){
					$day = date("d",strtotime(self::ALTERNATIVE_SALARY_DAY,$date->format("U")));
				}

				$this->table[$date->format("F")]["Salary"] = $day;
			}
		}

		//The following function runs through the date range and set each month bonus pay day in $table
		private function _getBonusesDate(){
			$interval 	= DateInterval::createFromDateString('1 month');
			$period 	= new DatePeriod($this->start_date, $interval, $this->end_date);

			foreach ($period as $date){
				$year 		= $date->format("Y");
				$month 		= $date->format("m");
				$day 		= 15;

				if($this->isDayForbidden(date("l",strtotime("$year-$month-15")))){
					$day = date("d",strtotime(self::ALTERNATIVE_BONUS_DAY,strtotime("$year-$month-15")));
				}

				$this->table[$date->format("F")]["Bonus"] = $day;
			}
		}

		//Checks if the day string is in the forbidden days string
		private function isDayForbidden($day){
			return strpos(self::FORBIDDEN_DAYS, $day) > -1;
		}

	}
?>