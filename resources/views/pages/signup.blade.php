@extends('layouts.app')

@section('title') Signup @endsection

@section('content')
@include('includes.navout')
<div class="container">
	<h2 class="text-center">Room and Appartment Rentals</h2>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">

			@include('includes.showerrors')
			@include('includes.showsuccess')


			<div class="panel panel-primary">
				<div class="panel-heading">
					<b>Signup</b>
				</div>
				<div class="panel-body">
					<form action="user_signup" method="POST" role="form" autocomplete="off">
						<div class="form-group">
							<input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" required="required" class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" placeholder="First Name" required="required" class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" placeholder="Last Name" required="required" class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="bday" id="bday" value="{{ old('bday') }}" placeholder="Birth Day" required="required" class="form-control" />
						</div>
						<div class="form-group">
							<label for="gender-male">Male</label>
							<input type="radio" name="gender" id="gender-male" value="Male" required="required" />
							<label for="gender-female">Female</label>
							<input type="radio" name="gender" id="gender-female" value="Female" />
						</div>
						<div class="form-group">
							<input type="number" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="Mobile Number Ex: 09123456789" required="required" class="form-control" />
						</div>
						<div class="form-group">
							<input type="password" name="password" id="password" placeholder="Password" required="required" class="form-control" />
						</div>
						<div class="form-group">
							<input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-enter Password" required="required" class="form-control" />
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button type="submit" class="btn btn-primary">Singup</button>
							<button type="reset" class="btn btn-danger">Clear Fields</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection