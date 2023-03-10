
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?=$page_title?></title>
		<style type="text/css">
			
			.priview-body{font-size: 12px;color:#000;margin: 25px;}
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
			.mt-5 {margin-top: 8px;}
			.table td, .table th{border:1px solid #ddd;}
			td.text-center {font-size: 9px;}
			th.text-center {font-size: 12px;}
			th.text-left {font-size: 12px;}
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
							??????????????? ??????????????? ??????????????? ?????????????????????
						</div>
						<div class="col-6 d-flex text-center float-left">
							<img style="width:50px; height: 50px;" src="{{ asset('global_assets/images/favicon.png') }}" alt="">
							<p class="text-center" style="margin-top: 0;">??????????????? ??????????????? ?????????????????????<span style="font-size:20px;font-weight: bold;"></span><br> ?????????????????? , ????????????</p> 
							<!-- <div style="font-size:18px;"><u><?=$page_title?></u></div> -->
							<?php //!empty($data_status)?'?????????????????????????????? ??????????????? ?????????????????????????????? '.func_datasheet_status($data_status).'<br>':''?>
							<?php // !empty($division_info->div_name_bn)?'?????????????????? '.$division_info->div_name_bn.'<br>':''?>						
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
								<div style="font-size:18px;"><u>{{ $year }}</u><!-- </div>
								<div style="font-size:18px;"> --><u> 
																


															</u></div>
								<?php //!empty($data_status)?'?????????????????????????????? ??????????????? ?????????????????????????????? '.func_datasheet_status($data_status).'<br>':''?>
								<?php // !empty($division_info->div_name_bn)?'?????????????????? '.$division_info->div_name_bn.'<br>':''?>
								
							</div>
						</div>
					</div>

					<div class="priview-demand">
						<div class="row">
							<div class="col-6">
								<table class="table table-hover table-bordered report">
									<thead class="headding">
										<tr>
											<th class="text-center" width="50" >????????????</th>
											<th class="text-left" > ???????????? ?????????</th>
											<th class="text-center" >???????????? ?????????</th>
											<!-- <th class="text-center" >??????????????? </th> -->
											<th class="text-center" >???????????? ?????????????????? </th>
										</tr>
										
									</thead>
									<tbody>
										@php
											
											$grandtotalAmountIncome = $payments;
											
										@endphp
										<tr>
											<td class="text-center" widtd="50" >1</td>
											<td class="text-center" > ??????????????? ?????? </td>
											<td class="text-center" >????????? ????????????????????????????????? ??????????????? ??????</td>
											<!-- <td class="text-center" >{{ $year }}-{{ $month }}-15</td> -->
											<td class="text-center" > {{ $payments }} </td>
										</tr>
										@foreach ($incomes as $key => $row) 
										@php
											$grandtotalAmountIncome = $grandtotalAmountIncome + $row->totalAmount;
										@endphp 
										<tr>
											<td class="text-center" widtd="50" >{{ 1+$key+1 }}</td>
											<td class="text-center" > {{ $row->name }} </td>
											<td class="text-center" >{{ $row->description }}</td>
											<!-- <td class="text-center" > {{ $row->entry_date }} </td> -->
											<td class="text-center" >{{ $row->totalAmount }}</td>
										</tr> 
										@endforeach
										<tr style="background-color: gray;">
											<td class="text-center" colspan="3"> ????????? ?????? </td>
											<td class="text-center"> {{ $grandtotalAmountIncome }} </td>
										</tr>
									</tbody>

								</table>
							</div>	
							<div class="col-6">	
								<table class="table table-hover table-bordered report">
									<thead class="headding">
										<tr>
											<th class="text-center" width="50" >????????????</th>
											<th class="text-left" > ????????????????????? ?????????</th>
											<th class="text-center" >??????????????????????????? </th>
											<!-- <th class="text-center" >??????????????? </th> -->
											<th class="text-center" >????????????????????? ?????????????????? </th>
										</tr>
										
									</thead>
									<tbody>
										@php
											
											$grandtotalAmountExpence = 0;
											
										@endphp
										@foreach ($expenses as $key => $row) 
										@php
											$grandtotalAmountExpence = $grandtotalAmountExpence + $row->totalAmount;
										@endphp 
										<tr>
											<td class="text-center" widtd="50" >{{ $key+1 }}</td>
											<td class="text-center" > {{ $row->name }} </td>
											<td class="text-center" >{{ $row->description }}</td>
											<!-- <td class="text-center" > {{ $row->entry_date }} </td> -->
											<td class="text-center" >{{ $row->totalAmount }}</td>
										</tr>
										@endforeach
										<tr style="background-color: gray;">
											<td class="text-center" colspan="3"> ????????? ???????????????</td>
											<td class="text-center"> {{ $grandtotalAmountExpence }} </td>
										</tr>
									</tbody>

								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-12" >
								@php
									$totalBalace = $grandtotalAmountIncome - $grandtotalAmountExpence; 
								@endphp
								<table class="table table-hover table-bordered report mt-5"  style="margin-left: auto; margin-right: auto; width: 250px;">
									<tr>
										<td class="text-center"> ????????? ?????? </td>
										<td class="text-center"> {{ $grandtotalAmountIncome }} </td>
									</tr>
									<tr>
										<td class="text-center">  ????????? ???????????????</td>
										<td class="text-center"> {{ $grandtotalAmountExpence }} </td>
									</tr>
									<tr>
										<td class="text-center">????????? ??????????????????????????? </td>
										<td class="text-center"> {{ $totalBalace }}</td>
									</tr>
								</table>
							</div>
						</div>				
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

