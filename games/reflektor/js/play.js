/*global Game*/
/*global Enemy*/

/**
 * Returns a random integer between min and max
 * Using Math.round() will give you a non-uniform distribution!
 */

// Choose Random integer in a range
function rand (min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var musicOn = true;

var wKey;
var aKey;
var sKey;
var dKey;
var muteKey;

var music;
var score = 0;
var numPoints = 6;
var squareSize = 64;
var missLimit = 10;
var arc = (2 * Math.PI) / missLimit; 
var milliseconds = 0;
var seconds = 0;
var minutes = 0;

Game.Play = function(game) {
  this.game = game;
};

Game.Play.prototype = {
  create: function() {
    this.game.physics.startSystem(Phaser.ARCADE);
    this.game.world.setBounds(0, 0 ,Game.w ,Game.h);
    this.startTime = this.game.time.time;

    //Setup WASD and extra keys
    wKey = this.game.input.keyboard.addKey(Phaser.Keyboard.W);
    aKey = this.game.input.keyboard.addKey(Phaser.Keyboard.A);
    sKey = this.game.input.keyboard.addKey(Phaser.Keyboard.S);
    dKey = this.game.input.keyboard.addKey(Phaser.Keyboard.D);
    muteKey = this.game.input.keyboard.addKey(Phaser.Keyboard.M);
    this.cursors = this.game.input.keyboard.createCursorKeys();
     
    this.player = this.game.add.sprite( this.game.world.centerX, this.game.world.centerY, this.drawCircle(0));
    this.player.anchor.setTo(0.5,0.5);
    this.player.alive = true;

    this.game.physics.enable(this.player, Phaser.Physics.ARCADE);
    this.player.body.maxVelocity.setTo(0, 0);

    this.reflektor = this.game.add.sprite(this.game.world.centerX+50,this.game.world.centerY,'reflektor');
    this.reflektor.enableBody = true;
    this.reflektor.anchor.set(0.5,0.5);
    this.reflektor.scale.x = 0.8;
    this.reflektor.scale.y = 0.8;
    this.reflektor.rAngle = 0;
    this.reflektor.distanceFromCenter = 75;
    this.reflektor.animations.add('hit',[1,0],true);


    this.game.physics.enable(this.reflektor, Phaser.Physics.ARCADE);
    

    // Position a sprite relative to another, moves and rotates with the parent
    //  Calculate degrees for 6 points 2*Math.PI/6 * point(n)
    this.pbullets = this.game.add.group();
    this.pbullets.enableBody = true;
    this.pbullets.physicsBodyType = Phaser.Physics.ARCADE;
    this.pbullets.createMultiple(numPoints, 'pbullet');
    this.pbullets.setAll('anchor.x', 0.5);
    this.pbullets.setAll('anchor.y', 0.5);

    music = this.game.add.sound('music');
    music.volume = 1.5;
    music.play('',0,1,true);


    this.hit = [];
    this.hit.push(this.game.add.sound('hit1'));
    this.hit.push(this.game.add.sound('hit2'));

    this.enemy = new Enemy(this.game, this.player, numPoints);

    this.starfield = this.game.add.emitter(this.game.world.centerX,Game.h,400);
    this.starfield.width = this.game.world.width;
    this.starfield.makeParticles('star');
    this.starfield.minParticleScale = 0.1;
    this.starfield.maxParticleScale = 0.5;

    this.starfield.setYSpeed(-300, -500);
    this.starfield.setXSpeed(-5, 5);

    this.starfield.start(false, 1600, 5, 0);  

    this.runningTimeText = this.game.add.bitmapText(20, 20, 'minecraftia','00:00',32);
    
  },
  showRunningTime: function() {
   
    this.runningTime = this.game.time.time - this.startTime;
    
    minutes = Math.floor(this.runningTime / 60000) % 60; 
    seconds = Math.floor(this.runningTime / 1000) % 60;
    milliseconds = Math.floor(this.runningTime) % 100;

    if (minutes < 10) {
      minutes = '0' + minutes;
    }

    if (seconds < 10) {
      seconds = '0' + seconds;
    }

    if (milliseconds < 10) {
      milliseconds = '0' + milliseconds;
    }

    if (minutes !== '00') {
      this.runningTimeText.setText(minutes+':'+seconds+':'+milliseconds);
    }else {
      this.runningTimeText.setText(seconds+':'+milliseconds);
    }

    Game.bestTime = this.runningTime;
 },

  update: function() {
   this.showRunningTime();

   if (this.enemy.missedShot === true) {
      this.player.loadTexture(this.drawCircle(this.enemy.enemiesMissed));
      this.enemy.missedShot = false;
    }

   if ((this.enemy.enemiesMissed >= missLimit) || (this.runningTime >= 90000)){
      this.reset();
      this.game.state.start('PlayAgain');
   }

  
   // // Toggle Music
   muteKey.onDown.add(this.toggleMute, this);

   this.game.physics.arcade.overlap(this.enemy.bullets, this.reflektor, this.reflectShot, null, this);

   this.enemy.update(this.pbullets,this.runningTime); //Check if Enemy got hit by a reflected bullet


   if (this.cursors.left.isDown || aKey.isDown ){
     this.reflektor.rAngle -= 0.25; 
     this.reflektor.x = this.game.world.centerX + this.reflektor.distanceFromCenter * Math.cos(this.reflektor.rAngle);
     this.reflektor.y = this.game.world.centerY + this.reflektor.distanceFromCenter * Math.sin(this.reflektor.rAngle);
     this.reflektor.rotation = this.game.physics.arcade.angleBetween(this.reflektor, this.player);
   }
   else if (this.cursors.right.isDown || dKey.isDown){
     this.reflektor.rAngle += 0.25; 
     this.reflektor.x = this.game.world.centerX + this.reflektor.distanceFromCenter * Math.cos(this.reflektor.rAngle);
     this.reflektor.y = this.game.world.centerY + this.reflektor.distanceFromCenter * Math.sin(this.reflektor.rAngle);
     this.reflektor.rotation = this.game.physics.arcade.angleBetween(this.reflektor, this.player);
  }

  if (this.game.input.activePointer.isDown) {
    var pointerAngle = this.game.math.angleBetween(
        this.game.world.centerX, this.game.world.centerY,
        this.game.input.activePointer.x, this.game.input.activePointer.y
        );

    // Move to Pointer - Kind of fun, different from keyboard controlled game
     // this.reflektor.x = this.game.input.activePointer.x + this.reflektor.distanceFromCenter * Math.sin(pointerAngle);
     // this.reflektor.y = this.game.input.activePointer.y + this.reflektor.distanceFromCenter * Math.cos(pointerAngle);
     
    //Move to Pointer but not inside the circle
    //  this.reflektor.x = this.game.input.activePointer.x;
    //  this.reflektor.y = this.game.input.activePointer.y;
    // if ((this.game.input.activePointer.x > this.game.world.centerX - 30) && (this.game.input.activePointer.x < this.game.world.centerX + 30 )) {
    //  this.game.input.activePointer.x = this.game.input.activePointer.x + 30 * Math.sin(pointerAngle);
    // }
    //
    // if ((this.game.input.activePointer.y > this.game.world.centerY - 30) && (this.game.input.activePointer.y < this.game.world.centerY + 30 )) {
    //  this.game.input.activePointer.y = this.game.input.activePointer.y + 30 * Math.cos(pointerAngle);
    // }

     //Locked to Center Rotates to face the active pointer
     this.reflektor.x = this.game.world.centerX + this.reflektor.distanceFromCenter * Math.sin(pointerAngle);
     this.reflektor.y = this.game.world.centerY + this.reflektor.distanceFromCenter * Math.cos(pointerAngle);
     this.reflektor.rotation = this.game.physics.arcade.angleBetween(this.reflektor, this.player);

  }
     
  },
  reflectShot: function(reflektor,bullet) {
   this.hit[rand(0,this.hit.length-1)].play();  
   this.reflektor.play('hit',10);
   
   var pbullet = this.pbullets.getFirstDead();
   pbullet.reset(bullet.x, bullet.y);
   pbullet.rotation = bullet.rotation; 
   pbullet.body.velocity.x = -(2*bullet.body.velocity.x);
   pbullet.body.velocity.y = -(2*bullet.body.velocity.y);

   bullet.kill();
   score++;
   return true;
  },

  drawCircle: function(missed) {
    var bmd = this.game.add.bitmapData(squareSize, squareSize);
    var outsideRadius = squareSize / 2;
    var insideRadius = 20;

    bmd.ctx.clearRect(0,0,squareSize,squareSize);
    bmd.ctx.strokeStyle = '#404040';
    bmd.ctx.lineWidth = 0;

    for(var i = 0; i < missLimit; i++) {
      var angle =  i * arc;
      if (missed === 0) {
        bmd.ctx.fillStyle = '#ececec';
      }else{
        if (i < missed) {
          bmd.ctx.fillStyle = Game.bgcolor;
        }else{
          bmd.ctx.fillStyle = '#ececec';
        }
      }

      bmd.ctx.beginPath();
      bmd.ctx.arc(squareSize / 2, squareSize / 2, outsideRadius, angle, angle + arc, false);
      bmd.ctx.arc(squareSize / 2, squareSize / 2, insideRadius, angle + arc, angle, true);

      bmd.ctx.stroke();
      bmd.ctx.fill();
      bmd.ctx.save();

    }

    bmd.ctx.restore();
    bmd.ctx.closePath();
    return bmd;
  },

  reset: function() {
    this.startTime = this.game.time.time;
  },
  toggleMute: function() {
    if (musicOn === true) {
      musicOn = false;
      music.volume = 0;
    }else {
      musicOn = true;
      music.volume = 1;
    }
  },

};
