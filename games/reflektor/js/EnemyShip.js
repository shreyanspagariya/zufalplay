/*global Game*/
var EnemyShip = function(index, game, player, bullets,numPoints) {
    this.game = game;
    this.spawnedAt = this.game.time.now; 
    this.bullets = bullets;
    var distance = Game.h / 2 - 20;
    var ex = this.game.world.centerX + distance * Math.cos(2*Math.PI/numPoints*index);
    var ey = this.game.world.centerY + distance * Math.sin(2*Math.PI/numPoints*index);
 
    this.player = player;
    this.sprite = this.game.add.sprite(ex,ey, 'enemy');
    this.sprite.frame = 0;
    this.sprite.anchor.set(0.5,0.5);

    this.game.physics.enable(this.sprite, Phaser.Physics.ARCADE);
    this.sprite.rotation = this.game.physics.arcade.angleBetween(this.sprite, this.player);
    this.sprite.fired = false;
    this.sprite.name = index.toString();
    this.sprite.animations.add('warp-in',[3,4,5,6,7,8,0],true);
    this.sprite.animations.add('warp-out',[0,8,7,6,5,4,3],true);
    this.sprite.animations.add('fire',[8,0],true);
    this.sprite.animations.play('warp-in',27);
    this.spawnTimer = this.game.time.now;
    this.nextFire = 0;
    this.alive = true;
    this.fireRate = 500;

};

EnemyShip.prototype = {
  damage: function() {
    this.alive = false;
    this.emitter.x = this.sprite.x;
    this.emitter.y = this.sprite.y;
    this.emitter.start(true, 1000, null, 128);
    // this.emitter.start(true, 1000, 5, 128);

    this.sprite.kill();

    return true;
  },
  update: function() {
   if ((this.game.time.now >= this.spawnTimer+300) && (this.sprite.fired === false)) {

       if (this.player.alive === true){
         var bullet = this.bullets.getFirstDead();
         bullet.reset(this.sprite.x, this.sprite.y);
         bullet.rotation = this.game.physics.arcade.moveToObject(bullet, this.player, 500);
         this.sprite.animations.play('fire',27);
         this.sprite.fired = true;
      }
   }

  },
};

