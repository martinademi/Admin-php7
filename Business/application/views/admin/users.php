<?php
//$this->load->database();
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
?>

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .span6{
        display:none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script>
$(document).ready(function()
{
  $('#tableWithSearch').DataTable();
	$('#search-table').keyup(function()
	{
		searchTable($(this).val());
	});
});

function searchTable(inputVal)
{
	var table = $('#tableWithSearch');
	table.find('tr').each(function(index, row)
	{
		var allCells = $(row).find('td');
		if(allCells.length > 0)
		{
			var found = false;
			allCells.each(function(index, td)
			{
				var regExp = new RegExp(inputVal, 'i');
				if(regExp.test($(td).text()))
				{
					found = true;
					return false;
				}
			});
			if(found == true)$(row).show();else $(row).hide();
		}
	});
}
    
</script>

<script>
    $(document).ready(function () {
         $("#display-data").text("");
        $(".name").on("input", function () {
            var regexp = /[^a-zA-Z0-9/ ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });
       
        $(".phone").on("input", function () {
            var regexp = /[^0-9 / ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });

    });
     
     function ValidateFromDb() {

        $.ajax({
            url: "<?php echo base_url('index.php/Business') ?>/validateEmail_user",
            type: "POST",
            data: {email: $('#email').val()},
            dataType: "JSON",
            success: function (result) {
//                alert(result.msg);
                $('#email').attr('data', result.msg);

                if (result.msg == 1) {

                    $("#editerrorbox").html("Email is already allocated !");
                    $('#email').focus();
                    return false;
                } else if (result.msg == 0) {
                    $("#editerrorbox").html("");

                }
            }
        });
      }
      
     function ValidateUsername() {

        $.ajax({
            url: "<?php echo base_url('index.php/Business') ?>/validate_username",
            type: "POST",
            data: {username: $('#username').val()},
            dataType: "JSON",
            success: function (result) {
//                alert(result.msg);
                $('#username').attr('data', result.msg);

                if (result.msg == 1) {

                    $("#errorbox").html("Username is already exist !");
                    $('#username').focus();
                    return false;
                } else if (result.msg == 0) {
                    $("#errorbox").html("");

                }
            }
        });

    }
    
   
</script>

<script>
    
    $(document).ready(function () {

        $('#insert').click(function () {
            $('.clearerror').text("");
          
            var username = $("#username").val();
            var phone = $("#phone").val();
            var Email = $("#email").val();
            var Password = $("#password").val();
            var select = $('.accepts:checked').val();
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            
           if (username == "" || username == null)
            {
                $("#clearerror").text("Please enter the username");
            } 
           else if (phone == "" || phone == null)
            {
                $("#clearerror").text("Please enter the phone number");
            } 
            else if (Email == "" || Email == null)
            {
                $("#clearerror").text("Please enter your email");
            }
           else if ((!emails.test(Email)))
            {
                $("#clearerror").text("Please enter valid email");
            }
            else if ($("#email").attr('data') == 1)
            {
                $("#clearerror").text("Email id is already exist !");
            }
            else if (Password == "" || Password == null)
            {
                $("#clearerror").text("Please enter the password ");
            }
             
            else {
                
                    $('#addentity').submit();
                 }
        });
        
        $('#useredit').click(function () {
            $('.clearerror').text("");
//            var providername = $("#businessname").val();
             var Username = $("#Username").val();
            var phone = $("#Phone").val();
            var Email = $("#Email").val();
//            var Password = $("#Password").val();
           
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            
           if (Username == "" || Username == null)
            {
                $("#clearerror").text("Please enter the username");
            } 
          else if (phone == "" || phone == null)
            {
                $("#clearerror").text("Please enter the name");
            } 
           else if (Email == "" || Email == null)
           {
                $("#clearerror").text("Please enter your email");
           }
          else if (!emails.test(Email))
            {
                $("#clearerror").text("Please enter the valid email");
            }
           else
           {
                    $('#editentity').submit();
            }
        });
        
        
        $('#changepass').click(function () {
            $('.clearerror2').text("");
//            var providername = $("#businessname").val();
             var NewPwd = $("#newPwd").val();
            var ReNewPwd = $("#reNewPwd").val();
            
           if (NewPwd == "" || NewPwd == null)
            {
                $("#clearerror2").text("Please enter the Password");
            } 
          else if (ReNewPwd == "" || ReNewPwd == null)
            {
                $("#clearerror2").text("Please re-enter the Password");
            }
          else if(ReNewPwd != "" && NewPwd.localeCompare(ReNewPwd) ){
       
               $("#clearerror2").text("Please re-enter the same Password");
            }
         else
           {
                    $('#changepassword').submit();
            }
        });


        $('#changepwd').click(function () {
          
//                alert();
//                 $('#modalHeading').html("Edit User");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
//            alert(val);
           $('#user_id1').val(val);

            if (val.length < 1) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select any one user");
            } 
            else if (val.length == 1)
            {
//                 alert(val);
                $('#modalHeading').html(<?php echo json_encode(SELECT_COUNTRY_ANDBUSINESS_COMMISSION); ?>);
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#ChangeModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#ChangeModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
            }
             else if (val.length > 1)
                {
                //      alert("select atleast one passenger");
                $('#displayData').modal('show');
                    $("#display-data").text("Please select only one user" );
                } 
//           
        });

        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");

            $('#modalHeading').html(<?php echo json_encode(SELECT_COUNTRY_ANDBUSINESS_COMMISSION); ?>);
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModal');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModal').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });
        
        $('#edit').click(function () {
           
            $('#modalHeading').html("Edit User");
           
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
//            alert(val);
            
           $('#user_id').val(val);

            if (val.length < 1) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select any one user to edit");
            } 
            else if (val.length == 1)
            {
//                 alert(val);
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#editModal');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else {
                    
                      $.ajax({
                               url: "<?php echo base_url('index.php/Business') ?>/get_managerdata",
                               type: "POST",
                                data: {val: val},
                                dataType: 'json',
                               success: function (response)
                               {
                                 console.log(response);
////                                alert(response.length);
                                  $.each(response, function(index, row){
//                                      alert(row.Email);
                                                
                                                $('#Username').val(response.ManagerName);
                                                $('#Phone').val(response.Phone);
                                                $('#Email').val(response.Email);
//                                                $('.edit_accepts').val(row.Accepts);
                                        
                                  });
                               }
                           });
                    
                            $('#editModal').modal('show')
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            } else if (size == "full") {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                     }
             
             } 
             else if (val.length > 1)
                {
                //      alert("select atleast one passenger");
                $('#displayData').modal('show');
                    $("#display-data").text("Please select only one user to edit" );
                }   
        });

        $('#fdelete').click(function (e) {
//            $("#display-data").text("");
               var val = $('.checkbox:checked').map(function () {
                           return this.value;
                        }).get();

                   if (val.length < 0||val.length == 0) {
                       $('#displayData').modal('show');
                            $("#display-data").text("Please select any one  to delete");
                        }
                   else if (val.length == 1)
                        {
                          $("#display-data").text("");
                          var id =  val; 
            //                       alert(id);
            //                    alert(BusinessId);
                          var size = $('input[name=stickup_toggler]:checked').val()
                          var modalElem = $('#confirmmodel');
                          if (size == "mini") {
                             $('#modalStickUpSmall').modal('show')
                          } 
                          else 
                          {
                            $('#confirmmodel').modal('show')
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            }
                            else if (size == "full") 
                            {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                          }

                            $("#confirmed").click(function(){
            //                        else if (confirm("Are you sure to Delete this company")) {

                                      $.ajax({
                                           url: "<?php echo base_url('index.php/Business') ?>/delete_User",

                                         type: "POST",
                                                data: {
                                                id: id,
                                                },

                                            dataType: 'json',
                                           success: function (response)
                                           {
            //                                   alert(id);
                                            $(".close").trigger("click");
                                            location.reload();
                                           }
                                       });

                                   });             
                         }

                        else if (val.length > 1)
                        {
                            $('#displayData').modal('show');
                            $("#display-data").text("Please select only one  to delete");
                        }

               });

    });
    
     function makeid()
                {
                    var text = "";
                    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                    for( var i=0; i < 5; i++ )
                        text += possible.charAt(Math.floor(Math.random() * possible.length));
//                    alert(text);
                $('#password').val(text);
                    return text;
                    
                }
   

</script>

<style>
    #active{
        display:none;
    }
    .exportOptions{
        display: none;
    }
</style>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content" style="  padding-top: 30px;">

        <div class="brand inline breadcrumb" style="">
            <strong>STORE MANAGERS</strong><!-- id="define_page"-->
        </div>
        <div class="add_new">
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="changepwd" style="margin-bottom:0px;">Change Password</button></a></div>
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="fdelete" style="margin-bottom:0px;background: #d9534f !important;border-color: #d9534f !important;">Delete</button></a></div>
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="edit" style="margin-bottom:0px;background: #5bc0de !important;border-color: #5bc0de !important;">Edit</button></div>
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" style="margin-bottom:0px;background: #337ab7 !important;border-color: #337ab7 !important;"><span>Add</button></a></div>
        </div>
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax" style="padding:0px;">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="padding:0px;">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs 
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <li id= "1" class="tabs_active active">
                            <a  class="changeMode" ><span><?php echo LIST_USERS; ?></span></a>
                        </li>
                      
                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="changepwd">Change Password</button></a></div>
                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="fdelete">Delete</button></a></div>
                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="edit">Edit</button></div>
                        <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler"><span>Add</button></a></div>

                    </ul> -->
                    <!-- Tab panes -->
                    <div class="tab-content">
                        
<!--                        <div class="container-fluid container-fixed-lg bg-white">
                             START PANEL 
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center"></div>
                                    <div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div>
                                    <div class="searchbtn row clearfix pull-right" >
                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                    <div class="dltbtn">
                                    </div>
                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    
                                   <?php // echo $this->table->generate(); ?>


                                </div>
                            </div>
                             END PANEL 
                        </div>-->


                        <div class="container-fluid container-fixed-lg bg-white">
                             <!--START PANEL--> 
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <!--<div class="error-box" id="display-data" style="text-align:center"></div>-->
                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog modal-sm">                                        
                                        <!-- Modal content-->
                                            <div class="modal-content">                                            
                                                <div class="modal-body">
                                                <h5 class="error-box" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>     
                                    <!--<div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div>-->
                                    <div class="searchbtn row clearfix pull-right" >
                                    <div class="pull-right">
                                        <div class="col-xs-12" style="margin: 10px 0px;">
                                            <input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>">
                                        </div>
                                    </div>                                        
                                    </div>
                                </div>
                                <br>
                                <div class="panel-body">
                                 
                                    
                                    
                <div class="dataTables_wrapper form-inline no-footer" id="tableWithDynamicRows_wrapper">
                    <div class="table-responsive" style="overflow-x: hidden">
                        
                        <table aria-describedby="tableWithSearch_info" role="grid" class="table table-striped table-bordered table-hover demo-table-dynamic dataTable no-footer" id="tableWithSearch">
                                <thead>

                                    <tr>                                   
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Slno</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            User Id</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            User Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 0px;">
                                            Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                            Phone</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 00px;">
                                            Current Status</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                            Device Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                            Select</th>

                                    </tr>

                                </thead>

                                <tbody>

                          <?php
                          $start = 1;
                         $dev = [];
                         $arr = [];
                                
                           foreach ($table as $result)
                           {
                               if($result['currentStatus']==1){
                                   $status = 'online';
                               }
                               else if($result['currentStatus']==0){
                                    $status = 'offline';
                                }
                                
                                
                              ?>
                                    <tr>
                                        <td><?php echo $start++;?></td>
                                        <td><?php echo (string)$result['seqID'];?></td>
                                        <td><?php echo $result['managerName'];?></td>
                                        <td><?php echo $result['email'];?></td>
                                      
                                        <td><?php echo $result['phone'];?></td>
                                        <td><?php echo $status;?></td>
                                        
                                        <?php 
                                      
                                        foreach($result['devices'] as $res){
//                                           array_push($arr, $res['LastOnline']);
                                                 
                                            if($res['active']=="1")
                                            {
                                               array_push($arr, $res['lastOnline']);
//                                                print_r($arr);
                                                if($res['lastOnline'] == max($arr))
                                                    if($res['deviceType']=="1"){
                                                         $device = 'IOS';
                                                    }
                                                    else if($res['deviceType']=="2"){
                                                        $device = 'Android';
                                                    } 
                                                    else if($res['deviceType']=="3"){
                                                        $device = 'Website';
                                                    } 
                                                    else if($res['deviceType']=="4"){
                                                         $device = 'other';
                                                    }
                                            }
                                            else {
                                                $device = "Web";
                                            }
                                            
                                           
//                                          array_push($dev, $device);  
                                         }  ?>
                                        <td>
                                            <?php
//                                            foreach($dev as $r) {
//                                               echo  $r.' ';  
                                               echo  $device;  
//                                             } ?>
                                        </td>
                                        <td><input type="checkbox" class="checkbox" value="<?php echo (string)$result['_id']['$oid'];?>"></td>
                                                                           
                                    </tr>
                                    
                               <?php
                            
                           }
                          ?>
                            </tbody>
                          </table>

                        </div>
                     </div>
                      <!--END PANEL--> 
                   </div>
                 </div>
              </div>

             </div>

        </div>
        <!-- END JUMBOTRON -->
    </div>
    <!-- END PAGE CONTENT -->

</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center">Are you sure to delete</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">                        
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3> Add User</h3>
                </div>

                <div class="modal-body">                  
                    
                    <form id="addentity" method="post" class="" role="form" action="<?php echo base_url('index.php/Business') ?>/insertmanager"  method="post" enctype="multipart/form-data">
                    
                     
                     <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">USER NAME<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="username" name="username" onblur="ValidateUsername()" style="" class="username form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                   <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                        </div>
                    </div>
                        <br>
                        <br>
                     <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">PHONE<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="phone" name="phone" style="" class="phone form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                        
                        <br>
                        <br>
                  
                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">EMAIL<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="email" id="email" name="email"  style="" class="form-control error-box-class" onblur="makeid(),ValidateFromDb()" />

                                <div id="suggesstion-box"></div>
                            </div>
                        
                   <span id="editerrorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                       </div>
                    </div>
                        
                          <br>
                        <br>
                   
                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">PASSWORD<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" id="password" name="password" style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                      <br>
                        <br>
                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                             <label for="fname" class="col-sm-4 control-label">ACCEPTS<span style="color:red;font-size: 18px">*</span></label>
                             <div class="col-sm-8" id="accepts" >
                                 <input type="radio" name="Accepts" class="accepts radio-inline" id="accepts_1" style="margin-top: 0;" value="1"> Pickup
                                    <input type="radio" name="Accepts" class="accepts radio-inline" id="accepts_2" value="2"> Delivery
                                    <input type="radio" name="Accepts" class="accepts radio-inline" id="accepts_3" value="3"> Both<br>
                               </div>
                        </div>
                    </div>                        
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-6 error-box" style="color:red;" id="clearerror"></div>
                        <div class="col-sm-4" ></div>                        
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                        </div>
                    </div>
                   
                </form>
                </div>            
    </div>

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
    </button>
        </div>
    </div>

<div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Edit User</h3>
                </div>

            <div class="modal-body">

            <form id="editentity" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/editmanager"  method="post" enctype="multipart/form-data">
                <input type="hidden" id="user_id" name="user_id">
                 
                <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">USER NAME<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="Username" name="username" style="" class="username form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                           <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>

                        </div>
                    </div>
                        <br>
                        <br>
                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">PHONE<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" id="Phone" name="phone" style="" class="phone form-control error-box-class"/>

                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">EMAIL<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="email" id="Email"  name="email" style="" class="form-control error-box-class" onblur="makeid(),ValidateFromDb()"/>

                                <div id="suggesstion-box"></div>
                            </div>
                       <span id="editerrorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                        </div>
                    </div>                    
<!--                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">PASSWORD<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" id="Password" name="password"  style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>-->
                    
<!--                    <div class="form-group" class="formex">

                        <div class="frmSearch">
                             <label for="fname" class="col-sm-4 control-label">ACCEPTS<span style="color:red;font-size: 18px">*</span></label>
                             <div class="col-sm-8" id="accepts" >
                                 <input type="radio" name="Accepts" class="edit_accepts" id="accepts_1" value="1"> Pickup
                                    <input type="radio" name="Accepts" class="edit_accepts" id="accepts_2" value="2"> Delivery
                                    <input type="radio" name="Accepts" class="edit_accepts" id="accepts_3" value="3"> Both<br>
                               </div>
                        </div>
                    </div>-->
                     
<!--                    <br>
                    <br>-->
                    </div>
                    <div class="modal-footer">
                         <div class="col-sm-6 error-box" style="color:red;" id="clearerror1"></div>
                        <div class="col-sm-4" ></div>                       
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="useredit" >Save</button>
                        </div>
                    </div>
            </form>
                </div>
            
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
        
        
<div class="modal fade stick-up" id="ChangeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>Change Password</h3>
                </div>
                <div class="modal-body">
            <form id="changepassword" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/change_password"  method="post" enctype="multipart/form-data">
                <input type="hidden" id="user_id1" name="user_id1">
                 <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">New Password<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" id="newPwd" name="newpassword" placeholder="New Password" style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                <br>
                <br>
                 <div class="form-group" class="formex">

                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">Re-Type New Password<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" id="reNewPwd" placeholder="Re-Type New Password" name="renewpassword"  style="" class="form-control error-box-class"/>
                                    
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
              </div>
                    <div class="modal-footer">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-6 error-box" style="color:red;" id="clearerror2"></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="changepass" >Save</button>
                        </div>
                    </div>
            </form>
                </div>
          
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
    </button>
</div>
        
</div>
