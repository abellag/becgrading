@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
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
                                                                <option value="10">College Teacher</option>
                                                                <option value="20">K - 12 Teacher</option>
                                                                <option value="30">Junior High Teacher</option>
                                                                <option value="40">Elementary Teacher</option>
                                                                <option value="50">Highest Approver</option>
                                                                <option value="2">Registrar</option>
                                                                
                                    
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
									Register
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
