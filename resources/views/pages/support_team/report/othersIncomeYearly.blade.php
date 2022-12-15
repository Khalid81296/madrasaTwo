
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
							আদর্শ মানুষ গড়ার লক্ষ্যে
						</div>
						<div class="col-6 d-flex text-center float-left">
							<img style="width:50px; height: 50px;" src="{{ asset('global_assets/images/favicon.png') }}" alt="">
							<p class="text-center" style="margin-top: 0;">দারুল ইনসান মাদরাসা<span style="font-size:20px;font-weight: bold;"></span><br> মিরপুর , ঢাকা</p> 
							<!-- <div style="font-size:18px;"><u><?=$page_title?></u></div> -->
							<?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''?>
							<?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''?>						
						</div>
						<div class="col-3 text-left float-right">
							 <?=date('d-m-Y')?>
						</div>
					</div>			
				</div>

					<div class="priview-memorandum">
						<div class="row">
							<div class="col-12 text-center">
								<div style="font-size:18px;"><u>{{ $page_title }}</u></div>
								<div style="font-size:18px;"><u>{{ $year }}</u></div>
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
									<th class="text-left" > আয়ের খাত</th>
									<th class="text-center" >আয়ের পরিমান </th>
								</tr>
								
							</thead>
							<tbody>
								@php
									$grandtotalAmount = 0;
								@endphp
								
								@foreach ($incomes as $key => $row) 
								@php
									$grandtotalAmount = $grandtotalAmount + $row->totalAmount;
								@endphp 
								<tr>
									<td class="text-center" widtd="50" >{{ 1+$key+1 }}</td>
									<td class="text-center" > {{ $row->name }} </td>
									<td class="text-center" >{{ $row->totalAmount }}</td>
								</tr> 
								@endforeach
								<tr>
									<td class="text-center" colspan="2"> Total Amount</td>
									<td class="text-center"> {{ $grandtotalAmount }} </td>
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

