
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?=$page_title?></title>
		<style type="text/css">
			.priview-body{font-size: 16px;color:#000;margin: 25px;}
			.priview-header{margin-bottom: 10px;text-align:center;}
			.priview-header div{font-size: 18px;}
			.priview-memorandum, .priview-from, .priview-to, .priview-subject, .priview-message, .priview-office, .priview-demand, .priview-signature{padding-bottom: 20px;}
			.priview-office{text-align: center;}
			.priview-imitation ul{list-style: none;}
			.priview-imitation ul li{display: block;}
			.date-name{width: 20%;float: left;padding-top: 23px;text-align: right;}
			.date-value{width: 70%;float:left;}
			.date-value ul{list-style: none;}
			.date-value ul li{text-align: center;}
			.date-value ul li.underline{border-bottom: 1px solid black;}
			.subject-content{text-decoration: underline;}
			.headding{border-top:1px solid #000;border-bottom:1px solid #000;}

			.col-1{width:8.33%;float:left;}
			.col-2{width:16.66%;float:left;}
			.col-3{width:25%;float:left;}
			.col-4{width:33.33%;float:left;}
			.col-5{width:41.66%;float:left;}
			.col-6{width:50%;float:left;}
			.col-7{width:58.33%;float:left;}
			.col-8{width:66.66%;float:left;}
			.col-9{width:75%;float:left;}
			.col-10{width:83.33%;float:left;}
			.col-11{width:91.66%;float:left;}
			.col-12{width:100%;float:left;}

			.table{width:100%;border-collapse: collapse;}
			.table td, .table th{border:1px solid #ddd;}
			.table tr.bottom-separate td,
			.table tr.bottom-separate td .table td{border-bottom:1px solid #ddd;}
			.borner-none td{border:0px solid #ddd;}
			.headding td, .total td{border-top:1px solid #ddd;border-bottom:1px solid #ddd;}
			.table td{padding:5px;}
			.text-center{text-align:center;}
			.text-right{text-align:right;}
			b{font-weight:500;}
		</style>
	</head>
		<body onload="onload()">
			<div class="priview-body">
				<div class="priview-header">
					<div class="row">
						<div class="col-3 text-left float-left">
							 <?=date('d-m-Y')?>
						</div>
						<div class="col-6 text-center float-left">
							<p class="text-center" style="margin-top: 0;">দারুল ইনসান মাদরাসা<span style="font-size:20px;font-weight: bold;"></span><br> মিরপুর , ঢাকা</p> 
							<!-- <div style="font-size:18px;"><u><?=$page_title?></u></div> -->
							<?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''?>
							<?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''?>						
						</div>
						<div class="col-3 text-right float-right">
							আদর্শ মানুষ গড়ার লক্ষ্যে
						</div>
					</div>			
				</div>

					<div class="priview-memorandum">
						<div class="row">
							<div class="col-12 text-center">
								<div style="font-size:18px;"><u>{{ $page_title }}</u></div>
								<div style="font-size:18px;"><u>{{ $year }}</u></div>
								<div style="font-size:18px;"><u>
																@if($month == 1)
																	জানুয়ারি
																@elseif($month == 2)
																	ফেব্রুয়ারী
																@elseif($month == 3)
																	মার্চ 
																@elseif($month == 4)
																	এপ্রিল 
																@elseif($month == 5)
																	মে 
																@elseif($month == 6)
																	জুন 
																@elseif($month == 7)
																	জুলাই 
																@elseif($month == 8)
																	আগষ্ট 
																@elseif($month == 9)
																	সেপ্টেম্বর 
																@elseif($month == 10)
																	অক্টোবর 
																@elseif($month == 11)
																	নভেম্বর 
																@elseif($month == 12)
																	ডিসেম্বর  
																@endif


															</u></div>
								<?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''?>
								<?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''?>
								
							</div>
						</div>
					</div>

					<div class="priview-demand">
						<table class="table table-hover table-bordered report">
							<thead class="headding">
								<tr>
									<th class="text-center" width="50" >ক্রম</th>
									<th class="text-center" >ছবি</th>
									<th class="text-left" > নাম</th>
									<th class="text-center" >মোবাইল নং </th>
									<th class="text-center" >মাসিক বেতনের পরিমান </th>
									<th class="text-center" >পরিশোধিত টাকার পরিমান</th>
									<th class="text-center" >ভর্তুকির পরিমান</th>
								</tr>
								
							</thead>
							<tbody>
								@php
									$totalSubsidy = 0;
									$grandtotalAmount = 0;
									$grandtotalAmountPaid = 0;
								@endphp
								@foreach ($payment_status as $key => $row) 
								@php

									
									$totalSubsidy = $totalSubsidy+ $row->balance;
									$grandtotalAmount = $grandtotalAmount + $row->amount;
									$grandtotalAmountPaid = $grandtotalAmountPaid + $row->amt_paid;
								@endphp 
								<tr>
									<td class="text-center" widtd="50" >{{ $key+1 }}</td>
									<td class="text-center" ><img src="{{ $row->photo }}" alt="profile Pic" height="20" width="20"></td>
									<td class="text-center" > {{ $row->name }} </td>
									<td class="text-center" > {{ $row->phone }} </td>
									<td class="text-center" >{{ $row->amount }}</td>
									<td class="text-center" >{{ $row->amt_paid }}</td>
									<td class="text-center" > {{ $row->balance }} </td>
								</tr>
								@endforeach
								<tr>
									<td class="text-center" colspan="4"> Total </td>
									<td class="text-center"> {{ $grandtotalAmount }} </td>
									<td class="text-center"> {{ $grandtotalAmountPaid }} </td>
									<td class="text-center"> {{ $totalSubsidy }} </td>
									
								</tr>
							</tbody>

						</table>			
					</div>

			</div>
			<script type="text/javascript">
	            function onload() {
	               // var url = window.location.search.substring(1)
	               // var img = document.getElementById('img')
	               // img.src = url
	               window.print()
	            }
	        </script>	
		</body>
</html>

