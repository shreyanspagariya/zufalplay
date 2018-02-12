Game.End = function (game) { };

Game.End.prototype = {
    create: function () {
	result = 'hi';
	resultColor = '#888';
	resultSize = 40;
	attrColor = '#ccc';

	var final_score;

	difference = players[0].score - players[1].score;
	if (difference > 0) {
	    this.createBackground(players[0].color);
	    result = players[0].color.charAt(0).toUpperCase() + players[0].color.slice(1) + ' wins!';
	    attrColor = hexColors[players[0].colorId];

	    final_score = players[1].score;
	}
	else if (difference < 0) {
	    this.createBackground(players[1].color);
	    result = players[1].color.charAt(0).toUpperCase() + players[1].color.slice(1) + ' wins!';
	    attrColor = hexColors[players[1].colorId];

	     final_score = players[0].score;
	}
	else {
	    this.createBackground(null)
	    result = 'It\'s a tie!';
	    resultColor = '#ccc';
	    resultSize = 50;

	    final_score = players[1].score;
	}

	 var play_id = document.getElementById('play_id').value;
    $.ajax(
      {
        url: "../addscore.php",
        dataType: "json",
        type:"POST",
        async: false,

        data:
        {
          mode:'encrypt_score',
          this_score:final_score,
        },

        success: function(json)
        {
          if(json.status==1)
          {
            encrypted_score = json.msg;
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
            url: "../addscore.php",
            dataType: "json",
            type:"POST",
            async: false,

            data:
            {
              mode:'submit_score',
              this_score:final_score,
              encrypted_score:encrypted_score,
              play_id:play_id,
              game_id:18,
              is_competition:0
            },

            success: function(json)
            {
              if(json.status==1)
              {
               
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
        var score_display = final_score;
        setTimeout(function(){ window.location.replace("../newgame.php?game=multisnake&score="+score_display);}, 1000);

	console.log(attrColor);

	scoreText[0] = game.add.text(135, 296, players[0].score.toString(), { font: '50px Arial bold', fill: '#888' });
	scoreText[0].anchor.setTo(1, 0);
	scoreText[1] = game.add.text(165, 296, players[1].score.toString(), { font: '50px Arial bold', fill: '#888' });

	resultText  = game.add.text(w/2, 145, result, { font: '20px Arial bold', fill: resultColor, align: 'center' });
	resultText.anchor.setTo(0.5, 0.5);
	resultText.alpha = 0;
	game.add.tween(resultText).to({ alpha: 1, fontSize: resultSize }, 250, null, true, 0, 0, false);

	restartText = game.add.text(w/2, 280, "press W or UP to restart", { font: '22px Arial', fill: resultColor });
	restartText.anchor.setTo(0.5, 1);
	restartText.alpha = 0;
	game.add.tween(restartText).to({ alpha: 1 }, 1000, null, true, 250, 0, false);

	attr = game.add.text(w/2, h, 'music: "Kick Shock" by Kevin Macleod (incompetech.com)', { font: '9px Arial', fill: attrColor });
	attr.anchor.setTo(0.5, 1);
	attr.alpha = 0;
	game.add.tween(attr).to({ alpha: 1 }, 1000, null, true, 250, 0, false);

	game.input.keyboard.addKey(Phaser.Keyboard.UP).onDown.add(this.restart, this);
	game.input.keyboard.addKey(Phaser.Keyboard.W).onDown.add(this.restart, this);
    },

    createBackground: function (colorBig) {
	background = game.add.sprite(0, 0, 'background');
	if (colorBig) {
	    bgBig = game.add.sprite(10, 10, 'square-' + colorBig);
	    bgBig.scale.setTo(280 / 18, 280 / 18);
	}
	bgLeft = game.add.sprite(10, 300, 'square-' + players[0].color);
	bgRight = game.add.sprite(155, 300, 'square-' + players[1].color);
	bgLeft.scale.setTo(135 / 18, 90 / 18);
	bgRight.scale.setTo(135 / 18, 90 / 18);

	keysWasd = game.add.sprite(78, 390, 'keys-wasd');
	keysWasd.anchor.setTo(0.5, 1);
	keysArrows = game.add.sprite(300 - 78, 390, 'keys-arrows');
	keysArrows.anchor.setTo(0.5, 1);
    },

    restart: function () {
	game.state.start('Menu');
    }
};
