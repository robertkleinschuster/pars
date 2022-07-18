import ViewMessage from './ViewMessage'
import '@ungap/custom-elements'
import ViewSocket from './ViewSocket'

HTMLElement.prototype.getHelper = function () {
  if (null === this._helper || undefined === this._helper) {
    this._helper = new ViewHelper(this)
  }
  return this._helper;
}

HTMLElement.prototype.dispatch = function (e) {
  this.getHelper().dispatch(e)
}


export default class ViewHelper implements IViewHelper {
  public element: HTMLElement
  public socket: ViewSocket = ViewSocket.instance

  constructor (element: HTMLElement) {
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
