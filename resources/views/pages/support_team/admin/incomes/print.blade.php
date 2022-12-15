<html lang="en">
    <head>
        <meta charset="utf-8">
        
        <style type="text/css">
            .priview-body{font-size: 16px;color:#000;margin: 25px;  height: 250px;}
            .priview-header{margin-bottom: 10px;text-align:center;}
            .priview-header div{font-size: 18px;}
            .priview-footer{margin-bottom: 10px;text-align:center;}
            .priview-footer div{font-size: 10px;}
            .priview-memorandum, .priview-from, .priview-to, .priview-subject, .priview-message, .priview-office, .priview-demand, .priview-signature{padding-bottom: 20px; text-align: left;}
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
        <div class="priview-body" style="border:1px solid;">
            <div class="priview-header">
                <div class="row">
                    <div class="col-3 text-left float-left">
                     <img style="width:50px; height: 50px;" src="{{ asset('global_assets/images/favicon.png') }}" alt="">    
                    </div>
                    <div class="col-6 text-center float-left">
                        <p class="text-center" style="margin-top: 0;">দারুল ইনসান মাদরাসা<span style="font-size:10px;font-weight: bold;"><br> <small>বাড়ি ২৪, রোড 6, ব্লক সি, সেকশন ১৩<br>মিরপুর , ঢাকা </small></span></p>                                               
                    </div>
                    <div class="col-3 text-center float-center mt-10"style="margin-top: 10px;">
                        <span style="font-size:10px;font-weight: bold;">আদর্শ মানুষ গড়ার লক্ষ্যে</span>
                    </div>
                </div>          
            </div>
            <div class="priview-demand">
                <table class="table table-hover table-bordered report">
                        <tbody>
                           <tr>
                                <th width="100" style="text-align: left !important;">
                                    নাম
                                </th>
                                <td>
                                    {{ $income->description }}
                                </td>
                            </tr>
                            <tr>
                                <th width="100" style="text-align: left !important;">
                                    মোবাইল নং
                                </th>
                                <td>
                                    {{ $income->mobile_no }}
                                </td>
                            </tr>
                            <tr>
                                <th width="100" style="text-align: left !important;">
                                    ধরণ 
                                </th>
                                <td>
                                    {{ $income->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th width="100" style="text-align: left !important;">
                                    পরিমাণ
                                </th>
                                <td>
                                    {{ $income->amount }}
                                </td>
                            </tr>
                            <tr>
                                <th width="100" style="text-align: left !important;">
                                    তারিখ
                                </th>
                                <td>
                                    {{ $income->entry_date }}
                                </td>
                            </tr>
                            
                            
                        </tbody>
                </table>
            </div>
            <div class="priview-footer">
                <div class="row">
                    <div class="col-3 text-left float-left">
                        <small>অধ্যক্ষের স্বাক্ষর</small>
                    </div>
                    <div class="col-6 text-center float-left">
                        <small>প্রদানকারীর স্বাক্ষর</small>
                    </div>
                    <div class="col-3 text-center float-center">
                        <small>গ্রহণকারীর স্বাক্ষর</small>
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
