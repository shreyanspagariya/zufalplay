class Highscore

  constructor: ->
    @list = @getHighscoreObj()

  getHighscoreObj: ->
    obj = localStorage.getItem('highscore')
    if obj?
      return JSON.parse(obj)
    else
      return { '1': 0, '2': 0, '3': 0, '4': 0, '5': 0 }

  setHighscore: (level, steps) ->
    current = @list[level]
    if (current > steps) or (current is 0)
      @list[level] = steps
      localStorage.setItem('highscore', JSON.stringify(@list))

  getHighscore: (level) ->
    return @list[level]