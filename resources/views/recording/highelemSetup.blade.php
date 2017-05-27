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
    @if($statuses->quarter=='First Quarter')
         $('#radio1').prop('checked',true);
    @elseif($statuses->quarter=='Second Quarter')
        $('#radio2').prop('checked',true);
    @elseif($statuses->quarter=='Third Quarter')
        $('#radio3').prop('checked',true);
    @else
        $('#radio4').prop('checked',true);
    @endif
    @endforeach
            
});
</script>



<div class="col-lg-2">
    
</div>
<div class="col-lg-4"  id="grade" >
			<div class="panel panel-default">
                            @if($department == 'shs')
				<div class="panel-heading">Setup Quarterly Exam for Senior High School</div>
                            @elseif($department == 'jhs')
				<div class="panel-heading">Setup Quarterly Exam for Junior High School</div>
                            @elseif($department == 'psgs')
				<div class="panel-heading">Setup Quarterly Exam for Primary Education</div>
                            @endif   
                                <div class="panel-body">
				
					<form class="form-horizontal" role="form" method="POST" action="{{url('/setup/quarterly/')}}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="department" value="{{$department}}">
                                                    
                                                <label style="padding-left: 14%;" align="left" class="col-md-9">First Quarter Grade</label>
                                                  
                                                <div class="form-group">
                                                      <div align="left" class="col-md-3">
                                                            <input type="radio" id="radio1" name="quarter" value="First Quarter"> 
							</div>
						   </div> 
                                                
                                                <label style="padding-left: 14%;" align="left" class="col-md-9">Second Quarter Grade</label>
                                                
                                                <div class="form-group">
							<div align="left" class="col-md-3">
                                                            <input type="radio" id="radio2" name="quarter" value="Second Quarter">  
							</div>
						   </div> 
                                                
                                                <label style="padding-left: 14%;" align="left" class="col-md-9">Third Quarter Grade</label>
                                                
                                                <div class="form-group">
							<div align="left" class="col-md-3">
                                                            <input type="radio" id="radio3" name="quarter" value="Third Quarter">
							</div>
						   </div> 
                                                
                                                <label style="padding-left: 14%;" align="left" class="col-md-9">Fourth Quarter Grade</label>
                                                
                                                <div class="form-group">
							<div align="left" class="col-md-3">
                                                            <input type="radio" id="radio4" name="quarter" value="Fourth Quarter">
							</div>
						   </div> 
                                                
                                                <label class="col-md-4 control-label">Start Date</label>
                                                
                                                <div class="form-group">
							<div align="right"  class="col-md-6">
                                                            <div class='input-group date' id='datetimepicker6'>
                                                                 <input type='text' name="startDate" class="datepicker datepicker form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div></div>
						   </div> 
                                                <label class="col-md-4 control-label">End Date</label>
                                                <div class="form-group">
							<div align="right"  class="col-md-6">
                                                            <div class='input-group date' id='datetimepicker7'>
                                                                 <input type='text' name="endDate" class="datepicker datepicker form-control" />
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
                                                        $('#datetimepicker6').datetimepicker();
                                                        $('#datetimepicker7').datetimepicker({
                                                            useCurrent: false //Important! See issue #1075
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