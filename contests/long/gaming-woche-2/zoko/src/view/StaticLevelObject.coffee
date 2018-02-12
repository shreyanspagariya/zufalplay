class StaticLevelObject extends e3d.Object
  levelTextures = []
  
  @setTextures = (textures) ->
    for texture, index in textures
      levelTextures[index] = texture
  
  constructor: (levelState) ->
    super()
    
    width = levelState.width
    depth = levelState.depth
    
    side = []
    solidTop = []
    platformTop = []
    
    # Construct level model
    levelState.forEachBlock (block, position) ->
      if block.static
        leftBlock  = levelState.blockAt(vec.add(position, [-1, 0, 0]))
        rightBlock = levelState.blockAt(vec.add(position, [ 1, 0, 0]))
        backBlock  = levelState.blockAt(vec.add(position, [ 0,-1, 0]))
        frontBlock = levelState.blockAt(vec.add(position, [ 0, 1, 0]))
        topBlock   = levelState.blockAt(vec.add(position, [ 0, 0, 1]))
        if not leftBlock.static  then side = side.concat(makeLeftFace(position))
        if not rightBlock.static then side = side.concat(makeRightFace(position))
        if not backBlock.static  then side = side.concat(makeBackFace(position) )
        if not frontBlock.static then side = side.concat(makeFrontFace(position))
        if not topBlock.static
          if block.type is 'solid' then solidTop = solidTop.concat(makeTopFace(position))
          if block.type is 'platform' then platformTop = platformTop.concat(makeTopFace(position))
    
    @meshes = [ new e3d.Mesh(side)
                new e3d.Mesh(solidTop)
                new e3d.Mesh(platformTop) ]
    @textures = levelTextures
