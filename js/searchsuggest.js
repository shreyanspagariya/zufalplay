var g_url="http://localhost:8080/zufalplay/";
// /var g_url="http://www.zufalplay.com/";

;(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 500; // 500 millisecond default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress paste',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too preemptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);

$('#querybox').donetyping(function()
{
  query = document.getElementById("querybox").value;

  if(query.length > 0)
  {
    $.ajax(
        {
          url: g_url + "searchsuggest.php",
          dataType: "json",
          type:"POST",
          async: false,

          data:
          {
            mode:'search',
            query:query,
          },

          success: function(json)
          {
            if(json.status==1)
            {
              $(".showsuggest").html(json.msg);
              $('#dropdownsearch').find('[data-toggle=dropdown]').dropdown('toggle');
              $("#querybox").focus();
            }
            else
            {
              //console.log('Hi');
            }
          },
          
          error : function()
          {
          //console.log("something went wrong");
          }
      });
    }
});

function suggest_search(query)
{
	if(query.length > 0)
	{
    $("#querybox").focus();
    //$(".showsuggest").html("<div class='dropdown' style='margin-top:32px;' id='dropdownsearch'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' style='display:none;'>Dropdown Example<span class='caret'></span></button><ul class='dropdown-menu'><li><center><img src=" + g_url + "images/loading.gif></center></li></ul></div>");
    $('#dropdownsearch').find('[data-toggle=dropdown]').dropdown('toggle');
	}
}