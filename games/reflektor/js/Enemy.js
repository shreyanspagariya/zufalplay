/*global Game*/
/*global Enemy*/
var Enemy = function(game, player, numPoints) {
 
  this.numPoints = numPoints;

  this.game = game;
  this.player = player;
  // this.spawnTimer = this.game.time.time;
  this.missedShot = false;

  this.enemies = [];
  this.enemiesTotal = 1;
  this.enemiesAlive = 0;
  this.enemiesMissed = 0;

  this.spawnDelay = 1600;

  this.bullets = this.game.add.group();
  this.bullets.enableBody = true;
  this.bullets.physicsBodyType = Phaser.Physics.ARCADE;
  // this.bullets.createMultiple(100, 'ebullet');
  this.bullets.createMultiple(this.numPoints, 'ebullet');

  this.bullets.setAll('anchor.x', 0.5);
  this.bullets.setAll('anchor.y', 0.5);
  // this.bullets.setAll('outOfBoundsKill', true); //expensive (find a better way)

  this.emitter = game.add.emitter(0, 0, 200);
  this.emitter.makeParticles('pixel');
  // this.emitter.makeParticles('star');
  this.emitter.minParticleScale = 0.1;
  this.emitter.maxParticleScale = 0.5;

  // this.emitter.gravity = 0;
  this.emitter.minParticleSpeed.setTo(-200, -200);
  this.emitter.maxParticleSpeed.setTo(200, 200);

};

Enemy.prototype = {
  update: function(pbullets,runningTime) {
    
    if ((this.game.time.time - this.awayTimeout) > 2000) {
      // console.log('timed out');
      Game.timedOut = true;
      this.game.state.start('PlayAgain');
    }
    
    //Generate more baddies
    if ((this.enemiesAlive == 0) || (this.game.time.time > this.spawnTimer)) {
      if (runningTime < 20000) {
        this.enemiesTotal = 1;
      }
      else if ((runningTime >= 20000) && (runningTime < 40000)) {
        this.enemiesTotal = 2;
      }else if ((runningTime >= 40000) && (runningTime < 60000)) {
        this.enemiesTotal = 3;
      }

      this.spawnEnemy(runningTime);
    }

    //Enemy waits until finished spawning and then opens fire
    for (var i = 0; i < this.enemies.length; i++)
    {
        if (this.enemies[i].alive)
        {
            this.game.physics.arcade.overlap(pbullets, this.enemies[i].sprite, this.bulletHitEnemy, null, this);
            this.enemies[i].update();
        }
    }
  },
  spawnEnemy: function(runningTime) {
    this.clearEnemies();
   
    if (this.enemiesTotal == 1) {
      var positions = []
      for (var i = 0; i < this.numPoints; i++) {
        positions.push(i);
      }
      this.enemiesAlive = 1;
      this.enemies.push(new EnemyShip(positions.splice(Math.floor( Math.random() * positions.length),1), this.game, this.player, this.bullets, this.numPoints));
     
    } 
    else if (this.enemiesTotal == 2) {
      var positions = []
      for (var i = 0; i < this.numPoints; i++) {
        positions.push(i);
      }
      for (var i = 0; i < this.enemiesTotal; i++) {
        this.enemiesAlive++;
        this.enemies.push(new EnemyShip(positions.splice(Math.floor( Math.random() * positions.length),1), this.game, this.player, this.bullets, this.numPoints));
      }
    }else if (this.enemiesTotal == 3) {
      var formations = [
                        [0,1,2],
                        [1,2,3],
                        [2,3,4],
                        [3,4,5],
                        [4,5,0],
                        [0,2,3],
                        [0,3,4],
                        [1,3,4],
                        [1,4,5],
                        [2,4,5],
                        [2,5,0],
                        [3,5,0],
                        [3,0,1],
                        [4,0,1],
                        [4,1,2],
                        [5,1,2],
                        [5,2,3]
                       ];
      var formation = formations[Math.floor(Math.random()*formations.length)];
      formation.forEach(function(position) {
        this.enemiesAlive++;
        this.enemies.push(new EnemyShip(position, this.game, this.player, this.bullets, this.numPoints));
      },this);
    }

    this.spawnDelay = 1600; // width/bulletspeed = 800px/500px/s
    this.spawnTimer = this.game.time.time + this.spawnDelay;
    
  },
  clearEnemies: function() {
    this.awayTimeout = this.game.time.time;
    //  Kill all enemies
    if (this.enemiesAlive > 0) {
      this.enemiesMissed += this.enemiesAlive;
      this.missedShot = true;
    }

    this.enemiesAlive = 0;
    for (var i = 0; i < this.enemies.length; i++)
    {
      this.enemies[i].sprite.alive = false;
      this.enemies[i].sprite.kill();
      // this.enemiesAlive--;
    }
    // Kill all bullets
    this.bullets.forEach(function(bullet) {
      bullet.kill();
    },this);
    
  },
  bulletHitEnemy: function(enemy, bullet) {
    bullet.kill();
    this.emitter.x = enemy.x;
    this.emitter.y = enemy.y;
    this.emitter.start(true, 1000, null, 128);

    enemy.kill();
    this.enemiesAlive--;
  },
};
