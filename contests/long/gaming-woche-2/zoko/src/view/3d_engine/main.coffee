e3d = e3d || {}

e3d.init = (canvas) ->
  # Init WebGL
  gl = canvas.getContext('experimental-webgl', { alpha: false })
  gl.enable(gl.DEPTH_TEST)

  # Set properties
  e3d.width = canvas.width
  e3d.height = canvas.height
  e3d.gl = gl
  e3d.scene = null
  e3d.noTexture = new e3d.Texture(null)
  e3d.onrender = null
  
  # Init shader programs
  e3d.program.mesh.init()

e3d.run = ->
  # Setup rendering loop
  requestAnimationFrame = window.requestAnimationFrame ||
                          window.webkitRequestAnimationFrame ||
                          window.mozRequestAnimationFrame ||
                          window.oRequestAnimationFrame ||
                          window.msRequestAnimationFrame ||
                          (callback) -> window.setTimeout(callback, 1000/60)

  frame = ->
    requestAnimationFrame(frame)
    gl = e3d.gl
    
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT)
    
    if e3d.scene?
      e3d.scene.render()
    
    if e3d.onrender?
      e3d.onrender()

  # Start rendering loop
  requestAnimationFrame(frame)
