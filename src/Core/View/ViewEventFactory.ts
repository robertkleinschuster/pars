import ViewEvent from './ViewEvent'
import ViewEventTargetBlank from './ViewEventTargetBlank'
import ViewEventTargetSelf from './ViewEventTargetSelf'
import ViewEventTargetAction from './ViewEventTargetAction'
import ViewEventTargetWindow from './ViewEventTargetWindow'
import ViewEventTargetState from './ViewEventTargetState'
import ViewState from './ViewState'

export default class ViewEventFactory {
  public static create(element: HTMLElement) {
    switch (element.dataset.target) {
      case ViewEvent.TARGET_BLANK:
        return new ViewEventTargetBlank(element)
      case ViewEvent.TARGET_SELF:
        return new ViewEventTargetSelf(element)
      case ViewEvent.TARGET_ACTION:
        return new ViewEventTargetAction(element)
      case ViewEvent.TARGET_WINDOW:
        return new ViewEventTargetWindow(element)
    }
    throw 'Missing event target!';
  }

  public static createState(state: ViewState, element: HTMLElement)
  {
    const viewEvent = new ViewEventTargetState(element)
    viewEvent.url = state.url
    viewEvent.target = state.target
    viewEvent.selector = state.selector
    return viewEvent
  }

}