# Vector math functions
vec =
  equal: ( u, v ) ->
    ( u is v ) or ( u[0] == v[0] and
                    u[1] == v[1] and
                    u[2] == v[2] )
  
  add: ( u, v ) ->
    [ u[0] + v[0]
      u[1] + v[1]
      u[2] + v[2] ]
  
  sub: ( u, v ) ->
    [ u[0] - v[0]
      u[1] - v[1]
      u[2] - v[2] ]
  
  mul: ( v, k ) ->
    [ v[0] * k
      v[1] * k
      v[2] * k ]
  
  div: ( v, k ) ->
    [ v[0] / k
      v[1] / k
      v[2] / k ]
  
  neg: ( v ) ->
    [ -v[0]
      -v[1]
      -v[2] ]
  
  dot: ( u, v ) ->
    u[0] * v[0] + u[1] * v[1] + u[2] * v[2]
  
  dot4: ( u, v ) ->
    u[0] * v[0] + u[1] * v[1] + u[2] * v[2] + u[3] * v[3]
  
  cross: ( u, v ) ->
    [ u[1] * v[2] - u[2] * v[1]
      u[2] * v[0] - u[0] * v[2]
      u[0] * v[1] - u[1] * v[0] ]
  
  len: ( v ) ->
    Math.sqrt( vec.dot( v, v ) )
  
  unit: ( v ) ->
    vec.div( v, vec.len( v ) )
