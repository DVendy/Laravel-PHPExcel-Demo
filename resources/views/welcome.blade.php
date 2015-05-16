<html>
<head>
	<title>Laravel</title>

	<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<style>
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			color: #B0BEC5;
			display: table;
			font-weight: 100;
		}

		.content {
			text-align: center;
			display: inline-block;
		}

		.sung{
			font-family: 'Lato';
		}

		.title {
			font-size: 96px;
			margin-bottom: 40px;
		}

		.quote {
			font-size: 24px;
		}
		.quote2 {

			font-weight: 700;
			font-size: 17px;
		}
		.main-left{
			position: fixed;
		}
	</style>
</head>
<body>
	<div class="container main-left">
		<div class="row">
			<div class="col-md-6">
				<div class="content">
					<div class="sung">
						<div class="title">Laravel 5</div>
						<div class="quote2">Excel demo by : Dvendy</div>
						<div class="quote">{{ Inspiring::quote() }}</div>
					</div>
					&nbsp;
					<form method="post" action="{{URL::to('upload')}}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label for="file">File: </label>
							<input name="file" id="file" type="file" class="file btn-success" accept=".xlsx; .xls"></input>
						</div>	
						<div class="form-group">
							<input type="submit" value="Upload" class="btn btn-primary"></input>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container main-right">
		<div class="row">
			<div class="col-md-6">
				
			</div>
			<div class="col-md-6" style="padding: 50px 10px">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Bounty</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pirates as $key)
						<tr>
							<td>{{ $key->id}}</td>
							<td>{{ $key->name }}</td>
							<td>{{ $key->bounty }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
