class Observable
  notifyObservers: () ->
    if @observers?
      for observer in @observers
        if observer?
          observer.update(this, arguments)
