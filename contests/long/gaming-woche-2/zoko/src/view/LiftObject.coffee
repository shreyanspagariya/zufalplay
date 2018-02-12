class LiftObject extends e3d.Object
  liftMeshes = []
  liftTextures = []
  
  @setTextures = (textures) ->
    for texture, index in textures
      liftTextures[index] = texture
  
  constructor: (@lift) ->
    super()
    
    if liftMeshes.length is 0
      liftMeshes = [ new e3d.Mesh(makeLidlessBox())
                     new e3d.Mesh(makeTopFace()) ]
    
    @meshes = liftMeshes
    @textures = liftTextures
    
    @prevPosition = @lift.position
    @position = @lift.position
  
  animate: (frame) ->
    target = @lift.position
    if frame isnt LevelView.ANIMATION_FRAMES_PER_STEP
      diff = vec.sub(target, @prevPosition)
      time = frame / LevelView.ANIMATION_FRAMES_PER_STEP
      dist = vec.mul(diff, time)
      @position = vec.add(@prevPosition, dist)
    else
      @position = target
      @prevPosition = target
  
  render: (matrix) ->
    super(matrix)
