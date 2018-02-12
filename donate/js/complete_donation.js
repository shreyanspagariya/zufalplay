function complete_donation(unique_id)
{
	$("#submit_donation").hide();
	$("#donation_amount").prop('disabled', true);

	var donation_amount = document.getElementById("donation_amount").value;
	$.ajax(
	{
		url: "backend/complete_donation.php",
		dataType: "json",
		type:"POST",
		async: false,

		data:
		{
			mode:'complete_donation',
			unique_id: unique_id,
			donation_amount: donation_amount,
		},

		success: function(json)
		{
			if(json.status==1)
			{	
				$("#donation_notify").html("<center><font size='4' color='green'><i class='fa fa-check-circle' aria-hidden='true'></i> <b>Donation Successful,</b></font> <br>Thank You for your Donation.</center>");
				$("#user_points").html(Math.floor(json.user_points*100)/100);
			}
			else if(json.status==0)
			{
				$("#donation_notify").html("<center><br><font size='4' color='orange'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Donation Failed,</b></font> <br>Sorry, you cannot Donate more than your Account Balance.</center>");
				$("#donation_amount").prop('disabled', false);
				$("#submit_donation").show();
			}
			else if(json.status==-1)
			{
				$("#donation_notify").html("<center><br><font size='4' color='orange'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> <b>Donation Failed,</b></font> <br>Sorry, please donate a +ve amount.</center>");
				$("#donation_amount").prop('disabled', false);
				$("#submit_donation").show();
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