# Creates an array of textures from an array of images
createTextures = (images) ->
  for image in images then new e3d.Texture(image)

# Makes a quadrangle out of two triangles
# Vertex positions should be specified in the following order:
# 1-----2
# |   / |
# | /   |
# 3-----4
makeQuad = (positions, color) ->
  p = positions
  [r, g, b] = color
  #     |         position         | texcoord | color  |
  v = [ [ p[0][0], p[0][1], p[0][2],   0, 0,   r, g, b ]
        [ p[1][0], p[1][1], p[1][2],   1, 0,   r, g, b ]
        [ p[2][0], p[2][1], p[2][2],   0, 1,   r, g, b ]
        [ p[3][0], p[3][1], p[3][2],   1, 1,   r, g, b ] ]
  #               |   triangle 1   |   triangle 2   |
  return [].concat(v[0], v[1], v[2], v[3], v[2], v[1])

# Creates the left face of a cube at position
makeLeftFace = (position = [0, 0, 0]) ->
  [x, y, z] = position
  positions = [ [x, y, z+1], [x, y+1, z+1], [x, y, z], [x, y+1, z] ]
  color = [0.7, 0.7, 0.7]
  return makeQuad(positions, color)

# Creates the right face of a cube at position
makeRightFace = (position = [0, 0, 0]) ->
  [x, y, z] = position
  positions = [ [x+1, y+1, z+1], [x+1, y, z+1], [x+1, y+1, z], [x+1, y, z] ]
  color = [0.8, 0.8, 0.8]
  return makeQuad(positions, color)

# Creates the back face of a cube at position
makeBackFace = (position = [0, 0, 0]) ->
  [x, y, z] = position
  positions = [ [x+1, y, z+1], [x, y, z+1], [x+1, y, z], [x, y, z] ]
  color = [0.6, 0.6, 0.6]
  return makeQuad(positions, color)

# Creates the front face of a cube at position
makeFrontFace = (position = [0, 0, 0]) ->
  [x, y, z] = position
  positions = [ [x, y+1, z+1], [x+1, y+1, z+1], [x, y+1, z], [x+1, y+1, z] ]
  color = [0.9, 0.9, 0.9]
  return makeQuad(positions, color)

# Creates the top face of a cube at position
makeTopFace = (position = [0, 0, 0]) ->
  [x, y, z] = position
  positions = [ [x, y, z+1], [x+1, y, z+1], [x, y+1, z+1], [x+1, y+1, z+1] ]
  color = [1.0, 1.0, 1.0]
  return makeQuad(positions, color)

# Creates a box without lid at position
makeLidlessBox = (position) ->
  return [].concat( makeLeftFace(position),
                    makeRightFace(position),
                    makeBackFace(position),
                    makeFrontFace(position) )

# Creates a box at position
makeBox = (position) ->
  return [].concat( makeLidlessBox(position),
                    makeTopFace(position) )
