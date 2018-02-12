class PlayerController
  relativeDirections = [
    {
      left: 'left',
      up: 'up',
      right: 'right',
      down: 'down'
    },
    {
      left: 'up',
      up: 'right',
      right: 'down',
      down: 'left'
    },
    {
      left: 'right',
      up: 'down',
      right: 'left',
      down: 'up'
    },
    {
      left: 'down',
      up: 'left',
      right: 'up',
      down: 'right'
    },
  ]

  # Map current camera rotation to correct relative directions
  getRelativeDirection = (rotationZ) ->

    # Get "even" quadrant
    q = rotationZ + (Math.PI / 4)

    # We want to stay within the interval [0, 2*PI]
    mod = q % (2*Math.PI)
    mod = mod + 2*Math.PI if mod < 0

    # Get index
    index = Math.floor( mod / ( Math.PI / 2 ) )

    return relativeDirections[index]

  constructor: (levelView) ->
    camera = levelView.camera

    $(document).on 'keydown', (e) ->
      levelState = levelView.currState
      rotationZ = camera.rotation[2]
      directions = getRelativeDirection(rotationZ)
      switch e.which
        when 37 # left
          levelState.movePlayer(directions.left)
          return false
        when 38 # up
          levelState.movePlayer(directions.up)
          return false
        when 39 # right
          levelState.movePlayer(directions.right)
          return false
        when 40 # down
          levelState.movePlayer(directions.down)
          return false
      return true
