jQuery(document).idle({
  onIdle: function(){
    idle_user_logout_callback();
  },
  onHide: function(){
    idle_user_logout_callback();
  },
  idle: iul.idleTimeDuration
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