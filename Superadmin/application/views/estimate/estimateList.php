<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
$active="active";


?>
<style>
    .badge {
    font-size: 9px;
    margin-left: 2px;
}
.nav-md .container.body .right_col {
    padding: 2% 2% 0 3% !important;
    margin-left: 230px !important;
}


</style>

<script>
    $(document).ready(function () {

      var table = $('#campaigns-datatable');
                 var settings = {
                                        "autoWidth": false,
                                        "sDom": "<'table-responsive't><'row'<p i>>",
                                        "destroy": true,
                                        "scrollCollapse": true,
                                        "iDisplayLength": 20,
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url('index.php?/EstimateController/get_estimateList');?>',
                                        "bJQueryUI": true,
                                        "sPaginationType": "full_numbers",
                                        "iDisplayStart ": 20,
                                        "oLanguage": {

                                        },
                                        
                                        'fnServerData': function (sSource, aoData, fnCallback)
                                        {
                                            $.ajax
                                                    ({
                                                        'dataType': 'json',
                                                        'type': 'POST',
                                                        'url': sSource,
                                                        'data': aoData,
                                                        'success': fnCallback
                                                    });
                                        }
                        };

        table.dataTable(settings);
         $('#search-tables').keyup(function () {
                table.fnFilter($(this).val());
        });

     });


     
    
</script>

<script>




 $(document).on('click','.getCustInfo',function(){
           
   //$('#customerModal').modal('show');

   var cusId=$(this).attr('id');

  $.ajax({
        url:'<?php echo base_url()?>/EstimateController/getCustomerinfo/' + cusId,
        type:'GET',
        dataType: 'json',



    }).done(function(json){

        console.log(json);
         $('#customerModal').modal('show');

                        $('.dprofilePic').attr('src', '');
                         $('.dprofilePic').hide();


                        $('.dname').text(json.name);
                        $('.demail').text(json.email);
                        $('.dphone').text(json.countryCode + json.phone);

                        
                         
                        if (json.profilePic != '')
                        {
                            $('.dprofilePic').attr('src', json.profilePic);
                            $('.dprofilePic').show();
                        }
                        
    });

        });
</script>


<!----------------------------------------view page start-------------------------------------------------------->
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
         <input type="hidden" id="businessId" value="<?php echo $this->session->userdata('userId');?>" >
        <div class="content">
        <div class="brand inline" style="  width: auto;color: gray;margin-left: 30px;padding-top: 20px;">
                <strong style="color:#0090d9;"><?php echo $this->lang->line('student');?></strong>
        </div>
        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             margin-left: 7px;padding-top: 20px;padding-bottom:10px;">

            <strong style="color:#0090d9;">ESTIMATE LIST</strong><!-- id="define_page"-->
        </div>
           
            <!-- Tab panes -->
            <!-- START JUMBOTRON -->
            <div class="">
                <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                    <div class="panel panel-transparent ">
                        <div class="tab-content">
                            <div class="container-fluid container-fixed-lg bg-white">
                                <!-- START PANEL -->
                                <div class="panel panel-transparent">
                               
                                <div class="pull-right" style="margin-bottom:15px;    margin-right: 16px"><input type="text" id="search-tables" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
                                           
                                <div class="panel-body">
										<?php
										echo $this->table->generate();
										?>
									</div>
                                </div>
                                <!-- END PANEL -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>


<!-- customer model -->
				  <!-- Modal -->
                  <div class="modal fade" id="customerModal" role="dialog">
						<div class="modal-dialog">
						
						
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Customer Information</h4>
							</div>
							<div class="modal-body">
							  
                            


                            <!-- customer info -->

                     <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2"><br>
                       <img src="" class="img-circle dprofilePic style_prevu_kit" onerror="this.src = '<?php echo base_url('/../../pics/user.jpg ') ?>'" alt="pic" style="width:80px;height:80px;display: none;">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dname"></span>
                            </div>

                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="demail"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Phone</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dphone"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        
                    </div>
                </div>


                            <!-- custo info -->



							</div>
							<div class="modal-footer">
							
							<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
							</div>
						</div>
						
						</div>
					</div>
		<!-- end cuxtomer pop up -->


