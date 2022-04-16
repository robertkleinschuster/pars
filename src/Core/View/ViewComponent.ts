import ViewEventInitializer from './ViewEventInitializer'

export default class ViewComponent {
  public element: HTMLElement
  public eventHandler: ViewEventInitializer

  constructor (element: HTMLElement) {
    this.element = element
    this.eventHandler = new ViewEventInitializer(this)
    this.eventHandler.init()
    this.init()
  }

  // eslint-disable-next-line @typescript-eslint/no-empty-function
  protected init (): void {}
}
