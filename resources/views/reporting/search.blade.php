<br/>
<br/>
<br/>
<div class="col-lg-1">
    
</div>
<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">Search TOR</div>
				<div class="panel-body">
				
                                    <form class="form-horizontal" name="formTOR" role="formTOR" id="formTOR" method="GET" action="{{url('/view/tor')}}">
				            <div class="form-group">
							<label class="col-md-4 control-label">Department</label>
							<div class="col-md-6">
                                                            <select form="formTOR" id="department" name="department" class='form-control'>
                                                                <option>Select Department</option>
                                                                <option value="College">College</option>
                                                                <option value="Diploma">Diploma</option>
                                                                <option value="Senior High School">Senior High School</option>
                                                                <option value="Junior High School">Junior High School</option>
                                                                <option value="Primary Education">Primary Education</option>
                                                            </select>     
                                                        </div>
				            </div>
                                            <label style="text-align: center;"class="col-md-3 control-label">Student Name</label>
							<div class="col-md-9" align="left">
                                                            
                                                            <input class='form-control' form="formTOR" text="text" name="studentName" onkeypress="getTOR(event)"  id="studentName"/>
                                                            
                                                
                                                        </div>
                                    </form>  
                                    
                                    <div class="form-group">
							<div class="col-md-12">
                                                            <table class="table table-striped" style="padding-right:10px"> 
                                                                <caption>Select Student</caption>
                                                                <tr><th width="30%">Student ID</th><th width="30%">Name</th><th width="40%">Department</th>
                                                                    <th>Image</th>
                                                                    <th colspan="2" width="5%">Action</th>
                                                                </tr>
                                                                
                                                           </table>
                                                        </div>
                                                </div>
                                    
                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <table name="student" class="table table-striped" id="student" style="padding-right:10px"> 
                                                                        </table>
                                                                    </div>
                                                </div>
                                    
                                                
					
				</div>
			</div>
		</div>
	
