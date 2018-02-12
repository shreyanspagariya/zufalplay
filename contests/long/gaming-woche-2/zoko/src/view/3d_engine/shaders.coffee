e3d = e3d || {}

# List of shader programs
e3d.program =
  mesh:
    vertexSource: """
      uniform mat4 uMatrix;
      attribute vec3 aPosition;
      attribute vec2 aTexCoord;
      attribute vec3 aColor;
      varying vec2 vTexCoord;
      varying vec3 vColor;
      
      void main() {

        gl_Position = uMatrix * vec4(aPosition,1);
        vTexCoord = aTexCoord;
        vColor = aColor;

      }
    """
    fragmentSource: """
      precision mediump float;

      uniform sampler2D uTexture;
      varying vec2 vTexCoord;
      varying vec3 vColor;

      void main() {

        gl_FragColor = texture2D(uTexture, vTexCoord) * vec4(vColor,1);

      }
    """
    init: ->
      gl = e3d.gl
      me = e3d.program.mesh
      
      program = e3d.compileProgram(me.vertexSource, me.fragmentSource)
      
      uMatrixLoc = gl.getUniformLocation(program, 'uMatrix')
      uTextureLoc = gl.getUniformLocation(program, 'uTexture')
      me.aPositionLoc = gl.getAttribLocation(program, 'aPosition')
      me.aTexCoordLoc = gl.getAttribLocation(program, 'aTexCoord')
      me.aColorLoc = gl.getAttribLocation(program, 'aColor')
      
      gl.useProgram(program)
      gl.uniform1i(uTextureLoc, 0)
      gl.useProgram(null)
      
      me.setMatrix = (matrix) ->
        gl.uniformMatrix4fv(uMatrixLoc, false, matrix)
      
      me.begin = ->
        gl.useProgram(program)
        gl.enableVertexAttribArray(me.aPositionLoc)
        gl.enableVertexAttribArray(me.aTexCoordLoc)
        gl.enableVertexAttribArray(me.aColorLoc)
      
      me.end = ->
        gl.disableVertexAttribArray(me.aPositionLoc)
        gl.disableVertexAttribArray(me.aTexCoordLoc)
        gl.disableVertexAttribArray(me.aColorLoc)
        gl.useProgram(null)

e3d.compileProgram = (vertexSource, fragmentSource) ->
  gl = e3d.gl

  compileShader = (type,source) ->
    shader = gl.createShader(type)
    gl.shaderSource(shader, source)
    gl.compileShader(shader)
    if not gl.getShaderParameter(shader, gl.COMPILE_STATUS)
      console.log gl.getShaderInfoLog(shader)
      throw "compileShader fail!"
    return shader

  program = gl.createProgram()
  gl.attachShader(program, compileShader(gl.VERTEX_SHADER, vertexSource))
  gl.attachShader(program, compileShader(gl.FRAGMENT_SHADER, fragmentSource))
  gl.linkProgram(program)
  if not gl.getProgramParameter(program, gl.LINK_STATUS)
    console.log gl.getProgramInfoLog(program)
    throw "linkProgram fail!"

  return program
