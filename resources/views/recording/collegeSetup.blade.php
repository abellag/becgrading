@extends('/recording/approver')

@section('content1')        

<script type="text/javascript" src="//code.jquery.com/jquery-1.7.1.js"></script>
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<script>
    
$(window).load(function(){
    
    @foreach($status as $statuses)
    @if($statuses->quarter=='Prelim')
         $('#radio1').prop('checked',true);
    @elseif($statuses->quarter=='Midterm')
        $('#radio2').prop('checked',true);
    @else
        $('#radio3').prop('checked',true);
    @endif
    @endforeach
            
});
</script>



<div class="col-lg-2">
    
</div>
<div class="col-lg-4"  id="grade" >
			<div class="panel panel-default">
                            @if($department == 'college')
				<div class="panel-heading">Setup Quarterly Exam for College</div>
                            @else
                                <div class="panel-heading">Setup Quarterly Exam for Diploma</div>
                            @endif
				<div class="panel-body">
				
					<form class="form-horizontal" role="form" method="POST" name="formSetup"  action="{{url('/setup/quarterly/')}}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="department" value="{{$department}}">

                                                <!--label style="padding-right: 9%;" class="col-md-5 control-label">Department</label>
							<div class="form-group col-md-6">
                                                            <select form="formSetup" id="department" name="department" class='form-control'>
                                                                <option>Select Department</option>
                                                                <option value="College">College</option>
                                                                <option value="Diploma">Diploma</option>
                                                                <!--option value="Senior High School">Senior High School</option>
                                                                <option value="Junior High School">Junior High School</option>
                                                                <option value="Primary Education">Primary Education</option>
                                                            </select>     
                                                        </div-->
                                                <label style="padding-left: 14%;" align="left" class="col-md-9">Preliminary Grade</label>
                                                
                                                <div class="form-group">
							<div align="left"  class="col-md-3">
                                                            <input type="radio" id="radio1" name="quarter" value="Prelim"> 
							</div>
						   </div> 
                                                <label style="padding-left: 14%;" align="left" class="col-md-9">Midterm Grade</label>
                                                
                                                 <div class="form-group">
							<div align="left"  class="col-md-3">
                                                            <input type="radio" id="radio2" name="quarter" value="Midterm"> &nbsp; &nbsp;&nbsp;     
							</div>
						   </div> 
                                                
                                                <label style="padding-left: 14%;" align="left" class="col-md-9">Final Grade</label>
                                                
                                                <div class="form-group">
							<div align="left"  class="col-md-3">
                                                            <input type="radio" id="radio3" name="quarter" value="Final"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
							</div>
						   </div> 
                                                
                                                <label class="col-md-4 control-label">Start Date</label>
                                                
                                                <div class="form-group">
							<div align="right"  class="col-md-6">
                                                            <div class='input-group date' id='datetimepicker6'>
                                                               <input type='text' name="startDate" value="<?php echo $statuses->startDate?>" class="datepicker datepicker form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div></div>
						   </div> 
                                                <label class="col-md-4 control-label">End Date</label>
                                                <div class="form-group">
							<div align="right"  class="col-md-6">
                                                            <div class='input-group date' id='datetimepicker7'>
                                                                 <input type='text' name="endDate" value="<?php echo $statuses->endDate?>" class="datepicker datepicker form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div></div>
						   </div> 
                                                
                                                   <!--div class='col-md-6'>
                                                        <div class="form-group">
                                                            <div class='input-group date' id='datetimepicker6'>
                                                                <input type='text' class="datepicker datepicker form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div><br/>
                                                    
                                                   End Date <div class='col-md-6'>
                                                        <div class="form-group">
                                                            <div class='input-group date' id='datetimepicker7'>
                                                                <input type='text' class="datepicker datepicker form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div-->
                                                <script type="text/javascript">
                                                    $(function () {
                                                        
                                                        $('#datetimepicker6').datetimepicker({
                                                            useCurrent: false,
                                                            format: 'YYYY-MM-DD'//Important! See issue #1075
                                                        });
                                                        $('#datetimepicker7').datetimepicker({
                                                            useCurrent: false,
                                                            format: 'YYYY-MM-DD'//Important! See issue #1075
                                                        });
                                                        $("#datetimepicker6").on("dp.change", function (e) {
                                                            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                                                        });
                                                        $("#datetimepicker7").on("dp.change", function (e) {
                                                            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                                                        });
                                                    });
                                                </script>
                                                <div class="form-group">
							<div align="right"  class="col-md-10">
								<input type="submit"  id="submit" class="btn btn-primary" name="submit" value="Set" /> 
							</div>
						   </div> 
                                                
					</form>
				</div>
			</div>
		</div>
	


@stop