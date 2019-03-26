@extends('layouts.app')

@section('content')
		<script>
			$(document).ready( function () {
				$('#employees').DataTable();
			} );
		 </script>
		 <br><br><br><br><br><br><br>
            <div style="width:50%;margin:0 auto 0 auto;" class="content">
				<table id="employees">
					<thead>
						<th>First_name</th>
						<th>Last_name</th>
						<th>Companie</th>
						<th>Email</th>
						<th>Phone</th>
					</thead>
					<tbody>
						@foreach($Employees as $row)
							<tr>
								<td>{{ $row->First_name }}</td>
								<td>{{ $row->Last_name }}</td>
								<td>{{ $row->Companie }}</td>
								<td>{{ $row->Email }}</td>
								<td>{{ $row->Phone }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
            </div>
        </div>
@endsection