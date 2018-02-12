Game.Load = function (game) { };

Game.Load.prototype = {
    preload: function () {
	// create loading screen
	game.stage.backgroundColor = '#222';

	background = game.add.sprite(0, 0, 'background');

	frame = game.add.sprite(w/2, 145, 'loadframe');
	frame.anchor.setTo(0, 0.5);
	frame.x -= frame.width / 2;
	bar = game.add.sprite(w/2, 145, 'loadbar');
	bar.x -= frame.width / 2 - 5;
	bar.anchor.setTo(0, 0.5);

	game.load.setPreloadSprite(bar);

	// load everything
	game.load.image('square-green', 'assets/img/square-green.png');
	game.load.image('square-blue', 'assets/img/square-blue.png');
	game.load.image('square-orange', 'assets/img/square-orange.png');
	game.load.image('square-purple', 'assets/img/square-purple.png');
	game.load.image('square-pink', 'assets/img/square-pink.png');
	game.load.image('square-lime', 'assets/img/square-lime.png');
	
	game.load.image('food-green', 'assets/img/food-green.png');
	game.load.image('food-blue', 'assets/img/food-blue.png');
	game.load.image('food-orange', 'assets/img/food-orange.png');
	game.load.image('food-purple', 'assets/img/food-purple.png');
	game.load.image('food-pink', 'assets/img/food-pink.png');
	game.load.image('food-lime', 'assets/img/food-lime.png');

	game.load.image('keys-wasd', 'assets/img/keys-wasd.png');
	game.load.image('keys-arrows', 'assets/img/keys-arrows.png');

	game.load.image('ready', 'assets/img/ready.png');

	game.load.audio('music', 'assets/aud/Kick\ Shock.mp3');
	game.load.audio('die', 'assets/aud/die.wav');
	game.load.audio('eat', 'assets/aud/eat.wav');
	game.load.audio('eat2', 'assets/aud/eat2.wav');
	music = game.add.sound('music');
	sfx.die = game.add.sound('die');
	sfx.eat = game.add.sound('eat');
	sfx.eat2 = game.add.sound('eat2');
    },

    create: function () {
	game.state.start('Menu');
    }
};
