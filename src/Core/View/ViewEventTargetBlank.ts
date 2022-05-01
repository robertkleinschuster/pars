import ViewEvent from './ViewEvent'

export default class ViewEventTargetBlank extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation();
    const newWindow = global.window.open(this.getUrl(), '_blank')
    if (newWindow) {
      newWindow.focus()
      newWindow.addEventListener('unload', () => {
        const popStateEvent = new PopStateEvent('popstate', {
          state: global.window.history.state
        })
        global.window.dispatchEvent(popStateEvent)
      })
    }
  }
}
