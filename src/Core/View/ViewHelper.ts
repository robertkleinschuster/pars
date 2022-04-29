import ViewEventInitializer from './ViewEventInitializer'
import ViewMessage from './ViewMessage'
import ViewElementInterface from './ViewElementInterface'

export default class ViewHelper {
  public element: ViewElementInterface
  public eventHandler: ViewEventInitializer

  constructor (element: ViewElementInterface) {
    this.element = element
    this.eventHandler = new ViewEventInitializer(this)
    this.eventHandler.init()
    this.init()
  }

  private init () {
    this.element.addEventListener(ViewMessage.name, this.dispatchToChildNodes.bind(this, this.element))
  }

  private dispatchToChildNodes (node: Node, event: CustomEvent) {
    node.childNodes.forEach(child => {
      if ('helper' in child) {
        child.dispatchEvent(new CustomEvent(ViewMessage.name, {
          detail: event.detail
        }))
      } else {
        this.dispatchToChildNodes(child, event)
      }
    })
  }

  public on (code: string, listener: (message: ViewMessage) => void) {
    this.element.addEventListener(ViewMessage.name, (event: CustomEvent) => {
      const message = event.detail as ViewMessage
      if (code === message.code) {
        listener(message)
      }
    })
  }

  public trigger (code: string) {
    this.element.dispatchEvent(
      new CustomEvent(ViewMessage.name, {
        detail: new ViewMessage(code),
        bubbles: true
      })
    )
  }
}
