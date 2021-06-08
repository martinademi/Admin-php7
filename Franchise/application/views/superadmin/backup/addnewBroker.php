<style>
    .form-horizontal .form-group 
     {
        margin-left: 13px;
     }    
</style>




<script>
   $(document).ready(function() {

        
    });
    //submit form data from forth tab
    function submitform()
    {
        if(signatorytab('fourthlitab','tab4'))
        {
            $("#addentity").submit();
        }
    }
    
    //load mobile prefix as country code
    
    function fillcountrycode()
    {
        var country = $("#entitycountry").val();
        if(country!=="null")
        {
            var n = country.indexOf(",");
            $("#mobileprefix").val(country.substring((n+1),country.length));  
            $("#countrycode").val(country.substring((n+1),country.length));
        }
    }
    
    //validations for each previous tab before proceeding to the next tab
    function managebuttonstate()
    {
        $("#prevbutton").addClass("hidden");
    }
    
    function profiletab(litabtoremove,divtabtoremove)
    {
       var pstatus = true;
       if((isBlank($("#entityname").val()) || isBlank($("#entityregno").val())))
       {
           pstatus = false;           
       }
       
       if(validateEmail($("#entityemail").val())!==2)
       {
           pstatus = false;
       }
       
       if(pstatus === false)
       {
          setTimeout(function() 
          {            
              proceed(litabtoremove,divtabtoremove,'firstlitab','tab1');
          },300);
          
          alert("complete profile tab properly")
          $("#tab1icon").removeClass("fs-14 fa fa-check");
          return false;
       }
       $("#tab1icon").addClass("fs-14 fa fa-check");
       $("#prevbutton").removeClass("hidden");       
       $("#nextbutton").removeClass("hidden");       
       $("#finishbutton").addClass("hidden");       
       return true;
    }
    
    function addresstab(litabtoremove,divtabtoremove)
    {
       var astatus = true;
       //alert(profiletab());
       if(profiletab(litabtoremove,divtabtoremove))
       {            
            if($("#entitytown").val()==="null")
            {
                astatus=false;
            }

            if(isBlank($("#entitypobox").val()) || isBlank($("#entityzipcode").val()))
            {
                astatus=false;
            }

            if(astatus === false)
            {
               setTimeout(function() 
               {            
                   proceed(litabtoremove,divtabtoremove,'secondlitab','tab2');
                   
               },100);
               
               alert("complete address tab properly")
               $("#tab2icon").removeClass("fs-14 fa fa-check");
               return false;
            }
            $("#tab2icon").addClass("fs-14 fa fa-check");            
            $("#nextbutton").removeClass("hidden");       
            $("#finishbutton").addClass("hidden");       

            return astatus;
        }
    }
    
    function bonafidetab(litabtoremove,divtabtoremove)
    {
        var bstatus = true;
        if(addresstab(litabtoremove,divtabtoremove))
        {             
            if(isBlank($("#entitydocname").val()) || isBlank($("#entitydocfile").val()) || isBlank($("#entityexpirydate").val()))            
            {
                bstatus=false;
            }
                        
            if(bstatus === false)
            {
               setTimeout(function() 
               {            
                   proceed(litabtoremove,divtabtoremove,'thirdlitab','tab3');
                   
               },100);
               
               alert("complete bonafide tab properly");
               $("#tab3icon").removeClass("fs-14 fa fa-check");
               return false;
            }

            $("#tab3icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");       
            $("#finishbutton").removeClass("hidden");       

            return bstatus;
            
        }
    }
    
    function signatorytab(litabtoremove,divtabtoremove)
    {
        var bstatus = true;
        if(bonafidetab(litabtoremove,divtabtoremove))
        {             
            if(isBlank($("#entitypersonname").val()) || isBlank($("#entitysignatorymobileno").val()) || isBlank($("#entitysignatoryfile").val()) || $("#entitydegination").val()==="null")
            {
                bstatus=false;
            }
            
            if(validateEmail($("#entitysignatoryemail").val())!==2)
            {
                bstatus = false;
            }

            if(bstatus === false)
            {
               setTimeout(function() 
               {            
                   proceed(litabtoremove,divtabtoremove,'fourthlitab','tab4');
                   
               },100);
               
               alert("complete signatory tab properly");
               $("#tab4icon").removeClass("fs-14 fa fa-check");
               return false;
            }

            $("#tab4icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");       
            $("#finishbutton").removeClass("hidden");       

            return bstatus;            
        }
       
    }
   
    
    function proceed(litabtoremove,divtabtoremove,litabtoadd,divtabtoadd)
    {                                        
        $("#"+litabtoremove).removeClass("active");
        $("#"+divtabtoremove).removeClass("active");
        
        $("#"+litabtoadd).addClass("active");
        $("#"+divtabtoadd).addClass("active");        
    }
    
   /*-----managing direct click on tab is over -----*/
   
   //manage next next and finish button
   function movetonext()
   {
      var currenttabstatus = $("li.active").attr('id');
      if(currenttabstatus === "firstlitab")
      {
          profiletab('secondlitab','tab2');
          proceed('firstlitab','tab1','secondlitab','tab2');
      }
      else if(currenttabstatus === "secondlitab")
      {
          addresstab('thirdlitab','tab3');
          proceed('secondlitab','tab2','thirdlitab','tab3');
      }
      else if(currenttabstatus === "thirdlitab")
      {
          bonafidetab('fourthlitab','tab4');
          proceed('thirdlitab','tab3','fourthlitab','tab4');
          $("#finishbutton").removeClass("hidden");
          $("#nextbutton").addClass("hidden");
      }
   }
   
   function movetoprevious()
   {
      var currenttabstatus = $("li.active").attr('id');
      if(currenttabstatus === "secondlitab")
      {
          profiletab('secondlitab','tab2');
          proceed('secondlitab','tab2','firstlitab','tab1');
          $("#prevbutton").addClass("hidden");
      }
      else if(currenttabstatus === "thirdlitab")
      {
          addresstab('thirdlitab','tab3');
          proceed('thirdlitab','tab3','secondlitab','tab2');
      }
      else if(currenttabstatus === "fourthlitab")
      {
          bonafidetab('fourthlitab','tab4');
          proceed('fourthlitab','tab4','thirdlitab','tab3');          
          $("#nextbutton").removeClass("hidden");
          $("#finishbutton").addClass("hidden");
      }
   }
       
</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-left: 20px;">
                    <li>
                        <a href="<?php echo base_url()?>index.php/superadmin/loadDashbord">Dashboard</a>
                    </li>
                    
                    <li><a href="<?php echo base_url()?>index.php/superadmin/loadEntity/Broker">Broker</a>
                    </li>
                    
                    <li style="width: 100px"><a href="#" class="active">Add New</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">
              
                  <div id="rootwizard" class="m-t-50">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                <li class="active" id="firstlitab" onclick="managebuttonstate()">
                    <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Profile</span></a>
                </li>
                <li class="" id="secondlitab">
                    <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab','tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Address</span></a>
                </li>
                <li class="" id="thirdlitab">
                    <a data-toggle="tab" href="#tab3" onclick="addresstab('thirdlitab','tab3')"><i id="tab3icon" class=""></i> <span>Bonafide</span></a>
                </li>
                <li class="" id="fourthlitab">
                    <a data-toggle="tab" href="#tab4" onclick="bonafidetab('fourthlitab','tab4')"><i id="tab4icon" class=""></i> <span>signatory</span></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url()?>index.php/superadmin/AddNewEntity/Broker" method="post" enctype="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane padding-20 slide-left active" id="tab1">
                    <div class="row row-same-height">

                        
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityname" placeholder="Name" name="entityname"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityemail" placeholder="Email" name="entityemail"  aria-required="true">
                                </div>
                                <div class="col-sm-1">
                                <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-6">
                                    <input type="radio" value="active" checked="true" name="entitystatus" id="entitystatus">&nbsp;&nbsp;&nbsp;Active&nbsp;&nbsp;&nbsp;
                                    <input type="radio" value="deactive" name="entitystatus" id="entitystatus">&nbsp;&nbsp;&nbsp;Deactive&nbsp;&nbsp;&nbsp;
                                </div>
                                 <div class="col-sm-1">
                                <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Registration No</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entityregno" placeholder="Registration no" name="entityregno"  aria-required="true">
                                </div>
                                 <div class="col-sm-1">
                                <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            
                        

                    </div>
                </div>
                <div class="tab-pane slide-left padding-20" id="tab2">
                    <div class="row row-same-height">
                       
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="entityaddress" id="entityaddress" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Town</label>
                                <div class="col-sm-6">                             
                                    <input type="text" name="entitytown" id="entitytown" class="form-control">                                    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">State</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="entitystate" id="entitystate">                                                                                                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Country</label>
                                <div class="col-sm-6">
                                    <select class="form-control" style="height: 37px;" name="entitycountry" id="entitycountry" onchange="fillcountrycode()">
                                        <option value="null" selected="">select..</option>
                                        <option value="Afghanistan,93">Afghanistan,93</option>
                                        <option value="Albania,355">Albania,355</option>                                                                                
                                    </select>
                                </div>
                                
                                <div class="col-sm-1">
                                        <span style="color: red; font-size: 20px">*</span>
                                     
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">POBox</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="entitypobox" placeholder="Po-Box" name="entitypobox"  aria-required="true">
                                </div>
                                
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
               
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Zipcode</label>
                                <div class="col-sm-6">
                                    <input type="text" onkeypress="return OnlyInt(event,'ziperror')" class="form-control" id="entityzipcode" placeholder="Zipcode" name="entityzipcode"  aria-required="true">
                                    <span id="ziperror" style="color: red"></span>
                                </div>
                                
                                 <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                        
                    </div>
                </div>


                <div class="tab-pane slide-left padding-20" id="tab3">
                    <div class="row row-same-height">

                     
                         <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Document Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="entitydocname" id="entitydocname">                                    
                                </div>
                                
                                <div class="col-sm-1">
                                  <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                         
                           <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="entitydescription" id="entitydescription" rows="3"></textarea>
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Document file</label>
                                <div class="col-sm-6">                     
                                    <input type="file" class="form-control" style="height: 37px;" name="entitydocfile" id="entitydocfile">                                           
                                </div>
                                
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Issue date</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" style="height: 37px;" name="entityissuedate" id="entityissuedate">                                           
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Expiry date</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" style="height: 37px;" name="entityexpirydate" id="entityexpirydate">                                           
                                </div>
                                
                                <div class="col-sm-1">
                                 <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                           
                        

                    </div>
                </div>
                <div class="tab-pane slide-left padding-20" id="tab4">
                  
                       <div class="row row-same-height">

                    
                         <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Person Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="entitypersonname" id="entitypersonname">                                    
                                </div>
                                
                                 <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                         
                           <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="entitysignatorydescription" id="entitysignatorydescription"></textarea>
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Signatory Image file</label>
                                <div class="col-sm-6">                     
                                    <input type="file" class="form-control" style="height: 37px;" name="entitysignatoryfile" id="entitysinatoryfile">                                           
                                </div>
                                
                                 <div class="col-sm-1">
                                <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Mobile No</label>
                                 <div class="col-sm-1">
                                     <input type="text" class="form-control" style="height: 37px;" name="mobileprefix" id="mobileprefix" disabled>
                                     <input type="hidden" class="form-control" style="height: 37px;" name="countrycode" id="countrycode">
                                     
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" style="height: 37px;" name="entitysignatorymobileno" id="entitysignatorymobileno" onkeypress="return OnlyInt(event,'phoneerror')">                                           
                                    <span id="phoneerror" style="color: red"></span>
                                </div>
                                
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Designation</label>
                                <div class="col-sm-6">
                                    <select class="form-control" style="height: 37px;" name="entitydegination" id="entity">
                                           <option value="null" selected="">select..</option>
                                           <option value="clerk">clerk</option>
                                           <option value="CEO">CEO</option>                                           
                                           <option value="manager">Manager</option>                                           
                                    </select>
                                </div>
                                
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Person Email</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" style="height: 37px;" name="entitysignatoryemail" id="entitysignatoryemail">                                           
                                </div>
                                
                                <div class="col-sm-1">
                                    <span style="color: red; font-size: 20px">*</span>
                                </div>
                            </div>
                                                    
                        

                    </div>
                                        
                </div>
                <div class="padding-20 bg-white">
                    <ul class="pager wizard">
                        <li class="next" id="nextbutton">
                            <button class="btn btn-primary btn-cons btn-animated from-left  pull-right" type="button" onclick="movetonext()">
                                <span>Next</span>
                            </button>
                        </li>
                        <li class="hidden" id="finishbutton">
                            <button class="btn btn-primary btn-cons btn-animated from-left fa fa-cog pull-right" type="button" onclick="submitform()">
                                <span>Finish</span>
                            </button>
                        </li>
                        
                        <li class="previous hidden" id="prevbutton">
                            <button class="btn btn-default btn-cons pull-right" type="button" onclick="movetoprevious()">
                                <span>Previous</span>
                            </button>
                        </li>
                    </ul>
                </div>

            </div>               
          </form>
            
        </div>

           
            </div>
            <!-- END PANEL -->
        </div>
      
    </div>
    <!-- END JUMBOTRON -->

    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="hint-text">Copyright © 2014</span>
            <span class="font-montserrat">REVOX</span>.
            <span class="hint-text">All rights reserved.</span>
                <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                </span>
        </p>
        <p class="small no-margin pull-right sm-pull-reset">
            <a href="#">Hand-crafted</a>
            <span class="hint-text">&amp; Made with Love ®</span>
        </p>
        <div class="clearfix"></div>
    </div>
</div>
<!-- END FOOTER -->


