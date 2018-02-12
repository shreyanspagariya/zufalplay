e3d = e3d || {}

class e3d.Mesh
  constructor: (data) ->
    gl = e3d.gl
    program = e3d.program.mesh
    
    @vertexbuffer = gl.createBuffer()
    gl.bindBuffer(gl.ARRAY_BUFFER, @vertexbuffer)
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(data), gl.STATIC_DRAW)
    
    @nvertices = data.length / 8
  
  render: ->
    gl = e3d.gl
    program = e3d.program.mesh
    
    gl.bindBuffer(gl.ARRAY_BUFFER, @vertexbuffer)
    gl.vertexAttribPointer(program.aPositionLoc, 3, gl.FLOAT, false, 32, 0)
    gl.vertexAttribPointer(program.aTexCoordLoc, 2, gl.FLOAT, false, 32, 12)
    gl.vertexAttribPointer(program.aColorLoc, 3, gl.FLOAT, false, 32, 20)
    gl.drawArrays(gl.TRIANGLES, 0, @nvertices)
