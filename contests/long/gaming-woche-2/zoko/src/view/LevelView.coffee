class LevelView

  ANIMATION_FRAMES_PER_STEP = 6
  
  @ANIMATION_FRAMES_PER_STEP = ANIMATION_FRAMES_PER_STEP
  
  constructor: ->
    @camera = new Camera
    @camera.distance = 12

    @scene = new e3d.Scene
    @scene.camera = @camera

    imagefiles =
      'sky': ['/textures/sky.png']
      'level': ['/textures/wall.png', '/textures/floor.png', '/textures/platform.png']
      'box': ['/textures/box.png']
      'lift': ['/textures/lift.png', '/textures/lifttop.png']
      'player': ['/textures/player.png']

    instance = this
    loadImageFiles imagefiles, (images) ->
      SkyObject.setTextures(createTextures(images['sky']))
      StaticLevelObject.setTextures(createTextures(images['level']))
      BoxObject.setTextures(createTextures(images['box']))
      LiftObject.setTextures(createTextures(images['lift']))
      PlayerObject.setTextures(createTextures(images['player']))
      e3d.scene = instance.scene

    @currState = null
    @onAnimationFinished = null
    @animationFramesLeft = 0

  build: (levelState) ->
    center = [ levelState.width / 2
               levelState.depth / 2
               levelState.height / 2 ]

    @camera.position = center
    @camera.rotation = [0.5, 0, 0]

    skySphere = new SkyObject
    skySphere.position = center

    levelModel = new StaticLevelObject(levelState)

    @boxGroup = new e3d.Object
    @boxGroup.children = levelState.forEach 'box',
                                            (box, position) ->
                                              new BoxObject(box)

    @liftGroup = new e3d.Object
    @liftGroup.children = levelState.forEach 'lift',
                                             (lift, x, y, z) ->
                                               new LiftObject(lift)

    @player = new PlayerObject(levelState.player)

    @scene.objects = [skySphere, levelModel, @boxGroup, @liftGroup, @player]

  update: (levelState, args) ->
    if levelState isnt @currState
      @currState = levelState
      @build(levelState)

      instance = this
      e3d.onrender = ->
        player = instance.player
        boxes = instance.boxGroup.children
        lifts = instance.liftGroup.children
        
        animationFramesLeft = instance.animationFramesLeft
        if animationFramesLeft > 0
          frame = ANIMATION_FRAMES_PER_STEP - animationFramesLeft + 1
          player.animate(frame)
          for box in boxes then box.animate(frame)
          for lift in lifts then lift.animate(frame)
          instance.animationFramesLeft--
        else
          callback = instance.onAnimationFinished
          if callback?
            instance.onAnimationFinished = null
            callback()
        
        # Have the camera follow the player
        camera = instance.camera
        diff = vec.sub(vec.add(player.position,[0.0, 0.0, 0.0]), camera.position)
        toAdd = vec.mul(diff, 0.05)
        camera.position = vec.add(camera.position, toAdd)
    
    if args[0]?
      @onAnimationFinished = args[0]
      @animationFramesLeft = ANIMATION_FRAMES_PER_STEP
