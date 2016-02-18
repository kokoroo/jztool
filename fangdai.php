<?php



$room_total = 125;// 万
$shoufu_pct = 0.3;// 首付比例


// $loan_total = $room_total * 10000 * (1 - $shoufu_pct);
$loan_total = 775000;
$loan_years = 10;// 贷款年限
$loan_rate = 3.25;// 贷款年利率（百分之）


$loan_months = $loan_years * 12;
$loan_rate_month = $loan_rate / 12;

$loan_per_month = $loan_total / $loan_months;


function loan_analyze( $total,$month,$monthly_rate,$type ){

	$data = array(
		'total'=>$total,
		'monthly_rate'=>$monthly_rate,
		'month'=>$month,
	);

	$monthly_principal_refund = $total/$month;
	
	$monthly_data = array();

	$sum = 0;

	foreach( $i = 1; $i<= $month; $i++ ){
		$interest = ($month - $i + 1) * $monthly_principal_refund * $monthly_rate * 0.01;
		$interest_pct = $interest/$monthly_principal_refund;
		$sum = $sum + $interest + $loan_per_month;

		$monthly_data[$i] = array(
			'principal'=>$monthly_principal_refund,
			'interest'=>$interest,
			'interest_pct'=>$interest_pct,
			'sum'=>$sum,
		);
	}

	$data['sum'] = $sum;
	$data['interest_sum'] = $sum - $total;


	// $monthly_interest_refund = $total/$month;








}









?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	
	<table>
		<thead>
			<tr>
				<th>month</th>
				<th>principal</th>
				<th>interest</th>
				<th>total pay</th>
				<th>principal left</th>
				<th>sum</th>
				<th>interest rate</th>
				<th>interest rate sum</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$sum = 0;
			$interest_rate_sum = 0;
			for( $i=1;$i<=$loan_months;$i++ ){ 
				$interest = ($loan_months - $i + 1) * $loan_per_month * $loan_rate_month * 0.01;
				$interest_rate = $interest/$loan_per_month;
				$interest_rate_sum += $interest_rate;
				$sum = $sum + $interest + $loan_per_month;
			?>
			<tr>
				<td><?php echo $i ?></td>	
				<td><?php echo $loan_per_month ?></td>	
				<td><?php echo $interest ?></td>	
				<td><?php echo $interest + $loan_per_month ?></td>	
				<td><?php echo ($loan_months - $i) * $loan_per_month ?></td>
				<td><?php echo $sum ?></td>
				<td><?php echo $interest_rate ?></td>
				<td><?php echo $interest_rate_sum ?></td>
			</tr>
			<?php } ?>
		</tbody>


	</table>



</body>
</html>



