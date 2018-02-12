e3d = e3d || {}

class e3d.Texture
  constructor: (image) ->
    gl = e3d.gl
    
    @texture = gl.createTexture()
    gl.bindTexture(gl.TEXTURE_2D, @texture)
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.NEAREST)
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.NEAREST)
    
    if image?
      gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, image)
      @width = image.width
      @height = image.height
    else
      # Default to a simple single white pixel texture
      pixels = new Uint8Array([255,255,255,255])
      gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, 1, 1, 0, gl.RGBA, gl.UNSIGNED_BYTE, pixels)
      @width = 0
      @height = 0
  
  use: ->
    gl = e3d.gl
    gl.bindTexture(gl.TEXTURE_2D, @texture)
  
  free: ->
    gl = e3d.gl
    if @texture?
      gl.deleteTexture(@texture)
      @texture = null
