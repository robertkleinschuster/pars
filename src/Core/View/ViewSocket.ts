import ViewMessage from './ViewMessage'

export default class ViewSocket {
  private static _instance: ViewSocket | null
  private socket: WebSocket

  private constructor () {
    this.connect();
    this.onMessage(msg => {
      console.log(msg)
    })
    this.socket.onopen = () => {
      this.send(new ViewMessage('test'))
    }
  }

  private connect()
  {
    const url = new URL(window.location.href, document.baseURI)
    url.protocol = 'ws'
    if (window.location.protocol == 'https') {
      url.protocol = 'wss'
    }
    this.socket = new WebSocket(url)
  }

  public static get instance () {
    if (!ViewSocket._instance) {
      ViewSocket._instance = new ViewSocket()
    }
    return ViewSocket._instance
  }

  public send (message: ViewMessage): void {
    if (this.socket.readyState == WebSocket.CLOSED
    || this.socket.readyState == WebSocket.CLOSING) {
      this.connect()
    }
    this.socket.send(JSON.stringify({ view: message }))
  }

  public onMessage (listener: (data: ViewMessage) => void) {
    this.socket.addEventListener('message', event => {
      const view = JSON.parse(event.data).view
      if (undefined !== view && null !== view) {
        listener(Object.assign(ViewMessage.prototype, view))
      }
    })
  }
}