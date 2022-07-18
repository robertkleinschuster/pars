import ViewMessage from './ViewMessage'
import ViewElementInterface from './ViewElementInterface'
import '@ungap/custom-elements'
import ViewSocket from './ViewSocket'

Element.prototype.dispatch = function (e) {
  if (null === this.helper || undefined === this.helper) {
    this.helper = new ViewHelper(this)
  }
  this.helper.dispatch(e)
}

export default class ViewHelper implements IViewHelper {
  public element: ViewElementInterface
  public socket: ViewSocket = ViewSocket.instance

  constructor (element: ViewElementInterface) {
    this.element = element
    this.socket.onMessage(message => {
      if (this.element.dataset.id === message.id && message.html != null) {
        this.element.innerHTML = message.html
      }
    })
  }

  public on (code: string, listener: (message: ViewMessage) => void) {
    this.socket.onMessage(message => {
      if (code === message.code) {
        listener(message)
      }
    })
  }

  public dispatch (message: string | ViewMessage | Event) {
    if (typeof message == 'string') {
      message = new ViewMessage(message)
    } else if (message instanceof MessageEvent) {
      message = new ViewMessage(message.type, message.data)
    } else if (message instanceof CustomEvent) {
      message = new ViewMessage(message.type, message.detail)
    } else if (message instanceof Event) {
      message = new ViewMessage(message.type)
    }
    if (this.element.dataset.id != null) {
      message.id = this.element.dataset.id
    }
    console.log(message)
    this.socket.send(message)
  }
}
