resource_dir = 'resources/'

# Loads an image file to a new Image object which is returned via a callback
# function
loadImageFile = (filename, callback) ->
  image = new Image
  image.onload = -> callback(image)
  image.src = resource_dir + filename

# Loads a JSON file to a new JavaScript object which is returned via a
# callback function
loadJsonFile = (filename, callback) ->
  request = new XMLHttpRequest
  request.open('GET', resource_dir + filename, true)
  request.onreadystatechange = ->
    if request.readyState is 4 # Request finished and response is ready
      data = JSON.parse(request.responseText)
      callback(data)
  request.send()

# Meant for internal use in this .coffee file
loadFilesUsing = (loadFilesFunc, filenames, callback) ->
  if filenames instanceof Object is false
    filename = filenames
    loadFilesFunc filename, callback
  else
    if filenames instanceof Array
      nTotal = filenames.length
      loaded = []
    else
      nTotal = 0
      for own key of filenames then nTotal++
      loaded = {}
    nLoaded = 0
    for own key, entry of filenames
      do (key) ->
        loadFilesUsing loadFilesFunc, entry, (data) ->
          loaded[key] = data
          callback(loaded) if ++nLoaded is nTotal

# Loads multiple image files specified in 'filenames' to an object with new
# Image objects, returned via a callback function. The returned object retains
# the structure of 'filenames'.
loadImageFiles = (filenames, callback) ->
  loadFilesUsing loadImageFile, filenames, callback

# Loads multiple JSON files specified in 'filenames' to an object with new
# JavaScript objects, returned via a callback function. The returned object
# retains the structure of 'filenames'.
loadJsonFiles = (filenames, callback) ->
  loadFilesUsing loadJsonFile, filenames, callback

# Loads multiple resource files specified in 'filenames.images' and
# 'filenames.json' to an object with new Image and JavaScript objects, returned
# via a callback function. The returned object retains the structure of
# 'filenames'.
loadResourceFiles = (filenames, callback) ->
  imagesLoaded = false
  jsonLoaded = false

  loaded = {}

  loadImageFiles filenames.images, (images) ->
    loaded.images = images
    imagesLoaded = true
    callback(loaded) if jsonLoaded

  loadJsonFiles filenames.json, (json) ->
    loaded.json = json
    jsonLoaded = true
    callback(loaded) if imagesLoaded
