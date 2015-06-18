jQuery(window).on('load',function(){
  jQuery(document).idleTimer( {
        timeout:iul.idleTimeDuration, 
        idle:true
  });
  
  jQuery(document).bind("idle.idleTimer", function(){
      idle_user_logout_callback();
      console.log('User is Idle');
  });

});

function idle_user_logout_callback(){
  if(iul.is_admin){
    console.log("Hello Admin, You have been Idle for a while. Are you there? ");
  }
  else{
    jQuery.ajax({  
      type: 'POST',
      url: iul.ajaxurl,
      data: {action: 'logout_idle_user'},    
      success: function(response){ 
        if( response ==  "true" )
          location.reload();
      },  
      error: function(MLHttpRequest, textStatus, errorThrown){ console.log(errorThrown); }  
    });
  }
}