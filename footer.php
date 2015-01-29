<style type="text/css">
#fo {
	color: #000;
}	

.ui-tooltip, .arrow:after {
    background: #36F;
    
  }
  .ui-tooltip {
    padding: 10px 10px;
    color: white;
    font: bold 14px "Helvetica Neue", Sans-Serif;
    box-shadow: 0 0 7px black;
	height:80px;
	
  }
  .arrow {
    width: 70px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    margin-left: -35px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 60%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
#jjs::selection {
    color: white;
    background: red;
}
#jjs a{text-decoration:none;}
</style>
 <script>
  $(function() {

    $( "#for" ).tooltip({
	 position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      },
		track: true,
      hide: {
        effect: "slideUp",
        delay: 400
      },
	    close: function(event, ui){
            ui.tooltip.hover(
                function () {
                    $(this).stop(true).fadeTo(400, 1); 
                },
                function () {
                    $(this).fadeOut("400", function(){
                        $(this).remove(); 
                    })
                }
            );
        },
		content: 'Mustafa Syed Arif<span id="jjs" style=" font-size:11px;"><br /><a href="http://qa.linkedin.com/pub/mustafa-syed-arif/88/376/4a4" target="_blank">Linkedin </a>	<br /><a href="http://www.facebook.com/mengineer" target="_blank">Facebook</a><br /><span style="COLOR:BLACK">Contact# +97466522611<br />mustafa_sarif@hotmail.com<br /></span>',
    items:'*' 
		
    });
  
  });


  </script>
<div >

<div id="footer" align="right"  >

<strong id="for"  style="cursor:pointer;"> About Developer</strong>&nbsp;</div></div>