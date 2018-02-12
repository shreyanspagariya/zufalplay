class EmptyBlock
  type: 'empty'
  static: false

  constructor: (@level, @position) ->

  move: ->
    # If there is nothing to land on below an empty block then it should act as
    # a solid block.
    below = @level.blockBelow @position
    return below.type isnt 'empty'

  update: -> return false


class SolidBlock
  type: 'solid'
  static: true

  move: -> return false

  update: -> return false


class PlatformBlock
  type: 'platform'
  static: true

  move: -> return false

  update: -> return false


class BoxBlock
  type: 'box'
  static: false

  constructor: (@level, @position) ->

  move: (direction, force) ->
    if force >= 1
      here = @position
      next = vec.add(here, direction)
      if @level.blockAt(next).move(direction, force - 1)
        above = vec.add(here, [0,0,1])
        @level.blockAt(above).move(direction, force)
        @level.swapBlocksAt(here, next)
        return true
    return false

  update: ->
    gravity = 1
    return @move([0, 0, -1], gravity)


class LiftBlock
  type: 'lift'
  static: false

  constructor: (@level, @position) ->
    @bottom = @position[2]
    @top = @position[2]

  move: -> return false

  update: ->
    up = [0, 0, 1]
    down = [0, 0, -1]
    here = @position
    above = vec.add(here, up)
    below = vec.add(here, down)
    if @level.blockAt(above).type is 'empty'
      if here[2] isnt @bottom
        if @level.blockAt(below).type is 'empty'
          @level.swapBlocksAt(here, below)
          return true
    else
      if here[2] isnt @top
        force = Infinity
        if @level.blockAt(above).move(up, force)
          @level.swapBlocksAt(here, above)
          return true
    return false


class Player
  type: 'player'
  static: false

  constructor: (@level, @position) ->
    @direction = [0, 1, 0]

  move: (direction, force) ->
    if direction[2] == 0 # No vertical movement
      @direction = direction
    here = @position
    next = vec.add(here, direction)
    if @level.blockAt(next).move(direction, force)
      @level.swapBlocksAt(here, next)
      return true
    return false

  update: ->
    gravity = 1
    return @move([0, 0, -1], gravity)


class LevelState extends Observable
  constructor: (levelData) ->
    @blockArray = for layer, z in levelData
                    for row, y in layer
                      for block, x in row
                        position = [x, y, z]
                        switch block
                          when 'O' then new SolidBlock
                          when 'X' then new PlatformBlock
                          when '#' then new BoxBlock(this, position)
                          when '^' then new LiftBlock(this, position)
                          when 'S' then @player = new Player(this, position)
                          else new EmptyBlock(this, position)

    @height = @blockArray.length
    @depth = @blockArray[0].length
    @width = @blockArray[0][0].length

    instance = this
    @forEach 'lift', (lift, position) ->
      below = instance.blockBelow(position)
      if below.type is 'lift'
        below.top = position[2]
        instance.setBlockAt(position, new EmptyBlock)

    @steps = 0
    @asleep = false
    @solved = false
    @onUpdate = ->

  forEach: (type, callback) ->
    result = []
    for layer, z in @blockArray
      for row, y in layer
        for block, x in row
          if block.type is type
            result.push callback(block, [x, y, z])
    return result

  forEachBlock: (callback) ->
    for layer, z in @blockArray
      for row, y in layer
        for block, x in row
          callback(block, [x, y, z])

  blockAt: (position) ->
    [x, y, z] = position
    if x < 0 or x >= @width then return new EmptyBlock(this, position)
    if y < 0 or y >= @depth then return new EmptyBlock(this, position)
    if z < 0 or z >= @height then return new EmptyBlock(this, position)
    return @blockArray[z][y][x]

  blockBelow: (position) ->
    [x, y, z] = position
    until --z < 0
      block = @blockAt([x, y, z])
      if block.type isnt 'empty' then return block
    return new EmptyBlock(this, [x, y, z])

  setBlockAt: (position, block) ->
    block.level = this
    block.position = position
    [x, y, z] = position
    @blockArray[z][y][x] = block

  swapBlocksAt: (position1, position2) ->
    block1 = @blockAt(position1)
    block2 = @blockAt(position2)
    @setBlockAt(position1, block2)
    @setBlockAt(position2, block1)

  movePlayer: (direction) ->
    unless @solved or @asleep
      offset = switch direction
        when 'left'  then [-1, 0, 0]
        when 'up'    then [ 0,-1, 0]
        when 'right' then [ 1, 0, 0]
        when 'down'  then [ 0, 1, 0]
      force = 1

      if @player.move(offset, force)
        @steps++
        @update(true)

  checkIfSolved: ->
    allBoxesInPlace = true
    instance = this
    @forEach 'box', (box, position) ->
      if instance.blockBelow(position).type isnt 'platform'
        allBoxesInPlace = false

    if allBoxesInPlace is true
      @solved = true
  
  update: (changed = false) ->
    
    if changed is false
      @forEachBlock (block) ->
        changed = block.update() or changed
    
    if changed
      @onUpdate()
      @asleep = true
      instance = this
      @notifyObservers ->
        instance.update()
    else
      @checkIfSolved()
      @onUpdate() if @solved
      @asleep = false
    
    return changed
