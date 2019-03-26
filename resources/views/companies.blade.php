@extends('layouts.app')

@section('content')
		<script>
			function update(id){
				var name=document.getElementById(id+"_name").innerHTML;
				var website=document.getElementById(id+"_website").innerHTML;
				var email=document.getElementById(id+"_email").innerHTML;
				var str='<form action="update_companie" method="POST" id="update" enctype="multipart/form-data">'+
						'{{ csrf_field() }}'+
						'<input id="id" name="id" value="'+id+'" hidden>'+
						'Logo:'+
						'<input type="file" id="logo" name="logo" accept="image/*" />'+
						'Name:'+
						'<input id="name" name="name" value="'+name+'" type="text">'+
						'Email:'+
						'<input id="email" name="email" value="'+email+'" type="text">'+
						'Website:'+
						'<input id="website" name="website" value="'+website+'" type="text">'+
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
				$('#companies').DataTable();
			} );
		</script>
		
        <div class="flex-center position-ref full-height">

			
			@auth
			<form action="add_companie" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
				<div style="position:absolute;top:68px;left:10px;">
					Logo:
					<input type="file" id="logo" name="logo" accept="image/*" />
					Name:
					<input id="name" name="name" type="text">
					Email:
					<input id="email" name="email" type="text">
					Website:
					<input id="website" name="website" type="text">
					<input type="submit" value="Create">
				</div>
			</form>
			@endauth

            <div style="margin-top:130px;" class="content">
				<table id="companies">
					<thead>
						<th>Logo</th>
						<th>Name</th>
						<th>Email</th>
						<th>Website</th>
						@auth
						<th>Delete</th>
						<th>Update</th>
						@endauth
					</thead>
					<tbody>
						@foreach($Companies as $row)
							<tr>
								<td><img style="width:100px;height:100px;"src="storage/{{ $row->Logo }}"></td>
								<td id="{{ $row->id }}_name">{{ $row->Name }}</td>
								<td id="{{ $row->id }}_email">{{ $row->Email }}</td>
								<td id="{{ $row->id }}_website">{{ $row->Website }}</td>
								@auth
								<td><a href="delete_companie?id={{ $row->id }}"><font color=red>Delete</font></a></td>
								<td><button onclick="update({{ $row->id }})">Update</button></td>
								@endauth
							</tr>
						@endforeach
					</tbody>
				</table>
            </div>
        </div>
@endsection
