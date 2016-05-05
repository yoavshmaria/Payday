<?php
/**
 * Payday example usage
 * 
 * Author: Yoav Shmaria <yoavshmaria@live.com>
 */

	include 'class/output.php';
	include 'class/salaries.php';

	//Create new default Salary object. Constructor accepts an array e.g. ["January 2016","December 2016"]
	$salaries 	= new Salaries();
	$table 		= $salaries->getTable();

	$output 	= new Output($table);
	$output->toCSV();
	$output->download();
?>