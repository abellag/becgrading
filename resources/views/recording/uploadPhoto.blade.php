<br/>
<br/>
<br/>
<div class="col-lg-1">
    
</div>
<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">Upload Student Photo for TOR</div>
				<div class="panel-body">
				@if(count($message)>0)
                                <font color="Green"><b> {{$message}}</b></font>
                                
                                @endif
                                    <form  class="form-horizontal" id="uploadPhotoForm" method="POST" enctype="multipart/form-data">
					<label style="text-align: center;"class="col-md-3 control-label">Upload Photo</label>
							<div class="col-md-9" align="left">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="file" name="filePhoto" accept="image/*" class="btn btn-default"><br/><br/>
                                                            <a href="#" onclick="submitPhoto({{$studentid}},'{{$department}}')" >  <input class="btn btn-primary" type="button" value="Upload Photo" id="btnSubmit"/></a>
                                                
                                                        </div>
                                    </form>  
                                                
					
				</div>
			</div>
		</div>
	
