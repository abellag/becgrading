@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
                                <div class=" panel-body">
				<div class="col-md-6">
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register/update') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="accesslevel" value="{{ $accesslevel }}">
                                                <input type="hidden" name="username" value="{{ $username }}">
                                                
                                                <div class="form-group">
							<label class="col-md-4 control-label">Grade Level</label>
							<div class="col-md-6">
                                                            <select name="gradeLevel" id="gradeLevel" onchange="getValue(this.value)" class='form-control'>
                                                                <option>Select Level</option>
                                                                @if(count($gradeLevel)>0)    
                                                                    @foreach($gradeLevel as $gradeLevels)
                                                                        <option value="{{$gradeLevels->level}}">{{$gradeLevels->level}}</option>
                                                                     @endforeach
                                                                @endif
                                                            </select>    
                                                        </div>
						</div>
                                                <div class="form-group">
							<label class="col-md-4 control-label">Assignment</label>
							<div class="col-md-6">
                                                            <select name="assignment" class='form-control'>
                                                                <option>Select Assignment</option>
                                                                <option value="Adviser">Adviser</option>
                                                                <option value="Not Adviser">Not Adviser</option>
                                                            </select>     
                                                        </div>
						</div>
                                                <div class="form-group">
							<label class="col-md-4 control-label">Section</label>
							<div class="col-md-6">
                                                            <select name="section" id="section"  class='form-control'>
                                                                <option>Select Section</option>
                                                            </select>     
                                                        </div>
						</div>
                                                <div class="form-group">
							<label class="col-md-4 control-label">Subject</label>
							<div class="col-md-6">
                                                            <table name="subject" class="control-label" id="subject" style="padding-right:10px"> 
                                                               <tr><td>Select</td><td>Subject</td></tr>
                                                           </table>
                                                        </div>
						</div>
                                                
                                                                    
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Add
								</button>
							</div>
						</div>
					</form>
				</div>
                                
                                <div class="col-md-6">
					@if(count($user)>0)    
                                            <option value="{{$user->username}}">{{$gradeLevels->level}}</option>
                                            <label class="control-label">Username: {{$user->username}}</label>
                                            <label class="control-label">Name: {{$user->fname}} {{$user->mname}} {{$user->lname}}</label>
                                            <label class="control-label">Access Level: {{$user->accesslevel}}</label>
                                        @endif
                                         @if(count($gradeDetails)>0)    
                                             <!--@foreach($gradeDetails as $gradeDetail)-->
                                                   <label class="control-label">Grade Level: {{$gradeDetail->level}}</label>
                                                    <label class="control-label">Assignment: {{$gradeDetail->adviser}}</label>
                                                    <label class="control-label">Section: {{$gradeDetail->section}}</label>
                                                    @if(count($subjectAssign)>0)
                                                        @foreach($subjectAssign as $subjectAssigns)
                                                            @foreach($subjectAssigns as $subjectAss)
                                                                @if($gradeDetail->section == $subjectAssigns->section)
                                                                <label class="control-label">Subject: {{$subjectAss->subject}}</label>
                                                                @else
                                                                <label class="control-label">Subject: None</label>
                                                                @endif
                                                            @endforeach 
                                                        @endforeach
                                                    @endif
                                             <!--@endforeach-->
                                         @endif
                                            
                                    
                                </div>
                                
			</div>
                     </div>
		</div>
	</div>
</div>

@stop
