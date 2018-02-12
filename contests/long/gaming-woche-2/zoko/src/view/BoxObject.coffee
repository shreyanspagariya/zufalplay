class BoxObject extends e3d.Object
  boxMeshes = []
  boxTextures = []
  
  @setTextures = (textures) ->
    for texture, index in textures
      boxTextures[index] = texture
  
  constructor: (@box) ->
    super()
    
    if boxMeshes.length is 0
      boxMeshes = [new e3d.Mesh(makeBox())]
    
    @meshes = boxMeshes
    @textures = boxTextures
    
    @prevPosition = @box.position
    @position = @box.position
  
  animate: (frame) ->
    target = @box.position
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
