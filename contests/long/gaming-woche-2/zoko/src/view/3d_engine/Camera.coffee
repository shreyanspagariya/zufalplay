e3d = e3d || {}

class e3d.Camera
  constructor: ->
    @position = [0,0,0]
    @rotation = [0,0,0]
    @distance = 0
    
  createMatrix: ->
    fovy = 45
    aspect = e3d.width / e3d.height
    near = 0.1
    far = 100
    
    eye = [0,0,0]
    target = [0,-1,0]
    up = [0,0,1]
    
    matrix = mat.perspective(fovy, aspect, near, far)
    matrix = mat.lookat(matrix, eye, target, up)
    matrix = mat.translate(matrix, [0,-@distance,0])
    matrix = mat.rotateX(matrix, -@rotation[0])
    matrix = mat.rotateY(matrix, -@rotation[1])
    matrix = mat.rotateZ(matrix, -@rotation[2])
    matrix = mat.translate(matrix, vec.neg(@position))
    return matrix
