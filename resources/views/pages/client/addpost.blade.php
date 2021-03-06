@extends('layouts.app')

@section('title') Add Post @endsection

@section('content')
@include('includes.navin')
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			@include('includes.showerrors')
			@include('includes.showsuccess')
			<div class="panel panel-primary">
				<div class="panel-heading">
					<b>Add Room/Appartment Form</b>
				</div>
				<div class="panel-body">
					<form action="{{ route('postaddpost') }}" method="POST" role="form" enctype="multipart/form-data" autocomplete="off">
						<div class="form-group">
							<label for="room">Room</label>
							<input type="radio" name="type" value="Room" id="room" />
							<label for="appartment">Appartment</label>
							<input type="radio" name="type" value="Appartment" id="appartment" />
						</div>
						<div class="form-group">
							<input type="text" name="title" id="title" placeholder="Title" value="{{ old('title') }}" class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="price" id="price" placeholder="Price Rate" value="{{ old('price') }}" class="form-control" />
						</div>
						<div class="form-group">
							<textarea name="description" id="description" class="form-control" value="{{ old('description') }}" placeholder="Enter Description" rows="8"></textarea>
						</div>
						<div class="form-group">
							<input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="City Location Ex: Manila" class="form-control" />
						</div>
						<div class="form-group">
							<input type="file" name="images" id="images" accept=".jpg, .jpeg" />
						</div>
						<div class="form-group">
							<input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary" type="submit">Save Post</button>
							<button class="btn btn-danger" type="reset">Clear Fields</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection