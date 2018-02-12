Game.Play = function (game) { };

var time;
var turnCount;
var foodArray;
var scoreText = [];

Game.Play.prototype = {
    create: function () {
	if (audio) {
	    music.play('', 0, 0.25, true, true);
	}

	this.createPlayer(0, 3, rows, Directions.Up);
	this.createPlayer(1, columns - 3, rows, Directions.Up);

	this.createBackground();

	squares = game.add.group();

	this.generateFood(players[0]);
	this.generateFood(players[1]);

	// controls
	this.addControls(Phaser.Keyboard.W, Phaser.Keyboard.S, Phaser.Keyboard.A, Phaser.Keyboard.D, players[0]);
	this.addControls(Phaser.Keyboard.UP, Phaser.Keyboard.DOWN, Phaser.Keyboard.LEFT, Phaser.Keyboard.RIGHT, players[1]);
	this.addMute();

	time = game.time.now;
	turnCount = 0;
	
	scoreText[0] = game.add.text(135, 296, players[0].score.toString(), { font: '50px Arial bold', fill: '#888' });
	scoreText[0].anchor.setTo(1, 0);
	scoreText[0].alpha = 0;
	game.add.tween(scoreText[0]).to({ alpha: 1 }, 250, null, true, 0, 0, false);
	scoreText[1] = game.add.text(165, 296, players[1].score.toString(), { font: '50px Arial bold', fill: '#888' });
	scoreText[1].alpha = 0;
	game.add.tween(scoreText[1]).to({ alpha: 1 }, 250, null, true, 0, 0, false);

	this.paint();				
    },

    update: function () {
	for (var i = 0; i < players.length; i++) {
	    this.updateControls(players[i]);
	}

	if (Math.floor((game.time.now - time) / 200) > turnCount) {
	    this.advanceTurn();

	    this.paint();
	}

	if (this.allDead()) {
	    this.endGame();
	}
    },

    advanceTurn: function () {
	for (var i = 0; i < players.length; i++) {
	    if (players[i].alive) {
		this.move(players[i]);
	    }
	}
	for (var i = 0; i < players.length; i++) {
	    if (players[i].alive) {
		this.postMove(players[i], i);
	    }
	}
	for (var i = 0; i < players.length; i++) {
	    if (players[i].shouldDie) {
		players[i].alive = false;
		players[i].shouldDie = false;
		if (audio) {
		    sfx.die.play('', 0, 0.2, false, true);
		}
	    }
	}

	turnCount++;
    },

    move: function (player) {

    	if(players[0].score < players[1].score)
    	{
    		$('#gamescore').html('<b>'+players[0].score+'</b>');
    	}
    	else
    	{
    		$('#gamescore').html('<b>'+players[1].score+'</b>');
    	}

	player.snakePath.unshift([player.snakeHead[0], player.snakeHead[1]]);
	
	player.lastSnakeHead = [player.snakeHead[0], player.snakeHead[1]];
	
	switch (player.nextDirection) {
	case Directions.Up:
	    player.snakeHead[1] -= 1;
	    break;
	case Directions.Down:
	    player.snakeHead[1] += 1;
	    break;
	case Directions.Left:
	    player.snakeHead[0] -= 1;
	    break;
	case Directions.Right:
	    player.snakeHead[0] += 1;
	    break;
	}
	
	player.currentDirection = player.nextDirection;
	
	for (var i = 0; i < players.length; i++) {
	    var foodIndex = this.arrayIndexOf(player.snakeHead, players[i].foodArray);
	    if (foodIndex > -1) {
		players[i].foodArray.splice(foodIndex, 1);
		if (players[i] == player) {
		    player.addSquare = true;
		    if (audio) {
			sfx.eat.play('', 0, 1, false, true);
		    }
		}
		else {
		    player.score -= 5;
		    if (audio) {
			sfx.eat2.play('', 0, 1, false, true);
		    }
		}
		this.generateFood(players[i]);
	    }
	}
	
	if (player.addSquare) {
	    player.addSquare = false;
	    player.score += 10;
	}
	else {
	    player.snakePath.pop();
	}
    },

    postMove: function (player) {
	for (var i = 0; i < players.length; i++) {
	    if (players[i].snakeHead[0] === player.snakeHead[0] && players[i].snakeHead[1] === player.snakeHead[1] && players[i] !== player) {
		players[i].shouldDie = true;
		player.shouldDie = true;
	    }
	    else if (players[i].lastSnakeHead[0] === player.snakeHead[0] && players[i].lastSnakeHead[1] === player.snakeHead[1] && players[i].snakeHead[0] === player.lastSnakeHead[0] && players[i].snakeHead[1] === player.lastSnakeHead[1] ) {
		players[i].shouldDie = true;
		player.shouldDie = true;
	    }
	}

	if (!this.safeForSnake(player.snakeHead[0], player.snakeHead[1])) {
	    player.shouldDie = true;
	}
    },

    createPlayer: function (id, startX, startY, direction) {
	players[id].snakeHead = [startX, startY];
	players[id].lastSnakeHead = [];
	players[id].snakePath = [];

	players[id].currentDirection = direction;
	players[id].nextDirection = direction;

	players[id].foodArray = [];

	players[id].addSquare = false;
	players[id].alive = true;
	players[id].shouldDie = false;
	players[id].keys = {};
	players[id].score = 0;
    },

    createBackground: function () {
	background = game.add.sprite(0, 0, 'background');
	bgLeft = game.add.sprite(10, 300, 'square-' + players[0].color);
	bgRight = game.add.sprite(155, 300, 'square-' + players[1].color);
	bgLeft.scale.setTo(135 / 18, 90 / 18);
	bgRight.scale.setTo(135 / 18, 90 / 18);

	keysWasd = game.add.sprite(78, 390, 'keys-wasd');
	keysWasd.anchor.setTo(0.5, 1);
	keysArrows = game.add.sprite(300 - 78, 390, 'keys-arrows');
	keysArrows.anchor.setTo(0.5, 1);
    },

    updateBackground: function () {
	bgLeft = game.add.sprite(10, 300, 'square-' + players[0].color);
	bgRight = game.add.sprite(155, 300, 'square-' + players[1].color);
	bgLeft.scale.setTo(135 / 18, 90 / 18);
	bgRight.scale.setTo(135 / 18, 90 / 18);

	keysWasd.bringToTop();
	keysArrows.bringToTop();
    },

    setLoc: function (x, y, obj) {
	obj.x = this.gridLoc(x);
	obj.y = this.gridLoc(y);
    },

    setDirection: function (dir, player) {
	player.direction = dir;
    },

    gridLoc: function (pre) {
	return 20 * pre + 11;
    },

    allDead: function () {
	anyAlive = false;
	for (var i = 0; i < players.length; i++) {
	    if (players[i].alive) {
		anyAlive = true;
	    }
	}

	return !anyAlive;
    },

    paint: function () {
	squares.removeAll();

	for (var i = 0; i < players.length; i++) {
	    this.paintPlayer(players[i]);
	}

	for (var i = 0; i < scoreText.length; i++) {
	    scoreText[i].text = players[i].score;
	}
    },

    paintPlayer: function (player) {
	if (player.alive) {
	    this.createSquare(player.snakeHead[0], player.snakeHead[1], 'square-' + player.color);
	    this.paintArr(player.snakePath, 'square-' + player.color);
	}
	this.paintArr(player.foodArray, 'food-' + player.color);
    },

    paintArr: function (arr, image) {
	for (var i = 0; i < arr.length; i++) {
	    this.createSquare(arr[i][0], arr[i][1], image);
	}
    },

    createSquare: function (x, y, image) {
	square = squares.create(this.gridLoc(x), this.gridLoc(y), image);
    },

    generateFood: function (player) {
	var success = false;
	while (!success) {
	    x = Math.floor(Math.random() * columns);
	    y = Math.floor(Math.random() * rows);

	    if (this.squareAt(x, y) == 'empty') {
		this.createSquare(x, y, 'food-' + player.color);
		player.foodArray.push([x,y]);
		success = true;
	    }
	}
    },

    safeForSnake: function (x, y) {
	if (x < 0 || x > columns || y < 0 || y > rows) {	    
	    return false;
	}

	if (this.squareAt(x, y) == 'empty' || this.squareAt(x, y).substring(0, 4) == 'food') {	   
	    return true;
	}

	if (this.squareAt(x, y).substring(0, 9) == 'snakePath') {
	    return false;
	}

	return false;
    },

    squareAt: function (x, y) {
	for (var i = 0; i < players.length; i++) {
	    if (this.arrayIndexOf([x,y], players[i].foodArray) > -1) {
		return 'food' + i;
	    }

	    if (this.arrayIndexOf([x,y], players[i].snakePath) > -1 && players[i].alive) {
		return 'snakePath' + i;
	    }
	}

	return 'empty';
    },

    arrayIndexOf: function (arr, arr2d) {
	for (var i = 0; i < arr2d.length; i++) {
	    if (arr2d[i][0] === arr[0] && arr2d[i][1] === arr[1]) {
		return i;
	    }
	}

	return -1;
    },

    addControls: function (up, down, left, right, player) {
	player.keys.up = game.input.keyboard.addKey(up);
	player.keys.down = game.input.keyboard.addKey(down);
	player.keys.left = game.input.keyboard.addKey(left);
	player.keys.right = game.input.keyboard.addKey(right);
    },

    updateControls: function (player) {
	if (player.keys.up.isDown && (player.currentDirection != Directions.Down)) {
	    player.nextDirection = Directions.Up;
	}
	else if (player.keys.down.isDown && (player.currentDirection != Directions.Up)) {
	    player.nextDirection = Directions.Down;
	}
	else if (player.keys.left.isDown && (player.currentDirection != Directions.Right)) {
	    player.nextDirection = Directions.Left;
	}
	else if (player.keys.right.isDown && (player.currentDirection != Directions.Left)) {
	    player.nextDirection = Directions.Right;
	}
    },

    addMute: function() {
	muteKey = game.input.keyboard.addKey(Phaser.Keyboard.M);
	muteKey.onDown.add(
	    function () {
		if (audio) {
		    music.pause();
		}
		else {
		    if (music.paused) {
			music.resume();
		    }
		    else {
			music.play('', 0, 0.25, true, true);
		    }
		}
		audio = !audio;
	    }, this);
    },

    endGame: function () {
	music.stop();
	game.state.start('End');
    }
};
