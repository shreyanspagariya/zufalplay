var Game = {
  w: 800,
  h: 600,
  rndColor: function() {
    var colors = ['#606D80','2B4C7E','#681F63'];
    return colors[Math.floor(Math.random() * colors.length)];
  },
  bgcolor: 0, 
  bestTime: 0,
  timedOut: false
};

Game.Boot = function(game) {
  this.game = game;
};

Game.Boot.prototype = {
  preload: function() {
    Game.bgcolor = Game.rndColor();
		this.game.stage.backgroundColor = Game.bgcolor; 
		this.game.load.image('loading', 'assets/images/loading.png');
		this.game.load.image('title', 'assets/images/title.png');
		this.game.load.image('instructions', 'assets/images/instructions.png');
    
    this.game.load.bitmapFont('minecraftia','assets/fonts/font.png','assets/fonts/font.xml');
  },
  create: function() {
   this.game.state.start('Load');
  }
};

Game.Load = function(game) {
  this.game = game;
};

Game.Load.prototype = {
  preload: function() {

    var loadingText = this.game.add.bitmapText(Game.w/2, Game.h/2, 'minecraftia', 'Loading...', 21); 
    loadingText.x = this.game.width / 2 - loadingText.textWidth / 2;

  	var preloading = this.game.add.sprite(Game.w/2-64, Game.h/2+50, 'loading');
  	this.game.load.setPreloadSprite(preloading);

    this.game.load.image('pixel', 'assets/images/pixel.png');
    this.game.load.image('pbullet', 'assets/images/pbullet.png');
    this.game.load.image('ebullet', 'assets/images/ebullet.png');

    this.game.load.atlasXML('enemy','assets/images/enemy_sheet.png','assets/atlas/enemy_sheet.xml');
    this.game.load.atlasXML('reflektor','assets/images/reflektor_sheet.png','assets/atlas/reflektor_sheet.xml',0);
    this.game.load.spritesheet('star', 'assets/images/star.png', 20, 20);
    this.game.load.image('twitter','assets/images/twitter.png');
    this.game.load.image('playagain','assets/images/playagain.png');
    this.game.load.audio('hit1','assets/audio/hit1.wav');
    this.game.load.audio('hit2','assets/audio/hit2.wav');

    // Music Track
    this.game.load.audio('music','assets/audio/Android128-At_Last.mp3');

  },
  create: function() {
    this.game.state.start('Menu');
  }
};
