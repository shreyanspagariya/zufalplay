//Trying to preload all the images before to avoid latency 
function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
        // Alternatively you could use:
        // (new Image()).src = this;
    });
}

// Usage:

preload([
    'img/001.jpg',
    'img/002.jpg',
    'img/003.jpg',
    'img/004.jpg',
    'img/005.jpg',
    'img/006.jpg',
    'img/007.jpg',
    'img/008.jpg',
    'img/009.jpg',
    'img/010.jpg',
    'img/011.jpg',
    'img/012.jpg',
    'img/013.jpg',
    'img/101.jpg',
    'img/102.jpg',
    'img/103.jpg',
    'img/104.jpg',
    'img/105.jpg',
    'img/106.jpg',
    'img/107.jpg',
    'img/108.jpg',
    'img/109.jpg',
    'img/110.jpg',
    'img/111.jpg',
    'img/112.jpg',
    'img/113.jpg',
    'img/201.jpg',
    'img/202.jpg',
    'img/203.jpg',
    'img/204.jpg',
    'img/205.jpg',
    'img/206.jpg',
    'img/207.jpg',
    'img/208.jpg',
    'img/209.jpg',
    'img/210.jpg',
    'img/211.jpg',
    'img/212.jpg',
    'img/213.jpg',
    'img/301.jpg',
    'img/302.jpg',
    'img/303.jpg',
    'img/304.jpg',
    'img/305.jpg',
    'img/306.jpg',
    'img/307.jpg',
    'img/308.jpg',
    'img/309.jpg',
    'img/310.jpg',
    'img/311.jpg',
    'img/312.jpg',
    'img/313.jpg'
]);

$(document).ready(function(){
	var gamestart = 0;
	var chance = 0;
    var arr_diamond = [];
    var arr_heart = [];
    var arr_club = [];
    var arr_spade = [];
    var arr_deck_main = [];
    var arr_deck_gameplay = [];
    var arr_deck_player1 = [];
    var arr_deck_player2 = [];
    var player_done = 1;
    var same_card_found = 0;

    //Function list
    function randomGenerator(size){
        return Math.floor((Math.random() * size));
    }

    function shuffler(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

    return array;
    }

    function endCheck(){
        var play_id = document.getElementById('play_id').value;
        if(arr_deck_player1.length == 0 && arr_deck_player2.length == 0 || 
            arr_deck_player1.length == 0 && arr_deck_player2.length != 0 || 
            arr_deck_player1.length != 0 && arr_deck_player2.length == 0) {

            var score_display = "XXX";

            $.ajax(
            {
                url: "shufflecards.php",
                dataType: "json",
                type:"POST",
                async: false,

                data:
                {
                    mode:'shuffle_cards_between',
                    play_id:play_id,
                },

                success: function(json)
                {
                    if(json.status==1)
                    {
                        arr_deck_player1 = (json.arr_deck_player1).slice(0);
                        arr_deck_player2 = (json.arr_deck_player2).slice(0);
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

            $.ajax(
            {
                url: "addscore.php",
                dataType: "json",
                type:"POST",
                async: false,

                data:
                {
                    mode:'add_score',
                    play_id:play_id,
                },

                success: function(json)
                {
                    if(json.status==1)
                    {
                        score_display = json.result;
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

            setTimeout(function(){ window.location.replace("../newgame.php?game=twin-cards&score="+score_display);}, 1000);
            return false;
        }
        else return true;
    }
    function distributor(){
        //Diamond - red - 0
        //Heart - red - 1
        //Club - black - 2
        //Spade - black - 3
        /*
        arr_diamond = ["001","002","003","004","005","006","007","008","009","010","011","012","013"];
        arr_heart = ["101","102","103","104","105","106","107","108","109","110","111","112","113"];
        arr_club = ["201","202","203","204","205","206","207","208","209","210","211","212","213"];
        arr_spade = ["301","302","303","304","305","306","307","308","309","310","311","312","313"];
        arr_deck_main = arr_diamond.concat(arr_heart);
        arr_deck_main = arr_deck_main.concat(arr_club);
        arr_deck_main = arr_deck_main.concat(arr_spade);
        arr_deck_main = shuffler(arr_deck_main);
        arr_deck_player1 = arr_deck_main.slice(0,26);
        arr_deck_player2 = arr_deck_main.slice(26);
        arr_deck_player1 = shuffler(arr_deck_player1);
        arr_deck_player2 = shuffler(arr_deck_player2);
        */
        var play_id = document.getElementById('play_id').value;

        $.ajax(
        {
            url: "shufflecards.php",
            dataType: "json",
            type:"POST",
            async: false,

            data:
            {
                mode:'shuffle_cards_first',
                play_id:play_id,
            },

            success: function(json)
            {
                if(json.status==1)
                {
                    arr_deck_player1 = (json.arr_deck_player1).slice(0);
                    arr_deck_player2 = (json.arr_deck_player2).slice(0);
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

    function cpu_play(){
        $("#cards_number_2").text(arr_deck_player2.length-1+" cards left");
        $("#animator_player_1").css("z-index","0");
        $("#animator_player_2").css("z-index","1000");
        cpuMove();
        chance += 1;
        $("#card_player_1").css("border-color","#009C24");
        $("#player_1_id").css("color","#009C24");
        $("#card_player_2").css("border-color","#0B3C4D");
        $("#player_2_id").css("color","#0B3C4D");
    }
    
    function assigner(){
        if(chance%2==0){
            var temp = arr_deck_player1.pop();
            
            if(arr_deck_gameplay.length>0){
                var a = String(arr_deck_gameplay[arr_deck_gameplay.length-1]);
                var b = temp;
                if((a.charAt(1)+a.charAt(2))===(b.charAt(1)+b.charAt(2))) same_card_found = 1;
            }
            
            arr_deck_gameplay.push(String(temp));
            //alert(temp);
            /*
            if(temp[0]=="0"){
                $("#deck_type").html("&diams;");
                $("#num_top").css("color","red");
                $("#num_bottom").css("color","red");
                $("#deck_type").css("color","red");
            }
            if(temp[0]=="1"){
                $("#deck_type").html("&hearts;");
                $("#num_top").css("color","red");
                $("#num_bottom").css("color","red");
                $("#deck_type").css("color","red");
            }
            if(temp[0]=="2"){
                $("#deck_type").html("&clubs;");
                $("#num_top").css("color","black");
                $("#num_bottom").css("color","black");
                $("#deck_type").css("color","black");
            }
            if(temp[0]=="3"){
                $("#deck_type").html("&spades;");
                $("#num_top").css("color","black");
                $("#num_bottom").css("color","black");
                $("#deck_type").css("color","black");
            }

            var temp_num = temp.substring(1);
            temp_num = parseInt(temp_num);

            $("#num_top").text(temp_num);
            $("#num_bottom").text(temp_num);
            */
            var destination_string = '"img/'+temp+'.jpg"';
            $('#animator_player_1').html('<img width="250px" height="320px" src='+destination_string+'/>');

        }   
        if(chance%2!=0){
            var temp = arr_deck_player2.pop();
            
            if(arr_deck_gameplay.length>0){
                var a = String(arr_deck_gameplay[arr_deck_gameplay.length-1]);
                var b = temp;
                if((a.charAt(1)+a.charAt(2))===(b.charAt(1)+b.charAt(2))) same_card_found = 1;
            }
            
            arr_deck_gameplay.push(String(temp));
            /*
            if(temp[0]=="0"){
                $("#deck_type_2").html("&diams;");
                $("#num_top_2").css("color","red");
                $("#num_bottom_2").css("color","red");
                $("#deck_type_2").css("color","red");
            }
            if(temp[0]=="1"){
                $("#deck_type_2").html("&hearts;");
                $("#num_top_2").css("color","red");
                $("#num_bottom_2").css("color","red");
                $("#deck_type_2").css("color","red");
            }
            if(temp[0]=="2"){
                $("#deck_type_2").html("&clubs;");
                $("#num_top_2").css("color","black");
                $("#num_bottom_2").css("color","black");
                $("#deck_type_2").css("color","black");
            }
            if(temp[0]=="3"){
                $("#deck_type_2").html("&spades;");
                $("#num_top_2").css("color","black");
                $("#num_bottom_2").css("color","black");
                $("#deck_type_2").css("color","black");
            }

            var temp_num = temp.substring(1);
            temp_num = parseInt(temp_num);
            
            $("#num_top_2").text(temp_num);
            $("#num_bottom_2").text(temp_num);
            */
            var destination_string = '"img/'+temp+'.jpg"';
            $('#animator_player_2').html('<img width="250px" height="320px" src='+destination_string+'/>');
        }
        /*
        console.log("Gameplay deck is "+arr_deck_gameplay);
        console.log("Did we find same_card_found? "+same_card_found);
        console.log(arr_deck_player1);
        console.log(arr_deck_player2);
        */
    }
    
    function myMove() {
        assigner();
        $("#cards_number_main").text(arr_deck_gameplay.length+" cards");
        var elem = document.getElementById("animator_player_1"); 
        var pos = 190;
        $("#animator_player_1").show();
        var id = setInterval(frame, 3);
        function frame() {
            if (pos >= 523) {
                $("#animator_player_1").css("box-shadow" ,"10px 10px 1px #888888");
                $("#animator_player_2").css("box-shadow" ,"");
                clearInterval(id);
                if(same_card_found == 1){
                    $("#game_status").text("Shuffled");
                    //arr_deck_player1 = arr_deck_player1.concat(arr_deck_gameplay);
                    arr_deck_gameplay = [];
                    //arr_deck_player1 = shuffler(arr_deck_player1);

                    var play_id = document.getElementById('play_id').value;

                    $.ajax(
                    {
                        url: "shufflecards.php",
                        dataType: "json",
                        type:"POST",
                        async: false,

                        data:
                        {
                            mode:'shuffle_cards_between',
                            play_id:play_id,
                        },

                        success: function(json)
                        {
                            if(json.status==1)
                            {
                                //console.log("Shuffle happening");
                                arr_deck_player1 = (json.arr_deck_player1).slice(0);
                                arr_deck_player2 = (json.arr_deck_player2).slice(0);
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
                    
                    $("#cards_number_main").text(arr_deck_gameplay.length+" cards");
                    $("#cards_number_1").text(arr_deck_player1.length+" cards left");
                    $("#animator_player_1").hide();
                    $("#animator_player_2").hide();
                    same_card_found = 0;
                }
                cpu_play();
            } else {
                pos+=2; 
                elem.style.left = pos + 'px'; 
            }
        }
    }

    function cpuMove() {
        assigner();
        $("#cards_number_main").text(arr_deck_gameplay.length+" cards");
        $("#animator_player_2").show();
        var elem = document.getElementById("animator_player_2"); 
        var pos = 850;
        var id = setInterval(frame, 3);
        function frame() {
            if (pos <= 523) {
                clearInterval(id);
                $("#animator_player_1").hide();
                $("#animator_player_1").css("box-shadow" ,"");
                $("#animator_player_2").css("box-shadow" ,"10px 10px 1px #888888");
                $("#game_status").text("");
                if(same_card_found == 1){
                    $("#game_status").text("Shuffled");
                    //arr_deck_player2 = arr_deck_player2.concat(arr_deck_gameplay);
                    arr_deck_gameplay = [];
                    //arr_deck_player2 = shuffler(arr_deck_player2);

                    var play_id = document.getElementById('play_id').value;

                    $.ajax(
                    {
                        url: "shufflecards.php",
                        dataType: "json",
                        type:"POST",
                        async: false,

                        data:
                        {
                            mode:'shuffle_cards_between',
                            play_id:play_id,
                        },

                        success: function(json)
                        {
                            if(json.status==1)
                            {
                                //console.log("Shuffle happening");
                                arr_deck_player1 = (json.arr_deck_player1).slice(0);
                                arr_deck_player2 = (json.arr_deck_player2).slice(0);
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

                    $("#cards_number_main").text(arr_deck_gameplay.length+" cards");
                    $("#cards_number_2").text(arr_deck_player2.length+" cards left");
                    $("#animator_player_1").hide();
                    $("#animator_player_2").hide();
                    same_card_found = 0;
                }
                var ran = endCheck();
                player_done = 1;
            } else {
                pos-=2; 
                elem.style.left = pos + 'px'; 
            }
        }
    }

	$("#card_player_1").hide();
	$("#card_player_2").hide();
    $("#animator_player_1").hide();
    $("#animator_player_2").hide();

	$("#card_1").click(function(){
        $(this).hide();
        gamestart = 1;
        distributor();
        $("#card_player_1").show();
        $("#card_player_2").show();
    });

    $("#card_player_1").click(function(){
        if(chance%2==0 && player_done==1 && same_card_found==0 && endCheck()){
            player_done = 0;
            $("#animator_player_1").hide();
            $("#game_status").text("");
            $("#cards_number_1").text(arr_deck_player1.length-1+" cards left");
            $("#animator_player_1").css("z-index","1000");    
            $("#animator_player_2").css("z-index","0");
                    

            //Animation part
            myMove();


            //alert("Poop-1");
            $("#card_player_1").css("border-color","#0B3C4D");
            $("#player_1_id").css("color","#0B3C4D");
            $("#card_player_2").css("border-color","#009C24");
            $("#player_2_id").css("color","#009C24");
            chance += 1;
            //cpu_play();
        }
    });


    if(chance==0){
    	$("#card_player_1").css("border-color","#009C24");
    	$("#player_1_id").css("color","#009C24");
        $("#card_player_2").css("border-color","#0B3C4D");
        $("#player_2_id").css("color","#0B3C4D");
    }

});