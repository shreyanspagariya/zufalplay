class CameraController

  constructor: (levelView, canvasOverlay) ->
    camera = levelView.camera
    mouseDown = false
    previousX = 0
    previousY = 0
    sensitivity = 0.01

    $(canvasOverlay).on 'mousedown', (e) ->
      mouseDown = true
      previousX = e.screenX
      previousY = e.screenY

    $(document).on 'mouseup', (e) ->
      mouseDown = false
    .on 'mousemove', (e) ->
      if mouseDown
        dx = (e.screenX - previousX) * sensitivity
        dy = (e.screenY - previousY) * sensitivity
        camera.rotate(dx, dy)
        previousX = e.screenX
        previousY = e.screenY
