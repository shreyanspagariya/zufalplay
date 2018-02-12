function f(i,j)
{
	document.getElementById('hi').src="images/l"+i+".jpg";
	var x = 0;
	var addedpill = "";
	document.getElementById("one1").disabled = 'true';
	document.getElementById("two1").disabled = 'true';
	document.getElementById("three1").disabled = 'true';
	document.getElementById("four1").disabled = 'true';
	document.getElementById("five1").disabled = 'true';
	document.getElementById("six1").disabled = 'true';
	document.getElementById("one").disabled = 'true';
	document.getElementById("two").disabled = 'true';
	document.getElementById("three").disabled = 'true';
	document.getElementById("four").disabled = 'true';
	document.getElementById("five").disabled = 'true';
	document.getElementById("six").disabled = 'true';
	$.ajax(
		{
		  url: "addscore.php",
		  dataType: "json",
		  type:"POST",
		  data:
		  {
			mode:'add_score',
			this_score:i,
			challenge_id:j,
		  },
		  success: function(json)
		  {
			if(json.status==1)
			{
			  if(json.msg == 'cheater')
			  {
				  document.getElementById("cheating").submit();
			  }
			  else
			  {
				  if(json.msg == 'out')
				  {
					addedpill = "<button class='btn circle btn-flat btn-default' type='button' disabled>Out</button>";
					f.ball=(f.ball+1)||1;
					f.score=f.score||0;
					if(f.ball==1)
					{
						f.string=addedpill;
					}
					else
					{
						f.string = (f.string+"  "+addedpill);
					}
					document.getElementById('go').innerHTML="OUT!!";
					document.getElementById('runs').innerHTML = f.string;
					document.getElementById('totalballs').innerHTML = f.ball;
					document.getElementById("one").disabled = 'true';
					document.getElementById("two").disabled = 'true';
					document.getElementById("three").disabled = 'true';
					document.getElementById("four").disabled = 'true';
					document.getElementById("five").disabled = 'true';
					document.getElementById("six").disabled = 'true';
					//if(json.high == 1)
					{
						setTimeout(function(){location.reload();}, 2000);
					} 
				  }
				  else
				  {
					  x = json.gen;
					  var curr_score = json.score;
					  document.getElementById('by').src="images/r"+x+".jpg";
					  addedpill = "<button class='btn circle btn-flat btn-default' type='button' disabled>"+i+"</button>"
						f.score=(f.score+i)||i;
						f.ball=(f.ball+1)||1;
						if(f.ball==1)
						{
							f.string=addedpill;
						}
						else
						{
							f.string = (f.string+"  "+addedpill);
						}
						document.getElementById('totalruns').innerHTML = curr_score;
						document.getElementById('runs').innerHTML = f.string;
						document.getElementById('totalballs').innerHTML = f.ball;
						$('#one').prop("disabled", false);
						$('#two').prop("disabled", false);
						$('#three').prop("disabled", false);
						$('#four').prop("disabled", false);
						$('#five').prop("disabled", false);
						$('#six').prop("disabled", false);
						
				  }
			  }
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