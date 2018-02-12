class Camera extends e3d.Camera
  maxY = 1.3
  minY = 0.1

  rotate: (dx, dy) ->

    newRotation = vec.add(@rotation, [dy, 0, dx])

    newRotation[0] = Math.min(newRotation[0], maxY)
    newRotation[0] = Math.max(newRotation[0], minY)

    @rotation = newRotation

