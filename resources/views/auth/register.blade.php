@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Add Instructor</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                  <div class="form-group">
							<label class="col-md-4 control-label">User Name </label>
                                             
							<div class="col-md-6">
								<input type="text" class="form-control" name="username" value="{{ old('username') }}">
							</div>
						</div>      
                                                
						<div class="form-group">
							<label class="col-md-4 control-label">First Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="fname" value="{{ old('fname') }}">
							</div>
						</div>
                                                
                                                <div class="form-group">
							<label class="col-md-4 control-label">Middle Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mname" value="{{ old('mname') }}">
							</div>
						</div>
						
                                                <div class="form-group">
							<label class="col-md-4 control-label">Last Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="lname" value="{{ old('lname') }}">
							</div>
						</div>
                                                
                                                
                                                
                                                
                                                
                                                <div class="form-group">
							<label class="col-md-4 control-label">Access Level</label>
							<div class="col-md-6">
                                                            <select name="accesslevel" class='form-control'>
                                                                <option>Select Access...</option>
                                                                <option value="{{ env('COLLEGE_TEACHER')}}">College Teacher</option>
                                                                <option value="{{env('DIPLOMA_TEACHER')}}">Diploma Teacher</option>
                                                                
                                                                <!--option value="{{env('SENIOR_HIGH_SCHOOL')}}">Senior High School Teacher</option>
                                                                <option value="{{env('JUNIOR_HIGH_TEACHER')}}">Junior High Teacher</option>
                                                                <option value="{{env('PRIMARY_TEACHER')}}">Primary Education Teacher</option>
                                                                <option value="{{env('PRE_SCHOOL_TEACHER')}}">Pre-School Teacher</option>
                                                                <option value="{{env('HIGHEST_APPROVER')}}">Highest Approver</option>
                                                                <option value="{{env('REGISTRAR')}}">Registrar</option>
                                                                <option value="{{env('OTHERS')}}">Others</option-->
                                                                
                                                                
                                                                
                                    
                                                           </select>     
                                                            
                                                          
							</div>
						</div>
                                                
                                                                    
						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Submit
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
