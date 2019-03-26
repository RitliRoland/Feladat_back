@extends('layouts.app')

@section('content')
		<script>
			function update(id){
				var first_name=document.getElementById(id+"_first_name").innerHTML;
				var last_name=document.getElementById(id+"_last_name").innerHTML;
				var companie=document.getElementById(id+"_companie").innerHTML;
				var email=document.getElementById(id+"_email").innerHTML;
				var phone=document.getElementById(id+"_phone").innerHTML;
				var str='<form action="update_employee" method="POST" id="update">'+
					'{{ csrf_field() }}'+
					'<input id="id" name="id" value="'+id+'" hidden>'+
					'First name:'+
					'<input id="first_name" name="first_name" value="'+first_name+'" type="text">'+
					'Last name:'+
					'<input id="last_name" name="last_name" value="'+last_name+'" type="text">'+
					'Companie:'+
					'<select id="companie" name="companie">'+
					'@foreach($Companies as $row)'+
						'<option value="{{ $row->id }}">{{ $row->Name }}</option>'+
					'@endforeach'+
					'</select>'+
					'Email:'+
					'<input id="email" value="'+email+'" name="email" type="text">'+
					'Phone:'+
					'<input id="phone" value="'+phone+'" name="phone" type="text">'+
					'</form>';
				Swal.fire({
					html: str,
					showCancelButton: false,
					width: 'auto',
					padding:'0px',
				}).then(function() {
					document.forms["update"].submit();
				});
			}
			
			$(document).ready( function () {
				$('#employees').DataTable();
			} );
		</script>
		
	
        <div class="flex-center position-ref full-height">
			@auth
			<form action="add_employee" method="POST">
			{{ csrf_field() }}
				<div style="position:absolute;top:68px;left:10px;">
					First name:
					<input id="first_name" name="first_name" type="text">
					Last name:
					<input id="last_name" name="last_name" type="text">
					Companie:
					<select id="companie" name="companie">
					@foreach($Companies as $row)
						<option value="{{ $row->id }}">{{ $row->Name }}</option>
					@endforeach
					</select>
					Email:
					<input id="email" name="email" type="text">
					Phone:
					<input id="phone" name="phone" type="text">
					<input type="submit" value="Create">
				</div>
			</form>
			@endauth
            <div style="margin-top:130px;" class="content">
				<table id="employees">
					<thead>
						<th>First_name</th>
						<th>Last_name</th>
						<th>Companie</th>
						<th>Email</th>
						<th>Phone</th>
						@auth
						<th>Delete</th>
						<th>Update</th>
						@endauth
					</thead>
					<tbody>
						@foreach($Employees as $row)
							<tr>
								<td id="{{ $row->id }}_first_name">{{ $row->First_name }}</td>
								<td id="{{ $row->id }}_last_name">{{ $row->Last_name }}</td>
								<td id="{{ $row->id }}_companie">{{ $row->Companie }}</td>
								<td id="{{ $row->id }}_email">{{ $row->Email }}</td>
								<td id="{{ $row->id }}_phone">{{ $row->Phone }}</td>
								@auth
								<td><a href="delete_employee?id={{ $row->id }}"><font color=red>Delete</font></a></td>
								<td><button onclick="update({{ $row->id }})">Update</button></td>
								@endauth
							</tr>
						@endforeach
					</tbody>
				</table>
            </div>
        </div>
@endsection