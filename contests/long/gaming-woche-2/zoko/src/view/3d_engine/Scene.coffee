e3d = e3d || {}

class e3d.Scene
  constructor: ->
    @objects = []
    @camera = null
  
  render: ->
    program = e3d.program.mesh
    
    if @camera?
      program.begin()
      matrix = @camera.createMatrix()
      for object in @objects
        if object?
          object.render(matrix)
      program.end()
