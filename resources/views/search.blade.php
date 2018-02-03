@extends('layouts.wura')
@section('page_heading','Search Results')

@section('styles')
    <style>
		*, *:before, *:after {
			-webkit-box-sizing: border-box; 
			-moz-box-sizing: border-box; 
			box-sizing: border-box;
		}

		#integration-list {
			width: 80%;
			margin: 0 auto;
			display: table;
		}

		#integration-list ul {
			color: #fff;
			padding: 0;
			margin: 20px 0;
		}

		#integration-list ul > li {
			padding: 15px;
			display: block;
			overflow: hidden;
			list-style: none;
			border-top: 1px solid #ddd;
		}

		#integration-list ul:last-child {
			border-bottom: 1px solid #ddd;
		}

		.expand {
			display: block;
			text-decoration: none;
			color: #555;
			cursor: pointer;
		}

		h2 {
			padding: 0;
			margin: 0;
			font-size: 17px;
			font-weight: 400;
		}

		span {
			text-align: left;
			font-size: 12.5px;
		}

		#sup {
			display: table-cell;
			vertical-align: middle;
			width: 80%;
		}

		.detail a {
			float: left;
			text-decoration: none;
			color: #C0392B;
			border: 1px solid #C0392B;
			padding: 6px 10px 5px;
			font-size: 14px;
		}

		.detail {
			margin: 10px 0 10px 0px;
			display: none;
			line-height: 22px;
			height: 150px;
		}

		.detail span{
			margin: 0;
		}

		.right-arrow {
			margin-top: 12px;
			margin-left: 20px;
			width: 10px;
			height: 100%;
			float: right;
			font-weight: bold;
			font-size: 20px;
		}
    </style>
@stop

@section('content')
About 299,000 results (0.67 seconds) 

    <hgroup class="mb20">
		<h2 class="lead">
			<strong class="standout">{{ sizeof($searchResults) }}</strong> 
			results were found for 
			<strong class="standout">
				{{ $searchText }}
			</strong>
			under {{ round($executionTime, 3) }} seconds
		</h2>								
	</hgroup>

	<div id="integration-list">
		<ul>
			@foreach ($searchResults as $searchresult)
				<?php
					$classname = ''; $url = '';
					switch (strtolower($searchresult->tablename)) {
						case 'audits':
							$classname = 'fa fa-history fa-fw';
							break;

						case 'calendars':
							$classname = 'fa fa-calendar fa-fw';
							break;
							
						case 'cards':
							$classname = 'fa fa-credit-card fa-fw';
							break;
				
						case 'notifications':
							$classname = 'fa fa-bell-o fa-fw';
							break;
			
						case 'transactions':
							$classname = 'fa fa-exchange-alt fa-fw';
							break;
		
						case 'users':
							$classname = 'fa fa-users fa-fw';
							break;
	
						case 'vehicle_docs':
							$classname = 'fa fa-file-alt fa-fw';
							break;

						case 'vehicles':
							$classname = 'fa fa-car fa-fw';
							break;
	
						case 'wallets':
							$classname = 'fa fa-google-wallet fa-fw';
							break;
							
						case 'drivers':
							$classname = 'fa fa-id-badge fa-fw';
							break;
					}
				?>
				<li>
					<a class="expand">
						<div class="right-arrow">+</div>
						<div>
							<h2 class="pull-left">
								<i class="{{ $classname }}"></i>
								{{ ucwords($searchresult->tablename) }}
							</h2>
							<span>Meets SPCC Regulation 40CFR112, Oil spill solutions, Oil Solidifier - just pick it up and send it to a land fill, Spill kits, Sub-station containment</span>
						</div>
					</a>

					<div class="detail">
						<div class="table-responsive">
							<table class="table dtable table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th> S / N </th>
									<th> Passport </th>
									<th> Staff ID </th>
									<th> Full Name </th>
									<th> Mobile Number </th>
									<th> Date of Birth </th>
									<th> Action </th>
								</tr>
							</thead>
							<tbody></tbody>
							</table>
						</div>
					</div>

					<br />
					<br />
				</li>
			@endforeach
		</ul>
	</div>
@endsection