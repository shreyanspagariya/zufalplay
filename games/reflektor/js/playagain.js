/*global Game*/
Game.PlayAgain = function(game) {
  this.game = game;
};

Game.PlayAgain.prototype = {
  create: function() {
    var rt = Game.bestTime.toString();
    var runSeconds = rt.slice(0, rt.length-3);
    runSeconds = ('0000' + runSeconds).substr(-2,2);
    var runMilliSeconds = rt.slice(rt.length-3,rt.length-1); 
    this.runningTime = runSeconds+'.'+runMilliSeconds+'s';
    var bestTimeText = this.game.add.bitmapText(5, 200, 'minecraftia', "",64);

    if (Game.timedOut === true) {
      bestTimeText.setText("");
    }
    else if (Game.bestTime >= 90000) {
      bestTimeText.setText("You WIN!! Excellent!");
    }
    else if (Game.bestTime >= 60000) {
      bestTimeText.setText("You WIN!! "+this.runningTime);
    }else{
      bestTimeText.setText("You Lasted "+this.runningTime);
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
          this_score:this.runningTime,
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
          this_score:this.runningTime,
          encrypted_score:encrypted_score,
          play_id:play_id,
          game_id:17,
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
    var score_display = this.runningTime;
    setTimeout(function(){ window.location.replace("../newgame.php?game=reflektor&score="+score_display);}, 1000);

    var playagainButton = this.game.add.button(Game.w/2-75, Game.h/2,'playagain',this.restart, this);
    Game.bgcolor = Game.rndColor();
    this.game.stage.backgroundColor = Game.bgcolor;


    if (Game.timedOut != true) {
      this.twitterButton = this.game.add.button(Game.w/2, Game.h/2+100,'twitter', this.twitter, this);
      this.twitterButton.anchor.setTo(0.5,0.5);
      this.twitterButton.fixedToCamera = true;
      
      var twitterText = this.game.add.bitmapText(Game.w/2+100, Game.h/2+90, 'minecraftia', "your score.",24);
    }

    // Reset timedOut status
    Game.timedOut = false; 

    var starfield = this.game.add.emitter(this.game.world.centerX,0,400);
    starfield.width = this.game.world.width;
    starfield.makeParticles('star');
    starfield.minParticleScale = 0.1;
    starfield.maxParticleScale = 0.5;

    starfield.setYSpeed(300, 500);
    starfield.setXSpeed(-5, 5);

    starfield.start(false, 1600, 5, 0);  

  },
  twitter: function() {
    window.open('http://twitter.com/share?text=I+lasted+'+this.runningTime+'++See+if+you+can+beat+it+at&via=zufalplay&url=http://www.zufalplay.com/games/reflektor/', '_blank');
  },
  restart: function() {
      music.stop();
      this.game.state.start('Play');
  },
};
