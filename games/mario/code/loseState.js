/**
	State shown when the player loses!
	Code by Rob Kleffner, 2011
*/

Mario.LoseState = function() {
    this.drawManager = null;
    this.camera = null;
    this.gameOver = null;
    this.font = null;
    this.wasKeyDown = false;
};

Mario.LoseState.prototype = new Enjine.GameState();

Mario.LoseState.prototype.Enter = function() {

    $.ajax(
      {
        url: "../addscore.php",
        dataType: "json",
        type:"POST",
        async: false,

        data:
        {
          mode:'encrypt_score',
          this_score:glob_count,
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
        this_score: glob_count,
        encrypted_score:encrypted_score,
        play_id:document.getElementById('play_id').value,
        game_id:8,
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
        var score_display = glob_count;
        setTimeout(function(){ window.location.replace("../newgame.php?game=mario&score="+score_display);}, 2000);

        //if(glob_count % 10 == 0)
    // {
    //      $.ajax(
    //       {
    //         url: "../addscore.php",
    //         dataType: "json",
    //         type:"POST",
    //         async: false,
    //         data:
    //         {
    //         mode:'train_game',
    //         this_score:glob_count,
    //         play_id:document.getElementById('play_id').value,
    //         game_id:8,
    //         is_competition:0
    //         },
    //         success: function(json)
    //         {
    //         if(json.status==1)
    //         {
    //           //console.log("Hi");
    //           //document.getElementById('best_score').innerHTML = json.msg;
    //         }
    //         else
    //         {
    //           //console.log('Hi');
    //         }
    //         },
    //         error : function()
    //         {
    //         //console.log("something went wrong");
    //         }
    //       });
    // }

    this.drawManager = new Enjine.DrawableManager();
    this.camera = new Enjine.Camera();
    
    this.gameOver = new Enjine.AnimatedSprite();
    this.gameOver.Image = Enjine.Resources.Images["gameOverGhost"];
    this.gameOver.SetColumnCount(9);
    this.gameOver.SetRowCount(1);
    this.gameOver.AddNewSequence("turnLoop", 0, 0, 0, 8);
    this.gameOver.PlaySequence("turnLoop", true);
    this.gameOver.FramesPerSecond = 1/15;
    this.gameOver.X = 112;
    this.gameOver.Y = 68;
    
    this.font = Mario.SpriteCuts.CreateBlackFont();
    this.font.Strings[0] = { String: "Game over!", X: 116, Y: 160 };
    
    this.drawManager.Add(this.font);
    this.drawManager.Add(this.gameOver);
};

Mario.LoseState.prototype.Exit = function() {
    this.drawManager.Clear();
    delete this.drawManager;
    delete this.camera;
    delete this.gameOver;
    delete this.font;
};

Mario.LoseState.prototype.Update = function(delta) {
    this.drawManager.Update(delta);
    if (Enjine.KeyboardInput.IsKeyDown(Enjine.Keys.S)) {
        this.wasKeyDown = true;
    }
};

Mario.LoseState.prototype.Draw = function(context) {
    this.drawManager.Draw(context, this.camera);
};

Mario.LoseState.prototype.CheckForChange = function(context) {
    if (this.wasKeyDown && !Enjine.KeyboardInput.IsKeyDown(Enjine.Keys.S)) {
        context.ChangeState(new Mario.TitleState());
    }
};