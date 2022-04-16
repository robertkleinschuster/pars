import ViewEvent from './ViewEvent'

export default class ViewState {
  public url: string
  public target: string
  public selector: string

  public static createByEvent (viewEvent: ViewEvent) {
    const state = new this
    state.url = viewEvent.getUrl().toString();
    state.target = viewEvent.target;
    state.selector = viewEvent.selector;

    return state;
  }
}