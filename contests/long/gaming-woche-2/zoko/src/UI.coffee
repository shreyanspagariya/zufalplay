class UI

  constructor: (@game) ->
    @stepsCounter = $('#steps')
    @levelCounter = $('#level').find('.levelNumber')
    @nextBtn = $('#nextBtn')
    @previousBtn = $('#previousBtn')
    @menu = $('#menu')
    @menu.hide()
    @menuTitle = @menu.find('.title')
    @menuOverlay = $('#menuOverlay')
    @menuOverlay.hide()
    @menuShown = false
    @continueBtn = $('#continueBtn')
    @continueBtn.hide()

    @restartBtn = $('#restartBtn')
    @menuBtn = $('#menuBtn')

    @highscoreTable = $('.highscore > .table')

    instance = this

    @nextBtn.on 'click', ->
      instance.menu.fadeOut()
      instance.menuOverlay.fadeOut()
      instance.menuShown = false
      game = instance.game
      if game?
        game.nextLevel()
        instance.levelCounter.html(game.currentLevel)
        instance.resetStepsCount()

    @previousBtn.on 'click', ->
      instance.menu.fadeOut()
      instance.menuOverlay.fadeOut()
      instance.menuShown = false
      game = instance.game
      if game?
        game.previousLevel()
        instance.levelCounter.html(game.currentLevel)
        instance.resetStepsCount()

    @restartBtn.on 'click', ->
      game = instance.game
      if game? and not instance.menuShown
        game.restartLevel()
        instance.resetStepsCount()

    @menuBtn.on 'click', ->
      if instance.menuShown
        instance.menu.fadeOut()
        instance.menuOverlay.fadeOut()
        instance.menuShown = false
      else
        instance.setMenuTitle('Options')
        instance.updateHighscoreTable()
        instance.continueBtn.show()
        if instance.game.currentLevel in instance.game.solvedLevels
          instance.nextBtn.show()
        else
          instance.nextBtn.hide()
        if instance.game.currentLevel-1 in instance.game.solvedLevels
          instance.previousBtn.show()
        else
          instance.previousBtn.hide()

        instance.menuOverlay.fadeIn()
        instance.menu.fadeIn()
        instance.menuShown = true


    @continueBtn.on 'click', ->
      instance.menu.fadeOut()
      instance.menuOverlay.fadeOut()
      instance.menuShown = false

    $(document).on 'keydown', (e) ->
      switch e.which
        when 82 # r
          game = instance.game
          if game? and not instance.menuShown
            game.restartLevel()
            instance.resetStepsCount()
      return true


  update: (game, args) ->
    @game = game
    levelState = args[0]
    steps = levelState.steps

    if levelState.solved
      @game.highscore.setHighscore(game.currentLevel, steps)
      @game.solvedLevels.push(@game.currentLevel)
      @continueBtn.hide()
      @setMenuTitle('Good job!')
      @updateHighscoreTable()
      @nextBtn.show()
      if @game.currentLevel-1 in @game.solvedLevels
        @previousBtn.show()
      else
        @previousBtn.hide()
      @menuOverlay.fadeIn()
      @menu.fadeIn()
      @menuShown = true

    @updateStepsCount(steps)

  showWinnerModal: ->

  updateStepsCount: (steps) ->
    @stepsCounter.html(steps + ' steps')

  resetStepsCount: ->
    @stepsCounter.html('0 steps')

  setMenuTitle: (title) ->
    @menuTitle.html(title)

  updateHighscoreTable: ->
    tablebody = @highscoreTable.find('tbody')
    instance = this
    tablebody.children().each (index, element) ->
      cell = $(element).children('td').last()
      cell.html(instance.game.highscore.getHighscore(index+1) + " steps")