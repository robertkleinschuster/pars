import ViewMessage from './ViewMessage'

export default class ViewSocket {
  private static _instance: ViewSocket | null
  private socket: WebSocket
  private listener: ((data: ViewMessage) => void)[] = []

  private connect () {
    const url = new URL(window.location.href, document.baseURI)
    url.protocol = 'ws'
    if (window.location.protocol == 'https') {
      url.protocol = 'wss'
    }
    this.socket = new WebSocket(url)
    this.onMessage(msg => {
      console.log(msg)
    })
    this.socket.onmessage = event => {
      const data = JSON.parse(event.data)
      if (data.ctrl == 'close') {
        window.close()
      }
      if (data.ctrl == 'reload') {
        window.location.reload()
      }
      if (data.ctrl == 'open' && undefined != data.url) {
        window.open(data.url)
      }
      if (data.ctrl == 'replace' && undefined != data.url) {
        window.location.replace(data.url)
      }
      if (data.ctrl == 'assign' && undefined != data.url) {
        window.location.assign(data.url)
      }
      if (undefined != data.alert) {
        window.alert(data.alert)
      }
      this.listener.forEach(listener => {
        const view = data.view
        if (undefined !== view && null !== view) {
          listener(Object.assign(ViewMessage.prototype, view))
        }
      })
    }
  }

  public static get instance () {
    if (!ViewSocket._instance) {
      ViewSocket._instance = new ViewSocket()
    }
    return ViewSocket._instance
  }

  public send (message: ViewMessage): void {
    if (null == this.socket
      || this.socket.readyState == WebSocket.CLOSED
      || this.socket.readyState == WebSocket.CLOSING) {
      this.connect()
      this.socket.onopen = () => {
        this.socket.send(JSON.stringify({ view: message }))
      }
    } else if (this.socket.readyState == WebSocket.CONNECTING) {
      this.socket.onopen = () => {
        this.socket.send(JSON.stringify({ view: message }))
      }
    } else {
      this.socket.send(JSON.stringify({ view: message }))
    }
  }

  public onMessage (listener: (data: ViewMessage) => void) {
    this.listener.push(listener)
  }
}