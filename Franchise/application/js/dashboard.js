<script>
    $("#HeaderDashBoard").addClass("active");
    $(document).ready(function () {
        
         $('.dashboard').addClass('active');
        $('.dashboard_thumb').attr('src', "<?php echo base_url(); ?>assets/dash_board_on.png");


        $('#admin_control').click(function () {

            $('#call_admin').trigger("click");
        });

        $('#broker_control').click(function () {

            $('#broker_admin').trigger("click");
        });
        $('#Products').click(function () {

            $('#All_Products').trigger("click");
        });
        $('#AddOns').click(function () {

            $('#All_AddOns').trigger("click");
        });
        $('#Orders').click(function () {

            $('#All_Orders').trigger("click");
        });

    });

</script>

