class Zoko

  constructor: (container) ->
    canvas = container.find('canvas')[0]
    canvasOverlay = container.find('#overlay')
    e3d.init(canvas)
    levelView = new LevelView()
    new PlayerController(levelView)
    new CameraController(levelView, canvasOverlay)
    game = new Game(levelView)
    ui = new UI(game)
    game.observers = [ui]
    e3d.run()