
</section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="public/admin/assets/js/jquery.js"></script>
    <script src="public/admin/assets/js/jquery-1.8.3.min.js"></script>
    <script src="public/admin/assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="public/admin/assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="public/admin/assets/js/jquery.scrollTo.min.js"></script>
    <script src="public/admin/assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="public/admin/assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="public/admin/assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="public/admin/assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="public/admin/assets/js/sparkline-chart.js"></script>    
	<script src="public/admin/assets/js/zabuto_calendar.js"></script>
	
	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Sự kiện đặc biệt", badge: "00"},
                    {type: "block", label: "Sự kiện thường", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
  

  </body>
</html>